<?php
include_once 'conexao.php';

$sql_materias = "SELECT id_materia, nome FROM materia";
$result_materias = $conn->query($sql_materias);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Professor | EzClass</title>
    <link rel="stylesheet" href="estilo.css?v=<?php echo time(); ?>"> <!-- evita cache -->
</head>
<body>

  <!-- HEADER -->
  <div id="header">
    <div class="header-esquerda">
      <a href="index.php">EzClass</a>
      <img src="imagens/livroslogo3.png" alt="Icone do canto" width="6%" />
    </div>

    <div id="tema-react"></div>
    <script type="module" src="react/dist/assets/index-CaPnliW6.js"></script>
  </div>

  <!-- CONTEÚDO PRINCIPAL -->
  <div class="cadastro-alunos">
    <div class="cadastro-box">
      <h2>Cadastro de Professor</h2>

      <form action="salvar_cadastro_professor.php" method="POST" enctype="multipart/form-data">
        <label for="nome">Nome completo</label>
        <input type="text" id="nome" name="nome" required>

        <label for="foto">Foto de perfil</label>
        <input type="file" id="foto" name="foto" accept="image/*">

        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" required>

        <label for="data_nascimento">Data de Nascimento</label>
        <input type="date" id="data_nascimento" name="data_nascimento" required>

        <label for="telefone">Telefone</label>
        <input type="tel" id="telefone" name="telefone" placeholder="(99) 99999-9999" required>

        <label for="genero">Gênero</label>
        <select id="genero" name="genero" required>
          <option value="">Selecione...</option>
          <option value="M">Masculino</option>
          <option value="F">Feminino</option>
          <option value="Outro">Outro</option>
        </select>

        <label for="materia">Matéria</label>
        <select id="materia" name="materia" required>
          <option value="">Selecione a matéria</option>
          <?php
          if ($result_materias->num_rows > 0) {
              while ($row = $result_materias->fetch_assoc()) {
                  echo '<option value="' . $row['id_materia'] . '">' . htmlspecialchars($row['nome']) . '</option>';
              }
          } else {
              echo '<option value="">Nenhuma matéria encontrada</option>';
          }
          ?>
        </select>

        <label for="formacao">Formação Acadêmica</label>
        <textarea id="formacao" name="formacao" rows="4" placeholder="Descreva sua formação acadêmica" required></textarea>

        <label for="valor_hora">Valor/Hora (R$)</label>
        <input type="number" id="valor_hora" name="valor_hora" step="0.01" min="0" value="200" required>

        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" required>

        <label for="confirmar_senha">Confirmar Senha</label>
        <input type="password" id="confirmar_senha" name="confirmar_senha" required>

        <button type="submit">Cadastrar</button>
      </form>
    </div>
  </div>

  <script src="scripts.js"></script>
</body>
</html>
