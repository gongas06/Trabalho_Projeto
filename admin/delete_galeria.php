<?php
// Backoffice: elimina item da galeria e remove o ficheiro associado.
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_login();

if (!is_admin()) {
    http_response_code(403);
    die('Acesso negado. Apenas o administrador pode gerir a galeria.');
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: galeria.php');
    exit;
}

// Remove ficheiro físico (se existir).
$stmt = $mysqli->prepare('SELECT imagem FROM galeria WHERE id = ? LIMIT 1');
if ($stmt) {
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if ($row && !empty($row['imagem'])) {
        $file = basename($row['imagem']);
        $path = __DIR__ . '/../uploads/' . $file;
        if (file_exists($path)) {
            unlink($path);
        }
    }
}

// Remove registo da galeria.
$del = $mysqli->prepare('DELETE FROM galeria WHERE id = ?');
if ($del) {
    $del->bind_param('i', $id);
    $del->execute();
}

header('Location: galeria.php');
exit;
