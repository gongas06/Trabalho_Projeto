<?php
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: recuperar.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$msg = '';
$err = '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $err = 'Email inválido.';
} else {
    $stmt = $mysqli->prepare('SELECT id, username FROM utilizadores WHERE email = ? LIMIT 1');
    if (!$stmt) {
        $err = 'Erro ao preparar pedido.';
    } else {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user) {
            $create = "
                CREATE TABLE IF NOT EXISTS password_resets (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT NOT NULL,
                    token_hash CHAR(64) NOT NULL,
                    expires_at DATETIME NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    INDEX (user_id),
                    INDEX (token_hash)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
            ";
            $mysqli->query($create);

            $token = bin2hex(random_bytes(32));
            $token_hash = hash('sha256', $token);
            $expires_at = date('Y-m-d H:i:s', time() + 3600);

            $del = $mysqli->prepare('DELETE FROM password_resets WHERE user_id = ?');
            if ($del) {
                $del->bind_param('i', $user['id']);
                $del->execute();
            }

            $insert = $mysqli->prepare(
                'INSERT INTO password_resets (user_id, token_hash, expires_at) VALUES (?, ?, ?)'
            );

            if ($insert) {
                $insert->bind_param('iss', $user['id'], $token_hash, $expires_at);
                $insert->execute();
            }

            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
            $base = rtrim(dirname($_SERVER['PHP_SELF']), '/');
            $reset_link = $scheme . '://' . $host . $base . '/redefinir.php?token=' . $token;

            $subject = 'Recuperacao de palavra-passe';
            $message = "Ola " . $user['username'] . ",\n\n";
            $message .= "Recebemos um pedido para recuperar a tua palavra-passe.\n";
            $message .= "Clica no link para redefinir (valido por 1 hora):\n\n";
            $message .= $reset_link . "\n\n";
            $message .= "Se nao pediste isto, ignora este email.";

            $from = 'no-reply@' . $host;
            $headers = 'From: ' . $from . "\r\n" .
                       'Reply-To: ' . $from . "\r\n" .
                       'Content-Type: text/plain; charset=UTF-8';

            @mail($email, $subject, $message, $headers);
        }

        $msg = 'Se o email estiver registado, enviamos um link de recuperacao.';
    }
}
?>
<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Recuperar Palavra-Passe</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    .wrap { max-width:520px; margin:40px auto; padding:20px; }
    .alert { padding:12px; border-radius:6px; margin-bottom:12px; }
    .alert.err { background:#ffd4d4; color:#a10000; border:1px solid #a10000; }
    .alert.ok { background:#d4ffd4; color:#086; border:1px solid #086; }
    a { color:#b80000; }
  </style>
</head>
<body class="login-body">
  <div class="wrap">
    <?php if ($err): ?>
      <div class="alert err"><?= htmlspecialchars($err) ?></div>
    <?php else: ?>
      <div class="alert ok"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>
    <a href="login.php">Voltar ao login</a>
  </div>
</body>
</html>