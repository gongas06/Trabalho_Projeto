<?php
session_start();
require_once __DIR__ . '/db.php';

// Apenas o administrador pode aceder
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    http_response_code(403);
    die("Acesso negado. Apenas o administrador pode gerir notícias.");
}

// Buscar notícias
$sql = "SELECT * FROM noticias ORDER BY created_at DESC";
$result = $mysqli->query($sql);

if (!$result) {
    die("Erro ao carregar notícias: " . $mysqli->error);
}
?>
<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Gestão de Notícias — Admin</title>
  <link rel="stylesheet" href="../style.css">

  <style>
    body {
        padding: 20px;
        font-family: Arial, sans-serif;
    }
    table { width:100%; border-collapse:collapse; margin-top:20px; }
    th, td { padding:10px; border:1px solid #ddd; text-align:left; }
    th { background:#f2f2f2; }
    img.thumb { height:60px; border-radius:6px; display:block; }
    .topbar { display:flex; justify-content:space-between; align-items:center; }
    .btn {
        background:#b80000;
        color:white;
        padding:8px 14px;
        border-radius:6px;
        text-decoration:none;
        font-weight:600;
        margin-left:10px;
    }
    .btn.secondary {
        background:#444;
    }
  </style>
</head>
<body>

<div class="container">

    <div class="topbar">
        <h1>Gestão de Notícias</h1>
        <div>
            <a class="btn" href="add_news.php">+ Adicionar Notícia</a>
            <a class="btn secondary" href="dashboard.php">Voltar ao Dashboard</a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Imagem</th>
                <th>Publicado em</th>
                <th>Criado em</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>

                <td><?= htmlspecialchars($row['title']) ?></td>

                <td><?= htmlspecialchars($row['author']) ?></td>

                <td>
                    <?php
                    $image_path = '../uploads/noticias/' . $row['image'];
                    if (!empty($row['image']) && file_exists($image_path)): ?>
                        <img class="thumb" src="<?= $image_path ?>" alt="Imagem da notícia">
                    <?php else: ?>
                        <span style="color:#888;">Sem imagem</span>
                    <?php endif; ?>
                </td>

                <td><?= htmlspecialchars($row['published_at']) ?></td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>

                <td>
                    <a href="edit_news.php?id=<?= $row['id'] ?>">Editar</a> |
                    <a href="delete_news.php?id=<?= $row['id'] ?>"
                        onclick="return confirm('Eliminar esta notícia?');"
                        style="color:#c00;">
                        Eliminar
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>

        <?php else: ?>
            <tr><td colspan="7">Nenhuma notícia encontrada.</td></tr>
        <?php endif; ?>
        </tbody>

    </table>
</div>

</body>
</html>


