<?php
session_start();
include_once 'conexao.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: lista_professores.php");
    exit;
}

$id_professor = (int) $_GET['id'];

$sql = "SELECT p.*, m.nome AS materia_nome 
        FROM professor p 
        LEFT JOIN materia m ON p.especialidade = m.id_materia 
        WHERE p.id_professor = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$result = $stmt->get_result();
$prof = $result->fetch_assoc();

if (!$prof) {
    echo "<p>Professor não encontrado.</p>";
    exit;
}

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
<title><?= htmlspecialchars($prof['nome']) ?> - EzClass</title>

<link rel="stylesheet" href="estilo.css">

<style>
:root{
  --azul-1: #5a7eb9;
  --azul-2: #12357a;
  --dourado: #ebc867;
}

.page-bg {
  min-height: 100vh;
  background: linear-gradient(180deg, #f5f8ff 0%, #eef3ff 40%, #f7f9ff 100%);
  padding-bottom: 60px;
  padding-top: 30px;
}
body.modo-escuro .page-bg{
  background: linear-gradient(180deg, #272727ff 0%, #0e0e0eff 40%, #0e0e0eff 100%);
}


body.modo-escuro #header {
  background: linear-gradient(to bottom, #202020, #0d0d0d);
  border-bottom: 8px solid #222;
}

.voltar-area{
  max-width: 1100px;
  margin: 22px auto 0;
  padding: 0 16px;
}
.voltar-btn {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: linear-gradient(to right, #1e3a8a, #2a5298);
  color: #fff;
  text-decoration: none;
  font-weight: 700;
  padding: 11px 20px;
  border-radius: 28px;
  box-shadow: 0 6px 14px rgba(18,53,122,.22);
  transition: all 0.3s ease;
}
.voltar-btn:hover{
  transform: translateY(-1px);
  box-shadow: 0 10px 20px rgba(18,53,122,.28);
}
body.modo-escuro .voltar-btn{
  background: linear-gradient(135deg, #49a642, #58be6e);
  color: #0d0d0d;
}


.container-prof {
  max-width: 1100px;
  margin: 26px auto 0;
  padding: 0 16px;
}
.card-glass{
  display: grid;
  grid-template-columns: 300px 1fr;
  gap: 28px;
  padding: 28px;
  border-radius: 18px;
  background: rgba(255,255,255,0.65);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255,255,255,0.6);
  box-shadow: 0 18px 40px rgba(0,0,0,.08);
}
@media (max-width: 880px){
  .card-glass{ grid-template-columns: 1fr; }
}
body.modo-escuro .card-glass{
  background: rgba(18,18,18,0.7);
  border: 1px solid rgba(255,255,255,0.06);
  box-shadow: 0 18px 44px rgba(0,0,0,.36);
}

.foto-prof-detalhes img{
  width: 280px; height: 280px;
  border-radius: 16px;
  object-fit: cover;
  box-shadow: 0 10px 28px rgba(0,0,0,.2);
  transition: all .25s ease;
}
body.modo-escuro .foto-prof-detalhes img{
  border: 2px solid rgba(88,190,110,0.25);
}

.info-prof h1{
  font-size: 2.1rem;
  margin-bottom: 8px;
}
.chip{
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 12px;
  background: rgba(255,255,255,.7);
  border: 1px solid rgba(235,200,103,.4);
  border-radius: 10px;
  font-weight: 600;
}
body.modo-escuro .chip{
  background: rgba(32,32,32,.7);
  border-color: rgba(88,190,110,.25);
}

.valor{
  font-size: 1.35rem;
  font-weight: 800;
  color: #1e3a8a;
}
body.modo-escuro .valor{ color: #58be6e; }

.hr{
  height: 1px;
  background: linear-gradient(90deg, rgba(18,53,122,.15), rgba(0,0,0,0), rgba(18,53,122,.15));
  margin: 16px 0;
}
body.modo-escuro .hr{
  background: linear-gradient(90deg, rgba(88,190,110,.25), rgba(0,0,0,0), rgba(88,190,110,.25));
}

.descricao-bloco {
  background: rgba(255,255,255,0.75);
  border-radius: 14px;
  padding: 18px 22px;
  margin-top: 20px;
  border-left: 4px solid var(--dourado);
  box-shadow: 0 6px 18px rgba(0,0,0,0.07);
}
body.modo-escuro .descricao-bloco {
  background: rgba(28,28,28,0.75);
  border-left-color: #58be6e;
}

.btns{
  display: flex; gap: 12px; flex-wrap: wrap;
  margin-top: 20px;
}
.btn-contratar{
  padding: 13px 22px;
  border: none;
  border-radius: 30px;
  background: linear-gradient(135deg, #ffb347, #ffcc33);
  color: #1b1b1b;
  font-weight: 800;
  box-shadow: 0 10px 22px rgba(255,190,50,.45);
  text-decoration: none;
}
body.modo-escuro .btn-contratar{
  background: linear-gradient(135deg, #46ac33, #305b25);
  color: #0d0d0d;
}
.btn-sec{
  background: rgba(255,255,255,.75);
  border: 1px solid rgba(26,62,130,.18);
  color: #12357a;
  padding: 12px 18px;
  border-radius: 28px;
  text-decoration: none;
  font-weight: 700;
}
body.modo-escuro .btn-sec{
  background: rgba(36,36,36,.8);
  border-color: rgba(88,190,110,.25);
  color: #e5e5e5;
}

/* BOTÃO DO TEMA ESCURO */
#tema-react {
  position: absolute;
  top: 18px;
  right: 30px; 
  z-index: 10;
}

#tema-react .botao-tema {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  border: 2px solid rgba(255, 255, 255, 0.4);
  background: transparent;
  color: #ffffff;
  cursor: pointer;
  font-size: 19px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.35s ease;
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.15);
}

#tema-react .botao-tema:hover {
  color: #ffffff;
  border-color: #ffffff;
  box-shadow: 0 0 18px rgba(255, 255, 255, 0.4);
  transform: scale(1.05);
}

body.modo-escuro #tema-react .botao-tema {
  border-color: #58be6e;
  color: #58be6e;
  box-shadow: 0 0 10px rgba(88, 190, 110, 0.3);
}

body.modo-escuro #tema-react .botao-tema:hover {
  color: #ffffff;
  border-color: #ffffff;
  box-shadow: 0 0 20px rgba(255, 255, 255, 0.45);
  transform: scale(1.05);
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
    <a href="index.php" class="voltar-btn">← Voltar</a>
  </div>

  <div class="container-prof">
    <div class="card-glass">
      <div class="foto-prof-detalhes">
        <img src="<?= $foto_path ?>" alt="Foto de <?= htmlspecialchars($prof['nome']) ?>">
      </div>
      <div class="info-prof">
        <h1><?= htmlspecialchars($prof['nome']) ?></h1>
        <div class="info-sub">
          <span class="chip">Matéria: <strong><?= htmlspecialchars($prof['materia_nome'] ?? 'Não informada') ?></strong></span>
          <span class="chip">E-mail: <strong><?= htmlspecialchars($prof['email']) ?></strong></span>
          <span class="chip">Telefone: <strong><?= htmlspecialchars($prof['telefone'] ?? '—') ?></strong></span>
        </div>
        <div class="valor">R$ <?= formato_moeda($prof['valor_hora']) ?> / hora</div>
        <div class="hr"></div>
        <div class="descricao-bloco">
          <h2>Sobre o professor</h2>
          <?php if (!empty(trim($prof['formacao']))): ?>
            <p><?= nl2br(htmlspecialchars($prof['formacao'])) ?></p>
          <?php else: ?>
            <p>💬 Este professor ainda não adicionou uma biografia completa.</p>
          <?php endif; ?>
        </div>
        <div class="btns">
          <?php if (isset($_SESSION['id_aluno'])): ?>
            <a class="btn-contratar" href="resumo_contratacao.php?id_professor=<?= $prof['id_professor'] ?>">Contratar Professor</a>
          <?php else: ?>
            <a class="btn-sec" href="login.php">Faça login para contratar</a>
          <?php endif; ?>
          <a class="btn-sec" href="professores.php">Ver outros professores</a>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
