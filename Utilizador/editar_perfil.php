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
    <link rel="stylesheet" href="../style.css">
</head>
<body class="perfil-body">

<div class="perfil-container">
    <div class="perfil-card">
        <h2>Editar Perfil</h2>

        <form action="atualizar.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $user['id'] ?>">

            <label>Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <label>Nova password (opcional)</label>
            <input type="password" name="password">

            <?php if (!empty($user['foto'])): ?>
                <img src="../uploads/perfis/<?= htmlspecialchars($user['foto']) ?>"
                     alt="Foto de perfil" width="120" style="border-radius:50%; margin-top:12px;">
            <?php endif; ?>

            <label>Nova foto de perfil</label>
            <input type="file" name="foto" accept="image/*">

            <div class="perfil-acoes">
                <button type="submit" class="botao-vermelho">Guardar Alterações</button>
                <a href="perfil.php" class="botao-preto">Cancelar</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
