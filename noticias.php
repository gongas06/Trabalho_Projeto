<?php
session_start();
require_once "admin/db.php";  

// NOTÍCIA EM DESTAQUE
$destaque = $mysqli->query("
    SELECT * FROM noticias 
    WHERE destaque = 1 
    ORDER BY created_at DESC 
    LIMIT 1
");

// RESTANTES NOTÍCIAS
$result = $mysqli->query("
    SELECT * FROM noticias 
    WHERE destaque = 0 
    ORDER BY created_at DESC 
    LIMIT 4
");
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notícias</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="topo">
  <img src="Imagens/Gerais/Logotipo ADPB_projeto.png" alt="Logo ADPB" class="logo">

  <button class="hamburger" id="hamburger">☰</button>

  <nav class="nav-principal" id="navMenu">
    <ul>
      <li><a href="index.php">Início</a></li>
      <li><a href="história.php">História</a></li>
      <li><a href="noticias.php" class="ativo">Notícias</a></li>
      <li><a href="resultados.php">Resultados</a></li>
      <li><a href="agenda.php">Agenda</a></li>
      <li><a href="Equipa.php">Equipa</a></li>
      <li><a href="galeria.php">Galeria</a></li>
      <li><a href="contactos.php">Contactos</a></li>

      <?php if (isset($_SESSION['username'])): ?>
  <li class="user-info">
    <a href="Utilizador/perfil.php" class="user-link">
      <?php echo htmlspecialchars($_SESSION['username']); ?>
    </a>
    <a href="admin/logout.php" class="logout-link">Sair</a>
  </li>
<?php else: ?>
  <li><a href="admin/login.php">Entrar</a></li>
<?php endif; ?>
    </ul>
  </nav>
</header>

<!-- NOTÍCIA EM DESTAQUE -->
<?php if ($d = $destaque->fetch_assoc()): ?>
<section class="noticia-destaque"
  style="background-image: url('uploads/<?= htmlspecialchars($d['image']); ?>');">

  <div class="overlay"></div>

  <div class="conteudo-destaque">
    <h1><?= htmlspecialchars($d['title']); ?></h1>

    <a href="noticia.php?id=<?= $d['id']; ?>" class="btn-ler">
      Ler mais
    </a>
  </div>
</section>
<?php endif; ?>

<!-- LISTA DE NOTÍCIAS -->
<main class="ultimas-noticias">
  <div class="container">
    <div class="noticias-lista">

      <?php while ($n = $result->fetch_assoc()): ?>
        <article class="noticia-item">

          <a href="noticia.php?id=<?= $n['id']; ?>" class="noticia-img-wrapper">
            <img src="uploads/<?= htmlspecialchars($n['image']); ?>" alt="">
          </a>

          <div class="noticia-conteudo">
            <a href="noticia.php?id=<?= $n['id']; ?>">
              <h3 class="noticia-titulo">
                <?= htmlspecialchars($n['title']); ?>
              </h3>
            </a>

            <p class="noticia-excerto">
              <?= htmlspecialchars(substr(strip_tags($n['body']), 0, 150)); ?>...
            </p>

            <div class="noticia-data">
              <?= date("m/Y", strtotime($n['created_at'])); ?>
            </div>
          </div>

        </article>
      <?php endwhile; ?>

    </div>
  </div>
</main>

<?php include 'footer.php'; ?>

<script src="Menu.js"></script>

</body>
</html>