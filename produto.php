<?php
session_start();
require_once __DIR__ . '/admin/db.php';
require_once __DIR__ . '/loja_helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    http_response_code(404);
    die('Produto não encontrado.');
}

$stmt = $mysqli->prepare("
    SELECT p.*, c.nome AS categoria_nome
    FROM loja_produtos p
    LEFT JOIN loja_categorias c ON c.id = p.categoria_id
    WHERE p.id = ? AND p.ativo = 1
    LIMIT 1
");
$stmt->bind_param('i', $id);
$stmt->execute();
$produto = $stmt->get_result()->fetch_assoc();

if (!$produto) {
    http_response_code(404);
    die('Produto não encontrado.');
}

$imgStmt = $mysqli->prepare("SELECT imagem FROM loja_produto_imagens WHERE produto_id = ? ORDER BY ordem ASC");
$imgStmt->bind_param('i', $id);
$imgStmt->execute();
$imgsRes = $imgStmt->get_result();

$varStmt = $mysqli->prepare("SELECT * FROM loja_produto_variantes WHERE produto_id = ? AND ativo = 1 ORDER BY preco ASC");
$varStmt->bind_param('i', $id);
$varStmt->execute();
$varsRes = $varStmt->get_result();
$variants = $varsRes->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?= htmlspecialchars($produto['nome']); ?> — Loja ADPB</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="topo">
  <img src="Imagens/Gerais/Logotipo ADPB_projeto.png" class="logo">

  <button class="hamburger" id="hamburger">☰</button>

  <nav class="nav-principal" id="navMenu">
    <ul>
      <li><a href="index.php">Início</a></li>
      <li><a href="história.php">História</a></li>
      <li><a href="noticias.php">Noticias</a></li>
      <li><a href="resultados.php">Resultados</a></li>
      <li><a href="agenda.php">Agenda</a></li>
      <li><a href="Equipa.php">Equipa</a></li>
      <li><a href="galeria.php">Galeria</a></li>
      <li><a href="contactos.php">Contactos</a></li>
      <li><a href="loja.php" class="ativo">Loja</a></li>
      <li><a href="carrinho.php">Carrinho (<?= loja_cart_count(); ?>)</a></li>

      <?php if(isset($_SESSION['username'])): ?>
        <li class="user-info">
          <a href="Utilizador/perfil.php"><?= $_SESSION['username']; ?></a>
          <a href="admin/logout.php" class="logout-link">Sair</a>
        </li>
      <?php else: ?>
        <li><a href="admin/login.php">Entrar</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<section class="produto-detalhe">
  <div class="produto-galeria">
    <?php if (!empty($produto['imagem_principal'])): ?>
      <img src="uploads/loja/<?= htmlspecialchars($produto['imagem_principal']); ?>" alt="" class="produto-img-principal">
    <?php endif; ?>

    <div class="produto-thumbs">
      <?php while ($img = $imgsRes->fetch_assoc()): ?>
        <img src="uploads/loja/<?= htmlspecialchars($img['imagem']); ?>" alt="">
      <?php endwhile; ?>
    </div>
  </div>

  <div class="produto-info">
    <h1><?= htmlspecialchars($produto['nome']); ?></h1>
    <p class="produto-cat"><?= htmlspecialchars($produto['categoria_nome'] ?? 'Sem categoria'); ?></p>
    <p class="produto-desc"><?= nl2br(htmlspecialchars($produto['descricao'] ?? '')); ?></p>

    <?php if (!empty($variants)): ?>
      <form class="produto-form" method="post" action="carrinho.php?action=add">
        <input type="hidden" name="produto_id" value="<?= (int)$produto['id']; ?>">

        <label>Variante</label>
        <select name="variante_id" required>
          <?php foreach ($variants as $v): ?>
            <?php
              $nomeVar = trim(($v['tamanho'] ? $v['tamanho'] : '') . ' ' . ($v['cor'] ? $v['cor'] : ''));
              $nomeVar = $nomeVar !== '' ? $nomeVar : 'Standard';
            ?>
            <option value="<?= (int)$v['id']; ?>">
              <?= htmlspecialchars($nomeVar); ?> — <?= loja_preco((float)$v['preco']); ?> (stock <?= (int)$v['stock']; ?>)
            </option>
          <?php endforeach; ?>
        </select>

        <label>Quantidade</label>
        <input type="number" name="quantidade" min="1" value="1" required>

        <button type="submit" class="produto-btn">Adicionar ao carrinho</button>
      </form>
    <?php else: ?>
      <p>Produto indisponível.</p>
    <?php endif; ?>
  </div>
</section>

<?php include 'footer.php'; ?>
<script src="Menu.js"></script>

</body>
</html>
