<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

require_login();
if (!is_admin()) {
    http_response_code(403);
    die('Acesso negado. Apenas o administrador pode gerir a galeria.');
}

$sql = "SELECT * FROM galeria ORDER BY id DESC";
$result = $mysqli->query($sql);

if (!$result) {
    die("Erro ao carregar galeria: " . $mysqli->error);
}
?>
<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Gestão da Galeria — Admin</title>
  <link rel="stylesheet" href="../style.css">

  <style>
    body {
        padding: 20px;
        font-family: Arial, sans-serif;
    }
    table { width:100%; border-collapse:collapse; margin-top:20px; }
    th, td { padding:10px; border:1px solid #ddd; text-align:left; }
    th { background:#f2f2f2; }
    img.thumb, video.thumb { height:60px; border-radius:6px; display:block; }
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
        <h1>Gestão da Galeria</h1>
        <div>
            <a class="btn" href="add_galeria.php">+ Adicionar Foto</a>
            <a class="btn secondary" href="dashboard.php">Voltar ao Dashboard</a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagem</th>
                <th>Categoria</th>
                <th>Criado em</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= (int)$row['id'] ?></td>
                <td>
                    <?php
                    $file_name = $row['imagem'] ?? '';
                    $file_rel = $file_name ? ('../uploads/' . $file_name) : '';
                    $file_abs = $file_name ? (__DIR__ . '/../uploads/' . $file_name) : '';
                    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                    $is_video = in_array($ext, ['mp4', 'webm', 'ogg'], true);
                    if ($file_rel && $file_abs && file_exists($file_abs)): ?>
                        <?php if ($is_video): ?>
                            <video class="thumb" src="<?= $file_rel ?>" muted></video>
                        <?php else: ?>
                            <img class="thumb" src="<?= $file_rel ?>" alt="Media da galeria">
                        <?php endif; ?>
                    <?php else: ?>
                        <span style="color:#888;">Sem ficheiro</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['categoria'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['created_at'] ?? ($row['criado_em'] ?? '')) ?></td>
                <td>
                    <a href="edit_galeria.php?id=<?= (int)$row['id'] ?>">Editar</a> |
                    <a href="delete_galeria.php?id=<?= (int)$row['id'] ?>"
                        onclick="return confirm('Eliminar esta imagem?');"
                        style="color:#c00;">
                        Eliminar
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>

        <?php else: ?>
            <tr><td colspan="5">Nenhuma imagem encontrada.</td></tr>
        <?php endif; ?>
        </tbody>

    </table>
</div>

</body>
</html>
