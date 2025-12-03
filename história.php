<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>História - Associação Desportiva de Ponte da Barca</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <!-- 🔻 Cabeçalho -->
  <header class="topo">
    <img src="Imagens/Gerais/Logotipo ADPB_projeto.png" alt="Logotipo ADPB" class="logo">

    <button class="hamburger" id="hamburger">☰</button>

    <nav class="nav-principal" id="navMenu">
      <ul>
        <li><a href="index.php">Início</a></li>
        <li><a href="história.php" class="ativo">História</a></li>
        <li><a href="resultados.php">Resultados</a></li>
        <li><a href="agenda.php">Agenda</a></li>
        <li><a href="Equipa.php">Equipa</a></li>
        <li><a href="galeria.php">Galeria</a></li>
        <li><a href="contactos.php">Contactos</a></li>
        
 
<?php if (isset($_SESSION['username'])): ?>
  <li class="user-info">
    <a href="Utilizador/perfil.php" class="user-link">
      👤 <?php echo htmlspecialchars($_SESSION['username']); ?>
    </a>
    <a href="admin/logout.php" class="logout-link">Sair</a>
  </li>
<?php else: ?>
  <li><a href="admin/login.php">Entrar</a></li>
<?php endif; ?>


      </ul>
    </nav>
  </header>


  <!-- 📜 Fundo com imagem e overlay -->
 <section class="fundo-historia">
  <div class="overlay-historia">
    <div class="historia-container">
      <div class="historia-texto">
        <h1>A nossa História</h1>
        <p>
          Fundada em 1966, a Associação Desportiva de Ponte da Barca nasceu da paixão local pelo futebol.  
          Desde então, tornou-se símbolo desportivo e social da vila, levando o nome de Ponte da Barca a todo o país.
        </p>
      </div>

      <div class="historia-imagens">
        <img src="Imagens/História/Imagem_Jogadores.png" alt="Equipa ADPB" class="historia-foto">
        <img src="Imagens/História/Imagem_Estádio_e_Adeptos.jpg" alt="Adeptos ADPB" class="historia-foto">
      </div>
    </div>
  </div>
</section>


  <!-- 📘 Conteúdo principal -->
  <main class="container historia">

    <!-- 🕓 Linha do Tempo -->
    <section class="timeline-section">
      <p>Momentos marcantes da história da Associação Desportiva de Ponte da Barca.</p>

      <div class="timeline">
        <div class="timeline-item">
          <span class="year">1966</span>
          <div class="dot"></div>
          <p class="event">Fundação</p>
        </div>

        <div class="timeline-item">
          <span class="year">1984</span>
          <div class="dot"></div>
          <p class="event">Jogo histórico com o Benfica</p>
        </div>

        <div class="timeline-item">
          <span class="year">2013/2014</span>
          <div class="dot"></div>
          <p class="event">Taça de Portugal vs Académica</p>
        </div>

        <div class="timeline-item">
          <span class="year">2015/2016</span>
          <div class="dot"></div>
          <p class="event">Campeonato Distrital + Supertaça</p>
        </div>

        <div class="timeline-item">
          <span class="year">2022</span>
          <div class="dot"></div>
          <p class="event">Reestruturação e nova direção</p>
        </div>
      </div>
    </section>


    <!-- 🏆 Palmarés -->
    <section class="palmares">
      <h2>Conquistas e Palmarés</h2>
      <div class="palmares-grid">
        <div class="palmares-item">
          <h3 class="contador" data-target="4">0</h3>
          <p>1ª Divisão AFVC</p>
        </div>
        <div class="palmares-item">
          <h3 class="contador" data-target="5">0</h3>
          <p>Divisão de Honra AFVC</p>
        </div>
        <div class="palmares-item">
          <h3 class="contador" data-target="1">0</h3>
          <p>Supertaça AFVC</p>
        </div>
      </div>
    </section>




  <!-- ⚫ Rodapé -->
  <footer class="rodape">
    <p>© 2025 Associação Desportiva de Ponte da Barca</p>
  </footer>

  <script src="Menu.js"></script>
</body>
</html>




