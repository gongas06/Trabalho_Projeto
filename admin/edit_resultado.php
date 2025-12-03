<?php
require_once 'auth.php';
require_once 'db.php';
require_login();

$id = intval($_GET['id'] ?? 0);
if ($id === 0) {
    die("ID inválido.");
}

$res = $mysqli->query("SELECT * FROM resultados WHERE id = $id");
$r = $res->fetch_assoc();

include 'includes/header.php';
?>

<h3>Editar Resultado</h3>

<form action="edit_resultado_submit.php" method="POST" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $r['id'] ?>">
include 'includes/header.php';
?>

<h3>Editar Resultado</h3>

<form action="edit_resultado_submit.php" method="POST" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $r['id'] ?>">

    <div class="mb-3">
        <label>Equipa da Casa</label>
        <input class="form-control" name="equipa_casa" value="<?= htmlspecialchars($r['equipa_casa']) ?>" required>
    </div>

    <div class="mb-3">
        <label>Equipa de Fora</label>
        <input class="form-control" name="equipa_fora" value="<?= htmlspecialchars($r['equipa_fora']) ?>" required>
    </div>

    <div class="mb-3">
        <label>Golos da Casa</label>
        <input class="form-control" type="number" name="golo_casa" value="<?= $r['golo_casa'] ?>" required>
    </div>

    <div class="mb-3">
        <label>Golos de Fora</label>
        <input class="form-control" type="number" name="golo_fora" value="<?= $r['golo_fora'] ?>" required>
    </div>

    <p><strong>Imagem Casa atual:</strong> <?= $r['imagem_casa'] ?: "Nenhuma" ?></p>
    <input type="file" class="form-control mb-3" name="imagem_casa">

    <p><strong>Imagem Fora atual:</strong> <?= $r['imagem_fora'] ?: "Nenhuma" ?></p>
    <input type="file" class="form-control mb-3" name="imagem_fora">

    <button class="btn btn-primary">Guardar Alterações</button>

</form>

<?php include 'includes/footer.php'; ?>
