<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado.");
}

$produtoId = isset($_GET['produto_id']) ? (int)$_GET['produto_id'] : 0;
if ($produtoId <= 0) {
    die('Produto inválido.');
}

$pStmt = $mysqli->prepare("SELECT nome FROM loja_produtos WHERE id = ? LIMIT 1");
$pStmt->bind_param('i', $produtoId);
$pStmt->execute();
$produto = $pStmt->get_result()->fetch_assoc();
if (!$produto) {
    die('Produto não encontrado.');
}

$result = $mysqli->query("SELECT * FROM loja_produto_variantes WHERE produto_id = " . $produtoId . " ORDER BY id DESC");
?>
<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Variantes</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body { padding:20px; font-family: Arial, sans-serif; }
    table { width:100%; border-collapse:collapse; margin-top:20px; }
    th, td { padding:10px; border:1px solid #ddd; text-align:left; }
    th { background:#f2f2f2; }
    .topbar { display:flex; justify-content:space-between; align-items:center; }
    .btn { background:#b80000; color:#fff; padding:8px 14px; border-radius:6px; text-decoration:none; font-weight:600; border:none; }
    .btn.secondary { background:#444; }
    .form { max-width:680px; }
    .form input { width:100%; padding:10px; margin-bottom:10px; }
  </style>
</head>
<body>

<div class="container">
  <div class="topbar">
    <h1>Variantes — <?= htmlspecialchars($produto['nome']); ?></h1>
    <div>
      <a class="btn secondary" href="loja_produtos.php">Voltar</a>
    </div>
  </div>

  <form method="post" action="loja_variante_add.php" class="form">
    <input type="hidden" name="produto_id" value="<?= (int)$produtoId; ?>">
    <label>SKU</label>
    <input type="text" name="sku">
    <label>Tamanho</label>
    <input type="text" name="tamanho">
    <label>Cor</label>
    <input type="text" name="cor">
    <label>Preço</label>
    <input type="number" step="0.01" name="preco" required>
    <label>Stock</label>
    <input type="number" name="stock" value="0" required>
    <label><input type="checkbox" name="ativo" checked> Variante ativa</label>
    <button class="btn" type="submit">Adicionar variante</button>
  </form>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>SKU</th>
        <th>Tamanho</th>
        <th>Cor</th>
        <th>Preço</th>
        <th>Stock</th>
        <th>Ativo</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= (int)$row['id']; ?></td>
            <td><?= htmlspecialchars($row['sku']); ?></td>
            <td><?= htmlspecialchars($row['tamanho']); ?></td>
            <td><?= htmlspecialchars($row['cor']); ?></td>
            <td><?= number_format((float)$row['preco'], 2, ',', '.'); ?> €</td>
            <td><?= (int)$row['stock']; ?></td>
            <td><?= (int)$row['ativo'] === 1 ? 'Sim' : 'Não'; ?></td>
            <td>
              <a href="loja_variante_edit.php?id=<?= (int)$row['id']; ?>&produto_id=<?= (int)$produtoId; ?>">Editar</a> |
              <a href="loja_variante_delete.php?id=<?= (int)$row['id']; ?>&produto_id=<?= (int)$produtoId; ?>"
                 onclick="return confirm('Eliminar esta variante?');"
                 style="color:#c00;">
                 Eliminar
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="8">Nenhuma variante encontrada.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

</body>
</html>
