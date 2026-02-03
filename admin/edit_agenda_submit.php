<?php
// Handler para atualizar jogo na agenda.
require_once 'auth.php';
require_once 'db.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Método inválido');
}

$id = intval($_POST['id'] ?? 0);
if ($id <= 0) {
    die('ID inválido');
}

$stmt = $mysqli->prepare("
    UPDATE agenda
    SET equipa_casa = ?, equipa_fora = ?, data_jogo = ?, hora_jogo = ?, local_jogo = ?, competicao = ?, epoca = ?
    WHERE id = ?
");

$stmt->bind_param(
    "sssssssi",
    $_POST['equipa_casa'],
    $_POST['equipa_fora'],
    $_POST['data_jogo'],
    $_POST['hora_jogo'],
    $_POST['local_jogo'],
    $_POST['competicao'],
    $_POST['epoca'],
    $id
);

$stmt->execute();
$stmt->close();

header('Location: agenda.php');
exit;
