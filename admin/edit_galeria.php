<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_login();

if (!is_admin()) {
    http_response_code(403);
    die('Acesso negado. Apenas o administrador pode gerir a galeria.');
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die('ID invalido.');
}

$stmt = $mysqli->prepare('SELECT id, imagem, categoria FROM galeria WHERE id = ? LIMIT 1');
if (!$stmt) {
    die('Erro ao preparar pedido.');
}
$stmt->bind_param('i', $id);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();

if (!$item) {
    die('Imagem nao encontrada.');
}
?>

<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Editar Foto — Admin</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body {
        padding: 20px;
        font-family: Arial, sans-serif;
    }
    .btn {
        background:#b80000;
        color:#fff;
        padding:8px 14px;
        border-radius:6px;
        text-decoration:none;
        font-weight:600;
        margin-left:10px;
        border:none;
        cursor:pointer;
    }
    .btn.secondary { background:#444; }
    .form-row { margin-bottom:12px; }
    label { display:block; font-weight:600; margin-bottom:6px; }
    input[type="text"], input[type="file"] {
        width:100%;
        padding:8px;
        border:1px solid #ccc;
        border-radius:6px;
    }
    .thumb {
        height:80px;
        border-radius:6px;
        display:block;
        margin-top:8px;
    }
  </style>
</head>
<body>

<div class="container">
    <h1>Editar Foto ou Video</h1>

    <form action="edit_galeria_submit.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">

        <div class="form-row">
            <label>Ficheiro atual</label>
            <?php
            $file_name = $item['imagem'] ?? '';
            $file_rel = $file_name ? ('../uploads/' . $file_name) : '';
            $file_abs = $file_name ? (__DIR__ . '/../uploads/' . $file_name) : '';
            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $is_video = in_array($ext, ['mp4', 'webm', 'ogg'], true);
            ?>
            <?php if ($file_rel && $file_abs && file_exists($file_abs)): ?>
                <?php if ($is_video): ?>
                    <video class="thumb" src="<?= $file_rel ?>" muted></video>
                <?php else: ?>
                    <img class="thumb" src="<?= $file_rel ?>" alt="Ficheiro atual">
                <?php endif; ?>
            <?php else: ?>
                <span style="color:#888;">Sem ficheiro</span>
            <?php endif; ?>
        </div>

        <div class="form-row">
            <label>Substituir ficheiro</label>
            <input type="file" name="imagem" accept="image/*,video/*">
        </div>

        <div class="form-row">
            <label>Categoria</label>
            <input type="text" name="categoria" value="<?= htmlspecialchars($item['categoria'] ?? '') ?>" required>
        </div>

        <div style="margin-top:12px;">
            <button type="submit" class="btn">Guardar Alterações</button>
            <a class="btn secondary" href="galeria.php" style="margin-left:8px;">Voltar</a>
        </div>
    </form>
</div>

</body>
</html>
