<?php
include 'conexao.php';
header('Content-Type: application/json');
$method=$_SERVER['REQUEST_METHOD'];
function getInputData(){ return json_decode(file_get_contents("php://input"), true); }

if($method=='GET'){
    $result=$conn->query("SELECT * FROM notificacao");
    $notificacoes=[];
    while($row=$result->fetch_assoc()) $notificacoes[]=$row;
    echo json_encode($notificacoes);

} elseif($method=='POST'){
    $data=getInputData();
    $id_aluno=$data['id_aluno'] ?? NULL;
    $id_professor=$data['id_professor'] ?? NULL;
    $mensagem=$data['mensagem'];
    $data_envio=$data['data_envio'];
    $status=$data['status'];

    $sql="INSERT INTO notificacao (id_aluno,id_professor,mensagem,data_envio,status)
          VALUES ('$id_aluno','$id_professor','$mensagem','$data_envio','$status')";
    echo $conn->query($sql)? json_encode(["message"=>"Notificação cadastrada!"]):json_encode(["error"=>$conn->error]);

} elseif($method=='PUT'){
    $data=getInputData();
    $id=$data['id_notificacao'];
    $id_aluno=$data['id_aluno'] ?? NULL;
    $id_professor=$data['id_professor'] ?? NULL;
    $mensagem=$data['mensagem'];
    $data_envio=$data['data_envio'];
    $status=$data['status'];

    $sql="UPDATE notificacao SET id_aluno='$id_aluno', id_professor='$id_professor', mensagem='$mensagem',
          data_envio='$data_envio', status='$status' WHERE id_notificacao=$id";
    echo $conn->query($sql)? json_encode(["message"=>"Notificação atualizada!"]):json_encode(["error"=>$conn->error]);

} elseif($method=='DELETE'){
    $data=getInputData();
    $id=$data['id_notificacao'];
    $sql="DELETE FROM notificacao WHERE id_notificacao=$id";
    echo $conn->query($sql)? json_encode(["message"=>"Notificação deletada!"]):json_encode(["error"=>$conn->error]);
}
?>
