<?php
require_once 'auth.php';
require_login();
include 'includes/header.php';
?>

<div class="container mt-5">
    <h2 class="text-center mb-4" style="color:#b30000;">Adicionar Resultado</h2>

    <div class="card p-4 shadow-sm">

        <form action="add_resultado_submit.php" method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Equipa da Casa</label>
                <input type="text" name="equipa_casa" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Equipa de Fora</label>
                <input type="text" name="equipa_fora" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Golos da Casa</label>
                <input type="number" name="golo_casa" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Golos de Fora</label>
                <input type="number" name="golo_fora" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Imagem Casa (opcional)</label>
                <input type="file" name="imagem_casa" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Imagem Fora (opcional)</label>
                <input type="file" name="imagem_fora" class="form-control">
            </div>

            <button class="btn btn-success">Guardar</button>
            <a class="btn btn-secondary" href="resultados.php">Voltar</a>

        </form>

    </div>
</div>

<?php include 'includes/footer.php'; ?>

