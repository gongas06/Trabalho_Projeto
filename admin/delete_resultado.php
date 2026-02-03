<?php
// Backoffice: elimina resultado por ID.
require_once 'auth.php';
require_once 'db.php';
require_login();

$id = intval($_GET['id']);
$mysqli->query("DELETE FROM resultados WHERE id = $id");

header("Location: resultados.php");
exit;
