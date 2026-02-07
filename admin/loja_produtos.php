<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado.");
}

$result = $mysqli->query("
    SELECT p.*, c.nome AS categoria_nome
    FROM loja_produtos p
    LEFT JOIN loja_categorias c ON c.id = p.categoria_id
    ORDER BY p.created_at DESC
");
?>
<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Loja — Produtos</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body { padding:20px; font-family: Arial, sans-serif; }
    table { width:100%; border-collapse:collapse; margin-top:20px; }
    th, td { padding:10px; border:1px solid #ddd; text-align:left; }
    th { background:#f2f2f2; }
    img.thumb { height:60px; border-radius:6px; display:block; }
    .topbar { display:flex; justify-content:space-between; align-items:center; }
    .btn { background:#b80000; color:#fff; padding:8px 14px; border-radius:6px; text-decoration:none; font-weight:600; }
    .btn.secondary { background:#444; }
  </style>
</head>
<body>

<div class="container">
  <div class="topbar">
    <h1>Produtos</h1>
    <div>
      <a class="btn" href="loja_produto_add.php">+ Novo produto</a>
      <a class="btn secondary" href="dashboard.php">Voltar</a>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Categoria</th>
        <th>Imagem</th>
        <th>Ativo</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= (int)$row['id']; ?></td>
            <td><?= htmlspecialchars($row['nome']); ?></td>
            <td><?= htmlspecialchars($row['categoria_nome'] ?? 'Sem categoria'); ?></td>
            <td>
              <?php if (!empty($row['imagem_principal']) && file_exists('../uploads/loja/' . $row['imagem_principal'])): ?>
                <img class="thumb" src="../uploads/loja/<?= htmlspecialchars($row['imagem_principal']); ?>" alt="">
              <?php else: ?>
                <span style="color:#888;">Sem imagem</span>
              <?php endif; ?>
            </td>
            <td><?= (int)$row['ativo'] === 1 ? 'Sim' : 'Não'; ?></td>
            <td>
              <a href="loja_produto_edit.php?id=<?= (int)$row['id']; ?>">Editar</a> |
              <a href="loja_variantes.php?produto_id=<?= (int)$row['id']; ?>">Variantes</a> |
              <a href="loja_produto_delete.php?id=<?= (int)$row['id']; ?>"
                 onclick="return confirm('Eliminar este produto?');"
                 style="color:#c00;">
                 Eliminar
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="6">Nenhum produto encontrado.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

</body>
</html>
