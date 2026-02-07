<?php
session_start();
require_once __DIR__ . '/admin/db.php';
require_once __DIR__ . '/loja_helpers.php';

$categoriaId = isset($_GET['categoria']) ? (int)$_GET['categoria'] : 0;

$categoriasRes = $mysqli->query("SELECT id, nome, slug FROM loja_categorias ORDER BY nome ASC");
$categorias = [];
if ($categoriasRes) {
    while ($c = $categoriasRes->fetch_assoc()) {
        $categorias[] = $c;
    }
}

$sql = "
    SELECT p.id, p.nome, p.slug, p.descricao, p.imagem_principal, c.nome AS categoria_nome,
           MIN(v.preco) AS preco_min, MAX(v.preco) AS preco_max
    FROM loja_produtos p
    LEFT JOIN loja_categorias c ON c.id = p.categoria_id
    LEFT JOIN loja_produto_variantes v ON v.produto_id = p.id AND v.ativo = 1
    WHERE p.ativo = 1
";

if ($categoriaId > 0) {
    $sql .= " AND p.categoria_id = " . $categoriaId . " ";
}

$sql .= " GROUP BY p.id ORDER BY p.created_at DESC";
$produtosRes = $mysqli->query($sql);

$destaques = $mysqli->query("
    SELECT p.id, p.nome, p.imagem_principal, MIN(v.preco) AS preco_min, MAX(v.preco) AS preco_max
    FROM loja_produtos p
    LEFT JOIN loja_produto_variantes v ON v.produto_id = p.id AND v.ativo = 1
    WHERE p.ativo = 1
    GROUP BY p.id
    ORDER BY p.created_at DESC
    LIMIT 4
");

$novidades = $mysqli->query("
    SELECT p.id, p.nome, p.imagem_principal, MIN(v.preco) AS preco_min, MAX(v.preco) AS preco_max
    FROM loja_produtos p
    LEFT JOIN loja_produto_variantes v ON v.produto_id = p.id AND v.ativo = 1
    WHERE p.ativo = 1
    GROUP BY p.id
    ORDER BY p.created_at DESC
    LIMIT 8
");

$promocoes = $mysqli->query("
    SELECT p.id, p.nome, p.imagem_principal, MIN(v.preco) AS preco_min, MAX(v.preco) AS preco_max
    FROM loja_produtos p
    LEFT JOIN loja_produto_variantes v ON v.produto_id = p.id AND v.ativo = 1
    WHERE p.ativo = 1
    GROUP BY p.id
    ORDER BY preco_min ASC
    LIMIT 4
");
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Loja ADPB</title>
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

<section class="loja-hero">
  <div class="loja-hero-content">
    <h1>Loja Oficial ADPB</h1>
    <p>Equipamentos, merch e acessórios do clube.</p>
  </div>
</section>

<section class="loja-sec">
  <div class="loja-sec-header">
    <h2>Destaques</h2>
    <p>Os produtos mais procurados do clube.</p>
  </div>
  <div class="loja-grid loja-grid-compact">
    <?php if ($destaques && $destaques->num_rows > 0): ?>
      <?php while ($p = $destaques->fetch_assoc()): ?>
        <article class="produto-card">
          <a href="produto.php?id=<?= (int)$p['id']; ?>" class="produto-card-img">
            <?php if (!empty($p['imagem_principal'])): ?>
              <img src="uploads/loja/<?= htmlspecialchars($p['imagem_principal']); ?>" alt="">
            <?php else: ?>
              <div class="produto-placeholder">Sem imagem</div>
            <?php endif; ?>
          </a>
          <div class="produto-card-body">
            <h3><?= htmlspecialchars($p['nome']); ?></h3>
            <p class="produto-preco">
              <?php if ($p['preco_min'] !== null): ?>
                <?= loja_preco((float)$p['preco_min']); ?>
                <?php if ((float)$p['preco_max'] > (float)$p['preco_min']): ?>
                  - <?= loja_preco((float)$p['preco_max']); ?>
                <?php endif; ?>
              <?php else: ?>
                Sob consulta
              <?php endif; ?>
            </p>
            <a class="produto-btn" href="produto.php?id=<?= (int)$p['id']; ?>">Ver produto</a>
          </div>
        </article>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="loja-empty">Ainda não há destaques.</p>
    <?php endif; ?>
  </div>
</section>

<section class="loja-sec alt">
  <div class="loja-sec-header">
    <h2>Novidades</h2>
    <p>Os lançamentos mais recentes na loja ADPB.</p>
  </div>
  <div class="loja-grid">
    <?php if ($novidades && $novidades->num_rows > 0): ?>
      <?php while ($p = $novidades->fetch_assoc()): ?>
        <article class="produto-card">
          <a href="produto.php?id=<?= (int)$p['id']; ?>" class="produto-card-img">
            <?php if (!empty($p['imagem_principal'])): ?>
              <img src="uploads/loja/<?= htmlspecialchars($p['imagem_principal']); ?>" alt="">
            <?php else: ?>
              <div class="produto-placeholder">Sem imagem</div>
            <?php endif; ?>
          </a>
          <div class="produto-card-body">
            <h3><?= htmlspecialchars($p['nome']); ?></h3>
            <p class="produto-preco">
              <?php if ($p['preco_min'] !== null): ?>
                <?= loja_preco((float)$p['preco_min']); ?>
                <?php if ((float)$p['preco_max'] > (float)$p['preco_min']): ?>
                  - <?= loja_preco((float)$p['preco_max']); ?>
                <?php endif; ?>
              <?php else: ?>
                Sob consulta
              <?php endif; ?>
            </p>
            <a class="produto-btn" href="produto.php?id=<?= (int)$p['id']; ?>">Ver produto</a>
          </div>
        </article>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="loja-empty">Ainda não há novidades.</p>
    <?php endif; ?>
  </div>
</section>

<section class="loja-sec">
  <div class="loja-sec-header">
    <h2>Promoções</h2>
    <p>Os preços mais acessíveis da coleção.</p>
  </div>
  <div class="loja-grid loja-grid-compact">
    <?php if ($promocoes && $promocoes->num_rows > 0): ?>
      <?php while ($p = $promocoes->fetch_assoc()): ?>
        <article class="produto-card">
          <a href="produto.php?id=<?= (int)$p['id']; ?>" class="produto-card-img">
            <?php if (!empty($p['imagem_principal'])): ?>
              <img src="uploads/loja/<?= htmlspecialchars($p['imagem_principal']); ?>" alt="">
            <?php else: ?>
              <div class="produto-placeholder">Sem imagem</div>
            <?php endif; ?>
          </a>
          <div class="produto-card-body">
            <h3><?= htmlspecialchars($p['nome']); ?></h3>
            <p class="produto-preco">
              <?php if ($p['preco_min'] !== null): ?>
                <?= loja_preco((float)$p['preco_min']); ?>
                <?php if ((float)$p['preco_max'] > (float)$p['preco_min']): ?>
                  - <?= loja_preco((float)$p['preco_max']); ?>
                <?php endif; ?>
              <?php else: ?>
                Sob consulta
              <?php endif; ?>
            </p>
            <a class="produto-btn" href="produto.php?id=<?= (int)$p['id']; ?>">Ver produto</a>
          </div>
        </article>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="loja-empty">Ainda não há promoções.</p>
    <?php endif; ?>
  </div>
</section>

<section class="loja-container">
  <aside class="loja-categorias">
    <h3>Categorias</h3>
    <a class="<?= $categoriaId === 0 ? 'active' : '' ?>" href="loja.php">Todas</a>
    <?php foreach ($categorias as $cat): ?>
      <a class="<?= $categoriaId === (int)$cat['id'] ? 'active' : '' ?>"
         href="loja.php?categoria=<?= (int)$cat['id']; ?>">
        <?= htmlspecialchars($cat['nome']); ?>
      </a>
    <?php endforeach; ?>
  </aside>

  <div class="loja-grid">
    <?php if ($produtosRes && $produtosRes->num_rows > 0): ?>
      <?php while ($p = $produtosRes->fetch_assoc()): ?>
        <article class="produto-card">
          <a href="produto.php?id=<?= (int)$p['id']; ?>" class="produto-card-img">
            <?php if (!empty($p['imagem_principal'])): ?>
              <img src="uploads/loja/<?= htmlspecialchars($p['imagem_principal']); ?>" alt="">
            <?php else: ?>
              <div class="produto-placeholder">Sem imagem</div>
            <?php endif; ?>
          </a>
          <div class="produto-card-body">
            <h3><?= htmlspecialchars($p['nome']); ?></h3>
            <p class="produto-cat"><?= htmlspecialchars($p['categoria_nome'] ?? 'Sem categoria'); ?></p>
            <p class="produto-preco">
              <?php if ($p['preco_min'] !== null): ?>
                <?= loja_preco((float)$p['preco_min']); ?>
                <?php if ((float)$p['preco_max'] > (float)$p['preco_min']): ?>
                  - <?= loja_preco((float)$p['preco_max']); ?>
                <?php endif; ?>
              <?php else: ?>
                Sob consulta
              <?php endif; ?>
            </p>
            <a class="produto-btn" href="produto.php?id=<?= (int)$p['id']; ?>">Ver produto</a>
          </div>
        </article>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="loja-empty">Ainda não há produtos disponíveis.</p>
    <?php endif; ?>
  </div>
</section>

<section class="loja-faq">
  <div class="loja-sec-header">
    <h2>FAQ</h2>
    <p>Respostas rápidas sobre compras e entregas.</p>
  </div>
  <div class="loja-faq-grid">
    <div class="loja-faq-item">
      <h4>Quanto tempo demora a entrega?</h4>
      <p>Normalmente entre 2 a 5 dias úteis após confirmação do pagamento.</p>
    </div>
    <div class="loja-faq-item">
      <h4>Posso trocar tamanhos?</h4>
      <p>Sim, desde que o produto esteja novo e com etiqueta. Contacta-nos.</p>
    </div>
    <div class="loja-faq-item">
      <h4>Que métodos de pagamento existem?</h4>
      <p>Pagamento online seguro com Stripe. Outros métodos podem ser adicionados.</p>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
<script src="Menu.js"></script>

</body>
</html>
