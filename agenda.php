<?php
require_once __DIR__ . '/admin/db.php';

// Obter épocas disponíveis
$anos = $mysqli->query("SELECT DISTINCT epoca FROM agenda ORDER BY epoca DESC");

// Definir época selecionada
$epoca = isset($_GET['epoca']) ? $_GET['epoca'] : date("Y");

// Obter jogos da época selecionada
$jogos = $mysqli->query("
    SELECT * FROM agenda
    WHERE epoca = '$epoca'
    ORDER BY data_jogo ASC, hora_jogo ASC
");
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Agenda</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<section class="agenda-hero">
    <h1>Agenda</h1>

    <form method="GET">
        <select name="epoca" class="dropdown-epoca" onchange="this.form.submit()">
            <?php while ($a = $anos->fetch_assoc()): ?>
                <option value="<?= $a['epoca'] ?>"
                    <?= $a['epoca'] == $epoca ? "selected" : "" ?>>
                    <?= $a['epoca'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>
</section>


<section class="agenda-lista">

<?php if ($jogos->num_rows === 0): ?>
    <p class="nenhum">Nenhum jogo encontrado para esta época.</p>

<?php else: ?>

    <?php while ($j = $jogos->fetch_assoc()): ?>

        <div class="agenda-card">

            <div class="agenda-card-title">
                <?= htmlspecialchars($j['competicao']) ?>
            </div>

            <div class="agenda-card-info">

                <strong><?= htmlspecialchars($j['equipa_casa']) ?></strong>
                <span>—</span>
                <strong><?= htmlspecialchars($j['equipa_fora']) ?></strong>

                <span class="agenda-data">
                    <?= date("d/m", strtotime($j['data_jogo'])) ?>
                </span>

                <span class="agenda-hora">
                    <?= substr($j['hora_jogo'], 0, 5) ?>
                </span>

                <div class="agenda-local">
                    <?= htmlspecialchars($j['local_jogo']) ?>
                </div>

            </div>

        </div>

    <?php endwhile; ?>

<?php endif; ?>

</section>

</body>
</html>
