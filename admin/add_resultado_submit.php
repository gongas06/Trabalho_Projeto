<?php
// Handler para criação de resultado (dados + upload de imagens).
require_once 'auth.php';
require_once 'db.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $equipa_casa = $_POST['equipa_casa'];
    $equipa_fora = $_POST['equipa_fora'];
    $golo_casa = $_POST['golo_casa'];
    $golo_fora = $_POST['golo_fora'];
    $competicao = $_POST['competicao'] ?? '';
    $epoca = $_POST['epoca'] ?? '';

    // Preparar uploads e nomes de ficheiros.
    $imagem_casa = null;
    $imagem_fora = null;
    $uploads_dir = __DIR__ . '/../uploads';
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0755, true);
    }

    // Upload imagem da equipa da casa.
    if (!empty($_FILES['imagem_casa']['name'])) {
        $safe_name = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', basename($_FILES['imagem_casa']['name']));
        $imagem_casa = time() . "_casa_" . $safe_name;
        move_uploaded_file($_FILES['imagem_casa']['tmp_name'], $uploads_dir . '/' . $imagem_casa);
    } elseif (!empty($_POST['imagem_casa_existente'])) {
        $casa_file = basename($_POST['imagem_casa_existente']);
        if (file_exists($uploads_dir . '/' . $casa_file)) {
            $imagem_casa = $casa_file;
        }
    }

    // Upload imagem da equipa de fora.
    if (!empty($_FILES['imagem_fora']['name'])) {
        $safe_name = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', basename($_FILES['imagem_fora']['name']));
        $imagem_fora = time() . "_fora_" . $safe_name;
        move_uploaded_file($_FILES['imagem_fora']['tmp_name'], $uploads_dir . '/' . $imagem_fora);
    } elseif (!empty($_POST['imagem_fora_existente'])) {
        $fora_file = basename($_POST['imagem_fora_existente']);
        if (file_exists($uploads_dir . '/' . $fora_file)) {
            $imagem_fora = $fora_file;
        }
    }

    // Inserir na base de dados.
    $stmt = $mysqli->prepare("
        INSERT INTO resultados (equipa_casa, equipa_fora, golo_casa, golo_fora, imagem_casa, imagem_fora, competicao, epoca)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("ssiissss",
        $equipa_casa,
        $equipa_fora,
        $golo_casa,
        $golo_fora,
        $imagem_casa,
        $imagem_fora,
        $competicao,
        $epoca
    );

    $stmt->execute();
    header("Location: resultados.php");
    exit;
}

echo "Erro!";
