<?php

session_start();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    
    header("Location: lista_professores.php");
    exit;
}

$id_professor = (int) $_GET['id'];

include 'conexao.php';

$sql = "SELECT id_professor, nome, email, data_nascimento, telefone, genero, especialidade, formacao, valor_hora, foto
        FROM professor
        WHERE id_professor = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_professor);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$prof = mysqli_fetch_assoc($res);

if (!$prof) {
    echo "<p>Professor não encontrado.</p>";
    exit;
}

// BUSCA AS AVALIAÇÕES E A MÉDIA
$sql2 = "SELECT COUNT(*) AS qtd, AVG(nota) AS media FROM avaliacao WHERE id_professor = ?";
$stmt2 = mysqli_prepare($conn, $sql2);
mysqli_stmt_bind_param($stmt2, "i", $id_professor);
mysqli_stmt_execute($stmt2);
$res2 = mysqli_stmt_get_result($stmt2);
$av = mysqli_fetch_assoc($res2);
$qtd_av = (int)($av['qtd'] ?? 0);
$media_av = $av['media'] !== null ? round($av['media'], 1) : null;

function formato_moeda($v) {
    return number_format((float)$v, 2, ',', '.');
}

// FOTO
$foto_path = $prof['foto'] ? htmlspecialchars($prof['foto']) : 'assets/default_user.png';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Detalhes do Professor - <?= htmlspecialchars($prof['nome']) ?></title>


  <style>
    .prof-card { 
    max-width:900px;
    margin:30px auto;
    display:flex; gap:24px; align-items:flex-start; padding:20px; border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,0.06); background:#fff; }

    .prof-foto { width:220px; height:220px; border-radius:10px; overflow:hidden; flex:0 0 220px; background:#f3f3f3; display:flex; align-items:center; justify-content:center; }

    .prof-foto img { width:100%; height:100%; object-fit:cover; display:block; }

    .prof-info { flex:1; }

    .prof-nome { font-size:1.6rem; margin:0 0 6px 0; }

    .prof-meta { color:#666; margin-bottom:10px; }
    
    .valor { font-weight:700; font-size:1.2rem; margin-top:6px; }
    .btn-contratar { background:linear-gradient(90deg,#1f8ef1,#2cc6ff); color:#fff; border:none; padding:12px 18px; border-radius:10px; cursor:pointer; font-weight:600; }
    .btn-voltar { background:transparent; color:#333; border:1px solid #ddd; padding:8px 12px; border-radius:8px; cursor:pointer; margin-right:10px; }
    .descricao { white-space:pre-wrap; margin-top:12px; line-height:1.5; color:#333; }
    .info-row { display:flex; gap:12px; flex-wrap:wrap; margin-top:8px; }
    .chip { background:#f5f7fb; padding:6px 10px; border-radius:8px; color:#333; font-weight:600; }
    .rating { display:inline-block; margin-left:8px; color:#ffb400; font-weight:700; }
    .modal-backdrop { position:fixed; left:0; top:0; right:0; bottom:0; background:rgba(0,0,0,0.5); display:none; align-items:center; justify-content:center; z-index:1000; }
    .modal { background:#fff; padding:18px; border-radius:10px; width:90%; max-width:480px; box-shadow:0 10px 30px rgba(0,0,0,0.2); }
    .modal h3 { margin-top:0; }
    .modal .form-row { margin-bottom:10px; }
    .modal input, .modal select, .modal textarea { width:100%; padding:8px; border-radius:6px; border:1px solid #ddd; }
    .modal-actions { display:flex; justify-content:flex-end; gap:8px; margin-top:12px; }
  </style>
</head>
<body>
  <main class="container">
    <div style="max-width:1100px;margin:24px auto;padding:0 16px;">
      <a href="lista_professores.php" class="btn-voltar">← Voltar à lista</a>
    </div>

    <div class="prof-card" role="region" aria-label="Detalhes do professor">
      <div class="prof-foto">
        <img src="<?= htmlspecialchars($foto_path) ?>" alt="Foto de <?= htmlspecialchars($prof['nome']) ?>">
      </div>

      <div class="prof-info">
        <h1 class="prof-nome"><?= htmlspecialchars($prof['nome']) ?></h1>
        <div class="prof-meta">
          <span class="chip"><?= $prof['especialidade'] ? htmlspecialchars($prof['especialidade']) : 'Sem especialidade informada' ?></span>
          <span class="chip">Formação: <?= $prof['formacao'] ? htmlspecialchars(substr($prof['formacao'],0,80)) . (strlen($prof['formacao'])>80?'...':'') : 'Não informada' ?></span>
          <span class="chip">Contato: <?= $prof['telefone'] ? htmlspecialchars($prof['telefone']) : '—' ?></span>
          <span class="chip">E-mail: <?= $prof['email'] ? htmlspecialchars($prof['email']) : '—' ?></span>

          <span class="rating">
            <?= $media_av !== null ? "{$media_av} ★ ({$qtd_av})" : "Sem avaliações" ?>
          </span>
        </div>

        <div style="margin-top:8px;">
          <strong>Valor/hora:</strong>
          <span class="valor">R$ <?= formato_moeda($prof['valor_hora']) ?></span>
        </div>

        <div class="descricao" aria-live="polite">
          <h3>Sobre o professor</h3>
          <?php if ($prof['formacao']): ?>
            <div class="descricao"><?= nl2br(htmlspecialchars($prof['formacao'])) ?></div>
          <?php else: ?>
            <p class="descricao">O professor ainda não adicionou uma descrição completa.</p>
          <?php endif; ?>
        </div>

        <div style="margin-top:16px;">
          <?php if (isset($_SESSION['id_aluno'])): ?>
            <!-- Botão contrata apenas visível para alunos logados -->
            <button class="btn-contratar" id="abrirModalContratar" data-professor-id="<?= $prof['id_professor'] ?>">Contratar Professor</button>
          <?php else: ?>
            <a href="login.php" class="btn-contratar" style="text-decoration:none;display:inline-block;">Faça login para contratar</a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- modal de contratação -->
    <div class="modal-backdrop" id="modalBackdrop" role="dialog" aria-hidden="true">
      <div class="modal" role="document" aria-labelledby="modalTitle">
        <h3 id="modalTitle">Contratar <?= htmlspecialchars($prof['nome']) ?></h3>

        <!-- Formulário envia para contratar.php (o mesmo que expliquei antes) -->
        <form id="formContratarModal" method="post" action="contratar.php">
          <input type="hidden" name="id_professor" value="<?= $prof['id_professor'] ?>">

          <div class="form-row">
            <label>Escolha a data da aula</label>
            <input type="date" name="data_aula" required />
          </div>

          <div class="form-row">
            <label>Horário (HH:MM)</label>
            <input type="time" name="horario" required />
          </div>

          <div class="form-row">
            <label>Forma de pagamento</label>
            <select name="metodo_pagamento" required>
              <option value="pix">PIX</option>
              <option value="cartão">Cartão</option>
              <option value="boleto">Boleto</option>
            </select>
          </div>

          <div class="modal-actions">
            <button type="button" class="btn-voltar" id="fecharModal">Cancelar</button>
            <button type="submit" class="btn-contratar">Confirmar Contratação</button>
          </div>
        </form>
      </div>
    </div>

  </main>

  <script>
    // ABRE E FECHA O MODAL
    (function(){
      const btn = document.getElementById('abrirModalContratar');
      const modalBg = document.getElementById('modalBackdrop');
      const fechar = document.getElementById('fecharModal');

      if (btn) {
        btn.addEventListener('click', function(){
          modalBg.style.display = 'flex';
          modalBg.setAttribute('aria-hidden','false');
        });
      }

      if (fechar) {
        fechar.addEventListener('click', function(){
          modalBg.style.display = 'none';
          modalBg.setAttribute('aria-hidden','true');
        });
      }


      modalBg.addEventListener('click', function(e){
        if (e.target === modalBg) {
          modalBg.style.display = 'none';
          modalBg.setAttribute('aria-hidden','true');
        }
      });

    })();
  </script>

  <?php /* NÃO REMOVA: include footer se o seu projeto tiver um */ ?>
  <?php /* exemplo: include 'footer.php'; */ ?>
</body>
</html>
