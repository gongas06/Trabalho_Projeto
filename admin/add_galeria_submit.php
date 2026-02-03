<?php
// Handler para adicionar item à galeria (upload e inserção).
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_login();

if (!is_admin()) {
    http_response_code(403);
    die('Acesso negado. Apenas o administrador pode gerir a galeria.');
}

// Processa submissão do formulário.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoria = trim($_POST['categoria'] ?? 'comunidade');

    if (empty($_FILES['imagem']['name'])) {
        die('Ficheiro obrigatorio.');
    }

    // Limite de tamanho do ficheiro.
    $max_size = 100 * 1024 * 1024;
    if (!empty($_FILES['imagem']['size']) && $_FILES['imagem']['size'] > $max_size) {
        die('O ficheiro excede o limite de 50MB.');
    }

    $uploadDir = __DIR__ . '/../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $safeName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', basename($_FILES['imagem']['name']));
    $image_name = time() . '_' . $safeName;
    $target = $uploadDir . $image_name;

    if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $target)) {
        die('Erro ao enviar imagem.');
    }

    // Grava o registo da galeria.
    $stmt = $mysqli->prepare("INSERT INTO galeria (imagem, categoria) VALUES (?, ?)");
    if (!$stmt) {
        die('Erro prepare: ' . $mysqli->error);
    }

    $stmt->bind_param('ss', $image_name, $categoria);
    $stmt->execute();

    header('Location: galeria.php');
    exit;
}

echo 'Erro!';
