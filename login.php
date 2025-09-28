<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login | EzClass</title>
    <link rel="stylesheet" href="estilo.css"> <!-- Reaproveitando seu estilo -->
</head>
<body>

    <!-- HEADER igual ao da página principal -->
    <div id="header">
        <div class="header-esquerda">
            <a href="index.php">EzClass</a>
            <img src="imagens/livroslogo3.png" alt="Icone do canto" width="6%" />
        </div>
    </div>

    <!-- CONTAINER DE LOGIN -->
    <div class="cadastro-alunos"> <!-- Reaproveitando mesma estrutura do cadastro -->
        <div class="cadastro-box">
            <h2>Login</h2>
            <form action="verifica_login.php" method="POST">
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>

                <button type="submit">Entrar</button>
            </form>

            <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a></p>
        </div>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
