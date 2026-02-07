<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../loja_helpers.php';

require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado.");
}

$cats = $mysqli->query("SELECT id, nome FROM loja_categorias ORDER BY nome ASC");
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $categoriaId = (int)($_POST['categoria_id'] ?? 0);
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    if ($nome === '') {
        $err = 'Nome obrigatório.';
    } else {
        $slug = loja_slug($nome);
        $imagem = null;

        if (!empty($_FILES['imagem_principal']['name'])) {
            $ext = pathinfo($_FILES['imagem_principal']['name'], PATHINFO_EXTENSION);
            $filename = time() . '_' . $slug . '.' . strtolower($ext);
            $target = __DIR__ . '/../uploads/loja/' . $filename;
            if (move_uploaded_file($_FILES['imagem_principal']['tmp_name'], $target)) {
                $imagem = $filename;
            }
        }

        $categoriaId = $categoriaId > 0 ? $categoriaId : null;
        $stmt = $mysqli->prepare("
            INSERT INTO loja_produtos (categoria_id, nome, slug, descricao, imagem_principal, ativo)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param('issssi', $categoriaId, $nome, $slug, $descricao, $imagem, $ativo);
        if ($stmt->execute()) {
            header('Location: loja_produtos.php');
            exit();
        }
        $err = 'Erro ao criar produto.';
    }
}
?>
<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Novo Produto</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body { padding:20px; font-family: Arial, sans-serif; }
    .form { max-width:680px; }
    .form input, .form textarea, .form select { width:100%; padding:10px; margin-bottom:10px; }
    .btn { background:#b80000; color:#fff; padding:8px 14px; border-radius:6px; text-decoration:none; font-weight:600; border:none; }
    .btn.secondary { background:#444; }
  </style>
</head>
<body>
  <h1>Novo produto</h1>
  <?php if ($err): ?>
    <div class="alert-error"><?= htmlspecialchars($err); ?></div>
  <?php endif; ?>
  <form method="post" class="form" enctype="multipart/form-data">
    <label>Nome</label>
    <input type="text" name="nome" required>

    <label>Categoria</label>
    <select name="categoria_id">
      <option value="0">Sem categoria</option>
      <?php if ($cats): ?>
        <?php while ($c = $cats->fetch_assoc()): ?>
          <option value="<?= (int)$c['id']; ?>"><?= htmlspecialchars($c['nome']); ?></option>
        <?php endwhile; ?>
      <?php endif; ?>
    </select>

    <label>Descrição</label>
    <textarea name="descricao" rows="5"></textarea>

    <label>Imagem principal</label>
    <input type="file" name="imagem_principal" accept="image/*">

    <label><input type="checkbox" name="ativo" checked> Produto ativo</label>

    <button class="btn" type="submit">Guardar</button>
    <a class="btn secondary" href="loja_produtos.php">Cancelar</a>
  </form>
</body>
</html>
