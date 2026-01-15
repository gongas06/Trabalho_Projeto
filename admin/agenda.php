<?php
require_once 'auth.php';
require_once 'db.php';
require_login();

$sql = "SELECT * FROM agenda ORDER BY data_jogo DESC, hora_jogo DESC";
$result = $mysqli->query($sql);

if (!$result) {
    die("Erro ao carregar agenda: " . $mysqli->error);
}
?>
<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Gestão de Agenda — Admin</title>
  <link rel="stylesheet" href="../style.css">

  <style>
    body {
        padding: 20px;
        font-family: Arial, sans-serif;
    }
    table { width:100%; border-collapse:collapse; margin-top:20px; }
    th, td { padding:10px; border:1px solid #ddd; text-align:left; }
    th { background:#f2f2f2; }
    .topbar { display:flex; justify-content:space-between; align-items:center; }
    .btn {
        background:#b80000;
        color:white;
        padding:8px 14px;
        border-radius:6px;
        text-decoration:none;
        font-weight:600;
        margin-left:10px;
    }
    .btn.secondary {
        background:#444;
    }
  </style>
</head>
<body>

<div class="container">
    <div class="topbar">
        <h1>Gestão de Agenda</h1>
        <div>
            <a class="btn" href="add_agenda.php">+ Adicionar Jogo</a>
            <a class="btn secondary" href="dashboard.php">Voltar ao Dashboard</a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Equipa Casa</th>
                <th>Equipa Fora</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Local</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['equipa_casa']) ?></td>
                <td><?= htmlspecialchars($row['equipa_fora']) ?></td>
                <td><?= htmlspecialchars($row['data_jogo']) ?></td>
                <td><?= htmlspecialchars($row['hora_jogo']) ?></td>
                <td><?= htmlspecialchars($row['local_jogo']) ?></td>
                <td>
                    <a href="edit_agenda.php?id=<?= $row['id'] ?>">Editar</a> |
                    <a href="delete_agenda.php?id=<?= $row['id'] ?>"
                        onclick="return confirm('Eliminar este jogo da agenda?');"
                        style="color:#c00;">
                        Eliminar
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>

        <?php else: ?>
            <tr><td colspan="7">Nenhum jogo encontrado.</td></tr>
        <?php endif; ?>
        </tbody>

    </table>
</div>

</body>
</html>
