<?php
session_start();
include_once 'conexao.php';

// BUSCA DAS MATÉRIAS PARA A BARRA
$sql_materias = "SELECT * FROM materia";
$result_materias = $conn->query($sql_materias);

// PEGA O ID DA MATÉRIA SELECIONADA
$id_materia = $_GET['id_materia'] ?? '';

// BUSCA PROFESSORES
$sql_professores = "
    SELECT p.id_professor, p.nome, p.foto, p.valor_hora, m.nome AS materia
    FROM professor p
    LEFT JOIN materia m ON p.especialidade = m.id_materia
";
if (!empty($id_materia)) {
    $sql_professores .= " WHERE p.especialidade = " . intval($id_materia);
}
$result_professores = $conn->query($sql_professores);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Professores - EzClass</title>
    <link rel="stylesheet" href="estilo.css" />
</head>
<body>

<div id="header">
    <div class="header-esquerda">
        <a href="index.php">EzClass</a>
        <img src="imagens/livroslogo3.png" alt="Icone" width="6%" />
    </div>
    <div class="header-direita">
        <?php if(isset($_SESSION['nome'])): ?>
            <img src="<?php echo htmlspecialchars($_SESSION['foto'] ?? 'uploads/default-user.png'); ?>" class="foto-perfil" />
            <span>Olá, <?php echo htmlspecialchars($_SESSION['nome']); ?></span> |
            <a href="perfil.php">Perfil</a> |
            <a href="logout.php">Sair</a>
        <?php else: ?>
            <a href="login.php">Conectar</a>
            <a href="cadastro.php">Sou aluno</a>
            <a href="cadastroprofessor.php">Seja um professor</a>
        <?php endif; ?>
    </div>
</div>


<div class="rolagem">
    <button class="botoes-rolagem" onclick="Rolagem(-200)">&#8249;</button>
    <div class="container-materias">
        <div class="materias" id="materiasBarra">
            <?php
            if ($result_materias->num_rows > 0):
                while($mat = $result_materias->fetch_assoc()):
                    $ativo = ($id_materia == $mat['id_materia']) ? ' style="border:2px solid #fff;"' : '';
            ?>
            <div class="materia" data-id="<?php echo $mat['id_materia']; ?>" <?php echo $ativo; ?>>
                <?php if(!empty($mat['icone'])): ?>
                    <img src="<?php echo htmlspecialchars($mat['icone']); ?>" alt="<?php echo htmlspecialchars($mat['nome']); ?>" />
                <?php endif; ?>
                <?php echo htmlspecialchars($mat['nome']); ?>
            </div>
            <?php
                endwhile;
            endif;
            ?>
        </div>
    </div>
    <button class="botoes-rolagem" onclick="Rolagem(200)">&#8250;</button>
</div>

<!-- PROFESSORES -->
<div id="professores">
    <div class="destaques">
        <h1>Professores desta matéria</h1>
        <div class="todos-professores" id="professores-container">
            <?php
            if($result_professores->num_rows > 0):
                while($prof = $result_professores->fetch_assoc()):
            ?>
            <div class="modelo-prof">
                <div class="foto-prof">
                    <img src="<?php echo htmlspecialchars($prof['foto'] ?? 'uploads/default-user.png'); ?>" alt="<?php echo htmlspecialchars($prof['nome']); ?>" />
                    <div class="nome-professor">
                        <h3><?php echo htmlspecialchars($prof['nome']); ?></h3>
                        <img src="imagens/estrelas.png" alt="estrelas" />
                    </div>
                    <div class="overlay-professor">
                        <a href="perfil.php?id=<?php echo $prof['id_professor']; ?>" class="botao-contratar">Ver perfil</a>
                    </div>
                </div>
                <div class="descricao-prof">
                    <h4><?php echo htmlspecialchars($prof['materia'] ?? 'Sem matéria'); ?></h4>
                    <p>R$<?php echo number_format($prof['valor_hora'],2,',','.'); ?>/H</p>
                </div>
            </div>
            <?php
                endwhile;
            else:
                echo "<p>Nenhum professor encontrado para esta matéria.</p>";
            endif;
            ?>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class="rodape">
    <div class="voltar-topo"><a href="#header">Voltar ao topo</a></div>
</footer>

<script src="scripts.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const materias = document.querySelectorAll('.materia');
    materias.forEach(m => {
        m.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            window.location.href = "professores.php?id_materia=" + id;
        });
    });
});
</script>
</body>
</html>
