<?php
// Backoffice: elimina resultado por ID.
require_once 'auth.php';
require_once 'db.php';
require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado. Apenas o administrador pode gerir os resultados.");
}

$id = intval($_GET['id']);
$mysqli->query("DELETE FROM resultados WHERE id = $id");

header("Location: resultados.php");
exit;
