<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado.");
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$produtoId = isset($_GET['produto_id']) ? (int)$_GET['produto_id'] : 0;

if ($id > 0) {
    $stmt = $mysqli->prepare("SELECT imagem FROM loja_produto_imagens WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $img = $stmt->get_result()->fetch_assoc();
    if ($img && !empty($img['imagem'])) {
        $path = __DIR__ . '/../uploads/loja/' . $img['imagem'];
        if (file_exists($path)) {
            unlink($path);
        }
    }

    $del = $mysqli->prepare("DELETE FROM loja_produto_imagens WHERE id = ?");
    $del->bind_param('i', $id);
    $del->execute();
}

header('Location: loja_produto_edit.php?id=' . $produtoId);
exit();
