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
    $stmt = $mysqli->prepare("DELETE FROM loja_categorias WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

header('Location: loja_categorias.php');
exit();
