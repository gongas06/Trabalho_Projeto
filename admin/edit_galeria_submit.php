<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_login();

if (!is_admin()) {
    http_response_code(403);
    die('Acesso negado. Apenas o administrador pode gerir a galeria.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: galeria.php');
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$categoria = trim($_POST['categoria'] ?? '');

if ($id <= 0) {
    die('ID invalido.');
}

$stmt = $mysqli->prepare('SELECT imagem FROM galeria WHERE id = ? LIMIT 1');
if (!$stmt) {
    die('Erro ao preparar pedido.');
}
$stmt->bind_param('i', $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row) {
    die('Imagem nao encontrada.');
}

$imagem_atual = $row['imagem'] ?? '';
$imagem_nova = $imagem_atual;

if (!empty($_FILES['imagem']['name'])) {
    $max_size = 100 * 1024 * 1024;
    if (!empty($_FILES['imagem']['size']) && $_FILES['imagem']['size'] > $max_size) {
        die('O ficheiro excede o limite de 50MB.');
    }

    $uploadDir = __DIR__ . '/../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $safeName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', basename($_FILES['imagem']['name']));
    $imagem_nova = time() . '_' . $safeName;
    $target = $uploadDir . $imagem_nova;

    if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $target)) {
        die('Erro ao enviar imagem.');
    }

    if (!empty($imagem_atual)) {
        $oldPath = $uploadDir . basename($imagem_atual);
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }
    }
}

$update = $mysqli->prepare('UPDATE galeria SET imagem = ?, categoria = ? WHERE id = ?');
if (!$update) {
    die('Erro ao preparar atualizacao.');
}
$update->bind_param('ssi', $imagem_nova, $categoria, $id);
$update->execute();

header('Location: galeria.php');
exit;
