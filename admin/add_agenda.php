<?php
require_once 'auth.php';
require_login();
?>

<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Adicionar Jogo — Admin</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body {
        padding: 20px;
        font-family: Arial, sans-serif;
    }
    .topbar { display:flex; justify-content:space-between; align-items:center; }
    .btn {
        background:#b80000;
        color:#fff;
        padding:8px 14px;
        border-radius:6px;
        text-decoration:none;
        font-weight:600;
        margin-left:10px;
        border:none;
        cursor:pointer;
    }
    .btn.secondary { background:#444; }
    .form-row { margin-bottom:12px; }
    label { display:block; font-weight:600; margin-bottom:6px; }
    input[type="text"], input[type="date"], input[type="time"] {
        width:100%;
        padding:8px;
        border:1px solid #ccc;
        border-radius:6px;
    }
  </style>
</head>
<body>

<div class="container">
    <div class="topbar">
        <h1>Adicionar Jogo</h1>
        <div>
            <a class="btn" href="agenda.php">Voltar à Agenda</a>
            <a class="btn secondary" href="dashboard.php">Voltar ao Dashboard</a>
        </div>
    </div>

    <form action="add_agenda_submit.php" method="POST">

        <div class="form-row">
            <label>Equipa da Casa</label>
            <input type="text" name="equipa_casa" required>
        </div>

        <div class="form-row">
            <label>Equipa de Fora</label>
            <input type="text" name="equipa_fora" required>
        </div>

        <div class="form-row">
            <label>Data do Jogo</label>
            <input type="date" name="data_jogo" required>
        </div>

        <div class="form-row">
            <label>Hora do Jogo</label>
            <input type="time" name="hora_jogo" required>
        </div>

        <div class="form-row">
            <label>Local do Jogo</label>
            <input type="text" name="local_jogo" required>
        </div>

        <div class="form-row">
            <label>Competição</label>
            <input type="text" name="competicao" required>
        </div>

        <div class="form-row">
            <label>Época</label>
            <input type="text" name="epoca" required>
        </div>

        <button type="submit" class="btn">Guardar</button>

    </form>
</div>

</body>
</html>
