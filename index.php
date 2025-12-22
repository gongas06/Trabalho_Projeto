<?php
session_start();
require_once __DIR__ . '/admin/db.php';
?>


<!DOCTYPE html>
<html lang="pt-PT">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>ADPB — Associação Desportiva de Ponte da Barca</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="topo">
  <img src="Imagens/Gerais/Logotipo ADPB_projeto.png" class="logo">

  <button class="hamburger" id="hamburger">☰</button>

  <nav class="nav-principal" id="navMenu">
    <ul>
      <li><a href="index.php" class="ativo">Início</a></li>
      <li><a href="história.php">História</a></li>
      <li><a href="noticias.php">Noticias</a></li>
      <li><a href="resultados.php">Resultados</a></li>
      <li><a href="agenda.php">Agenda</a></li>
      <li><a href="Equipa.php">Equipa</a></li>
      <li><a href="galeria.php">Galeria</a></li>
      <li><a href="contactos.php">Contactos</a></li>

      <?php if(isset($_SESSION['username'])): ?>
        <li class="user-info">
          <a href="Utilizador/perfil.php">👤 <?= $_SESSION['username']; ?></a>
          <a href="admin/logout.php" class="logout-link">Sair</a>
        </li>
      <?php else: ?>
        <li><a href="admin/login.php">Entrar</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<!-- HERO -->
<section class="hero">
  <div class="overlay">
    <h1>Paixão, Identidade e Resiliência desde 1966</h1>
    <p class="sub">
      Associação Desportiva de Ponte da Barca — orgulho local e futebol comunitário.
    </p>
    <a href="história.php" class="botao botao-branco">Saber mais</a>
  </div>
</section>

<!-- ÚLTIMOS RESULTADOS -->
<section class="ultimos-resultados">
    <div class="container">
        <h2>Últimos Resultados</h2>
        <?php
        $res = $mysqli->query("SELECT * FROM resultados ORDER BY created_at DESC LIMIT 4");
        ?>

        <div class="resultados-grid">
        <?php while ($r = $res->fetch_assoc()): ?>
            <div class="resultado-card">
                <div class="resultado-equipas">

                    <div class="equipa">
                        <img src="uploads/<?= htmlspecialchars($r['imagem_casa']); ?>" alt="">
                        <p><?= htmlspecialchars($r['equipa_casa']); ?></p>
                    </div>

                    <div class="resultado-score">
                        <?= $r['golo_casa'] ?> - <?= $r['golo_fora'] ?>
                    </div>

                    <div class="equipa">
                        <img src="uploads/<?= htmlspecialchars($r['imagem_fora']); ?>" alt="">
                        <p><?= htmlspecialchars($r['equipa_fora']); ?></p>
                    </div>

                    
                </div>
            </div>
        <?php endwhile; ?>

        </div>
    </div>
</section>



<!-- PRÓXIMO JOGO -->
<section class="proximo-jogo">
    <div class="container">

      <?php
date_default_timezone_set('Europe/Lisbon');

$proxSQL = "
    SELECT * FROM agenda
    WHERE TIMESTAMP(data_jogo, hora_jogo) > NOW()
    ORDER BY data_jogo ASC, hora_jogo ASC
    LIMIT 1
";
$proxRes = $mysqli->query($proxSQL);
$prox = $proxRes->fetch_assoc();
?>


        <?php if ($prox): ?>
        <div class="proximo-jogo-box">

            <div class="proximo-jogo-left">
                <h2>Próximo Jogo</h2>

                <div class="proximo-jogo-info">
                    <?= htmlspecialchars($prox['equipa_casa']) ?>
                    <span>—</span>
                    <?= htmlspecialchars($prox['equipa_fora']) ?>

                    <span><?= date("d/m", strtotime($prox['data_jogo'])) ?></span>
                    <span>—</span>
                    <?= substr($prox['hora_jogo'], 0, 5) ?>
                </div>
            </div>

            <a href="agenda.php" class="btn-agenda">Ver agenda completa</a>
        </div>

        <?php else: ?>
            <p>Nenhum jogo marcado.</p>
        <?php endif; ?>

    </div>
</section>

<!-- ÚLTIMAS NOTÍCIAS -->
<section class="ultimas-noticias">
    <div class="container">
        <h2 class="titulo-sec">Últimas Notícias</h2>

        <?php
        $news = $mysqli->query("SELECT * FROM noticias ORDER BY created_at DESC LIMIT 4");
        ?>

        <div class="noticias-grid">
            <?php while($n = $news->fetch_assoc()): ?>
                <article class="noticia-card">
                    <a href="noticia.php?id=<?= $n['id']; ?>">
                        <img src="uploads/<?= htmlspecialchars($n['image']); ?>" class="noticia-img">
                    </a>

                    <div class="noticia-info">
                        <h3><?= htmlspecialchars($n['title']); ?></h3>

                        <p class="noticia-excerto">
                            <?= htmlspecialchars(substr(strip_tags($n['body']), 0, 90)) ?>...
                        </p>

                        <a href="noticia.php?id=<?= $n['id']; ?>" class="btn-ler-mais">LER MAIS</a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <div class="centro">
            <a href="noticias.php" class="btn-ver-todas">Ver todas</a>
        </div>
    </div>
</section>

<?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin'): ?>
<div class="admin-actions">
    <a href="admin/dashboard.php" class="admin-btn">Dashboard</a>

</div>
<?php endif; ?>

<?php include 'footer.php'; ?>
<script>

document.getElementById("hamburger").addEventListener("click", () => {
  document.getElementById("navMenu").classList.toggle("ativo");
});
</script>

</body>
</html>



