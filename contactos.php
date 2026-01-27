<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contactos</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- 🔻 Cabeçalho -->
  <header class="topo">
    <img src="Imagens/Gerais/Logotipo ADPB_projeto.png" alt="Logo ADPB" class="logo">

    <button class="hamburger" id="hamburger">☰</button>

    <nav class="nav-principal" id="navMenu">

      <ul>
        <li><a href="index.php">Início</a></li>
        <li><a href="história.php">História</a></li>
        <li><a href="noticias.php">Noticias</a></li>
        <li><a href="resultados.php">Resultados</a></li>
        <li><a href="agenda.php">Agenda</a></li>
        <li><a href="Equipa.php">Equipa</a></li>
        <li><a href="galeria.php">Galeria</a></li>
        <li><a href="contactos.php" class="ativo">Contactos</a></li>


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
  <section class="contactos-section" id="contactos">
  <h1>Contactos</h1>

  <div class="contactos-container">

    <div class="contactos-info">
      <h2> Sede do Clube</h2>
      <p><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2974.146372538899!2d-8.415196935036624!3d41.80360713142451!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd2508dc3172a46d%3A0x544892d7971ca82b!2sAdponted%20Abarca!5e0!3m2!1spt-PT!2spt!4v1760873512212!5m2!1spt-PT!2spt" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></p>

      <h2> Email</h2>
      <p><a href="mailto:adpontedabarca@gmail.com">adpbarca@gmail.com</a></p>

      <h2> Telefone</h2>
      <p><a href="tel:+351 969 810 274">+351 969 810 274</a></p>

      <h2>Fax</h2>
      <p><a href="fax:258 453 939">258 453 939</a></p>
  <h2>Estádio</h2>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3826.0412810802286!2d-8.4186608!3d41.8048481!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd2508e000c0f401%3A0xa3ffd9d4e5bf6db3!2sCampo%20Municipal%20Ponte%20da%20Barca!5e1!3m2!1spt-PT!2spt!4v1760873349128!5m2!1spt-PT!2spt" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>


    </div>
    <div class="contactos-form">
      <h2> Envia-nos uma mensagem</h2>
      <?php if (!empty($_GET['enviado'])): ?>
        <p style="color:#0a7a3b; font-weight:600; margin-bottom:12px;">Mensagem enviada com sucesso.</p>
      <?php elseif (!empty($_GET['erro'])): ?>
        <p style="color:#b00020; font-weight:600; margin-bottom:12px;">Erro ao enviar. Tenta novamente.</p>
      <?php endif; ?>
      <form action="enviar_mensagem.php" method="post">
        <input type="text" name="nome" placeholder="O teu nome" required>
        <input type="email" name="email" placeholder="O teu email" required>
        <textarea name="mensagem" rows="5" placeholder="Escreve a tua mensagem..." required></textarea>
        <button type="submit" class="botao">Enviar</button>
      </form>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>

<script src="Menu.js"></script>

