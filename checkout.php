<?php
session_start();
require_once __DIR__ . '/admin/db.php';
require_once __DIR__ . '/loja_helpers.php';

if (empty($_SESSION['cart'])) {
    header('Location: carrinho.php');
    exit();
}

$cart = $_SESSION['cart'];
$variants = loja_fetch_cart_variants($mysqli, $cart);

$err = '';
$total = 0.0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $morada = trim($_POST['morada'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $codigoPostal = trim($_POST['codigo_postal'] ?? '');
    $metodo = $_POST['payment_method'] ?? '';

    if ($nome === '' || $email === '' || $morada === '' || $cidade === '' || $codigoPostal === '') {
        $err = 'Preenche todos os campos obrigatórios.';
    } elseif (!in_array($metodo, ['card', 'mb_way', 'multibanco', 'paypal'], true)) {
        $err = 'Seleciona um método de pagamento.';
    } else {
        $mysqli->begin_transaction();
        try {
            foreach ($cart as $varianteId => $qty) {
                if (!isset($variants[$varianteId])) {
                    throw new Exception('Produto inválido no carrinho.');
                }
                $v = $variants[$varianteId];
                $subtotal = (float)$v['preco'] * (int)$qty;
                $total += $subtotal;
            }

            $token = bin2hex(random_bytes(16));
            $userId = !empty($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
            $provider = $metodo === 'paypal' ? 'paypal' : 'stripe';

            $stmt = $mysqli->prepare("
                INSERT INTO loja_encomendas
                (user_id, public_token, total, status, payment_provider, payment_method, payment_status, shipping_nome, shipping_email, shipping_telefone, shipping_morada, shipping_cidade, shipping_codigo_postal)
                VALUES (?, ?, ?, 'pending_payment', ?, ?, 'pending', ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param(
                'isdssssssss',
                $userId,
                $token,
                $total,
                $provider,
                $metodo,
                $nome,
                $email,
                $telefone,
                $morada,
                $cidade,
                $codigoPostal
            );
            $stmt->execute();
            $orderId = $stmt->insert_id;

            $itemStmt = $mysqli->prepare("
                INSERT INTO loja_encomenda_itens
                (encomenda_id, produto_id, variante_id, nome_produto, nome_variante, preco_unitario, quantidade, subtotal)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");

            foreach ($cart as $varianteId => $qty) {
                $v = $variants[$varianteId];
                $nomeVar = trim(($v['tamanho'] ? $v['tamanho'] : '') . ' ' . ($v['cor'] ? $v['cor'] : ''));
                $nomeVar = $nomeVar !== '' ? $nomeVar : 'Standard';
                $subtotal = (float)$v['preco'] * (int)$qty;
                $itemStmt->bind_param(
                    'iiissdid',
                    $orderId,
                    $v['produto_id'],
                    $varianteId,
                    $v['produto_nome'],
                    $nomeVar,
                    $v['preco'],
                    $qty,
                    $subtotal
                );
                $itemStmt->execute();
            }

            $mysqli->commit();
            $_SESSION['last_order_token'] = $token;
            header('Location: pagamento.php?order_id=' . $orderId . '&token=' . urlencode($token));
            exit();
        } catch (Throwable $e) {
            $mysqli->rollback();
            $err = 'Erro ao criar encomenda. Tenta novamente.';
        }
    }
}

$emailPrefill = '';
if (!empty($_SESSION['user_id'])) {
    $uStmt = $mysqli->prepare("SELECT email FROM utilizadores WHERE id = ? LIMIT 1");
    $uStmt->bind_param('i', $_SESSION['user_id']);
    $uStmt->execute();
    $u = $uStmt->get_result()->fetch_assoc();
    $emailPrefill = $u['email'] ?? '';
}

$total = 0.0;
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Checkout — Loja ADPB</title>
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

<section class="checkout-container">
  <h1>Checkout</h1>

  <?php if (!empty($err)): ?>
    <div class="alert-error"><?= htmlspecialchars($err); ?></div>
  <?php endif; ?>

  <div class="checkout-grid">
    <form method="post" class="checkout-form">
      <h3>Dados de entrega</h3>
      <label>Nome completo *</label>
      <input type="text" name="nome" required>

      <label>Email *</label>
      <input type="email" name="email" value="<?= htmlspecialchars($emailPrefill); ?>" required>

      <label>Telefone</label>
      <input type="text" name="telefone">

      <label>Morada *</label>
      <input type="text" name="morada" required>

      <label>Cidade *</label>
      <input type="text" name="cidade" required>

      <label>Código Postal *</label>
      <input type="text" name="codigo_postal" required>

      <h3>Método de pagamento</h3>
      <div class="checkout-payments">
        <label><input type="radio" name="payment_method" value="card" required> Cartão bancário (Stripe)</label>
        <label><input type="radio" name="payment_method" value="mb_way"> MB WAY (Stripe)</label>
        <label><input type="radio" name="payment_method" value="multibanco"> Multibanco (Stripe)</label>
        <label><input type="radio" name="payment_method" value="paypal"> PayPal</label>
      </div>

      <button type="submit" class="produto-btn">Confirmar e pagar</button>
    </form>

    <div class="checkout-resumo">
      <h3>Resumo</h3>
      <?php foreach ($cart as $varianteId => $qty): ?>
        <?php if (!isset($variants[$varianteId])) continue; ?>
        <?php
          $v = $variants[$varianteId];
          $nomeVar = trim(($v['tamanho'] ? $v['tamanho'] : '') . ' ' . ($v['cor'] ? $v['cor'] : ''));
          $nomeVar = $nomeVar !== '' ? $nomeVar : 'Standard';
          $subtotal = (float)$v['preco'] * (int)$qty;
          $total += $subtotal;
        ?>
        <div class="checkout-item">
          <span><?= htmlspecialchars($v['produto_nome']); ?> (<?= htmlspecialchars($nomeVar); ?>) × <?= (int)$qty; ?></span>
          <strong><?= loja_preco($subtotal); ?></strong>
        </div>
      <?php endforeach; ?>

      <div class="checkout-total">
        <span>Total</span>
        <strong><?= loja_preco($total); ?></strong>
      </div>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
<script src="Menu.js"></script>

</body>
</html>
