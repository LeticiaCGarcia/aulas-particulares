<?php
session_start();
if (!isset($_SESSION['id_aluno'])) {
    header("Location: login.php");
    exit;
}
$id_aluno = (int)$_SESSION['id_aluno'];

$id_aula = isset($_POST['id_aula']) ? (int)$_POST['id_aula'] : 0;
$id_professor = isset($_POST['id_professor']) ? (int)$_POST['id_professor'] : 0;
$nota = isset($_POST['nota']) ? (int)$_POST['nota'] : 0;
$comentario = isset($_POST['comentario']) ? trim($_POST['comentario']) : null;

if ($nota < 1 || $nota > 5) {
    die("Nota inválida.");
}

include 'conexao.php'; 

// VERIFICADOR
$sql = "SELECT status, id_aluno FROM aula WHERE id_aula = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_aula);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$aula = mysqli_fetch_assoc($res);

if (!$aula) die("Aula não encontrada.");
if ($aula['id_aluno'] != $id_aluno) die("Você não tem permissão para avaliar esta aula.");
if ($aula['status'] !== 'concluída') die("Só é possível avaliar aulas concluídas.");

// CONFERE SE JA N TEM PRA N FICAR DUPLICADO
$sql = "SELECT id_avaliacao FROM avaliacao WHERE id_aula = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_aula);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($res) > 0) {
    die("A aula já foi avaliada.");
}

// COLOCA A AVALIAÇÃO NO BANCO
$sql = "INSERT INTO avaliacao (id_aluno, id_professor, id_aula, nota, comentario, data_avaliacao) VALUES (?, ?, ?, ?, ?, CURDATE())";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iiiis", $id_aluno, $id_professor, $id_aula, $nota, $comentario);
$ok = mysqli_stmt_execute($stmt);

if (!$ok) {
    error_log("Erro salvar_avaliacao: " . mysqli_error($conn));
    die("Erro ao salvar avaliação.");
}


header("Location: minhas_aulas.php?avaliacao=ok");
exit;
