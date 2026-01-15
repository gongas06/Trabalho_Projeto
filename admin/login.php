<?php
require_once __DIR__ . '/db.php';
session_start();

$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    if (!empty($username) && !empty($pass)) {

        $stmt = $mysqli->prepare('SELECT id, username, password, role FROM utilizadores WHERE username = ? LIMIT 1');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($row = $res->fetch_assoc()) {

            if (password_verify($pass, $row['password'])) {

                // Sessão normal
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                if ($row['username'] === 'admin') {
                    $_SESSION['role'] = 'superadmin';
                } else {
                    $_SESSION['role'] = $row['role'] ?? 'user';
                }

                // Sessão temporária só para mostrar o toast
                $_SESSION['login_message'] = $row['username'];

                header('Location: ../index.php');
                exit();

            } else {
                $err = "Credenciais inválidas.";
            }

        } else {
            $err = "Credenciais inválidas.";
        }

    } else {
        $err = "Preenche todos os campos.";
    }
}
?>



<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login ADPB</title>

    <link rel="stylesheet" type="text/css" href="../style.css">

</head>
<body class="login-bg">

    <a href="../index.php" class="back-button">← Voltar ao site</a>

    <div class="login-wrapper">
        <div class="login-card">

            <img src="../Imagens/Gerais/Logotipo ADPB_projeto.png" class="login-logo" alt="Logo ADPB">

            <h2 class="login-title">Login ADPB</h2>

            <?php if(!empty($err)): ?>
                <div class="alert-error">
                    <?php echo htmlspecialchars($err); ?>
                </div>
            <?php endif; ?>

            <form method="post">

                <input type="text" name="username" class="login-input" placeholder="Utilizador" required>

                <input type="password" name="password" class="login-input" placeholder="Palavra-passe" required>

                <button type="submit" class="login-button">Entrar</button>

                <a href="recuperar.php" class="forgot-pass">Esqueceste-te da palavra-passe?</a>

            </form>

            <a href="registar.php" class="create-account">Criar Conta</a>

        </div>
    </div>

</body>
</html>
