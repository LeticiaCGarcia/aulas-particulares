<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | EzClass</title>
  <link rel="stylesheet" href="estilo.css" />
  <style>
    :root {
      --azul-1: #5a7eb9;
      --azul-2: #12357a;
      --verde: #58be6e;
      --dourado: #ebc867;
    }

    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background: linear-gradient(rgba(255,255,255,0.65), rgba(255,255,255,0.65)),
                  url('imagens/back03.png') center/cover no-repeat fixed;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      transition: background 0.4s ease;
    }

    body.modo-escuro {
      background: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)),
                  url('imagens/fundoescuro.png') center/cover no-repeat fixed;
    }

    /* HEADER */
    #header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      background: linear-gradient(to bottom, var(--azul-1), var(--azul-2));
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      padding: 15px 50px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #ddd;
      z-index: 10;
    }

    .header-esquerda {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .header-esquerda a {
      font-size: 2em;
      color: #fff;
      text-decoration: none;
      font-weight: 700;
      text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.4);
    }

    .header-esquerda img {
      height: 38px;
      margin-top: -19px;
      margin-right: 10px;
    }

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
      border-color: var(--verde);
      color: var(--verde);
      box-shadow: 0 0 10px rgba(88, 190, 110, 0.3);
    }

    body.modo-escuro #tema-react .botao-tema:hover {
      color: #ffffff;
      border-color: #ffffff;
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.45);
    }

    .login-container {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(8px);
      padding: 45px 40px;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
      max-width: 420px;
      width: 90%;
      margin-top: 90px;
      text-align: center;
    }

    .login-container h2 {
      color: var(--azul-2);
      font-size: 1.7em;
      margin-bottom: 25px;
    }

    .login-container label {
      display: block;
      margin-bottom: 6px;
      text-align: left;
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
      transition: border-color 0.3s, box-shadow 0.3s;
    }

    .login-container input:focus {
      border-color: var(--azul-1);
      box-shadow: 0 0 0 3px rgba(90, 126, 185, 0.2);
      outline: none;
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
      color: var(--azul-2);
      font-weight: 700;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .login-container p a:hover {
      color: var(--dourado);
    }


    body.modo-escuro .login-container label {
  color: #f1f1f1; 
}

    body.modo-escuro .login-container {
      background: rgba(46, 46, 46, 0.9);
      color: #e5e5e5;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
    }

    body.modo-escuro .login-container h2 {
      color: #58be6e;
    }

    body.modo-escuro .login-container input {
      background: #1a1a1a;
      border: 1px solid #494949ff;
      color: #e5e5e5;
    }

    body.modo-escuro .login-container button {
      background: linear-gradient(135deg, #46ac33, #305b25);
      color: #0d0d0d;
      font-weight: 800;
    }

    body.modo-escuro .login-container p a {
      color: #83de6a;
    }

    body.modo-escuro .login-container p a:hover {
      color: #ffffff;
    }
  </style>
</head>
<body>

  <div id="header">
    <div class="header-esquerda">
      <a href="index.php">EzClass</a>
      <img src="imagens/livroslogo3.png" alt="Icone do canto" />
    </div>
    <div id="tema-react"></div>
    <script type="module" src="react/dist/assets/index-CaPnliW6.js"></script>
  </div>

  <div class="login-container" role="main" aria-labelledby="login-title">
    <h2 id="login-title">Entrar na sua conta</h2>
    <form action="verifica_login.php" method="POST">
      <label for="email">E-mail</label>
      <input type="email" id="email" name="email" required autocomplete="email" />
      
      <label for="senha">Senha</label>
      <input type="password" id="senha" name="senha" required autocomplete="current-password" />
      
      <button type="submit">Entrar</button>
    </form>
    <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a></p>
  </div>

</body>
</html>
