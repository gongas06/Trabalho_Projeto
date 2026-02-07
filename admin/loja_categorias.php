<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../loja_helpers.php';

require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado.");
}

$result = $mysqli->query("SELECT * FROM loja_categorias ORDER BY nome ASC");
?>
<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Loja — Categorias</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body { padding:20px; font-family: Arial, sans-serif; }
    table { width:100%; border-collapse:collapse; margin-top:20px; }
    th, td { padding:10px; border:1px solid #ddd; text-align:left; }
    th { background:#f2f2f2; }
    .topbar { display:flex; justify-content:space-between; align-items:center; }
    .btn { background:#b80000; color:#fff; padding:8px 14px; border-radius:6px; text-decoration:none; font-weight:600; }
    .btn.secondary { background:#444; }
  </style>
</head>
<body>

<div class="container">
  <div class="topbar">
    <h1>Categorias</h1>
    <div>
      <a class="btn" href="loja_categoria_add.php">+ Nova categoria</a>
      <a class="btn secondary" href="dashboard.php">Voltar</a>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Slug</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= (int)$row['id']; ?></td>
            <td><?= htmlspecialchars($row['nome']); ?></td>
            <td><?= htmlspecialchars($row['slug']); ?></td>
            <td>
              <a href="loja_categoria_edit.php?id=<?= (int)$row['id']; ?>">Editar</a> |
              <a href="loja_categoria_delete.php?id=<?= (int)$row['id']; ?>"
                 onclick="return confirm('Eliminar esta categoria?');"
                 style="color:#c00;">
                 Eliminar
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="4">Nenhuma categoria encontrada.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

</body>
</html>
