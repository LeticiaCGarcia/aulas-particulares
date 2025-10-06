<?php
include_once 'conexao.php';

session_start();
if (!isset($_SESSION['id_aluno'])) {
    header("Location: login.php");
    exit;
}

$id_aluno = (int)$_SESSION['id_aluno'];

$id_professor = isset($_POST['id_professor']) ? (int)$_POST['id_professor'] : null;
$id_agenda = isset($_POST['id_agenda']) && !empty($_POST['id_agenda']) ? (int)$_POST['id_agenda'] : null;
$data_aula = isset($_POST['data_aula']) ? $_POST['data_aula'] : null;
$horario = isset($_POST['horario']) ? $_POST['horario'] : null;
$metodo_pagamento = isset($_POST['metodo_pagamento']) ? $_POST['metodo_pagamento'] : 'pix';

if (!$id_professor || ( !$id_agenda && (!$data_aula || !$horario) )) {
    die("Dados inválidos. Verifique professor e horário.");
}

// conexão - adapte conforme seu arquivo de conexão
// exemplo com mysqli procedural; se usa PDO, adapte.
include 'conexao.php'; // deve criar $conn mysqli
mysqli_begin_transaction($conn);

try {
    if ($id_agenda) {
        $sql = "SELECT status, id_professor, data, hora_inicio FROM agenda WHERE id_agenda = ? FOR UPDATE";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_agenda);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $agenda = mysqli_fetch_assoc($res);
        if (!$agenda) throw new Exception("Agenda não encontrada.");
        if ($agenda['status'] !== 'disponível') throw new Exception("Slot já reservado.");

        if ($agenda['id_professor'] != $id_professor) throw new Exception("Agenda não pertence ao professor selecionado.");

        $sql = "UPDATE agenda SET status = 'reservado' WHERE id_agenda = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_agenda);
        mysqli_stmt_execute($stmt);

        $data_aula = $agenda['data'];
        $horario = $agenda['hora_inicio'];
    } else {
    }

    // COLOCA AULA NO BANCO
    $sql = "INSERT INTO aula (id_professor, id_aluno, data_aula, horario, status) VALUES (?, ?, ?, ?, 'agendada')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiss", $id_professor, $id_aluno, $data_aula, $horario);
    mysqli_stmt_execute($stmt);
    $id_aula = mysqli_insert_id($conn);

    if (!$id_aula) throw new Exception("Erro ao criar aula.");

    // CRIA O PAGAMENTO DO VALOR DA HORA DO PROFESSOR
    $sql = "SELECT valor_hora FROM professor WHERE id_professor = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_professor);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $prof = mysqli_fetch_assoc($res);
    $valor = $prof ? $prof['valor_hora'] : 0.00;

    $sql = "INSERT INTO pagamento (id_aula, valor, metodo_pagamento, status) VALUES (?, ?, ?, 'pendente')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ids", $id_aula, $valor, $metodo_pagamento);
    mysqli_stmt_execute($stmt);

    mysqli_commit($conn);

    // NOTIFICAÇÃO DA AGENDA PARA O PROFESSOR

    header("Location: confirmado_contratacao.php?id_aula=".$id_aula);
    exit;
} catch (Exception $e) {
    mysqli_rollback($conn);
    error_log("Erro contratar.php: " . $e->getMessage());
    die("Não foi possível concluir a contratação: " . htmlspecialchars($e->getMessage()));
}
