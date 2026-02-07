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

if (!empty($_FILES['imagem']['name'])) {
    $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $filename = time() . '_produto_' . $produtoId . '.' . strtolower($ext);
    $target = __DIR__ . '/../uploads/loja/' . $filename;
    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $target)) {
        $stmt = $mysqli->prepare("INSERT INTO loja_produto_imagens (produto_id, imagem) VALUES (?, ?)");
        $stmt->bind_param('is', $produtoId, $filename);
        $stmt->execute();
    }
}

header('Location: loja_produto_edit.php?id=' . $produtoId);
exit();
