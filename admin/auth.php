<?php
session_start();

function require_login() {
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

function is_admin() {
    return (
        !empty($_SESSION['role']) &&
        in_array($_SESSION['role'], ['admin', 'superadmin'], true)
    );
}

function is_superadmin() {
    return (!empty($_SESSION['username']) && $_SESSION['username'] === 'admin');
}
?>
