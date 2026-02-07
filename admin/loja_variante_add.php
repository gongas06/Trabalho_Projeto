<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado.");
}

$produtoId = (int)($_POST['produto_id'] ?? 0);
if ($produtoId <= 0) {
    header('Location: loja_produtos.php');
    exit();
}

$sku = trim($_POST['sku'] ?? '');
$tamanho = trim($_POST['tamanho'] ?? '');
$cor = trim($_POST['cor'] ?? '');
$preco = (float)($_POST['preco'] ?? 0);
$stock = (int)($_POST['stock'] ?? 0);
$ativo = isset($_POST['ativo']) ? 1 : 0;

$stmt = $mysqli->prepare("
    INSERT INTO loja_produto_variantes (produto_id, sku, tamanho, cor, preco, stock, ativo)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param('isssdii', $produtoId, $sku, $tamanho, $cor, $preco, $stock, $ativo);
$stmt->execute();

header('Location: loja_variantes.php?produto_id=' . $produtoId);
exit();
