<?php
session_start();

// Liga à base de dados
include_once("../Backoffice/ligacao.php");

// Verifica se o utilizador está logado
if (!isset($_SESSION['username'])) {
    header("Location: ../admin/login.php");
    exit;
}

$username = $_SESSION['username'];

// Obtém informações do utilizador logado
try {
    $stmt = $ligacao->prepare("SELECT * FROM utilizadores WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao obter dados do utilizador: " . $e->getMessage());
}

// Se não encontrar utilizador
if (!$user) {
    echo "<p>Utilizador não encontrado.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Utilizador</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .perfil-container {
            max-width: 600px;
            background: white;
            margin: 80px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #c8102e;
        }
        .info {
            margin: 20px 0;
        }
        .info strong {
            display: inline-block;
            width: 150px;
        }
        .botao-editar {
            display: block;
            width: 100%;
            background: #c8102e;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
        }
        .botao-editar:hover {
            background: #a00d25;
        }
    </style>
</head>
<body>

<div class="perfil-container">
    <h2>Perfil de <?php echo htmlspecialchars($user['username']); ?></h2>

    <div class="info">
        <p><strong>Nome:</strong> <?php echo htmlspecialchars($user['nome']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Data de Registo:</strong> <?php echo htmlspecialchars($user['data_registo']); ?></p>
    </div>

    <a href="atualizar.php" class="botao-editar">Editar Perfil</a>
</div>

</body>
</html>

