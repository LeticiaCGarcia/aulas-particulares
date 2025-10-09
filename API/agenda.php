<?php
include 'conexao.php';
header('Content-Type: application/json');
$method=$_SERVER['REQUEST_METHOD'];
function getInputData(){ return json_decode(file_get_contents("php://input"), true); }

if($method=='GET'){
    $result=$conn->query("SELECT * FROM agenda");
    $agendas=[];
    while($row=$result->fetch_assoc()) $agendas[]=$row;
    echo json_encode($agendas);

} elseif($method=='POST'){
    $data=getInputData();
    $id_professor=$data['id_professor'];
    $data_agenda=$data['data'];
    $hora_inicio=$data['hora_inicio'];
    $hora_fim=$data['hora_fim'];
    $status=$data['status'];

    $sql="INSERT INTO agenda (id_professor,data,hora_inicio,hora_fim,status)
          VALUES ('$id_professor','$data_agenda','$hora_inicio','$hora_fim','$status')";
    echo $conn->query($sql)? json_encode(["message"=>"Agenda cadastrada!"]):json_encode(["error"=>$conn->error]);

} elseif($method=='PUT'){
    $data=getInputData();
    $id=$data['id_agenda'];
    $id_professor=$data['id_professor'];
    $data_agenda=$data['data'];
    $hora_inicio=$data['hora_inicio'];
    $hora_fim=$data['hora_fim'];
    $status=$data['status'];

    $sql="UPDATE agenda SET id_professor='$id_professor', data='$data_agenda', hora_inicio='$hora_inicio',
          hora_fim='$hora_fim', status='$status' WHERE id_agenda=$id";
    echo $conn->query($sql)? json_encode(["message"=>"Agenda atualizada!"]):json_encode(["error"=>$conn->error]);

} elseif($method=='DELETE'){
    $data=getInputData();
    $id=$data['id_agenda'];
    $sql="DELETE FROM agenda WHERE id_agenda=$id";
    echo $conn->query($sql)? json_encode(["message"=>"Agenda deletada!"]):json_encode(["error"=>$conn->error]);
}
?>
