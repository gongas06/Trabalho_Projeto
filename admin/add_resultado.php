<?php
// Backoffice: formulário para adicionar resultado.
require_once 'auth.php';
require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado. Apenas o administrador pode gerir os resultados.");
}
?>

<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Adicionar Resultado — Admin</title>
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
    input[type="text"], input[type="number"], input[type="file"] {
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
        <h1>Adicionar Resultado</h1>
        <div>
            <a class="btn" href="resultados.php">Voltar aos Resultados</a>
            <a class="btn secondary" href="dashboard.php">Voltar ao Dashboard</a>
        </div>
    </div>

    <form action="add_resultado_submit.php" method="POST" enctype="multipart/form-data">

        <div class="form-row">
            <label>Equipa da Casa</label>
            <input type="text" name="equipa_casa" required>
        </div>

        <div class="form-row">
            <label>Equipa de Fora</label>
            <input type="text" name="equipa_fora" required>
        </div>

        <div class="form-row">
            <label>Golos da Casa</label>
            <input type="number" name="golo_casa" required>
        </div>

        <div class="form-row">
            <label>Golos de Fora</label>
            <input type="number" name="golo_fora" required>
        </div>

        <div class="form-row">
            <label>Competição</label>
            <input type="text" name="competicao" required>
        </div>

        <div class="form-row">
            <label>Época</label>
            <input type="text" name="epoca" required>
        </div>

        <div class="form-row">
            <label>Imagem Casa</label>
            <input type="file" name="imagem_casa" accept="image/*" required>
        </div>

        <div class="form-row">
            <label>Imagem Fora </label>
            <input type="file" name="imagem_fora" accept="image/*" required>
        </div>

        <button type="submit" class="btn">Guardar</button>

    </form>
</div>

</body>
</html>
