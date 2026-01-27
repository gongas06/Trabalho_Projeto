<?php
require_once "auth.php";
require_once "db.php";
require_login();

$id = intval($_GET['id']);
$res = $mysqli->query("SELECT * FROM agenda WHERE id = $id");
$j = $res->fetch_assoc();

include "includes/header.php";
?>

<div class="container mt-5">
    <h2 class="text-center mb-4" style="color:#b30000;">Editar Jogo</h2>

    <div class="card p-4 shadow-sm">
        <form action="edit_agenda_submit.php" method="POST">

            <input type="hidden" name="id" value="<?= $j['id'] ?>">

            <div class="mb-3">
                <label>Equipa da Casa</label>
                <input type="text" name="equipa_casa" class="form-control"
                       value="<?= htmlspecialchars($j['equipa_casa']) ?>" required>
            </div>

            <div class="mb-3">
                <label>Equipa de Fora</label>
                <input type="text" name="equipa_fora" class="form-control"
                       value="<?= htmlspecialchars($j['equipa_fora']) ?>" required>
            </div>

            <div class="mb-3">
                <label>Data</label>
                <input type="date" name="data_jogo" class="form-control"
                       value="<?= $j['data_jogo'] ?>" required>
            </div>

            <div class="mb-3">
                <label>Hora</label>
                <input type="time" name="hora_jogo" class="form-control"
                       value="<?= $j['hora_jogo'] ?>" required>
            </div>

            <div class="mb-3">
                <label>Local</label>
                <input type="text" name="local_jogo" class="form-control"
                       value="<?= htmlspecialchars($j['local_jogo']) ?>" required>
            </div>

            <button class="btn btn-primary">Guardar Alterações</button>
            <a href="agenda.php" class="btn btn-secondary">Voltar</a>

        </form>
    </div>
</div>

<?php include "includes/footer.php"; ?>
