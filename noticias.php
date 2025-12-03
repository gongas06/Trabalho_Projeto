<?php
require_once "admin/db.php";

$id = $_GET['id'] ?? 0;

$stmt = $mysqli->prepare("SELECT * FROM noticias WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$noticia = $res->fetch_assoc();

if (!$noticia) {
    echo "Notícia não encontrada.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($noticia['title']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header class="topo">
    <a href="index.php" class="logo-voltar">⬅ Voltar</a>
</header>

<section class="noticia-pagina">
    <div class="container">
        <img src=".../uploads<?php echo $noticia['image']; ?>" class="noticia-img">

        <h1><?php echo htmlspecialchars($noticia['title']); ?></h1>

        <p class="noticia-corpo">
            <?php echo nl2br($noticia['body']); ?>
        </p>

        <p class="autor-data">
            Publicada em <?php echo date("d/m/Y", strtotime($noticia['created_at'])); ?>
            • Autor: <?php echo htmlspecialchars($noticia['author']); ?>
        </p>
    </div>
</section>

</body>
</html>
