<?php
session_start();
require_once __DIR__ . '/admin/db.php';
require_once __DIR__ . '/loja_helpers.php';

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_GET['action'] ?? '';

if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $varianteId = (int)($_POST['variante_id'] ?? 0);
    $quantidade = (int)($_POST['quantidade'] ?? 1);

    if ($varianteId > 0 && $quantidade > 0) {
        $stmt = $mysqli->prepare("
            SELECT v.id, v.stock, p.ativo
            FROM loja_produto_variantes v
            JOIN loja_produtos p ON p.id = v.produto_id
            WHERE v.id = ? AND v.ativo = 1
            LIMIT 1
        ");
        $stmt->bind_param('i', $varianteId);
        $stmt->execute();
        $variant = $stmt->get_result()->fetch_assoc();

        if ($variant && (int)$variant['ativo'] === 1) {
            $current = $_SESSION['cart'][$varianteId] ?? 0;
            $newQty = $current + $quantidade;
            $maxStock = (int)$variant['stock'];
            if ($maxStock <= 0) {
                $newQty = 0;
            } elseif ($newQty > $maxStock) {
                $newQty = $maxStock;
            }
            if ($newQty > 0) {
                $_SESSION['cart'][$varianteId] = $newQty;
            }
        }
    }

    header('Location: carrinho.php');
    exit();
}

if ($action === 'remove') {
    $varianteId = (int)($_GET['variante_id'] ?? 0);
    if ($varianteId > 0) {
        unset($_SESSION['cart'][$varianteId]);
    }
    header('Location: carrinho.php');
    exit();
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantidades = $_POST['quantidade'] ?? [];
    foreach ($quantidades as $varId => $qty) {
        $varId = (int)$varId;
        $qty = (int)$qty;
        if ($varId <= 0) {
            continue;
        }
        if ($qty <= 0) {
            unset($_SESSION['cart'][$varId]);
            continue;
        }
        $_SESSION['cart'][$varId] = $qty;
    }
    header('Location: carrinho.php');
    exit();
}

$cart = $_SESSION['cart'];
$variants = loja_fetch_cart_variants($mysqli, $cart);

$total = 0.0;

foreach (array_keys($cart) as $varId) {
    if (!isset($variants[$varId])) {
        unset($_SESSION['cart'][$varId]);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Carrinho — Loja ADPB</title>
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
      <li><a href="loja.php">Loja</a></li>
      <li><a href="carrinho.php" class="ativo">Carrinho (<?= loja_cart_count(); ?>)</a></li>

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

<section class="carrinho-container">
  <h1>O teu carrinho</h1>

  <?php if (empty($cart)): ?>
    <p>O carrinho está vazio.</p>
    <a class="produto-btn" href="loja.php">Voltar à loja</a>
  <?php else: ?>
    <form method="post" action="carrinho.php?action=update">
      <div class="carrinho-tabela">
        <?php foreach ($cart as $varianteId => $qty): ?>
          <?php if (!isset($variants[$varianteId])) continue; ?>
          <?php
            $v = $variants[$varianteId];
            $nomeVar = trim(($v['tamanho'] ? $v['tamanho'] : '') . ' ' . ($v['cor'] ? $v['cor'] : ''));
            $nomeVar = $nomeVar !== '' ? $nomeVar : 'Standard';
            $subtotal = (float)$v['preco'] * (int)$qty;
            $total += $subtotal;
          ?>
          <div class="carrinho-item">
            <div class="carrinho-item-img">
              <?php if (!empty($v['imagem_principal'])): ?>
                <img src="uploads/loja/<?= htmlspecialchars($v['imagem_principal']); ?>" alt="">
              <?php else: ?>
                <div class="produto-placeholder small">Sem imagem</div>
              <?php endif; ?>
            </div>
            <div class="carrinho-item-info">
              <h3><?= htmlspecialchars($v['produto_nome']); ?></h3>
              <p><?= htmlspecialchars($nomeVar); ?></p>
              <p class="carrinho-preco"><?= loja_preco((float)$v['preco']); ?></p>
            </div>
            <div class="carrinho-item-qty">
              <input type="number" name="quantidade[<?= (int)$varianteId; ?>]" min="1" value="<?= (int)$qty; ?>">
            </div>
            <div class="carrinho-item-subtotal">
              <?= loja_preco($subtotal); ?>
            </div>
            <div class="carrinho-item-remove">
              <a href="carrinho.php?action=remove&variante_id=<?= (int)$varianteId; ?>">Remover</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="carrinho-resumo">
        <p>Total</p>
        <strong><?= loja_preco($total); ?></strong>
      </div>

      <div class="carrinho-actions">
        <button type="submit" class="produto-btn">Atualizar carrinho</button>
        <a href="checkout.php" class="produto-btn secundario">Finalizar compra</a>
      </div>
    </form>
  <?php endif; ?>
</section>

<?php include 'footer.php'; ?>
<script src="Menu.js"></script>

</body>
</html>
