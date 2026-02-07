<?php
session_start();
require_once __DIR__ . '/admin/db.php';

$orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
$token = $_GET['token'] ?? ($_SESSION['last_order_token'] ?? '');
if ($orderId <= 0) {
    http_response_code(404);
    die('Encomenda inválida.');
}
if ($token === '') {
    http_response_code(403);
    die('Token inválido.');
}

$stmt = $mysqli->prepare("SELECT * FROM loja_encomendas WHERE id = ? AND public_token = ? LIMIT 1");
$stmt->bind_param('is', $orderId, $token);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if ($order && $order['status'] !== 'paid') {
    $upd = $mysqli->prepare("UPDATE loja_encomendas SET status = 'cancelled', payment_status = 'cancelled' WHERE id = ?");
    $upd->bind_param('i', $orderId);
    $upd->execute();
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Pagamento cancelado — Loja ADPB</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<section class="pagamento-status">
  <div class="pagamento-card">
    <h1>Pagamento cancelado</h1>
    <p>Podes tentar novamente quando quiseres.</p>
    <div class="pagamento-actions">
      <a class="produto-btn" href="carrinho.php">Voltar ao carrinho</a>
      <a class="produto-btn secundario" href="loja.php">Loja</a>
    </div>
  </div>
</section>

</body>
</html>
