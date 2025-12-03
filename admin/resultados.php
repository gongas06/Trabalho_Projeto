<?php
session_start();
require_once __DIR__ . '/admin/db.php';
?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Resultados — ADPB</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1 class="titulo">Resultados</h1>

<div class="todos-resultados">

<?php
$sql = "SELECT * FROM resultados ORDER BY created_at DESC";
$res = $mysqli->query($sql);

if ($res && $res->num_rows > 0):
    while ($r = $res->fetch_assoc()):
?>

    <div class="resultado-card">

        <div class="equipas">
            <img src="uploads/<?= htmlspecialchars($r['imagem_casa']) ?>" alt="">
            <div class="vs">
                <?= htmlspecialchars($r['golo_casa']) ?> - <?= htmlspecialchars($r['golo_fora']) ?>
            </div>
            <img src="uploads/<?= htmlspecialchars($r['imagem_fora']) ?>" alt="">
        </div>

        <p class="texto-equipas">
            <?= htmlspecialchars($r['equipa_casa']) ?> vs <?= htmlspecialchars($r['equipa_fora']) ?>
        </p>

        <p class="info">
            <?= htmlspecialchars($r['competicao'] ?? '') ?> —
            <?= htmlspecialchars($r['epoca'] ?? '') ?>
        </p>

    </div>

<?php
    endwhile;
else:
    echo "<p>Nenhum resultado disponível.</p>";
endif;
?>

</div>

</body>
</html>
