<?php
require_once "admin/db.php";

// Filtros (podes adaptar)
$epoca = $_GET['epoca'] ?? '';
$competicao = $_GET['competicao'] ?? '';

$sql = "SELECT * FROM resultados WHERE 1";

if ($epoca !== '') {
    $sql .= " AND epoca = '$epoca'";
}

if ($competicao !== '') {
    $sql .= " AND competicao = '$competicao'";
}

$sql .= " ORDER BY created_at DESC";

$res = $mysqli->query($sql);
?>

<section class="todos-resultados">
    <div class="container">
        <h2>Resultados</h2>

        <div class="resultados-grid">
            <?php while ($r = $res->fetch_assoc()): ?>
                <div class="resultado-card">

                    <div class="resultado-equipas">

                        <div class="equipa">
                            <img src="uploads/<?= htmlspecialchars($r['imagem_casa']) ?>" alt="">
                            <p><?= htmlspecialchars($r['equipa_casa']) ?></p>
                        </div>

                        <div class="resultado-score">
                            <?= $r['golo_casa'] ?> - <?= $r['golo_fora'] ?>
                        </div>

                        <div class="equipa">
                            <img src="uploads/<?= htmlspecialchars($r['imagem_fora']) ?>" alt="">
                            <p><?= htmlspecialchars($r['equipa_fora']) ?></p>
                        </div>

                    </div>

                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>



