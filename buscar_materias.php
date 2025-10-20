<?php
include_once 'conexao.php';

$termo = $_GET['q'] ?? '';
$termo = trim($termo);

if ($termo !== '') {
    // BUSCA LETRAS MINUSCULA E MAIUSCULA
    $stmt = $conn->prepare("
        SELECT id_materia, nome 
        FROM materia 
        WHERE LOWER(nome) LIKE LOWER(CONCAT('%', ?, '%')) 
        LIMIT 6
    ");
    
    if ($stmt) {
        $stmt->bind_param("s", $termo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $materias = [];
        while ($row = $resultado->fetch_assoc()) {
            $materias[] = $row;
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($materias, JSON_UNESCAPED_UNICODE);
    } else {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(["erro" => "Falha na consulta ao banco."]);
    }
} else {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([]);
}
?>
