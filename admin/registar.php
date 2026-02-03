<!-- Página pública de registo de utilizadores. -->
<!doctype html>
<html lang="pt">
<head><meta charset="utf-8"><title>Registar | ADPB</title>
<link rel="stylesheet" href="../style.css"></head>
<body class="login-body">
  <div class="form-login">
    <h2>Criar Conta</h2>
    <form action="register_action.php" method="POST">
      <input name="username" required placeholder="Nome de utilizador">
      <input name="email" type="email" required placeholder="Email">
      <input name="password" type="password" required placeholder="Palavra-passe">
      <input name="password2" type="password" required placeholder="Confirmar palavra-passe">
      <button type="submit">Registar</button>
      <!-- Mensagens de feedback do registo -->
      <?php if (isset($_GET['success'])): ?>
    <div class="alert-success">Conta criada com sucesso!</div>
<?php endif; ?>

<?php if (isset($_GET['erro']) && $_GET['erro'] === "user_exists"): ?>
    <div class="alert-error">O nome de utilizador já está a ser utilizado.</div>
<?php endif; ?>

<?php if (isset($_GET['erro']) && $_GET['erro'] === "empty"): ?>
    <div class="alert-error">Preenche todos os campos.</div>
<?php endif; ?>

<?php if (isset($_GET['erro']) && $_GET['erro'] === "unknown"): ?>
    <div class="alert-error">Ocorreu um erro ao criar a conta.</div>
<?php endif; ?>

    </form>
    <a href="login.php">Voltar ao login</a>
  </div>
</body>
</html>
