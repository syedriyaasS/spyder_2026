<?php
session_start();
include __DIR__ . '/../../config.php';

if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
} else {
    header('Location: ' . BASE_URL . 'admin-login.html');
    exit();
}
?>












