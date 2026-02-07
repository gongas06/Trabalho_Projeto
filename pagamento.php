<?php
session_start();
require_once __DIR__ . '/admin/db.php';
require_once __DIR__ . '/admin/config.php';
require_once __DIR__ . '/loja_helpers.php';

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

if (!$order) {
    http_response_code(404);
    die('Encomenda não encontrada.');
}

if ($order['status'] === 'paid') {
    header('Location: pagamento_sucesso.php?order_id=' . $orderId);
    exit();
}

$itemsStmt = $mysqli->prepare("SELECT * FROM loja_encomenda_itens WHERE encomenda_id = ?");
$itemsStmt->bind_param('i', $orderId);
$itemsStmt->execute();
$itemsRes = $itemsStmt->get_result();
$items = [];
while ($row = $itemsRes->fetch_assoc()) {
    $items[] = $row;
}

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$baseUrl = $scheme . '://' . $host . $basePath;
$successUrl = $baseUrl . '/pagamento_sucesso.php?order_id=' . $orderId . '&token=' . urlencode($token) . '&session_id={CHECKOUT_SESSION_ID}';
$successUrlPaypal = $baseUrl . '/pagamento_sucesso.php?order_id=' . $orderId . '&token=' . urlencode($token);
$cancelUrl = $baseUrl . '/pagamento_cancelado.php?order_id=' . $orderId . '&token=' . urlencode($token);

if (($order['payment_provider'] ?? 'stripe') === 'stripe') {
    if (empty(STRIPE_SECRET_KEY)) {
        die('Stripe não configurado. Adiciona as chaves em admin/config.php.');
    }

    $method = $order['payment_method'] ?? 'card';
    if (!in_array($method, ['card', 'mb_way', 'multibanco'], true)) {
        $method = 'card';
    }

    $payload = [
        'mode' => 'payment',
        'success_url' => $successUrl,
        'cancel_url' => $cancelUrl,
        'client_reference_id' => (string)$orderId,
        'customer_email' => $order['shipping_email']
    ];

    $payload['payment_method_types[0]'] = $method;

    foreach ($items as $i => $item) {
        $payload["line_items[$i][price_data][currency]"] = 'eur';
        $payload["line_items[$i][price_data][product_data][name]"] = $item['nome_produto'] . ' - ' . $item['nome_variante'];
        $payload["line_items[$i][price_data][unit_amount]"] = (int)round(((float)$item['preco_unitario']) * 100);
        $payload["line_items[$i][quantity]"] = (int)$item['quantidade'];
    }

    $ch = curl_init('https://api.stripe.com/v1/checkout/sessions');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . STRIPE_SECRET_KEY,
        'Content-Type: application/x-www-form-urlencoded'
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode >= 200 && $httpCode < 300) {
        $session = json_decode($response, true);
        if (!empty($session['id']) && !empty($session['url'])) {
            $upd = $mysqli->prepare("UPDATE loja_encomendas SET payment_provider = 'stripe', payment_reference = ? WHERE id = ?");
            $upd->bind_param('si', $session['id'], $orderId);
            $upd->execute();
            header('Location: ' . $session['url']);
            exit();
        }
    }

    die('Erro ao iniciar pagamento. Verifica a configuração Stripe.');
}

if (($order['payment_provider'] ?? '') === 'paypal') {
    if (empty(PAYPAL_BUSINESS_EMAIL)) {
        die('PayPal não configurado. Adiciona o email de negócio em admin/config.php.');
    }

    $paypalHost = PAYPAL_ENV === 'sandbox'
        ? 'https://www.sandbox.paypal.com/cgi-bin/webscr'
        : 'https://www.paypal.com/cgi-bin/webscr';
    ?>
    <!DOCTYPE html>
    <html lang="pt-PT">
    <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width,initial-scale=1" />
      <title>Redirecionar para PayPal</title>
      <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <section class="pagamento-status">
      <div class="pagamento-card">
        <h1>A redirecionar para PayPal…</h1>
        <p>Se não fores redirecionado automaticamente, clica no botão abaixo.</p>
        <form id="paypal-form" action="<?= htmlspecialchars($paypalHost); ?>" method="post">
          <input type="hidden" name="cmd" value="_cart">
          <input type="hidden" name="upload" value="1">
          <input type="hidden" name="business" value="<?= htmlspecialchars(PAYPAL_BUSINESS_EMAIL); ?>">
          <input type="hidden" name="currency_code" value="EUR">
          <input type="hidden" name="return" value="<?= htmlspecialchars($successUrlPaypal); ?>">
          <input type="hidden" name="cancel_return" value="<?= htmlspecialchars($cancelUrl); ?>">
          <input type="hidden" name="custom" value="<?= htmlspecialchars($token); ?>">
          <input type="hidden" name="invoice" value="<?= (int)$orderId; ?>">
          <?php foreach ($items as $idx => $item): ?>
            <input type="hidden" name="item_name_<?= $idx + 1; ?>" value="<?= htmlspecialchars($item['nome_produto'] . ' - ' . $item['nome_variante']); ?>">
            <input type="hidden" name="amount_<?= $idx + 1; ?>" value="<?= number_format((float)$item['preco_unitario'], 2, '.', ''); ?>">
            <input type="hidden" name="quantity_<?= $idx + 1; ?>" value="<?= (int)$item['quantidade']; ?>">
          <?php endforeach; ?>
          <button type="submit" class="produto-btn">Ir para PayPal</button>
        </form>
      </div>
    </section>
    <script>
      document.getElementById('paypal-form').submit();
    </script>
    </body>
    </html>
    <?php
    exit();
}

die('Fornecedor de pagamento inválido.');
