<?php
require_once "admin/db.php";

$id = $_GET['id'] ?? 0;
$stmt = $mysqli->prepare("SELECT * FROM resultados WHERE id = ?");
$stmt->execute([$id]);
$result = $stmt->get_result();
$jogo = $result->fetch_assoc();


if (!$jogo) {
    echo "Jogo não encontrado.";
    exit;
}
?>

<h1><?= $jogo['equipa_casa'] ?> <?= $jogo['golos_casa'] ?> - <?= $jogo['golos_fora'] ?> <?= $jogo['equipa_fora'] ?></h1>
<p>Competição: <?= $jogo['competicao'] ?></p>
<p>Época: <?= $jogo['epoca'] ?></p>
