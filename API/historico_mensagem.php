<?php
include 'conexao.php';
header('Content-Type: application/json');
$method=$_SERVER['REQUEST_METHOD'];
function getInputData(){ return json_decode(file_get_contents("php://input"), true); }

if($method=='GET'){
    $result=$conn->query("SELECT * FROM historico_mensagem");
    $historicos=[];
    while($row=$result->fetch_assoc()) $historicos[]=$row;
    echo json_encode($historicos);

} elseif($method=='POST'){
    $data=getInputData();
    $id_mensagem=$data['id_mensagem'];
    $id_aluno=$data['id_aluno'];
    $id_professor=$data['id_professor'];
    $conteudo=$data['conteudo'];
    $data_envio=$data['data_envio'];
    $remetente=$data['remetente'];
    $status=$data['status'];
    $data_registro=$data['data_registro'];

    $sql="INSERT INTO historico_mensagem (id_mensagem,id_aluno,id_professor,conteudo,data_envio,remetente,status,data_registro)
          VALUES ('$id_mensagem','$id_aluno','$id_professor','$conteudo','$data_envio','$remetente','$status','$data_registro')";
    echo $conn->query($sql)? json_encode(["message"=>"Histórico cadastrado!"]):json_encode(["error"=>$conn->error]);

} elseif($method=='PUT'){
    $data=getInputData();
    $id=$data['id_hist_mensagem'];
    $id_mensagem=$data['id_mensagem'];
    $id_aluno=$data['id_aluno'];
    $id_professor=$data['id_professor'];
    $conteudo=$data['conteudo'];
    $data_envio=$data['data_envio'];
    $remetente=$data['remetente'];
    $status=$data['status'];
    $data_registro=$data['data_registro'];

    $sql="UPDATE historico_mensagem SET id_mensagem='$id_mensagem', id_aluno='$id_aluno', id_professor='$id_professor',
          conteudo='$conteudo', data_envio='$data_envio', remetente='$remetente', status='$status', data_registro='$data_registro'
          WHERE id_hist_mensagem=$id";
    echo $conn->query($sql)? json_encode(["message"=>"Histórico atualizado!"]):json_encode(["error"=>$conn->error]);

} elseif($method=='DELETE'){
    $data=getInputData();
    $id=$data['id_hist_mensagem'];
    $sql="DELETE FROM historico_mensagem WHERE id_hist_mensagem=$id";
    echo $conn->query($sql)? json_encode(["message"=>"Histórico deletado!"]):json_encode(["error"=>$conn->error]);
}
?>
