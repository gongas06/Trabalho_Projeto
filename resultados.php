<?php
session_start();
require_once "./admin/db.php";
?>


<header class="topo">
    <img src="Imagens/Gerais/Logotipo ADPB_projeto.png" alt="Logo ADPB" class="logo">

    <button class="hamburger" id="hamburger">☰</button>

    <nav class="nav-principal" id="navMenu">

      <ul>
            <li><a href="index.php">Início</a></li>
            <li><a href="história.php">História</a></li>
            <li><a href="noticias.php">Noticias</a></li>
            <li><a href="resultados.php" class="ativo">Resultados</a></li>
            <li><a href="agenda.php">Agenda</a></li>
            <li><a href="Equipa.php">Equipa</a></li>
            <li><a href="galeria.php">Galeria</a></li>
            <li><a href="contactos.php">Contactos</a></li>
            
            

            <?php if (isset($_SESSION['username'])): ?>
            <li class="user-info">
                <span>👤 <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="admin/logout.php" class="logout-link">Sair</a>
            </li>
            <?php else: ?>
            <li><a href="admin/login.php">Entrar</a></li>
            <?php endif; ?>
         </ul>
    </nav>

    </header>

<?php // Lê filtros
$epoca = $_GET['epoca'] ?? '';
$competicao = $_GET['competicao'] ?? '';

// Construção da query
$sql = "SELECT * FROM resultados WHERE 1=1";

// Parâmetros preparados
$params = [];
$tipos = "";

// Filtro por época
if ($epoca !== '') {
    $sql .= " AND epoca = ?";
    $params[] = $epoca;
    $tipos .= "s";
}

// Filtro por competição
if ($competicao !== '') {
    $sql .= " AND competicao = ?";
    $params[] = $competicao;
    $tipos .= "s";
}

$sql .= " ORDER BY created_at DESC";

// Preparar statement
$stmt = $mysqli->prepare($sql);

// Se existirem parâmetros, fazer bind
if (!empty($params)) {
    $stmt->bind_param($tipos, ...$params);
}

$stmt->execute();
$res = $stmt->get_result();
?>

<style>
body { font-family: Arial, sans-serif; background:#f5f5f5; }

.container {
    max-width: 1200px;
    margin: auto;
    padding: 30px;
}

/* Filtros */
.filtros {
    display: flex;
    gap: 25px;
    margin-bottom: 25px;
    align-items: flex-end;
}

.filtros select {
    padding: 10px;
    font-size: 16px;
    width: 220px;
    border-radius: 8px;
    border: 1px solid #aaa;
}

.btn {
    padding: 11px 28px;
    background: #c72626;
    border: none;
    color: white;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
}

/* Lista de resultados */
.jogos-lista {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.card {
    width: 260px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 14px;
    padding: 18px;
    text-align: center;
    box-shadow: 0 3px 8px rgba(0,0,0,0.10);
}

.card img {
    width: 65px;
}

.equipas {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.resultado {
    font-size: 24px;
    font-weight: bold;
    margin: 10px 0;
}
.info {
    margin-top: 8px;
    color: #555;
    font-size: 14px;
}
</style>

</head>
<body>

<div class="container">

<h1>Resultados</h1>
<h3>Filtros</h3>

<form class="filtros" method="GET">
    
    <div>
        <label>Época</label><br>
        <select name="epoca">
            <option value="">Todas</option>
            <option value="2025/26" <?= $epoca=="2025/26"?"selected":"" ?>>2025/26</option>
        </select>
    </div>

    <div>
        <label>Competição</label><br>
        <select name="competicao">
            <option value="">Todas</option>
            <option value="AF Viana do Castelo 1ª Divisão" <?= $competicao=="AF Viana do Castelo 1ª Divisão"?"selected":"" ?>>AF Viana do Castelo 1ª Divisão</option>
            <option value="AF Viana do Castelo Taça 25/26" <?= $competicao=="AF Viana do Castelo Taça 25/26"?"selected":"" ?>>AF Viana do Castelo Taça 25/26</option>
        </select>
    </div>

    <button class="btn">Procurar</button>
</form>


<!-- LISTA DE RESULTADOS (SEM CARROSSEL) -->
<div class="jogos-lista">

<?php while ($r = $res->fetch_assoc()): ?>
    
    <div class="card">
        
        <div class="equipas">
            <img src="uploads/<?= htmlspecialchars($r['imagem_casa']) ?>" alt="">
            <img src="uploads/<?= htmlspecialchars($r['imagem_fora']) ?>" alt="">
        </div>

        <div class="resultado">
            <?= $r['golo_casa'] ?> - <?= $r['golo_fora'] ?>
        </div>

        <p><?= htmlspecialchars($r['equipa_casa']) ?> vs <?= htmlspecialchars($r['equipa_fora']) ?></p>

        <p class="info">
            <?= htmlspecialchars($r['competicao']) ?> — <?= htmlspecialchars($r['epoca']) ?? '' ?>
        </p>

    </div>

<?php endwhile; ?>

</div>

</div>


<?php include 'footer.php'; ?>
<script src="Menu.js"></script>

</body>
</html>