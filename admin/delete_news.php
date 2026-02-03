<?php
// Backoffice: elimina uma notícia e remove a imagem associada.
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado. Apenas o administrador pode gerir notícias.");
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: news.php'); exit;
}

// Apagar imagem (se existir).
$r = $mysqli->prepare("SELECT image FROM noticias WHERE id = ?");
$r->bind_param('i', $id);
$r->execute();
$row = $r->get_result()->fetch_assoc();
if ($row && !empty($row['image'])) {
    $file = __DIR__ . '/../uploads/' . $row['image'];
    if (file_exists($file)) @unlink($file);
}

// Apagar registo.
$stmt = $mysqli->prepare("DELETE FROM noticias WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();

header('Location: news.php');
exit;
