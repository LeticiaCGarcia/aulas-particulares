<?php
error_reporting(0);
include __DIR__ . '/../conexao.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

function getInputData() {
    $data = json_decode(file_get_contents("php://input"), true);
    return is_array($data) ? $data : [];
}

if (!$conn) {
    echo json_encode(["error"=>"Falha na conexão com o banco"]);
    exit;
}

if ($method == 'GET') {
    $result = $conn->query("SELECT * FROM aluno");
    if (!$result) { echo json_encode(["error"=>$conn->error]); exit; }
    $alunos = [];
    while($row = $result->fetch_assoc()) $alunos[] = $row;
    echo json_encode($alunos);
    exit;
}

elseif ($method == 'POST') {
    $data = getInputData();
    $nome = $data['nome'] ?? '';
    $email = $data['email'] ?? '';
    $telefone = $data['telefone'] ?? '';
    $data_nascimento = $data['data_nascimento'] ?? '';
    $genero = $data['genero'] ?? '';
    $senha = $data['senha'] ?? '';
    $foto = $data['foto'] ?? '';

    $sql = "INSERT INTO aluno (nome,email,telefone,data_nascimento,genero,senha,foto) VALUES (?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    if($stmt){
        $stmt->bind_param("sssssss",$nome,$email,$telefone,$data_nascimento,$genero,$senha,$foto);
        if($stmt->execute()){
            echo json_encode(["message"=>"Aluno cadastrado com sucesso!","id_aluno"=>$stmt->insert_id]);
        } else { echo json_encode(["error"=>$stmt->error]); }
        $stmt->close();
    } else { echo json_encode(["error"=>$conn->error]); }
    exit;
}

elseif ($method == 'PUT') {
    $data = getInputData();
    $id = intval($data['id_aluno'] ?? 0);
    if($id<=0) { echo json_encode(["error"=>"ID inválido"]); exit; }

    $nome = $data['nome'] ?? '';
    $email = $data['email'] ?? '';
    $telefone = $data['telefone'] ?? '';
    $data_nascimento = $data['data_nascimento'] ?? '';
    $genero = $data['genero'] ?? '';
    $senha = $data['senha'] ?? '';
    $foto = $data['foto'] ?? '';

    $sql = "UPDATE aluno SET nome=?, email=?, telefone=?, data_nascimento=?, genero=?, senha=?, foto=? WHERE id_aluno=?";
    $stmt = $conn->prepare($sql);
    if($stmt){
        $stmt->bind_param("sssssssi",$nome,$email,$telefone,$data_nascimento,$genero,$senha,$foto,$id);
        if($stmt->execute()){
            echo json_encode(["message"=>"Aluno atualizado com sucesso!"]);
        } else { echo json_encode(["error"=>$stmt->error]); }
        $stmt->close();
    } else { echo json_encode(["error"=>$conn->error]); }
    exit;
}

elseif ($method == 'DELETE') {
    $data = getInputData();
    $id = intval($data['id_aluno'] ?? 0);
    if($id<=0) { echo json_encode(["error"=>"ID inválido"]); exit; }

    $sql = "DELETE FROM aluno WHERE id_aluno=?";
    $stmt = $conn->prepare($sql);
    if($stmt){
        $stmt->bind_param("i",$id);
        if($stmt->execute()){
            echo json_encode(["message"=>"Aluno deletado com sucesso!","id_aluno"=>$id]);
        } else { echo json_encode(["error"=>$stmt->error]); }
        $stmt->close();
    } else { echo json_encode(["error"=>$conn->error]); }
    exit;
}

else {
    echo json_encode(["error"=>"Método não suportado"]);
}
?>
