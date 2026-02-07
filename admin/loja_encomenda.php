<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado.");
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die('Encomenda inválida.');
}

$stmt = $mysqli->prepare("
    SELECT e.*, u.username
    FROM loja_encomendas e
    LEFT JOIN utilizadores u ON u.id = e.user_id
    WHERE e.id = ? LIMIT 1
");
$stmt->bind_param('i', $id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
if (!$order) {
    die('Encomenda não encontrada.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? $order['status'];
    $paymentStatus = $_POST['payment_status'] ?? ($order['payment_status'] ?? '');
    $allowedStatus = ['pending_payment', 'paid', 'cancelled'];
    if (!in_array($status, $allowedStatus, true)) {
        $status = $order['status'];
    }
    $upd = $mysqli->prepare("UPDATE loja_encomendas SET status = ?, payment_status = ? WHERE id = ?");
    $upd->bind_param('ssi', $status, $paymentStatus, $id);
    $upd->execute();
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();
}

$itemsStmt = $mysqli->prepare("SELECT * FROM loja_encomenda_itens WHERE encomenda_id = ?");
$itemsStmt->bind_param('i', $id);
$itemsStmt->execute();
$itemsRes = $itemsStmt->get_result();
?>
<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Encomenda #<?= (int)$order['id']; ?></title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body { padding:20px; font-family: Arial, sans-serif; }
    table { width:100%; border-collapse:collapse; margin-top:20px; }
    th, td { padding:10px; border:1px solid #ddd; text-align:left; }
    th { background:#f2f2f2; }
    .btn { background:#444; color:#fff; padding:8px 14px; border-radius:6px; text-decoration:none; font-weight:600; }
  </style>
</head>
<body>

<a class="btn" href="loja_encomendas.php">Voltar</a>

<h1>Encomenda #<?= (int)$order['id']; ?></h1>
<p><strong>Utilizador:</strong> <?= htmlspecialchars($order['username'] ?? 'Convidado'); ?></p>
<p><strong>Total:</strong> <?= number_format((float)$order['total'], 2, ',', '.'); ?> €</p>
<p><strong>Status:</strong> <?= htmlspecialchars($order['status']); ?></p>
<p><strong>Pagamento:</strong> <?= htmlspecialchars($order['payment_status'] ?? ''); ?></p>
<p><strong>Método:</strong> <?= htmlspecialchars($order['payment_method'] ?? ''); ?></p>

<h3>Atualizar estado</h3>
<form method="post">
  <label>Status</label>
  <select name="status">
    <option value="pending_payment" <?= $order['status'] === 'pending_payment' ? 'selected' : ''; ?>>Pendente</option>
    <option value="paid" <?= $order['status'] === 'paid' ? 'selected' : ''; ?>>Pago</option>
    <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelado</option>
  </select>
  <label>Estado do pagamento</label>
  <input type="text" name="payment_status" value="<?= htmlspecialchars($order['payment_status'] ?? ''); ?>">
  <button class="btn" type="submit">Guardar</button>
</form>

<h3>Entrega</h3>
<p><?= htmlspecialchars($order['shipping_nome']); ?> — <?= htmlspecialchars($order['shipping_email']); ?></p>
<p><?= htmlspecialchars($order['shipping_morada']); ?>, <?= htmlspecialchars($order['shipping_cidade']); ?>, <?= htmlspecialchars($order['shipping_codigo_postal']); ?></p>
<p><?= htmlspecialchars($order['shipping_telefone'] ?? ''); ?></p>

<h3>Itens</h3>
<table>
  <thead>
    <tr>
      <th>Produto</th>
      <th>Variante</th>
      <th>Preço</th>
      <th>Qtd</th>
      <th>Subtotal</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($item = $itemsRes->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($item['nome_produto']); ?></td>
        <td><?= htmlspecialchars($item['nome_variante']); ?></td>
        <td><?= number_format((float)$item['preco_unitario'], 2, ',', '.'); ?> €</td>
        <td><?= (int)$item['quantidade']; ?></td>
        <td><?= number_format((float)$item['subtotal'], 2, ',', '.'); ?> €</td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

</body>
</html>
