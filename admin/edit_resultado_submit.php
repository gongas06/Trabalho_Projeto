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
$competicao = $_POST['competicao'];
$epoca = $_POST['epoca'];

$res = $mysqli->query("SELECT * FROM resultados WHERE id = $id");
$r = $res->fetch_assoc();

$imagem_casa = $r['imagem_casa'] ? basename($r['imagem_casa']) : null;
$imagem_fora = $r['imagem_fora'] ? basename($r['imagem_fora']) : null;

$uploads_dir = __DIR__ . '/../uploads';
if (!is_dir($uploads_dir)) {
    mkdir($uploads_dir, 0755, true);
}

if (!empty($_FILES['imagem_casa']['name'])) {
    $safe_name = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', basename($_FILES['imagem_casa']['name']));
    $imagem_casa = time() . "_casa_" . $safe_name;
    move_uploaded_file($_FILES['imagem_casa']['tmp_name'], $uploads_dir . '/' . $imagem_casa);
}

if (!empty($_FILES['imagem_fora']['name'])) {
    $safe_name = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', basename($_FILES['imagem_fora']['name']));
    $imagem_fora = time() . "_fora_" . $safe_name;
    move_uploaded_file($_FILES['imagem_fora']['tmp_name'], $uploads_dir . '/' . $imagem_fora);
}

$stmt = $mysqli->prepare("
    UPDATE resultados 
    SET equipa_casa=?, equipa_fora=?, golo_casa=?, golo_fora=?, competicao=?, epoca=?, imagem_casa=?, imagem_fora=?
    WHERE id=?
");

$stmt->bind_param("ssiissssi",
    $equipa_casa,
    $equipa_fora,
    $golo_casa,
    $golo_fora,
    $competicao,
    $epoca,
    $imagem_casa,
    $imagem_fora,
    $id
);

$stmt->execute();

header("Location: resultados.php");
exit;
