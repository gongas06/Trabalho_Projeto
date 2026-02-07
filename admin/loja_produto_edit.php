<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../loja_helpers.php';

require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado.");
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die('Produto inválido.');
}

$stmt = $mysqli->prepare("SELECT * FROM loja_produtos WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$produto = $stmt->get_result()->fetch_assoc();
if (!$produto) {
    die('Produto não encontrado.');
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
        $imagem = $produto['imagem_principal'];

        if (!empty($_FILES['imagem_principal']['name'])) {
            $ext = pathinfo($_FILES['imagem_principal']['name'], PATHINFO_EXTENSION);
            $filename = time() . '_' . $slug . '.' . strtolower($ext);
            $target = __DIR__ . '/../uploads/loja/' . $filename;
            if (move_uploaded_file($_FILES['imagem_principal']['tmp_name'], $target)) {
                $imagem = $filename;
            }
        }

        $categoriaId = $categoriaId > 0 ? $categoriaId : null;
        $upd = $mysqli->prepare("
            UPDATE loja_produtos
            SET categoria_id = ?, nome = ?, slug = ?, descricao = ?, imagem_principal = ?, ativo = ?
            WHERE id = ?
        ");
        $upd->bind_param('issssii', $categoriaId, $nome, $slug, $descricao, $imagem, $ativo, $id);
        if ($upd->execute()) {
            header('Location: loja_produtos.php');
            exit();
        }
        $err = 'Erro ao atualizar produto.';
    }
}

$imgsStmt = $mysqli->prepare("SELECT * FROM loja_produto_imagens WHERE produto_id = ? ORDER BY ordem ASC");
$imgsStmt->bind_param('i', $id);
$imgsStmt->execute();
$imgsRes = $imgsStmt->get_result();
?>
<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Editar Produto</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body { padding:20px; font-family: Arial, sans-serif; }
    .form { max-width:680px; }
    .form input, .form textarea, .form select { width:100%; padding:10px; margin-bottom:10px; }
    .btn { background:#b80000; color:#fff; padding:8px 14px; border-radius:6px; text-decoration:none; font-weight:600; border:none; }
    .btn.secondary { background:#444; }
    .thumbs { display:flex; gap:10px; flex-wrap:wrap; margin:10px 0; }
    .thumbs img { height:60px; border-radius:6px; }
  </style>
</head>
<body>
  <h1>Editar produto</h1>
  <?php if ($err): ?>
    <div class="alert-error"><?= htmlspecialchars($err); ?></div>
  <?php endif; ?>
  <form method="post" class="form" enctype="multipart/form-data">
    <label>Nome</label>
    <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']); ?>" required>

    <label>Categoria</label>
    <select name="categoria_id">
      <option value="0">Sem categoria</option>
      <?php if ($cats): ?>
        <?php while ($c = $cats->fetch_assoc()): ?>
          <option value="<?= (int)$c['id']; ?>" <?= (int)$produto['categoria_id'] === (int)$c['id'] ? 'selected' : ''; ?>>
            <?= htmlspecialchars($c['nome']); ?>
          </option>
        <?php endwhile; ?>
      <?php endif; ?>
    </select>

    <label>Descrição</label>
    <textarea name="descricao" rows="5"><?= htmlspecialchars($produto['descricao'] ?? ''); ?></textarea>

    <label>Imagem principal</label>
    <?php if (!empty($produto['imagem_principal'])): ?>
      <div class="thumbs">
        <img src="../uploads/loja/<?= htmlspecialchars($produto['imagem_principal']); ?>" alt="">
      </div>
    <?php endif; ?>
    <input type="file" name="imagem_principal" accept="image/*">

    <label><input type="checkbox" name="ativo" <?= (int)$produto['ativo'] === 1 ? 'checked' : ''; ?>> Produto ativo</label>

    <button class="btn" type="submit">Guardar</button>
    <a class="btn secondary" href="loja_produtos.php">Cancelar</a>
  </form>

  <h2>Galeria do produto</h2>
  <form method="post" action="loja_produto_imagem_add.php" enctype="multipart/form-data" class="form">
    <input type="hidden" name="produto_id" value="<?= (int)$produto['id']; ?>">
    <label>Adicionar imagem</label>
    <input type="file" name="imagem" accept="image/*" required>
    <button class="btn" type="submit">Adicionar</button>
  </form>

  <div class="thumbs">
    <?php while ($img = $imgsRes->fetch_assoc()): ?>
      <div>
        <img src="../uploads/loja/<?= htmlspecialchars($img['imagem']); ?>" alt="">
        <div>
          <a href="loja_produto_imagem_delete.php?id=<?= (int)$img['id']; ?>&produto_id=<?= (int)$produto['id']; ?>" style="color:#c00;">Eliminar</a>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <div style="margin-top:20px;">
    <a class="btn secondary" href="loja_variantes.php?produto_id=<?= (int)$produto['id']; ?>">Gerir variantes</a>
  </div>
</body>
</html>
