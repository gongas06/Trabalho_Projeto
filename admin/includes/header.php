<?php
require_once __DIR__ . '/../auth.php';
$showUsersLink = is_admin();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Backoffice ADPB</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="admin-bg">

<header class="admin-header">
    <div class="admin-logo-area">
        <img src="../Imagens/Gerais/Logotipo ADPB_projeto.png" class="admin-logo">
        <span class="admin-title">Backoffice ADPB</span>
    </div>

    <nav class="admin-menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="resultados.php">Resultados</a>
        <a href="news.php">Notícias</a>
        <a href="agenda.php">Agenda</a>
        <a href="galeria.php">Galeria</a>
        <?php if ($showUsersLink): ?>
            <a href="users.php">Utilizadores</a>
        <?php endif; ?>
        <a href="logout.php" class="logout-btn">Terminar Sessão</a>
    </nav>
</header>

<div class="admin-content">
