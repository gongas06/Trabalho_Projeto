<?php
require_once 'auth.php';
require_once 'db.php';
require_login();

$isSuperAdmin = !empty($_SESSION['username']) && $_SESSION['username'] === 'admin';

$countGames = $mysqli->query(
    "SELECT COUNT(*) as c FROM resultados"
)->fetch_assoc()['c'] ?? 0;

$countNews = $mysqli->query(
    "SELECT COUNT(*) as c FROM noticias"
)->fetch_assoc()['c'] ?? 0;

$countAgenda = $mysqli->query(
    "SELECT COUNT(*) as c FROM agenda"
)->fetch_assoc()['c'] ?? 0;

$countUsers = 0;
$usersResult = null;
if ($isSuperAdmin) {
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
            <a href="users.php">Gestão de Utilizadores</a>
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

            <?php if ($isSuperAdmin): ?>
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
