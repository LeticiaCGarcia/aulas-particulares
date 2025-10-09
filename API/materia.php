<?php
include 'conexao.php';
header('Content-Type: application/json');
$method=$_SERVER['REQUEST_METHOD'];
function getInputData(){ return json_decode(file_get_contents("php://input"), true); }

if($method=='GET'){
    $result=$conn->query("SELECT * FROM materia");
    $materias=[];
    while($row=$result->fetch_assoc()) $materias[]=$row;
    echo json_encode($materias);

} elseif($method=='POST'){
    $data=getInputData();
    $nome=$data['nome'];
    $descricao=$data['descricao'] ?? NULL;
    $icone=$data['icone'] ?? NULL;

    $sql="INSERT INTO materia (nome,descricao,icone) VALUES ('$nome','$descricao','$icone')";
    echo $conn->query($sql)? json_encode(["message"=>"Matéria cadastrada!"]):json_encode(["error"=>$conn->error]);

} elseif($method=='PUT'){
    $data=getInputData();
    $id=$data['id_materia'];
    $nome=$data['nome'];
    $descricao=$data['descricao'] ?? NULL;
    $icone=$data['icone'] ?? NULL;

    $sql="UPDATE materia SET nome='$nome', descricao='$descricao', icone='$icone' WHERE id_materia=$id";
    echo $conn->query($sql)? json_encode(["message"=>"Matéria atualizada!"]):json_encode(["error"=>$conn->error]);

} elseif($method=='DELETE'){
    $data=getInputData();
    $id=$data['id_materia'];
    $sql="DELETE FROM materia WHERE id_materia=$id";
    echo $conn->query($sql)? json_encode(["message"=>"Matéria deletada!"]):json_encode(["error"=>$conn->error]);
}
?>
