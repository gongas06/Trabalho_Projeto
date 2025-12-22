<?php
session_start();
require_once __DIR__ . '/../admin/db.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../admin/login.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acesso inválido.");
}


$id = $_POST['id'] ?? null;
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');


if (!$id) {
    die("ID do utilizador não encontrado.");
}


if ($password !== "") {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE utilizadores SET username=?, email=?, password=? WHERE id=?");
    $stmt->bind_param("sssi", $username, $email, $hashed, $id);
} else {
    $stmt = $conn->prepare("UPDATE utilizadores SET username=?, email=? WHERE id=?");
    $stmt->bind_param("ssi", $username, $email, $id);
}

if ($stmt->execute()) {
    $_SESSION['username'] = $username;
    header("Location: perfil.php?sucesso=1");
    exit;
} else {
    echo "Erro ao atualizar perfil: " . $stmt->error;
}
?>

