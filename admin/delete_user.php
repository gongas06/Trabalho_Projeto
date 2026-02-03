<?php
// Backoffice: elimina utilizador (exceto conta protegida).
require_once 'auth.php';
require_once 'db.php';
require_login();

if (!is_admin()) {
    http_response_code(403);
    die('Acesso negado.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: users.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    header('Location: users.php');
    exit;
}

$stmt = $mysqli->prepare('SELECT username, role FROM utilizadores WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
$stmt->close();

if (!$user) {
    header('Location: users.php');
    exit;
}

// Protege a conta principal.
if ($user['username'] === 'admin' || $user['role'] === 'superadmin') {
    header('Location: users.php');
    exit;
}

$del = $mysqli->prepare('DELETE FROM utilizadores WHERE id = ?');
$del->bind_param('i', $id);
$del->execute();
$del->close();

header('Location: users.php');
exit;
