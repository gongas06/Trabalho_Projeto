<?php
// Página de resultados com filtros por época e competição.
session_start();
// Ligação à base de dados para carregar resultados.
require_once "./admin/db.php";
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Resultados</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="resultados.css">
</head>

<body>

<header class="topo">
    <img src="Imagens/Gerais/Logotipo ADPB_projeto.png" alt="Logo ADPB" class="logo">

    <button class="hamburger" id="hamburger">☰</button>

    <nav class="nav-principal" id="navMenu">
        <ul>
            <li><a href="index.php">Início</a></li>
            <li><a href="história.php">História</a></li>
            <li><a href="noticias.php">Notícias</a></li>
            <li><a href="resultados.php" class="ativo">Resultados</a></li>
            <li><a href="agenda.php">Agenda</a></li>
            <li><a href="Equipa.php">Equipa</a></li>
            <li><a href="galeria.php">Galeria</a></li>
            <li><a href="contactos.php">Contactos</a></li>

            <?php if (isset($_SESSION['username'])): ?>
                <li class="user-info">
                    <a href="Utilizador/perfil.php" class="user-link">
                        <?= htmlspecialchars($_SESSION['username']); ?>
                    </a>
                    <a href="admin/logout.php" class="logout-link">Sair</a>
                </li>
            <?php else: ?>
                <li><a href="admin/login.php">Entrar</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<?php
// Parâmetros de filtro vindos da query string.
$epoca = $_GET['epoca'] ?? '';
$competicao = $_GET['competicao'] ?? '';

// Consulta dinâmica com filtros opcionais (statement preparado).
$sql = "SELECT * FROM resultados WHERE 1=1";
$params = [];
$tipos = "";

if ($epoca !== '') {
    $sql .= " AND epoca = ?";
    $params[] = $epoca;
    $tipos .= "s";
}

if ($competicao !== '') {
    $sql .= " AND competicao = ?";
    $params[] = $competicao;
    $tipos .= "s";
}

$sql .= " ORDER BY created_at DESC";

$stmt = $mysqli->prepare($sql);

if (!empty($params)) {
    // Tipos e parâmetros apenas quando existem filtros ativos.
    $stmt->bind_param($tipos, ...$params);
}

$stmt->execute();
$res = $stmt->get_result();
?>

<div class="pagina-resultados">
    <div class="container">

        <h1>Resultados</h1>

        <form class="filtros" method="GET">
            <div>
                <label>Época</label>
                <select name="epoca">
                    <option value="">Todas</option>
                    <option value="2025/2026" <?= $epoca=="2025/2026"?"selected":"" ?>>2025/2026</option>
                </select>
            </div>

            <div>
                <label>Competição</label>
                <select name="competicao">
                    <option value="">Todas</option>
                    <option value="AF Viana do Castelo 1ª Divisão" <?= $competicao=="AF Viana do Castelo 1ª Divisão"?"selected":"" ?>>
                        AF Viana do Castelo 1ª Divisão
                    </option>
                    <option value="AF Viana do Castelo Taça" <?= $competicao=="AF Viana do Castelo Taça"?"selected":"" ?>>
                        AF Viana do Castelo Taça 
                    </option>
                </select>
            </div>

            <button class="btn">Procurar</button>
        </form>

        <div class="jogos-lista">
            <?php while ($r = $res->fetch_assoc()): ?>
                <!-- Card por jogo com imagens das equipas e resultado -->
                <div class="card">
                    <div class="equipas">
                        <img src="uploads/<?= htmlspecialchars($r['imagem_casa']) ?>">
                        <img src="uploads/<?= htmlspecialchars($r['imagem_fora']) ?>">
                    </div>

                    <div class="resultado">
                        <?= $r['golo_casa'] ?> - <?= $r['golo_fora'] ?>
                    </div>

                    <p><?= htmlspecialchars($r['equipa_casa']) ?> vs <?= htmlspecialchars($r['equipa_fora']) ?></p>

                    <p class="info">
                        <?= htmlspecialchars($r['competicao']) ?> — <?= htmlspecialchars($r['epoca']) ?>
                    </p>
                </div>
            <?php endwhile; ?>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>
<script src="Menu.js"></script>

</body>
</html>
