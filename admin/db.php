<?php
require_once __DIR__ . '/config.php';


$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, 8889);

if ($mysqli->connect_error) {
    die('Erro de ligação: ' . $mysqli->connect_error);
}

$mysqli->set_charset('utf8mb4');
?>
