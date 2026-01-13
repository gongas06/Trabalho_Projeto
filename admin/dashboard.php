<?php
require_once 'auth.php';
require_once 'db.php';
require_login();

$countGames = $mysqli->query(
    "SELECT COUNT(*) as c FROM resultados"
)->fetch_assoc()['c'] ?? 0;

$countNews = $mysqli->query(
    "SELECT COUNT(*) as c FROM noticias"
)->fetch_assoc()['c'] ?? 0;

$countAgenda = $mysqli->query(
    "SELECT COUNT(*) as c FROM agenda"
)->fetch_assoc()['c'] ?? 0;

include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-8">
        <h2>Dashboard</h2>
        <p>Bem-vindo, <?= htmlspecialchars($_SESSION['username']); ?>.</p>

        <div class="row">

            <!-- JOGOS -->
            <div class="col-sm-6 col-md-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Jogos</h5>
                        <p class="card-text">
                            <?= (int)$countGames; ?> registados
                        </p>
                        <a href="add_resultado.php" class="btn btn-primary">
                            Gerir Jogos
                        </a>
                    </div>
                </div>
            </div>

            <!-- NOTÍCIAS -->
            <div class="col-sm-6 col-md-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Notícias</h5>
                        <p class="card-text">
                            <?= (int)$countNews; ?> publicadas
                        </p>
                        <a href="news.php" class="btn btn-primary">
                            Gerir Notícias
                        </a>
                    </div>
                </div>
            </div>

            <!-- AGENDA -->
            <div class="col-sm-6 col-md-4">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Agenda</h5>
                        <p class="card-text">
                            <?= (int)$countAgenda; ?> jogos agendados
                        </p>
                        <a href="add_agenda.php" class="btn btn-primary">
                            Gerir Agenda
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
