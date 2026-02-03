<?php
// Handler de registo: valida campos, verifica duplicados e cria utilizador.
session_start();
require_once __DIR__ . "/db.php"; 

$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';


// Validação básica.
if ($username === '' || $email === '' || $password === '') {
    header("Location: registar.php?erro=empty");
    exit();
}


// Verifica se o username já existe.
$check = $mysqli->prepare("SELECT id FROM utilizadores WHERE username = ?");
$check->bind_param("s", $username);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    
    header("Location: registar.php?erro=user_exists");
    exit();
}


// Guarda com hash seguro.
$hash = password_hash($password, PASSWORD_DEFAULT);


// Cria o utilizador.
$insert = $mysqli->prepare("INSERT INTO utilizadores (username, email, password) VALUES (?, ?, ?)");
$insert->bind_param("sss", $username, $email, $hash);

if ($insert->execute()) {
    header("Location: registar.php?success=1");
    exit();
} else {
    header("Location: registar.php?erro=unknown");
    exit();
}
