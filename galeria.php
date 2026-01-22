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
                <?php
                $file_name = $row['imagem'] ?? '';
                $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $is_video = in_array($ext, ['mp4', 'webm', 'ogg'], true);
                ?>
                <div class="galeria-item" data-type="<?= $is_video ? 'video' : 'image' ?>" role="button" tabindex="0">
                    <?php if ($is_video): ?>
                        <video src="uploads/<?php echo $row['imagem']; ?>" muted playsinline></video>
                    <?php else: ?>
                        <img src="uploads/<?php echo $row['imagem']; ?>" alt="Imagem da galeria">
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>

    <?php else: ?>
        <p>Ainda não há imagens nesta secção.</p>
    <?php endif; ?>

    <div class="galeria-lightbox" id="galeriaLightbox" aria-hidden="true">
      <button type="button" class="galeria-lightbox-fechar" aria-label="Fechar">×</button>
      <button type="button" class="galeria-lightbox-nav prev" aria-label="Imagem anterior">‹</button>
      <button type="button" class="galeria-lightbox-nav next" aria-label="Imagem seguinte">›</button>
      <img src="" alt="Imagem ampliada">
      <video controls></video>
    </div>

<?php include 'footer.php'; ?>

  <script src="Menu.js"></script>
  <script>
    const lightbox = document.getElementById("galeriaLightbox");
    const lightboxImg = lightbox.querySelector("img");
    const lightboxVideo = lightbox.querySelector("video");
    const closeBtn = lightbox.querySelector(".galeria-lightbox-fechar");
    const prevBtn = lightbox.querySelector(".galeria-lightbox-nav.prev");
    const nextBtn = lightbox.querySelector(".galeria-lightbox-nav.next");
    const items = Array.from(document.querySelectorAll(".galeria-item"));
    let currentIndex = -1;

    function openLightbox(type, src, altText, index) {
      if (type === "video") {
        lightboxImg.style.display = "none";
        lightboxVideo.style.display = "block";
        lightboxVideo.src = src;
        lightboxVideo.play();
      } else {
        lightboxVideo.pause();
        lightboxVideo.removeAttribute("src");
        lightboxVideo.style.display = "none";
        lightboxImg.style.display = "block";
        lightboxImg.src = src;
        lightboxImg.alt = altText || "Imagem ampliada";
      }
      if (typeof index === "number") {
        currentIndex = index;
      }
      lightbox.classList.add("ativo");
      lightbox.setAttribute("aria-hidden", "false");
    }

    function closeLightbox() {
      lightbox.classList.remove("ativo");
      lightbox.setAttribute("aria-hidden", "true");
      lightboxVideo.pause();
      lightboxVideo.removeAttribute("src");
    }

    function openByIndex(index) {
      const total = items.length;
      if (!total) return;
      const normalized = (index + total) % total;
      const item = items[normalized];
      const img = item.querySelector("img");
      const video = item.querySelector("video");
      if (img) {
        openLightbox("image", img.src, img.alt, normalized);
      } else if (video) {
        openLightbox("video", video.currentSrc || video.src, "Video da galeria", normalized);
      }
    }

    items.forEach((item, index) => {
      item.addEventListener("click", () => openByIndex(index));
      item.addEventListener("keydown", (event) => {
        if (event.key === "Enter" || event.key === " ") {
          event.preventDefault();
          openByIndex(index);
        }
      });
    });

    document.addEventListener("keydown", (event) => {
      if (event.key === "Escape" && lightbox.classList.contains("ativo")) {
        closeLightbox();
      }
      if (lightbox.classList.contains("ativo") && (event.key === "ArrowRight" || event.key === "ArrowLeft")) {
        event.preventDefault();
        openByIndex(currentIndex + (event.key === "ArrowRight" ? 1 : -1));
      }
    });

    closeBtn.addEventListener("click", closeLightbox);
    prevBtn.addEventListener("click", () => openByIndex(currentIndex - 1));
    nextBtn.addEventListener("click", () => openByIndex(currentIndex + 1));
    lightbox.addEventListener("click", (event) => {
      if (event.target === lightbox) {
        closeLightbox();
      }
    });
  </script>
</body>
</html>
