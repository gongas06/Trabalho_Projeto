<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Recuperar Palavra-Passe | ADPB</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body class="login-body">

  <form action="enviar_recuperacao.php" method="POST" class="form-login">
    <h2>Recuperar Palavra-Passe</h2>
    <p>Insere o teu e-mail registado. Enviaremos um link para redefinir a tua palavra-passe.</p>
    <input type="email" name="email" placeholder="O teu e-mail" required>
    <button type="submit">Enviar Link</button>
    <a href="login.php">Voltar ao login</a>
  </form>

</body>
</html>
