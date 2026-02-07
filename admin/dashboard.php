<?php
// Dashboard do backoffice com métricas e acessos rápidos.
require_once 'auth.php';
require_once 'db.php';
require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado. Apenas o administrador pode gerir.");
}
$isAdmin = is_admin();
$isSuperAdmin = is_superadmin();

// Métricas de conteúdo.
$countGames = $mysqli->query(
    "SELECT COUNT(*) as c FROM resultados"
)->fetch_assoc()['c'] ?? 0;

$countNews = $mysqli->query(
    "SELECT COUNT(*) as c FROM noticias"
)->fetch_assoc()['c'] ?? 0;

$countAgenda = $mysqli->query(
    "SELECT COUNT(*) as c FROM agenda"
)->fetch_assoc()['c'] ?? 0;

$countGaleria = $mysqli->query(
    "SELECT COUNT(*) as c FROM galeria"
)->fetch_assoc()['c'] ?? 0;

$countMensagens = 0;
$mensagensCountResult = $mysqli->query(
    "SELECT COUNT(*) as c FROM mensagens"
);
if ($mensagensCountResult) {
    $countMensagens = $mensagensCountResult->fetch_assoc()['c'] ?? 0;
}

$countUsers = 0;
$usersResult = null;
if ($isAdmin) {
    // Apenas admins veem métricas e listagem de utilizadores.
    $countUsers = $mysqli->query(
        "SELECT COUNT(*) as c FROM utilizadores"
    )->fetch_assoc()['c'] ?? 0;

    $usersResult = $mysqli->query(
        "SELECT id, username, email, role FROM utilizadores ORDER BY id DESC LIMIT 10"
    );
}

include 'includes/header.php';
?>

<div class="admin-layout">
    <aside class="admin-sidebar">
        <div class="admin-sidebar-title">Painel</div>
        <nav class="admin-sidebar-nav">
            <a class="active" href="dashboard.php">Dashboard</a>
            <a href="resultados.php">Gestão de Resultados</a>
            <a href="news.php">Gestão de Notícias</a>
            <a href="agenda.php">Gestão de Agenda</a>
            <a href="galeria.php">Gestão da Galeria</a>
            <a href="mensagens.php">Mensagens</a>
            <?php if ($isAdmin): ?>
                <a href="users.php">Gestão de Utilizadores</a>
            <?php endif; ?>
            <a href="logout.php" class="danger">Terminar sessão</a>
        </nav>
        <a class="admin-sidebar-cta" href="../index.php">Ver site</a>
    </aside>

    <section class="admin-main">
        <div class="admin-main-header">
            <div>
                <h2>Dashboard</h2>
                <p>Bem-vindo, <?= htmlspecialchars($_SESSION['username']); ?>.</p>
            </div>
        </div>

        <div class="admin-card-grid">
            <article class="admin-card">
                <div class="admin-card-title">Resultados</div>
                <div class="admin-card-metric">
                    <?= (int)$countGames; ?> registados
                </div>
                <a href="resultados.php" class="admin-card-link">
                    Gerir Jogos
                </a>
            </article>

            <article class="admin-card">
                <div class="admin-card-title">Notícias</div>
                <div class="admin-card-metric">
                    <?= (int)$countNews; ?> publicadas
                </div>
                <a href="news.php" class="admin-card-link">
                    Gerir Notícias
                </a>
            </article>

            <article class="admin-card">
                <div class="admin-card-title">Agenda</div>
                <div class="admin-card-metric">
                    <?= (int)$countAgenda; ?> jogos agendados
                </div>
                <a href="agenda.php" class="admin-card-link">
                    Gerir Agenda
                </a>
            </article>

            <article class="admin-card">
                <div class="admin-card-title">Galeria</div>
                <div class="admin-card-metric">
                    <?= (int)$countGaleria; ?> fotos
                </div>
                <a href="galeria.php" class="admin-card-link">
                    Gerir Galeria
                </a>
            </article>

            <article class="admin-card">
                <div class="admin-card-title">Mensagens</div>
                <div class="admin-card-metric">
                    <?= (int)$countMensagens; ?> recebidas
                </div>
                <a href="mensagens.php" class="admin-card-link">
                    Ver Mensagens
                </a>
            </article>

            <?php if ($isAdmin): ?>
            <article class="admin-card">
                <div class="admin-card-title">Utilizadores</div>
                <div class="admin-card-metric">
                    <?= (int)$countUsers; ?> registados
                </div>
                <a href="users.php" class="admin-card-link">
                    Gerir Utilizadores
                </a>
            </article>
            <?php endif; ?>
        </div>

    </section>
</div>

<?php include 'includes/footer.php'; ?>
