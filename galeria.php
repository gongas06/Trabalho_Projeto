<?php
session_start();


include __DIR__ . "/admin/db.php";


$result = $mysqli->query("SELECT * FROM galeria ORDER BY id DESC");



$result = $mysqli->query("SELECT * FROM galeria WHERE categoria='dia'");
?>

    <!-- 🔻 Cabeçalho -->
  <header class="topo">
    <img src="Imagens/Gerais/Logotipo ADPB_projeto.png" alt="Logo ADPB" class="logo">


    <button class="hamburger" id="hamburger">☰</button>

    <nav class="nav-principal" id="navMenu">

      <ul>
        <li><a href="index.php">Início</a></li>
        <li><a href="história.php">História</a></li>
        <li><a href="resultados.php">Resultados</a></li>
        <li><a href="agenda.php">Agenda</a></li>
        <li><a href="Equipa.php">Equipa</a></li>
        <li><a href="galeria.php" class="ativo">Galeria</a></li>
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

<h2 class="section-title">A nossa comunidade</h2>

<?php
$sqlCarousel = $mysqli->query("SELECT * FROM galeria WHERE categoria='comunidade'");
?>


<div class="carousel">
    <?php if ($sqlCarousel && $sqlCarousel->num_rows > 0): ?>
        <?php while ($row = $sqlCarousel->fetch_assoc()): ?>
            <img src="uploads/<?= $row['imagem']; ?>" alt="<?= $row['descricao']; ?>">
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center;">Ainda não há imagens nesta secção.</p>
    <?php endif; ?>
</div>





<h2 class="section-title">O nosso dia a dia</h2>

<?php
$sqlDia = $mysqli->query("SELECT * FROM galeria WHERE categoria='dia'");
?>


<div class="gallery">
    <?php if ($sqlDia && $sqlDia->num_rows > 0): ?>
        <?php while ($row = $sqlDia->fetch_assoc()): ?>
            <img src="uploads/<?= $row['imagem']; ?>" alt="<?= $row['descricao']; ?>">
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center;">Ainda não há fotos nesta secção.</p>
    <?php endif; ?>
</div>

</body>
</html>
