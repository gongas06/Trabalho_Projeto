<?php
require_once __DIR__ . '/db.php';

$token = $_GET['token'] ?? '';
$err = '';
$msg = '';

if ($token === '') {
    $err = 'Token invalido.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if ($token === '') {
        $err = 'Token invalido.';
    } elseif ($password === '' || $password2 === '') {
        $err = 'Preenche a palavra-passe.';
    } elseif ($password !== $password2) {
        $err = 'As palavras-passe nao coincidem.';
    } else {
        $token_hash = hash('sha256', $token);
        $stmt = $mysqli->prepare(
            'SELECT user_id, expires_at FROM password_resets WHERE token_hash = ? LIMIT 1'
        );
        if (!$stmt) {
            $err = 'Erro ao preparar pedido.';
        } else {
            $stmt->bind_param('s', $token_hash);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();

            if (!$row) {
                $err = 'Token invalido ou expirado.';
            } elseif (strtotime($row['expires_at']) < time()) {
                $err = 'Token expirado.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $upd = $mysqli->prepare('UPDATE utilizadores SET password = ? WHERE id = ?');
                if ($upd) {
                    $upd->bind_param('si', $hash, $row['user_id']);
                    if ($upd->execute()) {
                        $del = $mysqli->prepare('DELETE FROM password_resets WHERE user_id = ?');
                        if ($del) {
                            $del->bind_param('i', $row['user_id']);
                            $del->execute();
                        }
                        $msg = 'Palavra-passe atualizada com sucesso.';
                    } else {
                        $err = 'Erro ao atualizar a palavra-passe.';
                    }
                } else {
                    $err = 'Erro ao preparar atualizacao.';
                }
            }
        }
    }
}
?>
<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Redefinir Palavra-Passe</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    .wrap { max-width:520px; margin:40px auto; padding:20px; }
    .alert { padding:12px; border-radius:6px; margin-bottom:12px; }
    .alert.err { background:#ffd4d4; color:#a10000; border:1px solid #a10000; }
    .alert.ok { background:#d4ffd4; color:#086; border:1px solid #086; }
    .form-row { margin-bottom:12px; }
    label { display:block; font-weight:600; margin-bottom:6px; }
    input[type="password"] {
        width:100%;
        padding:8px;
        border:1px solid #ccc;
        border-radius:6px;
    }
    .btn {
        background:#b80000;
        color:#fff;
        padding:8px 12px;
        border-radius:6px;
        text-decoration:none;
        border:none;
        cursor:pointer;
    }
  </style>
</head>
<body class="login-body">
  <div class="wrap">
    <?php if ($err): ?>
      <div class="alert err"><?= htmlspecialchars($err) ?></div>
    <?php elseif ($msg): ?>
      <div class="alert ok"><?= htmlspecialchars($msg) ?></div>
      <a href="login.php">Voltar ao login</a>
    <?php endif; ?>

    <?php if (!$msg && !$err): ?>
      <form method="post">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <div class="form-row">
          <label>Nova palavra-passe</label>
          <input type="password" name="password" required>
        </div>

        <div class="form-row">
          <label>Confirmar palavra-passe</label>
          <input type="password" name="password2" required>
        </div>

        <button type="submit" class="btn">Atualizar</button>
      </form>
    <?php endif; ?>
  </div>
</body>
</html>
