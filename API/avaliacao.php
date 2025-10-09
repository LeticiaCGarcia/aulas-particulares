<?php
include 'conexao.php';
header('Content-Type: application/json');
$method=$_SERVER['REQUEST_METHOD'];
function getInputData(){ return json_decode(file_get_contents("php://input"), true); }

if($method=='GET'){
    $result=$conn->query("SELECT * FROM avaliacao");
    $avals=[];
    while($row=$result->fetch_assoc()) $avals[]=$row;
    echo json_encode($avals);

} elseif($method=='POST'){
    $data=getInputData();
    $id_aluno=$data['id_aluno'];
    $id_professor=$data['id_professor'];
    $id_aula=$data['id_aula'] ?? NULL;
    $nota=$data['nota'];
    $comentario=$data['comentario'] ?? NULL;
    $data_avaliacao=$data['data_avaliacao'];

    $sql="INSERT INTO avaliacao (id_aluno,id_professor,id_aula,nota,comentario,data_avaliacao)
          VALUES ('$id_aluno','$id_professor','$id_aula','$nota','$comentario','$data_avaliacao')";
    echo $conn->query($sql)? json_encode(["message"=>"Avaliação cadastrada!"]):json_encode(["error"=>$conn->error]);

} elseif($method=='PUT'){
    $data=getInputData();
    $id=$data['id_avaliacao'];
    $id_aluno=$data['id_aluno'];
    $id_professor=$data['id_professor'];
    $id_aula=$data['id_aula'] ?? NULL;
    $nota=$data['nota'];
    $comentario=$data['comentario'] ?? NULL;
    $data_avaliacao=$data['data_avaliacao'];

    $sql="UPDATE avaliacao SET id_aluno='$id_aluno',id_professor='$id_professor',id_aula='$id_aula',
          nota='$nota',comentario='$comentario',data_avaliacao='$data_avaliacao' WHERE id_avaliacao=$id";
    echo $conn->query($sql)? json_encode(["message"=>"Avaliação atualizada!"]):json_encode(["error"=>$conn->error]);

} elseif($method=='DELETE'){
    $data=getInputData();
    $id=$data['id_avaliacao'];
    $sql="DELETE FROM avaliacao WHERE id_avaliacao=$id";
    echo $conn->query($sql)? json_encode(["message"=>"Avaliação deletada!"]):json_encode(["error"=>$conn->error]);
}
?>
