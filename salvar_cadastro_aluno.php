<?php
include_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $data_nascimento = $_POST['data_nascimento'];
    $telefone = $_POST['telefone'];
    $genero = $_POST['genero'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    if ($senha !== $confirmar_senha) {
        die("Erro: as senhas não coincidem.");
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Processar upload da foto, se enviada
    $foto_nome = NULL; // padrão NULL no banco

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $arquivo_tmp = $_FILES['foto']['tmp_name'];
        $nome_arquivo = basename($_FILES['foto']['name']);
        $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));
        
        // Permitir somente extensões seguras
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($extensao, $extensoes_permitidas)) {
            // Criar nome único para evitar sobrescrever arquivos
            $novo_nome = uniqid('foto_', true) . '.' . $extensao;

            $destino = 'uploads/' . $novo_nome;

            // Criar pasta uploads se não existir
            if (!is_dir('uploads')) {
                mkdir('uploads', 0755, true);
            }

            if (move_uploaded_file($arquivo_tmp, $destino)) {
                $foto_nome = $novo_nome; // salvar nome do arquivo para o banco
            } else {
                die("Erro ao salvar a foto.");
            }
        } else {
            die("Tipo de arquivo não permitido. Use JPG, PNG ou GIF.");
        }
    }

    // Alterar seu INSERT para incluir o campo foto
    // Atenção: a tabela aluno precisa ter a coluna 'foto' que aceita NULL

    $stmt = $conn->prepare("INSERT INTO aluno (nome, email, data_nascimento, telefone, genero, senha, foto) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nome, $email, $data_nascimento, $telefone, $genero, $senha_hash, $foto_nome);

    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
        // Você pode redirecionar para login ou perfil
        header("Location: login.php");
        exit();
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    echo "Método inválido.";
}
?>
