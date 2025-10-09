<?php
include 'conexao.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
function getInputData(){ return json_decode(file_get_contents("php://input"), true); }

if($method=='GET'){
    $result = $conn->query("SELECT * FROM aula");
    $aulas=[];
    while($row=$result->fetch_assoc()) $aulas[]=$row;
    echo json_encode($aulas);

} elseif($method=='POST'){
    $data=getInputData();
    $id_professor=$data['id_professor'];
    $id_aluno=$data['id_aluno'];
    $data_aula=$data['data_aula'];
    $horario=$data['horario'];
    $status=$data['status'];
    $avaliada=$data['avaliada'] ?? 0;

    $sql="INSERT INTO aula (id_professor,id_aluno,data_aula,horario,status,avaliada)
          VALUES ('$id_professor','$id_aluno','$data_aula','$horario','$status','$avaliada')";
    echo $conn->query($sql)? json_encode(["message"=>"Aula cadastrada com sucesso!"]):json_encode(["error"=>$conn->error]);

} elseif($method=='PUT'){
    $data=getInputData();
    $id=$data['id_aula'];
    $id_professor=$data['id_professor'];
    $id_aluno=$data['id_aluno'];
    $data_aula=$data['data_aula'];
    $horario=$data['horario'];
    $status=$data['status'];
    $avaliada=$data['avaliada'] ?? 0;

    $sql="UPDATE aula SET id_professor='$id_professor',id_aluno='$id_aluno',data_aula='$data_aula',
          horario='$horario',status='$status',avaliada='$avaliada' WHERE id_aula=$id";
    echo $conn->query($sql)? json_encode(["message"=>"Aula atualizada com sucesso!"]):json_encode(["error"=>$conn->error]);

} elseif($method=='DELETE'){
    $data=getInputData();
    $id=$data['id_aula'];
    $sql="DELETE FROM aula WHERE id_aula=$id";
    echo $conn->query($sql)? json_encode(["message"=>"Aula deletada com sucesso!"]):json_encode(["error"=>$conn->error]);
}
?>
