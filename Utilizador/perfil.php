<?php
session_start();

// Ligação à base de dados
require_once __DIR__ . '/../admin/db.php';

// Verifica se está logado
if (!isset($_SESSION['username'])) {
    header("Location: ../admin/login.php");
    exit;
}

$username = $_SESSION['username'];

// Buscar utilizador
$stmt = $mysqli->prepare("SELECT * FROM utilizadores WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("Utilizador não encontrado.");
}

// Foto (fallback seguro)
$foto = !empty($user['foto']) ? $user['foto'] : 'default.png';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Utilizador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .perfil-container {
            max-width: 600px;
            background: #fff;
            margin: 80px auto;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            color: #c8102e;
            margin-bottom: 10px;
        }

        .foto-perfil {
            margin: 20px 0;
        }

        .foto-perfil img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #c8102e;
        }

        .info {
            text-align: left;
            margin: 25px 0;
        }

        .info p {
            margin: 10px 0;
            font-size: 15px;
        }

        .info strong {
            width: 150px;
            display: inline-block;
            color: #333;
        }

        .botao-editar {
            display: block;
            width: 100%;
            background: #c8102e;
            color: #fff;
            border: none;
            padding: 14px;
            font-size: 16px;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            margin-top: 20px;
        }

        .botao-editar:hover {
            background: #a00d25;
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            background: #c71b1b;
            padding: 8px 16px;
            border-radius: 999px;
            box-shadow: 0 6px 14px rgba(199, 27, 27, 0.25);
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .back-button:hover {
            background: #9f1212;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

<a href="../index.php" class="back-button">← Voltar ao site</a>

<div class="perfil-container">

    <h2>Perfil de <?= htmlspecialchars($user['username']); ?></h2>

    <div class="foto-perfil">
        <img 
            src="../uploads/perfis/<?= htmlspecialchars($foto); ?>" 
            alt="Foto de perfil"
        >
    </div>

    <div class="info">
        <p><strong>Nome:</strong> <?= htmlspecialchars($user['username'] ?? '—'); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? '—'); ?></p>
        <p><strong>Data de registo:</strong>
            <?= !empty($user['criado_em']) 
                ? date("d/m/Y", strtotime($user['criado_em'])) 
                : '—'; ?>
        </p>
    </div>

    <a href="editar_perfil.php" class="botao-editar">Editar Perfil</a>

</div>

</body>
</html>
