<?php
include 'conexao.php';
header('Content-Type: application/json');
$method=$_SERVER['REQUEST_METHOD'];
function getInputData(){ return json_decode(file_get_contents("php://input"), true); }

if($method=='GET'){
    $result=$conn->query("SELECT * FROM pagamento");
    $pagamentos=[];
    while($row=$result->fetch_assoc()) $pagamentos[]=$row;
    echo json_encode($pagamentos);

} elseif($method=='POST'){
    $data=getInputData();
    $id_aula=$data['id_aula'];
    $valor=$data['valor'];
    $metodo_pagamento=$data['metodo_pagamento'];
    $status=$data['status'];

    $sql="INSERT INTO pagamento (id_aula,valor,metodo_pagamento,status)
          VALUES ('$id_aula','$valor','$metodo_pagamento','$status')";
    echo $conn->query($sql)? json_encode(["message"=>"Pagamento cadastrado!"]):json_encode(["error"=>$conn->error]);

} elseif($method=='PUT'){
    $data=getInputData();
    $id=$data['id_pagamento'];
    $id_aula=$data['id_aula'];
    $valor=$data['valor'];
    $metodo_pagamento=$data['metodo_pagamento'];
    $status=$data['status'];

    $sql="UPDATE pagamento SET id_aula='$id_aula', valor='$valor', metodo_pagamento='$metodo_pagamento',
          status='$status' WHERE id_pagamento=$id";
    echo $conn->query($sql)? json_encode(["message"=>"Pagamento atualizado!"]):json_encode(["error"=>$conn->error]);

} elseif($method=='DELETE'){
    $data=getInputData();
    $id=$data['id_pagamento'];
    $sql="DELETE FROM pagamento WHERE id_pagamento=$id";
    echo $conn->query($sql)? json_encode(["message"=>"Pagamento deletado!"]):json_encode(["error"=>$conn->error]);
}
?>
