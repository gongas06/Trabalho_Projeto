<?php
// Página de detalhe de um jogo/resultados (por ID).
require_once "admin/db.php";

// Consulta do jogo selecionado por ID (resultado).
$id = $_GET['id'] ?? 0;
$stmt = $mysqli->prepare("SELECT * FROM resultados WHERE id = ?");
// O ID é usado na query preparada para evitar SQL injection.
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
