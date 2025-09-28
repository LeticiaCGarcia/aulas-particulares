<?php
session_start();
require_once 'conexao.php'; 

$email = $_POST['email'];
$senha = $_POST['senha'];

$sqlAluno = "SELECT * FROM aluno WHERE email = ?";
$stmtAluno = $conn->prepare($sqlAluno);
$stmtAluno->bind_param("s", $email);
$stmtAluno->execute();
$resultAluno = $stmtAluno->get_result();

if ($resultAluno->num_rows === 1) {
    $aluno = $resultAluno->fetch_assoc();

    if (password_verify($senha, $aluno['senha'])) {
        $_SESSION['tipo_usuario'] = 'aluno';
        $_SESSION['id_aluno'] = $aluno['id_aluno'];
        $_SESSION['nome'] = $aluno['nome'];

        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Senha incorreta.'); window.location.href='login.php';</script>";
        exit();
    }
}

$stmtAluno->close();

$sqlProf = "SELECT * FROM professor WHERE email = ?";
$stmtProf = $conn->prepare($sqlProf);
$stmtProf->bind_param("s", $email);
$stmtProf->execute();
$resultProf = $stmtProf->get_result();

if ($resultProf->num_rows === 1) {
    $prof = $resultProf->fetch_assoc();

    if (password_verify($senha, $prof['senha'])) {
        $_SESSION['tipo_usuario'] = 'professor';
        $_SESSION['id_professor'] = $prof['id_professor'];
        $_SESSION['nome'] = $prof['nome'];
        $_SESSION['foto'] = $aluno['foto'];
        $_SESSION['foto'] = $prof['foto']; 


        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Senha incorreta.'); window.location.href='login.php';</script>";
        exit();
    }
}

$stmtProf->close();


echo "<script>alert('Email não encontrado.'); window.location.href='login.php';</script>";
$conn->close();
?>
