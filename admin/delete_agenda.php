<?php
// Backoffice: elimina um jogo da agenda por ID.
require_once "auth.php";
require_once "db.php";
require_login();
if (!is_admin()) {
    http_response_code(403);
    die("Acesso negado. Apenas o administrador pode gerir os resultados.");
}

$id = intval($_GET['id']);
$mysqli->query("DELETE FROM agenda WHERE id = $id");

header("Location: agenda.php");
exit;
