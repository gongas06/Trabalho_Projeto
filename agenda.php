<?php
session_start();
require_once __DIR__ . '/admin/db.php';
?>

<header class="topo">
    <img src="Imagens/Gerais/Logotipo ADPB_projeto.png" alt="Logo ADPB" class="logo">


    <button class="hamburger" id="hamburger">☰</button>

    <nav class="nav-principal" id="navMenu">

      <ul>
        <li><a href="index.php">Início</a></li>
        <li><a href="história.php">História</a></li>
        <li><a href="resultados.php">Resultados</a></li>
        <li><a href="agenda.php" class="ativo">Agenda</a></li>
        <li><a href="Equipa.php">Equipa</a></li>
        <li><a href="galeria.php">Galeria</a></li>
        <li><a href="contactos.php">Contactos</a></li>
        
        

<?php if (isset($_SESSION['username'])): ?>
  <li class="user-info">
    <span>👤 <?php echo htmlspecialchars($_SESSION['username']); ?></span>
    <a href="admin/logout.php" class="logout-link">Sair</a>
  </li>
<?php else: ?>
  <li><a href="admin/login.php">Entrar</a></li>
<?php endif; ?>


      </ul>
    </nav>

    </header>
<?php

$hoje = date("Y-m-d");

// Buscar épocas
$anos = $mysqli->query("SELECT DISTINCT epoca FROM agenda ORDER BY epoca DESC");

// Época selecionada
$epoca = isset($_GET['epoca']) ? $_GET['epoca'] : "2025/2026";

// Buscar apenas jogos futuros
$jogos = $mysqli->query("
    SELECT * FROM agenda
    WHERE epoca = '$epoca'
    AND data_jogo >= '$hoje'
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
    <p class="nenhum">Nenhum jogo futuro encontrado nesta época.</p>

<?php else: ?>

    <?php while ($j = $jogos->fetch_assoc()): ?>


           <div class="agenda-card">

    <div class="agenda-card-title">
        <?= htmlspecialchars($j['competicao']) ?>
    </div>

    <div class="agenda-linha">
        <strong><?= htmlspecialchars($j['equipa_casa']) ?></strong>
        <span>—</span>
        <strong><?= htmlspecialchars($j['equipa_fora']) ?></strong>

        <div class="agenda-data-hora">
            <span><?= date("d/m", strtotime($j['data_jogo'])) ?></span>
            <span><?= substr($j['hora_jogo'], 0, 5) ?></span>
        </div>
    </div>

    <div class="agenda-local">
        <?= htmlspecialchars($j['local_jogo']) ?>
    </div>

</div>


    <?php endwhile; ?>

<?php endif; ?>

</section>

</body>
</html>


