<?php
session_start();
include_once 'conexao.php';

if (!isset($_SESSION['id_aluno'])) {
  header("Location: login.php");
  exit;
}

if (!isset($_GET['id_professor']) || empty($_GET['id_professor'])) {
  header("Location: index.php");
  exit;
}

$id_professor = (int) $_GET['id_professor'];
$id_aluno = $_SESSION['id_aluno'];

// BUSCA PROFESSOR
$sql = "SELECT p.*, m.nome AS materia_nome 
        FROM professor p 
        LEFT JOIN materia m ON p.especialidade = m.id_materia 
        WHERE p.id_professor = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$prof = $stmt->get_result()->fetch_assoc();

// BUSCA ALUNO
$stmt2 = $conn->prepare("SELECT nome, email, telefone FROM aluno WHERE id_aluno = ?");
$stmt2->bind_param("i", $id_aluno);
$stmt2->execute();
$aluno = $stmt2->get_result()->fetch_assoc();

function formato_moeda($v) {
  return number_format((float)$v, 2, ',', '.');
}

$foto_path = $prof['foto'] ? htmlspecialchars($prof['foto']) : 'uploads/default-user.png';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Resumo da Contratação - EzClass</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

:root {
  --azul-1: #5a7eb9;
  --azul-2: #12357a;
  --dourado: #ebc867;
  --verde: #58be6e;
}

/* ===== FUNDO ===== */
body {
  margin: 0;
  font-family: 'Poppins', sans-serif;
  font-weight: 550;
}

.page-bg {
  min-height: 100vh;
  background: linear-gradient(180deg, #f7f9ff 0%, #edf1ff 100%);
  padding-bottom: 80px;
  display: flex;
  flex-direction: column;
  align-items: center;
}
body.modo-escuro .page-bg {
  background: linear-gradient(180deg, #0f0f0f 0%, #1a1a1a 100%);
}

#header {
  padding: 10px 30px;
  background: linear-gradient(to bottom, #5a7eb9, #12357a);
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 3px 12px rgba(0,0,0,0.1);
}

body.modo-escuro #header {
  background: linear-gradient(to bottom, #202020, #1c1c1cff);
  box-shadow: 0 3px 10px rgba(0,0,0,0.4);
}

.header-esquerda a {
  font-size: 1.8em;
  color: #fff;
  text-decoration: none;
  font-weight: 700;
}

.header-esquerda img {
  width: 45px;
  position: relative;
  top: 5px;
  left: 8px;
}

body.modo-escuro #header {
  background: linear-gradient(to bottom, #202020, #0d0d0d);
  border-bottom: 8px solid #222;
}

/* ===== VOLTAR ===== */
.voltar-area {
  width: 100%;
  max-width: 1100px;
  margin: 20px auto 0;
  padding: 0 20px;
}
.voltar-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  background: linear-gradient(135deg, #1e3a8a, #2a5298);
  color: #fff;
  font-weight: 600;
  border-radius: 30px;
  padding: 10px 18px;
  text-decoration: none;
  box-shadow: 0 4px 10px rgba(30,58,138,.25);
  transition: all 0.3s ease;
}
.voltar-btn:hover { transform: translateY(-2px); opacity: 0.9; }
body.modo-escuro .voltar-btn {
  background: linear-gradient(135deg, #49a642, #58be6e);
  color: #0d0d0d;
}

.resumo-container {
  max-width: 700px;
  width: 90%;
  margin-top: 30px;
  background: rgba(255,255,255,0.7);
  border-radius: 20px;
  padding: 35px 45px;
  -webkit-backdrop-filter: blur(12px);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255,255,255,0.5);
  box-shadow: 0 20px 50px rgba(0,0,0,0.08);
}
body.modo-escuro .resumo-container {
  background: rgba(45, 45, 45, 0.7);
  border-color: rgba(255,255,255,0.08);
  box-shadow: 0 20px 50px rgba(0,0,0,0.4);
}

h1 {
  text-align: center;
  margin-bottom: 35px;
  font-size: 2rem;
  color: var(--azul-2);
}
body.modo-escuro h1 { color: var(--verde); }

.section {
  background: rgba(255,255,255,0.8);
  border-radius: 14px;
  padding: 20px 25px;
  margin-bottom: 25px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.06);
  border-left: 4px solid var(--dourado);
}
body.modo-escuro .section {
  background: rgba(28,28,28,0.75);
  border-left-color: var(--verde);
  box-shadow: 0 8px 22px rgba(0,0,0,0.4);
}

.section h2 {
  margin-top: 0;
  font-size: 1.25rem;
  margin-bottom: 12px;
  color: var(--azul-2);
  display: flex;
  align-items: center;
  gap: 8px;
}
body.modo-escuro .section h2 { color: var(--verde); }

.section p {
  margin: 6px 0;
  line-height: 1.6;
  color: #333;
  font-weight: 500;
}
body.modo-escuro .section p { color: #ddd; }

.professor-foto {
  width: 120px;
  height: 120px;
  border-radius: 12px;
  object-fit: cover;
  margin-bottom: 12px;
  box-shadow: 0 8px 18px rgba(0,0,0,0.15);
}

form label {
  display: block;
  margin-top: 12px;
  font-weight: 600;
}
form input, form select {
  width: 100%;
  padding: 10px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-family: 'Poppins', sans-serif;
  transition: 0.3s;
}
form input:focus, form select:focus {
  border-color: var(--azul-1);
  outline: none;
}
body.modo-escuro form input,
body.modo-escuro form select {
  background: #1e1e1e;
  color: #f1f1f1;
  border-color: #333;
}

button {
  width: 100%;
  padding: 14px;
  margin-top: 30px;
  background: linear-gradient(135deg, #ffb347, #ffcc33);
  border: none;
  color: #1b1b1b;
  border-radius: 30px;
  font-weight: 800;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 8px 20px rgba(255, 190, 50, .45);
}
button:hover {
  transform: translateY(-2px);
  filter: brightness(0.98);
  box-shadow: 0 12px 28px rgba(255, 190, 50, .55);
}
body.modo-escuro button {
  background: linear-gradient(135deg, #49a642, #58be6e);
  color: #0d0d0d;
  box-shadow: 0 8px 18px rgba(88, 190, 110, .3);
}
</style>
</head>
<body>

<div id="header">
  <div class="header-esquerda">
      <a href="index.php">EzClass</a>
      <img src="imagens/livroslogo3.png" alt="Icone do canto" width="6%" />
  </div>

  <div id="tema-react"></div>
  <script type="module" src="react/dist/assets/index-CaPnliW6.js"></script>
</div>

<div class="page-bg">
  <div class="voltar-area">
    <a href="professor_detalhes.php?id=<?= $id_professor ?>" class="voltar-btn">← Voltar</a>
  </div>

  <div class="resumo-container">
    <h1>Resumo da Contratação</h1>

    <div class="section">
      <h2>👩‍🏫 Professor</h2>
      <img src="<?= $foto_path ?>" alt="Foto do Professor" class="professor-foto">
      <p><strong>Nome:</strong> <?= htmlspecialchars($prof['nome']) ?></p>
      <p><strong>Matéria:</strong> <?= htmlspecialchars($prof['materia_nome'] ?? 'Não informada') ?></p>
      <p><strong>Valor/hora:</strong> R$ <?= formato_moeda($prof['valor_hora']) ?></p>
    </div>

    <div class="section">
      <h2>🧍‍♀️ Seus Dados</h2>
      <p><strong>Nome:</strong> <?= htmlspecialchars($aluno['nome']) ?></p>
      <p><strong>E-mail:</strong> <?= htmlspecialchars($aluno['email']) ?></p>
      <p><strong>Telefone:</strong> <?= htmlspecialchars($aluno['telefone'] ?? '—') ?></p>
    </div>

    <div class="section">
      <h2>📅 Detalhes da Aula</h2>
      <form action="contratar.php" method="post">
        <input type="hidden" name="id_professor" value="<?= $id_professor ?>">

        <label>Data da aula:</label>
        <input type="date" name="data_aula" required>

        <label>Horário:</label>
        <input type="time" name="horario" required>

        <label>Forma de pagamento:</label>
        <select name="metodo_pagamento" required>
          <option value="pix">PIX</option>
          <option value="cartão">Cartão</option>
          <option value="boleto">Boleto</option>
        </select>

        <button type="submit">Confirmar Contratação</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>
