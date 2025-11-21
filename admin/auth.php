<?php
session_start();

function require_login() {
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

function is_admin() {
    return (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin');
}
?>