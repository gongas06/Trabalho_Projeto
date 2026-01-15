<?php
require_once 'auth.php';
require_once 'db.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Método inválido");
}

$stmt = $mysqli->prepare("
    INSERT INTO agenda (equipa_casa, equipa_fora, data_jogo, hora_jogo, local_jogo, competicao, epoca)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "sssssss",
    $_POST['equipa_casa'],
    $_POST['equipa_fora'],
    $_POST['data_jogo'],
    $_POST['hora_jogo'],
    $_POST['local_jogo'],
    $_POST['competicao'],
    $_POST['epoca']
);

$stmt->execute();
$stmt->close();

header("Location: agenda.php");
exit;
