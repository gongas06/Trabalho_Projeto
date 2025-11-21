<?php

session_start();
require_once __DIR__ . '/db.php';

// Proteção: só admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    http_response_code(403);
    die("Acesso negado. Apenas o administrador pode gerir notícias.");
}

$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $body = trim($_POST['body'] ?? '');
    $author = $_SESSION['username']; // autor = utilizador logado
    $published_at = trim($_POST['published_at'] ?? '');
    if ($published_at === '') $published_at = date('Y-m-d H:i:s');

    // valida
    if ($title === '' || $body === '') {
        $err = 'Preenche título e conteúdo.';
    } else {
        // trata upload
        $image_name = null;
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/../uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $safeName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', basename($_FILES['image']['name']));
            $image_name = time() . '_' . $safeName;
            $target = $uploadDir . $image_name;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $err = 'Erro ao enviar imagem.';
            }
        }

        if (!$err) {
            $stmt = $mysqli->prepare("INSERT INTO noticias (title, body, author, published_at, image) VALUES (?, ?, ?, ?, ?)");
            if (!$stmt) { $err = 'Erro prepare: ' . $mysqli->error; }
            else {
                $stmt->bind_param('sssss', $title, $body, $author, $published_at, $image_name);
                if ($stmt->execute()) {
                    $msg = 'Notícia publicada com sucesso.';
                    // limpa valores do form
                    $title = $body = '';
                    $image_name = null;
                } else {
                    $err = 'Erro ao inserir notícia: ' . $stmt->error;
                }
            }
        }
    }
}
?>
<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Adicionar Notícia — Admin</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    .form-row { margin-bottom:12px; }
    label { display:block; font-weight:600; margin-bottom:6px; }
    input[type="text"], textarea { width:100%; padding:8px; border:1px solid #ccc; border-radius:6px; }
    .btn { background:#b80000; color:#fff; padding:8px 12px; border-radius:6px; text-decoration:none; border:none; cursor:pointer; }
    .alert { padding:10px; border-radius:6px; margin-bottom:12px; }
    .alert.err { background:#ffd4d4; color:#a10000; border:1px solid #a10000; }
    .alert.ok { background:#d4ffd4; color:#086; border:1px solid #086; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Adicionar Notícia</h1>
    <?php if ($err): ?><div class="alert err"><?php echo htmlspecialchars($err); ?></div><?php endif; ?>
    <?php if ($msg): ?><div class="alert ok"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <div class="form-row">
        <label>Título</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($title ?? ''); ?>" required>
      </div>

      <div class="form-row">
        <label>Conteúdo</label>
        <textarea name="body" rows="8" required><?php echo htmlspecialchars($body ?? ''); ?></textarea>
      </div>

      <div class="form-row">
        <label>Imagem (opcional)</label>
        <input type="file" name="image" accept="image/*">
      </div>

      <div class="form-row">
        <label>Data de publicação (opcional, YYYY-MM-DD HH:MM:SS)</label>
        <input type="text" name="published_at" value="<?php echo htmlspecialchars($published_at ?? ''); ?>">
      </div>

    <label>Link da notícia </label>
    <input type="text" name="url" placeholder="https://exemplo.com/noticia">



      <button type="submit" class="btn">Publicar</button>
      <a href="news.php" class="btn" style="background:#444; margin-left:8px; text-decoration:none; display:inline-block;">Voltar</a>
    </form>
  </div>
</body>
</html>
