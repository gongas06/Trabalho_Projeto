<?php
session_start();
include __DIR__ . "/admin/db.php";

$result = $mysqli->query("SELECT * FROM galeria WHERE categoria = 'comunidade' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria - Associação Desportiva de Ponte da Barca</title>
    <link rel="stylesheet" href="style.css">
  </head>

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
        <li><a href="galeria.php" class="ativo">Galeria</a></li>
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

    <h2 class="section-title">A nossa comunidade</h2>

    <?php if ($result->num_rows > 0): ?>

        <div class="galeria-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="galeria-item">
                    <img src="uploads/<?php echo $row['imagem']; ?>" alt="">
                </div>
            <?php endwhile; ?>
        </div>

    <?php else: ?>
        <p>Ainda não há imagens nesta secção.</p>
    <?php endif; ?>


<?php include 'footer.php'; ?>

  <script src="Menu.js"></script>
  <script>
    const lightbox = document.getElementById("galeriaLightbox");
    const lightboxImg = lightbox ? lightbox.querySelector("img") : null;
    const closeBtn = lightbox ? lightbox.querySelector(".galeria-lightbox-fechar") : null;

    const openLightbox = (src, alt) => {
      if (!lightbox || !lightboxImg) return;
      lightboxImg.src = src;
      lightboxImg.alt = alt || "";
      lightbox.classList.add("ativo");
      lightbox.setAttribute("aria-hidden", "false");
      document.body.style.overflow = "hidden";
    };

    const closeLightbox = () => {
      if (!lightbox || !lightboxImg) return;
      lightbox.classList.remove("ativo");
      lightbox.setAttribute("aria-hidden", "true");
      lightboxImg.src = "";
      document.body.style.overflow = "";
    };

    document.querySelectorAll(".galeria-item img").forEach((img) => {
      img.addEventListener("click", () => {
        openLightbox(img.src, img.alt);
      });
    });

    if (lightbox) {
      lightbox.addEventListener("click", (event) => {
        if (event.target === lightbox) {
          closeLightbox();
        }
      });
    }

    if (closeBtn) {
      closeBtn.addEventListener("click", closeLightbox);
    }

    document.addEventListener("keydown", (event) => {
      if (event.key === "Escape") {
        closeLightbox();
      }
    });
  </script>
</html>
