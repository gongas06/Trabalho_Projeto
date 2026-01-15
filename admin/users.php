<?php
require_once 'auth.php';
require_once 'db.php';
require_login();

if (!is_superadmin()) {
    http_response_code(403);
    die('Acesso negado. Apenas o super admin pode gerir utilizadores.');
}

$result = $mysqli->query("SELECT id, username, email, role, criado_em FROM utilizadores ORDER BY id DESC");
if (!$result) {
    die("Erro ao carregar utilizadores: " . $mysqli->error);
}
?>
<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Gestão de Utilizadores — Admin</title>
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
        border:none;
        cursor:pointer;
    }
    .btn.secondary { background:#444; }
    .btn.ghost {
        background: transparent;
        color: #b80000;
        border: 1px solid #b80000;
    }
    form.inline { display:inline-block; margin:0; }
  </style>
</head>
<body>

<div class="container">
    <div class="topbar">
        <h1>Gestão de Utilizadores</h1>
        <div>
            <a class="btn secondary" href="dashboard.php">Voltar ao Dashboard</a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilizador</th>
                <th>Email</th>
                <th>Role</th>
                <th>Criado em</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= (int)$row['id'] ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['role']) ?></td>
                <td><?= htmlspecialchars($row['criado_em'] ?? '') ?></td>
                <td>
                    <?php if ($row['username'] === 'admin' || $row['role'] === 'superadmin'): ?>
                        <span style="color:#555;">Super admin</span>
                    <?php else: ?>
                        <form class="inline" action="update_user_role.php" method="post">
                            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                            <?php if ($row['role'] === 'admin'): ?>
                                <input type="hidden" name="role" value="user">
                                <button type="submit" class="btn ghost">Remover admin</button>
                            <?php else: ?>
                                <input type="hidden" name="role" value="admin">
                                <button type="submit" class="btn ghost">Tornar admin</button>
                            <?php endif; ?>
                        </form>
                        <form class="inline" action="delete_user.php" method="post"
                              onsubmit="return confirm('Eliminar este utilizador?');">
                            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                            <button type="submit" class="btn">Eliminar</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">Nenhum utilizador encontrado.</td></tr>
        <?php endif; ?>
        </tbody>

    </table>
</div>

</body>
</html>
