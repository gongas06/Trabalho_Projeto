<?php
session_start();
require_once __DIR__ . '/../admin/db.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../admin/login.php");
    exit;
}

$id = $_POST['id'];
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);

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
    echo "Erro ao atualizar perfil.";
}
?>
