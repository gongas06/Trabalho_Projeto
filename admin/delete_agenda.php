<?php
require_once "auth.php";
require_once "db.php";
require_login();

$id = intval($_GET['id']);
$mysqli->query("DELETE FROM agenda WHERE id = $id");

header("Location: agenda.php");
exit;
