<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado.");
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$produtoId = isset($_GET['produto_id']) ? (int)$_GET['produto_id'] : 0;
if ($id <= 0) {
    die('Variante inválida.');
}

$stmt = $mysqli->prepare("SELECT * FROM loja_produto_variantes WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$var = $stmt->get_result()->fetch_assoc();
if (!$var) {
    die('Variante não encontrada.');
}

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sku = trim($_POST['sku'] ?? '');
    $tamanho = trim($_POST['tamanho'] ?? '');
    $cor = trim($_POST['cor'] ?? '');
    $preco = (float)($_POST['preco'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    $upd = $mysqli->prepare("
        UPDATE loja_produto_variantes
        SET sku = ?, tamanho = ?, cor = ?, preco = ?, stock = ?, ativo = ?
        WHERE id = ?
    ");
    $upd->bind_param('sssdiii', $sku, $tamanho, $cor, $preco, $stock, $ativo, $id);
    if ($upd->execute()) {
        header('Location: loja_variantes.php?produto_id=' . $produtoId);
        exit();
    }
    $err = 'Erro ao atualizar variante.';
}
?>
<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Editar Variante</title>
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
  <h1>Editar variante</h1>
  <?php if ($err): ?>
    <div class="alert-error"><?= htmlspecialchars($err); ?></div>
  <?php endif; ?>
  <form method="post" class="form">
    <label>SKU</label>
    <input type="text" name="sku" value="<?= htmlspecialchars($var['sku']); ?>">
    <label>Tamanho</label>
    <input type="text" name="tamanho" value="<?= htmlspecialchars($var['tamanho']); ?>">
    <label>Cor</label>
    <input type="text" name="cor" value="<?= htmlspecialchars($var['cor']); ?>">
    <label>Preço</label>
    <input type="number" step="0.01" name="preco" value="<?= htmlspecialchars($var['preco']); ?>" required>
    <label>Stock</label>
    <input type="number" name="stock" value="<?= (int)$var['stock']; ?>" required>
    <label><input type="checkbox" name="ativo" <?= (int)$var['ativo'] === 1 ? 'checked' : ''; ?>> Variante ativa</label>

    <button class="btn" type="submit">Guardar</button>
    <a class="btn secondary" href="loja_variantes.php?produto_id=<?= (int)$produtoId; ?>">Cancelar</a>
  </form>
</body>
</html>
