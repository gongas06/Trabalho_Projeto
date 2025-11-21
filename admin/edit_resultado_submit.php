<?php
require_once 'auth.php';
require_once 'db.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Método inválido");
}

$id = intval($_POST['id']);
$equipa_casa = $_POST['equipa_casa'];
$equipa_fora = $_POST['equipa_fora'];
$golo_casa = $_POST['golo_casa'];
$golo_fora = $_POST['golo_fora'];

$res = $mysqli->query("SELECT * FROM resultados WHERE id = $id");
$r = $res->fetch_assoc();

$imagem_casa = $r['imagem_casa'];
$imagem_fora = $r['imagem_fora'];

if (!empty($_FILES['imagem_casa']['name'])) {
    $imagem_casa = 'uploads/' . time() . "_casa_" . basename($_FILES['imagem_casa']['name']);
    move_uploaded_file($_FILES['imagem_casa']['tmp_name'], $imagem_casa);
}

if (!empty($_FILES['imagem_fora']['name'])) {
    $imagem_fora = 'uploads/' . time() . "_fora_" . basename($_FILES['imagem_fora']['name']);
    move_uploaded_file($_FILES['imagem_fora']['tmp_name'], $imagem_fora);
}

$stmt = $mysqli->prepare("
    UPDATE resultados 
    SET equipa_casa=?, equipa_fora=?, golo_casa=?, golo_fora=?, imagem_casa=?, imagem_fora=?
    WHERE id=?
");

$stmt->bind_param("ssiissi",
    $equipa_casa,
    $equipa_fora,
    $golo_casa,
    $golo_fora,
    $imagem_casa,
    $imagem_fora,
    $id
);

$stmt->execute();

header("Location: resultados.php");
exit;
