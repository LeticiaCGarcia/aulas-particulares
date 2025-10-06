<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Login | EzClass</title>
    <link rel="stylesheet" href="estilo.css" />
    
<!-- CSS DA PÁGINA DE LOGIN ESTÁ APENAS AQUI, SEPARADO DO ARQUIVO DE CSS -->
    
    <style>
      .login-container {
        background-color: #ffffffcc; 
        padding: 40px 30px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        max-width: 400px;
        margin: 80px auto; 
      }

      .login-container h2 {
        text-align: center;
        color: #12357a;
        margin-bottom: 30px;
        font-size: 1.8em;
      }

      .login-container label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #333;
      }

      .login-container input {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 18px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 0.95em;
        box-sizing: border-box;
        transition: border 0.3s;
      }

      .login-container input:focus {
        border-color: #5a7eb9;
        outline: none;
        box-shadow: 0 0 0 3px rgba(90, 126, 185, 0.2);
      }

      .login-container button {
        width: 100%;
        background: linear-gradient(to right, #1e3a8a, #2a5298);
        color: white;
        padding: 14px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        font-size: 1em;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.2s;
      }

      .login-container button:hover {
        background: linear-gradient(to right, #1d3573, #25447d);
        transform: scale(1.02);
      }

      .login-container p {
        text-align: center;
        margin-top: 20px;
        font-weight: 500;
      }

      .login-container p a {
        color: #1e3a8a;
        font-weight: 700;
        text-decoration: none;
        transition: color 0.3s ease;
      }

      .login-container p a:hover {
        color: #e2bd58;
      }

     
      body {
        background: linear-gradient(rgba(255,255,255,0.65), rgba(255,255,255,0.65)),
                    url('imagens/back03.png') center/cover no-repeat fixed;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Poppins', sans-serif;
        margin: 0;
      }
    
      #header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to bottom, #5a7eb9, #12357a);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 15px 50px;
        display: flex;
        justify-content: flex-start;
        align-items: center;
        border-bottom: 1px solid #ddd;
        z-index: 10;
      }

      .header-esquerda a {
        font-size: 2em;
        color: #fff;
        text-decoration: none;
        font-weight: 700;
        margin-right: 15px;
        text-shadow: 2px 2px 6px rgba(0,0,0,0.4);
      }
      .header-esquerda img {
        height: 40px;
        vertical-align: middle;
        
      }
      
    </style>
</head>
<body>

  <div id="header">
    <div class="header-esquerda">
      <a href="index.php">EzClass</a>
      <img src="imagens/livroslogo3.png" alt="Icone do canto" />
    </div>
  </div>

  <div class="login-container" role="main" aria-labelledby="login-title">
    <h2 id="login-title">Login</h2>
    <form action="verifica_login.php" method="POST">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required autocomplete="email" />
      
      <label for="senha">Senha</label>
      <input type="password" id="senha" name="senha" required autocomplete="current-password" />
      
      <button type="submit">Entrar</button>
    </form>
    <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a></p>
  </div>

  <script src="scripts.js"></script>
</body>
</html>
