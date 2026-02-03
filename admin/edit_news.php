<?php
// Backoffice: edição de notícia existente.
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado. Apenas o administrador pode gerir notícias.");
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: news.php'); exit; }

// Buscar notícia atual.
$stmt = $mysqli->prepare("SELECT * FROM noticias WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$news = $stmt->get_result()->fetch_assoc();
if (!$news) { header('Location: news.php'); exit; }

$msg = '';
$err = '';

// Processa atualização após submissão.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $body = trim($_POST['body'] ?? '');
    $published_at = trim($_POST['published_at'] ?? '');
    $url = trim($_POST['url'] ?? '');
    $destaque = isset($_POST['destaque']) ? 1 : 0;
    if ($published_at === '') $published_at = date('Y-m-d H:i:s');

    if ($title === '' || $body === '') {
        $err = 'Preenche título e conteúdo.';
    } else {
        $image_name = $news['image'];

        // Upload de nova imagem (opcional).
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/../uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $safeName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', basename($_FILES['image']['name']));
            $newImage = time() . '_' . $safeName;
            $target = $uploadDir . $newImage;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                // apagar antiga se existir
                if (!empty($image_name) && file_exists($uploadDir . $image_name)) {
                    @unlink($uploadDir . $image_name);
                }
                $image_name = $newImage;
            } else {
                $err = 'Erro ao enviar nova imagem.';
            }
        }

        if (!$err) {
            $u = $mysqli->prepare("UPDATE noticias SET title=?, body=?, published_at=?, image=?, url=?, destaque=? WHERE id=?");
            $u->bind_param('sssssii', $title, $body, $published_at, $image_name, $url, $destaque, $id);
            if ($u->execute()) {
                $msg = 'Notícia atualizada com sucesso.';
                // refresh news data
                $news['title'] = $title;
                $news['body'] = $body;
                $news['published_at'] = $published_at;
                $news['image'] = $image_name;
                $news['url'] = $url;
                $news['destaque'] = $destaque;
            } else {
                $err = 'Erro ao atualizar: ' . $u->error;
            }
        }
    }
}
?>
<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Editar Notícia — Admin</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    label { display:block; margin-bottom:6px; font-weight:600; }
    input[type="text"], textarea { width:100%; padding:8px; border:1px solid #ccc; border-radius:6px; }
    .btn { background:#b80000; color:#fff; padding:8px 12px; border-radius:6px; border:none; cursor:pointer; }
    .alert { padding:10px; border-radius:6px; margin-bottom:12px; }
    .alert.err { background:#ffd4d4; color:#a10000; border:1px solid #a10000; }
    .alert.ok { background:#d4ffd4; color:#086; border:1px solid #086; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Editar Notícia</h1>

    <?php if ($err): ?><div class="alert err"><?php echo htmlspecialchars($err); ?></div><?php endif; ?>
    <?php if ($msg): ?><div class="alert ok"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <label>Título</label>
      <input type="text" name="title" value="<?php echo htmlspecialchars($news['title']); ?>" required>

      <label>Conteúdo</label>
      <textarea name="body" rows="8" required><?php echo htmlspecialchars($news['body']); ?></textarea>

      <label>Imagem atual</label>
      <?php if (!empty($news['image']) && file_exists(__DIR__ . '/../uploads/' . $news['image'])): ?>
        <img src="<?php echo '../uploads/' . htmlspecialchars($news['image']); ?>" alt="" style="max-height:140px; display:block; margin-bottom:8px;">
      <?php else: ?>
        <div style="color:#666; margin-bottom:8px;">Sem imagem</div>
      <?php endif; ?>

      <label>Substituir imagem (opcional)</label>
      <input type="file" name="image" accept="image/*">

      <label>Data de publicação (opcional)</label>
      <input type="text" name="published_at" value="<?php echo htmlspecialchars($news['published_at']); ?>">

      <label>Link da notícia</label>
      <input type="text" name="url" placeholder="https://exemplo.com/noticia"
             value="<?php echo htmlspecialchars($news['url'] ?? ''); ?>">

      <label>
        <input type="checkbox" name="destaque" value="1" <?php if (!empty($news['destaque'])) echo 'checked'; ?>>
        Colocar esta notícia em destaque
      </label>

      <div style="margin-top:12px;">
        <button class="btn" type="submit">Guardar Alterações</button>
        <a href="news.php" class="btn" style="background:#444; margin-left:8px; text-decoration:none; display:inline-block;">Voltar</a>
      </div>
    </form>
  </div>
</body>
</html>
