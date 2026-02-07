<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado.");
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $stmt = $mysqli->prepare("SELECT imagem_principal FROM loja_produtos WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $p = $stmt->get_result()->fetch_assoc();
    if ($p && !empty($p['imagem_principal'])) {
        $path = __DIR__ . '/../uploads/loja/' . $p['imagem_principal'];
        if (file_exists($path)) {
            unlink($path);
        }
    }

    $imgs = $mysqli->prepare("SELECT imagem FROM loja_produto_imagens WHERE produto_id = ?");
    $imgs->bind_param('i', $id);
    $imgs->execute();
    $imgsRes = $imgs->get_result();
    while ($img = $imgsRes->fetch_assoc()) {
        $path = __DIR__ . '/../uploads/loja/' . $img['imagem'];
        if (file_exists($path)) {
            unlink($path);
        }
    }

    $del = $mysqli->prepare("DELETE FROM loja_produtos WHERE id = ?");
    $del->bind_param('i', $id);
    $del->execute();
}

header('Location: loja_produtos.php');
exit();
