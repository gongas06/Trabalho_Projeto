<?php
require_once 'auth.php';
require_once 'db.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: mensagens.php');
    exit;
}

$stmt = $mysqli->prepare("DELETE FROM mensagens WHERE id = ?");
if ($stmt) {
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
}

header('Location: mensagens.php');
exit;
