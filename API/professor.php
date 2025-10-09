<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 0);
error_reporting(0);
session_start();
include_once 'conexao.php';


$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);

if($method === 'GET'){
    $res = $conn->query("SELECT * FROM professor");
    $professores = $res->fetch_all(MYSQLI_ASSOC);
    echo json_encode($professores);

} elseif($method === 'POST'){
    $stmt = $conn->prepare("INSERT INTO professor (nome,email,data_nascimento,telefone,especialidade,formacao,valor_hora,foto) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->bind_param(
        "ssssssds",
        $data['nome'],
        $data['email'],
        $data['data_nascimento'],
        $data['telefone'],
        $data['especialidade'],
        $data['formacao'],
        $data['valor_hora'],
        $data['foto']
    );

    if($stmt->execute()) echo json_encode(['message'=>'Professor adicionado com sucesso']);
    else echo json_encode(['error'=>'Erro ao adicionar professor']);

} elseif($method === 'PUT'){
    $stmt = $conn->prepare("UPDATE professor SET nome=?, email=?, data_nascimento=?, telefone=?, especialidade=?, formacao=?, valor_hora=?, foto=? WHERE id_professor=?");
    $stmt->bind_param(
        "ssssssdsi",
        $data['nome'],
        $data['email'],
        $data['data_nascimento'],
        $data['telefone'],
        $data['especialidade'],
        $data['formacao'],
        $data['valor_hora'],
        $data['foto'],
        $data['id_professor']
    );

    if($stmt->execute()) echo json_encode(['message'=>'Professor atualizado com sucesso']);
    else echo json_encode(['error'=>'Erro ao atualizar professor']);


} elseif($method === 'DELETE'){
    $stmt = $conn->prepare("DELETE FROM professor WHERE id_professor=?");
    $stmt->bind_param("i",$data['id_professor']);

    if($stmt->execute()) echo json_encode(['message'=>'Professor deletado com sucesso']);
    else echo json_encode(['error'=>'Erro ao deletar professor']);
}
?>
