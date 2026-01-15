<?php
require_once __DIR__ . '/admin/db.php';

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    http_response_code(404);
    echo "Notícia não encontrada";
    exit;
}

$stmt = $mysqli->prepare("SELECT * FROM noticias WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$noticia = $result->fetch_assoc();

if (!$noticia) {
    http_response_code(404);
    echo "Notícia não encontrada";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($noticia['title']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: #f2f2f2;
            color: #333;
        }

        .noticia-detalhe {
            padding: 60px 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 40px;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .voltar {
            text-decoration: none;
            color: #666;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 20px;
        }

        .titulo-noticia {
            font-size: 2.2rem;
            margin-bottom: 10px;
            color: #111;
        }

        .meta {
            font-size: 0.9rem;
            color: #888;
            margin-bottom: 30px;
        }

        .imagem-noticia {
            width: 100%;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .conteudo {
            font-size: 1.05rem;
            line-height: 1.8;
        }

        @media (max-width: 600px) {
            .container {
                padding: 25px;
            }

            .titulo-noticia {
                font-size: 1.7rem;
            }
        }
    </style>
</head>
<body>

<section class="noticia-detalhe">
    <div class="container">

        <a href="noticias.php" class="voltar">← Voltar às notícias</a>

        <h1 class="titulo-noticia"><?= htmlspecialchars($noticia['title']) ?></h1>

        <div class="meta">
            <?= date('d/m/Y', strtotime($noticia['created_at'])) ?>
        </div>

        <?php if (!empty($noticia['image'])): ?>
            <img src="uploads/<?= htmlspecialchars($noticia['image']) ?>" class="imagem-noticia">
        <?php endif; ?>

        <div class="conteudo">
            <?= nl2br(htmlspecialchars($noticia['body'])) ?>
        </div>

    </div>
</section>

</body>
</html>

