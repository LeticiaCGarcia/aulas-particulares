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
                        <div class="materia"><img src="imagens/icones-barra/inglaterra.png" alt="Inglaterra" />Inglês</div>
                        <div class="materia"><img src="imagens/icones-barra/matematica.png" alt="Matematica" />Matemática</div>
                        <div class="materia"><img src="imagens/icones-barra/programacao.png" alt="Programacao" />Programação</div>
                        <div class="materia"><img src="imagens/icones-barra/franca.png" alt="Francês" />Francês</div>
                        <div class="materia"><img src="imagens/icones-barra/espanha.png" alt="Espanha" />Espanhol</div>
                        <div class="materia"><img src="imagens/icones-barra/russia.png" alt="Russia" />Russo</div>
                        <div class="materia"><img src="imagens/icones-barra/japao.png" alt="Japao" />Japonês</div>
                        <div class="materia"><img src="imagens/icones-barra/personal.png" alt="Personal" />Personal Trainer</div>
                        <div class="materia">Violino</div>
                        <div class="materia">Guitarra</div>
                        <div class="materia">Teclado</div>
                    </div>
                </div>

                <button class="botoes-rolagem" onclick="Rolagem(200)">&#8250;</button>
            </div>
        </section>
    </div>  <!-- FIM DO PRINCIPAL -->

    <div id="professores">  <!-- COMEÇO DOS PROFESSORES -->
        <div class="destaques">
            <h1 class="destaques-semana">Destaques da semana!</h1>
            <img class="destaques-icone" src="imagens/destaques2.png" alt="destaquess" />

            <div class="todos-professores">
                <!-- Cartão 1 - Messi -->
                <div class="modelo-prof">
                    <div class="foto-prof">
                        <img src="imagens/professores/mercia.jpeg" alt="Mercia" />
                        <div class="nome-professor">
                            <h3>Mércia</h3>
                            <img src="imagens/estrelas.png" alt="estrelas" />
                        </div>
                    </div>
                    <div class="descricao-prof">
                        <h4>Professora de Espanhol</h4>
                        <p>R$190/H</p>
                    </div>
                </div>

                <!-- Cartão 2 - Putin -->
                <div class="modelo-prof">
                    <div class="foto-prof">
                        <img src="imagens/professores/valeria2.jpeg" alt="Valeria" />
                        <div class="nome-professor">
                            <h3>Valéria</h3>
                            <img src="imagens/estrelas.png" alt="estrelas" />
                        </div>
                    </div>
                    <div class="descricao-prof">
                        <h4>Professora de Russo</h4>
                        <p>R$249/H</p>
                    </div>
                </div>

                <!-- Cartão 3 - Trump -->
                <div class="modelo-prof">
                    <div class="foto-prof">
                        <img src="imagens/professores/donizete.jpeg" alt="Donizete" />
                        <div class="nome-professor">
                            <h3>Donizete</h3>
                            <img src="imagens/estrelas.png" alt="estrelas" />
                        </div>
                    </div>
                    <div class="descricao-prof">
                        <h4>Professora de Inglês</h4>
                        <p>R$210/H</p>
                    </div>
                </div>

                <!-- Cartão 4 - Dilma -->
                <div class="modelo-prof">
                    <div class="foto-prof">
                        <img src="imagens/professores/dilmo2.jpeg" alt="dilmo" />
                        <div class="nome-professor">
                            <h3>Dante</h3>
                            <img src="imagens/estrelas.png" alt="estrelas" />
                        </div>
                    </div>
                    <div class="descricao-prof">
                        <h4>Professor de Python</h4>
                        <p>R$100/H</p>
                    </div>
                </div>

                <!-- Cartão 5 - Jacquin -->
                <div class="modelo-prof">
                    <div class="foto-prof">
                        <img src="imagens/professores/erica.jpeg" alt="jacquin" />
                        <div class="nome-professor">
                            <h3>Erica</h3>
                            <img src="imagens/estrelas.png" alt="estrelas" />
                        </div>
                    </div>
                    <div class="descricao-prof">
                        <h4>Professora de Francês</h4>
                        <p>R$180/H</p>
                    </div>
                </div>

                <!-- Cartão 6 - Cariani -->
                <div class="modelo-prof">
                    <div class="foto-prof">
                        <img src="imagens/professores/cariani.jpeg" alt="cariani" />
                        <div class="nome-professor">
                            <h3>Cariani</h3>
                            <img src="imagens/estrelas.png" alt="estrelas" />
                        </div>
                    </div>
                    <div class="descricao-prof">
                        <h4>Personal Trainer</h4>
                        <p>R$300/H</p>
                    </div>
                </div>
            </div> <!-- fim todos-professores -->
        </div> <!-- fim destaques da semana -->

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
