<?php
require_once 'auth.php';
require_once 'db.php';
require_login();

$countGames = $mysqli->query('SELECT COUNT(*) as c FROM jogo')->fetch_assoc()['c'] ?? 0;
$countNews = $mysqli->query('SELECT COUNT(*) as c FROM noticia')->fetch_assoc()['c'] ?? 0;

include 'includes/header.php';
?>
<div class="row">
  <div class="col-md-8">
    <h2>Dashboard</h2>
    <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['user_name']); ?>.</p>
    <div class="row">
      <div class="col-sm-6">
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">Jogos</h5>
            <p class="card-text"><?php echo (int)$countGames; ?> registados</p>
            <a href="games.php" class="btn btn-primary">Gerir Jogos</a>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">Notícias</h5>
            <p class="card-text"><?php echo (int)$countNews; ?> publicadas</p>
            <a href="news.php" class="btn btn-primary">Gerir Notícias</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?>