<?php
// Handler para atualizar o role de um utilizador.
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
$role = $_POST['role'] ?? '';

if ($id <= 0 || !in_array($role, ['admin', 'user'], true)) {
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

$update = $mysqli->prepare('UPDATE utilizadores SET role = ? WHERE id = ?');
$update->bind_param('si', $role, $id);
$update->execute();
$update->close();

header('Location: users.php');
exit;
