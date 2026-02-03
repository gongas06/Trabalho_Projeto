<?php
// Helpers de autenticação e autorização do backoffice.
session_start();

// Garante que o utilizador está autenticado.
function require_login() {
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

// Verifica se o utilizador tem permissões de admin.
function is_admin() {
    return (
        !empty($_SESSION['role']) &&
        in_array($_SESSION['role'], ['admin', 'superadmin'], true)
    );
}

// Verifica se é o superadmin (conta principal).
function is_superadmin() {
    return (!empty($_SESSION['username']) && $_SESSION['username'] === 'admin');
}
?>
