<?php
session_start();
require_once __DIR__ . '/../admin/db.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../admin/login.php");
    exit;
}

$id = $_POST['id'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// 🔐 Atualizar password (se existir)
if (!empty($password)) {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare(
        "UPDATE utilizadores SET username=?, email=?, password=? WHERE id=?"
    );
    $stmt->bind_param("sssi", $username, $email, $passwordHash, $id);
} else {
    $stmt = $mysqli->prepare(
        "UPDATE utilizadores SET username=?, email=? WHERE id=?"
    );
    $stmt->bind_param("ssi", $username, $email, $id);
}

$stmt->execute();

// 📸 Upload da foto
if (!empty($_FILES['foto']['name'])) {

    $pasta = __DIR__ . "/../uploads/perfis/";
    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($ext, $permitidas)) {

        $nomeFoto = uniqid("perfil_") . "." . $ext;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $pasta . $nomeFoto)) {

            $stmt = $mysqli->prepare(
                "UPDATE utilizadores SET foto=? WHERE id=?"
            );
            $stmt->bind_param("si", $nomeFoto, $id);
            $stmt->execute();
        }
    }
}

$_SESSION['username'] = $username;
header("Location: perfil.php");
exit;


