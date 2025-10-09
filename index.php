<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EzClass</title>
    <link rel="stylesheet" type="text/css" href="estilo.css" />
</head>
<body>
<?php
session_start();
include_once 'conexao.php';


// PARA BUSCAR OS PROFESSORES E MATÉRIAS
$sql_materias = "SELECT * FROM materia";
$result_materias = $conn->query($sql_materias);


$sql_professores = "SELECT p.id_professor, p.nome, p.foto, p.valor_hora, p.especialidade, m.nome AS materia
                    FROM professor p
                    LEFT JOIN materia m ON p.especialidade = m.id_materia";
$result_professores = $conn->query($sql_professores);
?>



<div id="header"> <!-- INICIO DO HEADER-->
    <div class="header-esquerda">
        <a href="index.php">EzClass</a>
        <img src="imagens/livroslogo3.png" alt="Icone do canto" width="6%" />
    </div>

    <div class="header-direita">
        <?php if (isset($_SESSION['nome'])): ?>
            <img src="<?php echo htmlspecialchars($_SESSION['foto'] ?? 'uploads/default-user.png'); ?>" alt="Foto de perfil" class="foto-perfil" />
            <span>Olá, <?php echo htmlspecialchars($_SESSION['nome']); ?></span> |
            <a href="perfil.php">Perfil</a> |
            <a href="logout.php">Sair</a>
        <?php else: ?>
            <a href="login.php">Conectar</a>
            <a href="cadastro.php">Sou aluno (Novo!)</a>
            <a href="cadastroprofessor.php">Seja um professor</a>
        <?php endif; ?>
    </div>
</div> <!-- FIM DO HEADER -->

<div id="principal">  <!-- INICIO DO PRINCIPAL -->
    <section class="fundo-azul">
        <div class="nome-principal">
            <h1>Encontre seu professor ideal!</h1>
        </div>

        <div class="busca-principal">
            <input type="text" id="pesquisa-principal" placeholder='Busque "Inglês"' />
            <button class="botao-busca-principal">Buscar</button>
        </div>

        <!-- TROCA OS NOMES DA BARRA -->
       <div class="rolagem">
    <button class="botoes-rolagem" onclick="Rolagem(-200)">&#8249;</button>

    <div class="container-materias">
        <div class="materias" id="materiasBarra">
            <?php
            if ($result_materias->num_rows > 0):
                while ($mat = $result_materias->fetch_assoc()):
                    // Verifica se a matéria está selecionada para destacar
                    $ativo = (isset($_GET['id_materia']) && $_GET['id_materia'] == $mat['id_materia']) ? ' style="border:2px solid #fff;"' : '';
            ?>
                <div class="materia" data-id="<?php echo $mat['id_materia']; ?>" <?php echo $ativo; ?>>
                    <?php if (!empty($mat['icone'])): ?>
                        <img src="<?php echo htmlspecialchars($mat['icone']); ?>" alt="<?php echo htmlspecialchars($mat['nome']); ?>" />
                    <?php endif; ?>
                    <?php echo htmlspecialchars($mat['nome']); ?>
                </div>
            <?php
                endwhile;
            else:
                echo "<div class='materia'>Nenhuma matéria cadastrada</div>";
            endif;
            ?>
        </div>
    </div>

    <button class="botoes-rolagem" onclick="Rolagem(200)">&#8250;</button>
</div>

        <!-- LEVA PARA A PÁGINA PROFESSORES, SÓ FUNCIONOU NESSE ARQUIVO N SEI PQ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const materias = document.querySelectorAll('.materia');
    materias.forEach(materia => {
        materia.addEventListener('click', function() {
            const idMateria = this.getAttribute('data-id');
            window.location.href = "professores.php?id_materia=" + idMateria;
        });
    });
});
</script>


    </section>
</div>  <!-- FIM DO PRINCIPAL -->

<div id="professores">  <!-- COMEÇO DOS PROFESSORES -->
    <div class="destaques">
        <h1 class="destaques-semana">Destaques da semana!</h1>
        <img class="destaques-icone" src="imagens/destaques2.png" alt="destaques" />

        <div class="todos-professores" id="professores-container">
    <?php
    if ($result_professores->num_rows > 0):
        while ($prof = $result_professores->fetch_assoc()):
    ?>
        <div class="modelo-prof" 
             data-nome="<?php echo strtolower($prof['nome']); ?>" 
             data-materia="<?php echo strtolower($prof['materia'] ?? ''); ?>" 
             data-materia-id="<?php echo $prof['especialidade']; ?>">
            <div class="foto-prof">
                <img src="<?php echo htmlspecialchars($prof['foto'] ?? 'uploads/default-user.png'); ?>" alt="<?php echo htmlspecialchars($prof['nome']); ?>" />
                <div class="nome-professor">
                    <h3><?php echo htmlspecialchars($prof['nome']); ?></h3>
                    <img src="imagens/estrelas.png" alt="estrelas" />
                </div>

                <div class="overlay-professor">
                    <a href="professor_detalhes.php?id=<?php echo $prof['id_professor']; ?>" class="botao-contratar">Contratar</a>
                </div>
            </div>
            <div class="descricao-prof">
                <h4><?php echo htmlspecialchars($prof['materia'] ?? 'Sem matéria'); ?></h4>
                <p>R$<?php echo number_format($prof['valor_hora'], 2, ',', '.'); ?>/H</p>
            </div>
        </div>
    <?php
        endwhile;
    else:
        echo "<p>Nenhum professor cadastrado.</p>";
    endif;
    ?>
</div>

<script>
function contratarProfessor(id) {
    alert("Você selecionou o professor ID: " + id);
}
</script>
        </div> <!-- fim todos-professores -->
    </div> <!-- fim destaques da semana -->
</div>



<div class="borda-cinza">
    <h1>Como Funciona?</h1>
    <div class="container-como-funciona">
        <div class="item-como-funciona">
            <img src="imagens/procure.png" alt="Procure e Contate" />
            <h3>Procure e Contate</h3>
            <p>Procure o professor ideal e entre em contato com o perfil escolhido de acordo com os seus critérios.</p>
        </div>

        <div class="item-como-funciona">
            <img src="imagens/agende.png" alt="Agende" />
            <h3>Agende</h3>
            <p>Em poucos cliques, faça sua solicitação, receba o contato do professor e combine o melhor horário.</p>
        </div>

        <div class="item-como-funciona">
            <img src="imagens/conquiste.png" alt="Aprenda e Conquiste" />
            <h3>Aprenda e Conquiste</h3>
            <p>Aprenda o que quiser de onde estiver. Conquiste os melhores resultados com professores de excelência!</p>
        </div>
    </div>
</div>



<footer class="rodape">      <!-- INICIO DO RODAPÉ -->
    <div class="voltar-topo">
        <a href="#header">Voltar ao topo</a>
    </div>

    <div class="rodape-links">
        <div class="coluna">
            <h4>Matérias</h4>
            <a href="">Línguas</a>
            <a href="">Informática</a>
            <a href="">Reforço escolar</a>
            <a href="">Artes e Lazer</a>
            <a href="">Esportes e dança</a>
            <a href="">Música</a>
        </div>

        <div class="coluna">
            <h4>Sobre Nós</h4>
            <a href="#">Quem Somos</a>
            <a href="#">Nossa Missão</a>
            <a href="">Acessibildiade</a>
        </div>

        <div class="coluna">
            <h4>Ajuda</h4>
            <a href="#">Central de Atendimento</a>
            <a href="#">Perguntas Frequentes</a>
            <a href="#">Política de Privacidade</a>
        </div>

        <div class="coluna">
            <h4>Serviços</h4>
            <a href="#">Seja um Professor</a>
            <a href="#">Cadastro de Alunos</a>
            <a href="#">Planos e Preços</a>
        </div>

        <div class="coluna redes-sociais">
            <h4>Conecte-se</h4>
            <div class="icones-redes">
                <a href="#">
                    <img src="imagens/insta.png" alt="Instagram" width="9%">
                </a>
                <a href="#">
                    <img src="imagens/linkedin.png" alt="LinkedIn" width="9%">
                </a>
                <a href="#">
                    <img src="imagens/facebook.png" alt="Facebook" width="9%">
                </a>
            </div>
        </div>
    </div>

    <div class="rodape-final">
        <p>&copy; 2025 EzClass - Todos os direitos reservados.</p>
    </div>
</footer>
<!-- FIM DO RODAPÉ -->

<script src="scripts.js"></script>
</body>
</html>
