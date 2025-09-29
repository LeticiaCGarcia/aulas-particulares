<?php
include_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $data_nascimento = $_POST['data_nascimento'];
    $telefone = trim($_POST['telefone']);
    $genero = $_POST['genero'];
    $especialidade = $_POST['materia'];
    $formacao = trim($_POST['formacao']);
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];
    $valor_hora = $_POST['valor_hora'];

    if ($senha !== $confirmar_senha) {
        die("As senhas não coincidem. <a href='cadastroprofessor.php'>Voltar</a>");
    }
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $foto = 'uploads/default-user.png';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $pasta_destino = 'uploads/';
        if (!is_dir($pasta_destino)) {
            mkdir($pasta_destino, 0755, true);
        }
        $nome_arquivo = uniqid() . "_" . basename($_FILES['foto']['name']);
        $caminho_final = $pasta_destino . $nome_arquivo;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_final)) {
            $foto = $caminho_final;
        }
    }

    $stmt = $conn->prepare("INSERT INTO professor 
        (nome, email, data_nascimento, telefone, genero, especialidade, formacao, senha, foto, valor_hora) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssd", $nome, $email, $data_nascimento, $telefone, $genero, $especialidade, $formacao, $senha_hash, $foto, $valor_hora);

    if ($stmt->execute()) {
        echo "Professor cadastrado com sucesso! <a href='index.php'>Voltar ao site</a>";
    } else {
        echo "Erro ao cadastrar professor: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: cadastroprofessor.php");
    exit;
}
