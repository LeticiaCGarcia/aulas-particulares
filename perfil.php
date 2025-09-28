<?php
session_start();
include_once 'conexao.php';

if (!isset($_SESSION['tipo_usuario'])) {
    header("Location: login.php");
    exit();
}

$tipo = $_SESSION['tipo_usuario'];
$id_usuario = ($tipo === 'aluno') ? $_SESSION['id_aluno'] : $_SESSION['id_professor'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processar atualização do perfil

    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $genero = $_POST['genero'] ?? '';

    // Validações básicas
    if (!$nome || !$email || !$data_nascimento) {
        die("Por favor, preencha os campos obrigatórios.");
    }

    // Processar upload da nova foto (se enviada)
    $foto_nome = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $arquivo_tmp = $_FILES['foto']['tmp_name'];
        $nome_arquivo = basename($_FILES['foto']['name']);
        $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));

        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($extensao, $extensoes_permitidas)) {
            $novo_nome = uniqid('foto_', true) . '.' . $extensao;
            $destino = 'uploads/' . $novo_nome;

            if (!is_dir('uploads')) {
                mkdir('uploads', 0755, true);
            }

            if (move_uploaded_file($arquivo_tmp, $destino)) {
                $foto_nome = $novo_nome;

                // Remover foto antiga do servidor
                if ($tipo === 'aluno') {
                    $sqlFoto = "SELECT foto FROM aluno WHERE id_aluno = ?";
                } else {
                    $sqlFoto = "SELECT foto FROM professor WHERE id_professor = ?";
                }
                $stmtFoto = $conn->prepare($sqlFoto);
                $stmtFoto->bind_param("i", $id_usuario);
                $stmtFoto->execute();
                $resFoto = $stmtFoto->get_result();
                if ($resFoto->num_rows === 1) {
                    $rowFoto = $resFoto->fetch_assoc();
                    if ($rowFoto['foto'] && file_exists('uploads/' . $rowFoto['foto'])) {
                        unlink('uploads/' . $rowFoto['foto']);
                    }
                }
                $stmtFoto->close();

            } else {
                die("Erro ao salvar a foto.");
            }
        } else {
            die("Tipo de arquivo não permitido. Use JPG, PNG ou GIF.");
        }
    }

    // Atualizar banco
    if ($tipo === 'aluno') {
        if ($foto_nome) {
            $sqlUpdate = "UPDATE aluno SET nome=?, email=?, data_nascimento=?, telefone=?, genero=?, foto=? WHERE id_aluno=?";
            $stmt = $conn->prepare($sqlUpdate);
            $stmt->bind_param("ssssssi", $nome, $email, $data_nascimento, $telefone, $genero, $foto_nome, $id_usuario);
        } else {
            $sqlUpdate = "UPDATE aluno SET nome=?, email=?, data_nascimento=?, telefone=?, genero=? WHERE id_aluno=?";
            $stmt = $conn->prepare($sqlUpdate);
            $stmt->bind_param("sssssi", $nome, $email, $data_nascimento, $telefone, $genero, $id_usuario);
        }
    } else {
        if ($foto_nome) {
            $sqlUpdate = "UPDATE professor SET nome=?, email=?, data_nascimento=?, telefone=?, genero=?, foto=? WHERE id_professor=?";
            $stmt = $conn->prepare($sqlUpdate);
            $stmt->bind_param("ssssssi", $nome, $email, $data_nascimento, $telefone, $genero, $foto_nome, $id_usuario);
        } else {
            $sqlUpdate = "UPDATE professor SET nome=?, email=?, data_nascimento=?, telefone=?, genero=? WHERE id_professor=?";
            $stmt = $conn->prepare($sqlUpdate);
            $stmt->bind_param("sssssi", $nome, $email, $data_nascimento, $telefone, $genero, $id_usuario);
        }
    }

    if ($stmt->execute()) {
        $_SESSION['nome'] = $nome;
        if ($foto_nome) {
            $_SESSION['foto'] = $foto_nome;
        }
        $stmt->close();
        $conn->close();

        // Redirecionar para a mesma página com sucesso
        header("Location: perfil.php?sucesso=1");
        exit();
    } else {
        die("Erro ao atualizar: " . $stmt->error);
    }
}

// Se não for POST, exibir o formulário com dados atuais

if ($tipo === 'aluno') {
    $sql = "SELECT nome, email, data_nascimento, telefone, genero, foto FROM aluno WHERE id_aluno = ?";
} else {
    $sql = "SELECT nome, email, data_nascimento, telefone, genero, foto FROM professor WHERE id_professor = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Usuário não encontrado.");
}

$usuario = $result->fetch_assoc();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil</title>
    <link rel="stylesheet" href="estilo.css">
    <style>
      .foto-perfil {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        display: block;
        margin-bottom: 15px;
      }
    </style>
</head>
<body>

<div id="header">
  <div class="header-esquerda">
    <a href="index.php">EzClass</a>
    <img src="imagens/livroslogo3.png" alt="Icone do canto" width="6%" />
  </div>
</div>

<section class="cadastro-alunos">
  <div class="cadastro-box">
    <h2>Meu Perfil</h2>

    <?php if (isset($_GET['sucesso'])): ?>
      <p style="color:green;">Perfil atualizado com sucesso!</p>
    <?php endif; ?>

    <form action="perfil.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="tipo_usuario" value="<?php echo htmlspecialchars($tipo); ?>">

      <label for="nome">Nome completo</label>
      <input type="text" id="nome" name="nome" required value="<?php echo htmlspecialchars($usuario['nome']); ?>">

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($usuario['email']); ?>">

      <label for="data_nascimento">Data de Nascimento</label>
      <input type="date" id="data_nascimento" name="data_nascimento" required value="<?php echo htmlspecialchars($usuario['data_nascimento']); ?>">

      <label for="telefone">Telefone</label>
      <input type="tel" id="telefone" name="telefone" value="<?php echo htmlspecialchars($usuario['telefone']); ?>">

      <label for="genero">Gênero</label>
      <select id="genero" name="genero">
        <option value="" <?php if($usuario['genero'] == '') echo 'selected'; ?>>Selecione...</option>
        <option value="M" <?php if($usuario['genero'] == 'M') echo 'selected'; ?>>Masculino</option>
        <option value="F" <?php if($usuario['genero'] == 'F') echo 'selected'; ?>>Feminino</option>
        <option value="Outro" <?php if(strtolower($usuario['genero']) == 'outro') echo 'selected'; ?>>Outro</option>
        <option value="prefiro_nao_informar" <?php if($usuario['genero'] == 'prefiro_nao_informar') echo 'selected'; ?>>Prefiro não informar</option>
      </select>

      <label>Foto Atual</label><br>
      <?php if ($usuario['foto']): ?>
        <img src="uploads/<?php echo htmlspecialchars($usuario['foto']); ?>" alt="Foto de Perfil" class="foto-perfil">
      <?php else: ?>
        <img src="imagens/default-user.png" alt="Foto padrão" class="foto-perfil">
      <?php endif; ?>

      <label for="foto">Alterar Foto de Perfil</label>
      <input type="file" id="foto" name="foto" accept="image/*">

      <button type="submit">Salvar Alterações</button>
    </form>
  </div>
</section>

</body>
</html>
