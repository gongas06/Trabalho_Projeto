<?php
require_once 'auth.php';
require_once 'db.php';
require_login();

$sql = "SELECT * FROM resultados ORDER BY created_at DESC";
$result = $mysqli->query($sql);

if (!$result) {
    die("Erro ao carregar resultados: " . $mysqli->error);
}

function resolve_result_image_path($path) {
    if (!$path) {
        return null;
    }
    if (strpos($path, 'uploads/') === 0) {
        return '../' . $path;
    }
    return '../uploads/' . $path;
}
?>
<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Gestão de Resultados — Admin</title>
  <link rel="stylesheet" href="../style.css">

  <style>
    body {
        padding: 20px;
        font-family: Arial, sans-serif;
    }
    table { width:100%; border-collapse:collapse; margin-top:20px; }
    th, td { padding:10px; border:1px solid #ddd; text-align:left; }
    th { background:#f2f2f2; }
    img.thumb { height:60px; border-radius:6px; display:block; }
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
        <h1>Gestão de Resultados</h1>
        <div>
            <a class="btn" href="add_resultado.php">+ Adicionar Resultado</a>
            <a class="btn secondary" href="dashboard.php">Voltar ao Dashboard</a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Equipa Casa</th>
                <th>Equipa Fora</th>
                <th>Golos</th>
                <th>Imagem Casa</th>
                <th>Imagem Fora</th>
                <th>Criado em</th>
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
                <td><?= htmlspecialchars($row['golo_casa']) ?> - <?= htmlspecialchars($row['golo_fora']) ?></td>
                <td>
                    <?php
                    $casa_path = resolve_result_image_path($row['imagem_casa'] ?? '');
                    $casa_abs = $casa_path ? __DIR__ . '/' . $casa_path : null;
                    if ($casa_path && $casa_abs && file_exists($casa_abs)): ?>
                        <img class="thumb" src="<?= $casa_path ?>" alt="Imagem casa">
                    <?php else: ?>
                        <span style="color:#888;">Sem imagem</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php
                    $fora_path = resolve_result_image_path($row['imagem_fora'] ?? '');
                    $fora_abs = $fora_path ? __DIR__ . '/' . $fora_path : null;
                    if ($fora_path && $fora_abs && file_exists($fora_abs)): ?>
                        <img class="thumb" src="<?= $fora_path ?>" alt="Imagem fora">
                    <?php else: ?>
                        <span style="color:#888;">Sem imagem</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['created_at'] ?? '') ?></td>
                <td>
                    <a href="edit_resultado.php?id=<?= $row['id'] ?>">Editar</a> |
                    <a href="delete_resultado.php?id=<?= $row['id'] ?>"
                        onclick="return confirm('Eliminar este resultado?');"
                        style="color:#c00;">
                        Eliminar
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>

        <?php else: ?>
            <tr><td colspan="8">Nenhum resultado encontrado.</td></tr>
        <?php endif; ?>
        </tbody>

    </table>
</div>

</body>
</html>
