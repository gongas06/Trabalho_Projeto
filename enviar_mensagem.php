<?php
// Handler do formulário de contactos: valida e grava a mensagem.
require_once __DIR__ . '/admin/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contactos.php');
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

// Validação básica obrigatória.
if ($nome === '' || $email === '' || $mensagem === '') {
    header('Location: contactos.php?erro=1');
    exit;
}

// Inserção da mensagem na base de dados.
$stmt = $mysqli->prepare("
    INSERT INTO mensagens (nome, email, mensagem, created_at)
    VALUES (?, ?, ?, NOW())
");

if (!$stmt) {
    header('Location: contactos.php?erro=1');
    exit;
}

$stmt->bind_param('sss', $nome, $email, $mensagem);
$ok = $stmt->execute();
$stmt->close();

if ($ok) {
    header('Location: contactos.php?enviado=1');
    exit;
}

header('Location: contactos.php?erro=1');
exit;
