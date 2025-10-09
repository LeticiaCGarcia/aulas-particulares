<?php
include 'conexao.php';
header('Content-Type: application/json');
$method=$_SERVER['REQUEST_METHOD'];
function getInputData(){ return json_decode(file_get_contents("php://input"), true); }

if($method=='GET'){
    $result=$conn->query("SELECT * FROM mensagem");
    $msgs=[];
    while($row=$result->fetch_assoc()) $msgs[]=$row;
    echo json_encode($msgs);

} elseif($method=='POST'){
    $data=getInputData();
    $id_aluno=$data['id_aluno'];
    $id_professor=$data['id_professor'];
    $conteudo=$data['conteudo'];
    $data_envio=$data['data_envio'];
    $remetente=$data['remetente'];
    $status=$data['status'];

    $sql="INSERT INTO mensagem (id_aluno,id_professor,conteudo,data_envio,remetente,status)
          VALUES ('$id_aluno','$id_professor','$conteudo','$data_envio','$remetente','$status')";
    echo $conn->query($sql)? json_encode(["message"=>"Mensagem cadastrada!"]):json_encode(["error"=>$conn->error]);

} elseif($method=='PUT'){
    $data=getInputData();
    $id=$data['id_mensagem'];
    $id_aluno=$data['id_aluno'];
    $id_professor=$data['id_professor'];
    $conteudo=$data['conteudo'];
    $data_envio=$data['data_envio'];
    $remetente=$data['remetente'];
    $status=$data['status'];

    $sql="UPDATE mensagem SET id_aluno='$id_aluno',id_professor='$id_professor',conteudo='$conteudo',
          data_envio='$data_envio',remetente='$remetente',status='$status' WHERE id_mensagem=$id";
    echo $conn->query($sql)? json_encode(["message"=>"Mensagem atualizada!"]):json_encode(["error"=>$conn->error]);

} elseif($method=='DELETE'){
    $data=getInputData();
    $id=$data['id_mensagem'];
    $sql="DELETE FROM mensagem WHERE id_mensagem=$id";
    echo $conn->query($sql)? json_encode(["message"=>"Mensagem deletada!"]):json_encode(["error"=>$conn->error]);
}
?>
