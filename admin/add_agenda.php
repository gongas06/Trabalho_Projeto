<?php
require_once 'auth.php';
require_login();
include 'includes/header.php';
?>

<div class="container mt-5">
    <h2 class="text-center mb-4" style="color:#b30000;">Adicionar Jogo</h2>

    <div class="card p-4 shadow-sm">
        <form action="add_agenda_submit.php" method="POST">

            <div class="mb-3">
                <label>Equipa da Casa</label>
                <input type="text" name="equipa_casa" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Equipa de Fora</label>
                <input type="text" name="equipa_fora" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Data do Jogo</label>
                <input type="date" name="data_jogo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Hora do Jogo</label>
                <input type="time" name="hora_jogo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Local do Jogo</label>
                <input type="text" name="local_jogo" class="form-control" required>
            </div>

            <button class="btn btn-success">Guardar</button>
            <a href="agenda.php" class="btn btn-secondary">Cancelar</a>

        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
