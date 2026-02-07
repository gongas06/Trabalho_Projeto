<?php
session_start();
require_once __DIR__ . '/admin/db.php';
require_once __DIR__ . '/admin/config.php';
require_once __DIR__ . '/loja_helpers.php';

$orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
$sessionId = $_GET['session_id'] ?? '';
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

if (!$order) {
    http_response_code(404);
    die('Encomenda não encontrada.');
}

$mensagem = '';
$confirmado = false;

if ($order['status'] === 'paid') {
    $confirmado = true;
    $mensagem = 'Pagamento confirmado.';
} elseif (($order['payment_provider'] ?? 'stripe') === 'paypal') {
    $mensagem = 'Pagamento PayPal recebido. A encomenda será validada em breve.';
} elseif (PAYMENT_PROVIDER === 'stripe' && !empty($sessionId) && !empty(STRIPE_SECRET_KEY)) {
    if (!empty($order['payment_reference']) && $order['payment_reference'] !== $sessionId) {
        $mensagem = 'Sessão de pagamento inválida.';
    } else {
    $ch = curl_init('https://api.stripe.com/v1/checkout/sessions/' . $sessionId);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . STRIPE_SECRET_KEY
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode >= 200 && $httpCode < 300) {
        $session = json_decode($response, true);
        if (!empty($session['payment_status']) && $session['payment_status'] === 'paid') {
            $confirmado = true;
            $mensagem = 'Pagamento confirmado.';

            $upd = $mysqli->prepare("UPDATE loja_encomendas SET status = 'paid', payment_status = 'paid' WHERE id = ?");
            $upd->bind_param('i', $orderId);
            $upd->execute();

            $itemsStmt = $mysqli->prepare("SELECT variante_id, quantidade FROM loja_encomenda_itens WHERE encomenda_id = ?");
            $itemsStmt->bind_param('i', $orderId);
            $itemsStmt->execute();
            $itemsRes = $itemsStmt->get_result();
            while ($row = $itemsRes->fetch_assoc()) {
                $updStock = $mysqli->prepare("UPDATE loja_produto_variantes SET stock = GREATEST(stock - ?, 0) WHERE id = ?");
                $updStock->bind_param('ii', $row['quantidade'], $row['variante_id']);
                $updStock->execute();
            }

            $_SESSION['cart'] = [];
        } else {
            $mensagem = 'Pagamento ainda não confirmado. Se já pagaste, tenta novamente em instantes.';
        }
    } else {
        $mensagem = 'Não foi possível validar o pagamento.';
    }
    }
} else {
    $mensagem = 'Pagamento não confirmado.';
}

if ($confirmado && empty($order['email_sent'])) {
    $itemsStmt = $mysqli->prepare("
        SELECT nome_produto, nome_variante, quantidade, subtotal
        FROM loja_encomenda_itens
        WHERE encomenda_id = ?
    ");
    $itemsStmt->bind_param('i', $orderId);
    $itemsStmt->execute();
    $itemsRes = $itemsStmt->get_result();
    $items = [];
    while ($row = $itemsRes->fetch_assoc()) {
        $items[] = $row;
    }

    if (loja_send_order_email($order, $items)) {
        $updMail = $mysqli->prepare("UPDATE loja_encomendas SET email_sent = 1 WHERE id = ?");
        $updMail->bind_param('i', $orderId);
        $updMail->execute();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Pagamento — Loja ADPB</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<section class="pagamento-status">
  <div class="pagamento-card">
    <h1><?= $confirmado ? 'Obrigado pela tua compra!' : 'Pagamento em validação'; ?></h1>
    <p><?= htmlspecialchars($mensagem); ?></p>
    <div class="pagamento-actions">
      <a class="produto-btn" href="loja.php">Continuar a comprar</a>
      <a class="produto-btn secundario" href="index.php">Voltar ao site</a>
    </div>
  </div>
</section>

</body>
</html>
