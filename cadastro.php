    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Aluno</title>
        <link rel="stylesheet" href="estilo.css">
    </head>
    <body>

        <div id="header"> <!-- INICIO DO HEADER-->
            <div class="header-esquerda">
                <a href="index.php">EzClass</a>
                <img src="imagens/livroslogo3.png" alt="Icone do canto" width="6%" />
            </div>
        </div> <!-- FIM DO HEADER -->


        <div class="cadastro-alunos">  <!-- INICIO DO CADASTRO -->
            <div class="cadastro-box">
                <h2>Cadastro de Aluno</h2>
                <form action="salvar_cadastro_aluno.php" method="POST" enctype="multipart/form-data">
                    
                    <label for="nome">Nome completo</label>
                    <input type="text" id="nome" name="nome" required>

                    <label for="foto">Foto de perfil</label>
                    <input type="file" id="foto" name="foto" accept="image/*">


                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>

                    <label for="data_nascimento">Data de Nascimento</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" required>

                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" placeholder="(99) 99999-9999">

                    <label for="genero">Gênero</label>
                    <select id="genero" name="genero">
                    <option value="">Selecione...</option>
                    <option value="F">Feminino</option>
                    <option value="Outro">Outro</option>
                    <option value="prefiro_nao_informar">Prefiro não informar</option>
                    </select>

                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required>

                    <label for="confirmar_senha">Confirmar Senha</label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha" required>

                    <button type="submit">Cadastrar</button>
                </form>
            </div>
        </div> <!-- FIM DO CADASTRO -->

    <script src="scripts.js"></script>
    </body>
    </html>
