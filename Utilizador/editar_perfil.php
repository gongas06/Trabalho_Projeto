<?php
session_start();
require_once __DIR__ . '/../admin/db.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../admin/login.php");
    exit;
}

$username = $_SESSION['username'];

$stmt = $mysqli->prepare("SELECT * FROM utilizadores WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    exit("Utilizador não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
</head>
<body>

<h2>Editar Perfil</h2>

<form action="atualizar.php" method="POST" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $user['id'] ?>">

    <label>Username</label><br>
    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required><br><br>

    <label>Email</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br><br>

    <label>Nova password (opcional)</label><br>
    <input type="password" name="password"><br><br>

    <?php if (!empty($user['foto'])): ?>
        <img src="../uploads/perfis/<?= htmlspecialchars($user['foto']) ?>"
             width="120" style="border-radius:50%;"><br><br>
    <?php endif; ?>

    <label>Nova foto de perfil</label><br>
    <input type="file" name="foto" accept="image/*"><br><br>

    <button type="submit">Guardar Alterações</button>
</form>

</body>
</html>
