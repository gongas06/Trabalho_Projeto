<?php
// Backoffice: formulário de edição de resultado.
require_once 'auth.php';
require_once 'db.php';
require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado. Apenas o administrador pode gerir os resultados.");
}

$id = intval($_GET['id'] ?? 0);
if ($id === 0) {
    die("ID inválido.");
}

// Carrega dados atuais do resultado.
$res = $mysqli->query("SELECT * FROM resultados WHERE id = $id");
$r = $res->fetch_assoc();

// Normaliza o caminho das imagens.
function resolve_result_image_path($path) {
    if (!$path) {
        return null;
    }
    if (strpos($path, 'uploads/') === 0) {
        return '../' . $path;
    }
    return '../uploads/' . $path;
}

include 'includes/header.php';
?>

<div class="container admin-edit">
    <h1>Editar Resultado</h1>

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

    <div class="mb-3">
        <label>Competição</label>
        <input class="form-control" name="competicao" value="<?= htmlspecialchars($r['competicao'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label>Época</label>
        <input class="form-control" name="epoca" value="<?= htmlspecialchars($r['epoca'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label>Imagem Casa atual</label>
        <?php
        $casa_path = resolve_result_image_path($r['imagem_casa'] ?? '');
        $casa_abs = $casa_path ? __DIR__ . '/' . $casa_path : null;
        if ($casa_path && $casa_abs && file_exists($casa_abs)): ?>
            <img class="admin-image-preview" src="<?= $casa_path ?>" alt="Imagem casa">
        <?php else: ?>
            <div class="admin-muted">Nenhuma</div>
        <?php endif; ?>
        <input type="file" class="form-control" name="imagem_casa">
    </div>

    <div class="mb-3">
        <label>Imagem Fora atual</label>
        <?php
        $fora_path = resolve_result_image_path($r['imagem_fora'] ?? '');
        $fora_abs = $fora_path ? __DIR__ . '/' . $fora_path : null;
        if ($fora_path && $fora_abs && file_exists($fora_abs)): ?>
            <img class="admin-image-preview" src="<?= $fora_path ?>" alt="Imagem fora">
        <?php else: ?>
            <div class="admin-muted">Nenhuma</div>
        <?php endif; ?>
        <input type="file" class="form-control" name="imagem_fora">
    </div>

    <div style="margin-top:12px;">
        <button class="btn" type="submit">Guardar Alterações</button>
        <a href="resultados.php" class="btn btn-secondary" style="margin-left:8px;">Voltar</a>
      </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
