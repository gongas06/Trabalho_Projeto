<?php
session_start();
require_once __DIR__ . '/../admin/db.php';

if (empty($_SESSION['user_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

$userId = (int)$_SESSION['user_id'];
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die('Encomenda inválida.');
}

$stmt = $mysqli->prepare("
    SELECT *
    FROM loja_encomendas
    WHERE id = ? AND user_id = ?
    LIMIT 1
");
$stmt->bind_param('ii', $id, $userId);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
if (!$order) {
    die('Encomenda não encontrada.');
}

$itemsStmt = $mysqli->prepare("
    SELECT nome_produto, nome_variante, quantidade, preco_unitario, subtotal
    FROM loja_encomenda_itens
    WHERE encomenda_id = ?
");
$itemsStmt->bind_param('i', $id);
$itemsStmt->execute();
$itemsRes = $itemsStmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Encomenda #<?= (int)$order['id']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; margin:0; padding:0; }
        .container { max-width: 900px; margin: 80px auto; background:#fff; padding:30px; border-radius:14px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color:#c8102e; margin-bottom: 10px; }
        table { width:100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding:10px; border:1px solid #eee; text-align:left; }
        th { background:#fafafa; }
        .back-button { position:absolute; top:20px; left:20px; color:#ffffff; text-decoration:none; font-weight:600; background:#c71b1b; padding:8px 16px; border-radius:999px; box-shadow:0 6px 14px rgba(199,27,27,0.25); }
    </style>
</head>
<body>

<a href="encomendas.php" class="back-button">← Voltar</a>

<div class="container">
    <h2>Encomenda #<?= (int)$order['id']; ?></h2>
    <p><strong>Status:</strong> <?= htmlspecialchars($order['status']); ?></p>
    <p><strong>Pagamento:</strong> <?= htmlspecialchars($order['payment_status'] ?? ''); ?></p>
    <p><strong>Total:</strong> <?= number_format((float)$order['total'], 2, ',', '.'); ?> €</p>

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
</div>

</body>
</html>
