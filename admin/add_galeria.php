<?php
// Backoffice: formulário para adicionar item à galeria.
require_once __DIR__ . '/auth.php';
require_login();
if (!is_admin()) {
    http_response_code(403);
    die('Acesso negado. Apenas o administrador pode gerir a galeria.');
}
?>

<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <title>Adicionar Foto — Admin</title>
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
    input[type="text"], input[type="file"] {
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
        <h1>Adicionar Foto</h1>
        <div>
            <a class="btn" href="galeria.php">Voltar à Galeria</a>
            <a class="btn secondary" href="dashboard.php">Voltar ao Dashboard</a>
        </div>
    </div>

    <form action="add_galeria_submit.php" method="POST" enctype="multipart/form-data">

        <div class="form-row">
            <label>Imagem ou vídeo</label>
            <input type="file" name="imagem" accept="image/*,video/*" required>
        </div>

        <div class="form-row">
            <label>Categoria</label>
            <input type="text" name="categoria" value="comunidade" required>
        </div>

        <button type="submit" class="btn">Guardar</button>

    </form>
</div>

</body>
</html>
