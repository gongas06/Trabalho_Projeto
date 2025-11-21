<?php
require_once 'auth.php';
require_once 'db.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $equipa_casa = $_POST['equipa_casa'];
    $equipa_fora = $_POST['equipa_fora'];
    $golo_casa = $_POST['golo_casa'];
    $golo_fora = $_POST['golo_fora'];

    // Criar nomes dos ficheiros
    $imagem_casa = null;
    $imagem_fora = null;

    // Upload imagem da equipa da casa
    if (!empty($_FILES['imagem_casa']['name'])) {
        $imagem_casa = "uploads/" . time() . "_casa_" . basename($_FILES['imagem_casa']['name']);
        move_uploaded_file($_FILES['imagem_casa']['tmp_name'], __DIR__ . "/../" . $imagem_casa);
    }

    // Upload imagem da equipa de fora
    if (!empty($_FILES['imagem_fora']['name'])) {
        $imagem_fora = "uploads/" . time() . "_fora_" . basename($_FILES['imagem_fora']['name']);
        move_uploaded_file($_FILES['imagem_fora']['tmp_name'], __DIR__ . "/../" . $imagem_fora);
    }

    // Inserir na BD
    $stmt = $mysqli->prepare("
        INSERT INTO resultados (equipa_casa, equipa_fora, golo_casa, golo_fora, imagem_casa, imagem_fora)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("ssiiss",
        $equipa_casa,
        $equipa_fora,
        $golo_casa,
        $golo_fora,
        $imagem_casa,
        $imagem_fora
    );

    $stmt->execute();
    header("Location: resultados.php");
    exit;
}

echo "Erro!";


