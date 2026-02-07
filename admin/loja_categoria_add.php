<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../loja_helpers.php';

require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado.");
}

$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    if ($nome === '') {
        $err = 'Nome obrigatório.';
    } else {
        $slug = loja_slug($nome);
        $stmt = $mysqli->prepare("INSERT INTO loja_categorias (nome, slug) VALUES (?, ?)");
        $stmt->bind_param('ss', $nome, $slug);
        if ($stmt->execute()) {
            header('Location: loja_categorias.php');
            exit();
        }
        $err = 'Erro ao guardar categoria.';
    }
}
?>
<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Nova Categoria</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body { padding:20px; font-family: Arial, sans-serif; }
    .form { max-width:520px; }
    .form input { width:100%; padding:10px; margin-bottom:10px; }
    .btn { background:#b80000; color:#fff; padding:8px 14px; border-radius:6px; text-decoration:none; font-weight:600; border:none; }
    .btn.secondary { background:#444; }
  </style>
</head>
<body>
  <h1>Nova categoria</h1>
  <?php if ($err): ?>
    <div class="alert-error"><?= htmlspecialchars($err); ?></div>
  <?php endif; ?>
  <form method="post" class="form">
    <label>Nome</label>
    <input type="text" name="nome" required>
    <button class="btn" type="submit">Guardar</button>
    <a class="btn secondary" href="loja_categorias.php">Cancelar</a>
  </form>
</body>
</html>
