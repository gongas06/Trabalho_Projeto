<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado.");
}

$result = $mysqli->query("
    SELECT e.*, u.username
    FROM loja_encomendas e
    LEFT JOIN utilizadores u ON u.id = e.user_id
    ORDER BY e.created_at DESC
");
?>
<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Encomendas</title>
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
    <h1>Encomendas</h1>
    <div>
      <a class="btn secondary" href="dashboard.php">Voltar</a>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Utilizador</th>
        <th>Total</th>
        <th>Status</th>
        <th>Pagamento</th>
        <th>Método</th>
        <th>Data</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= (int)$row['id']; ?></td>
            <td><?= htmlspecialchars($row['username']); ?></td>
            <td><?= number_format((float)$row['total'], 2, ',', '.'); ?> €</td>
            <td><?= htmlspecialchars($row['status']); ?></td>
            <td><?= htmlspecialchars($row['payment_status'] ?? ''); ?></td>
            <td><?= htmlspecialchars($row['payment_method'] ?? ''); ?></td>
            <td><?= htmlspecialchars($row['created_at']); ?></td>
            <td>
              <a href="loja_encomenda.php?id=<?= (int)$row['id']; ?>">Ver</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="7">Nenhuma encomenda encontrada.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

</body>
</html>
