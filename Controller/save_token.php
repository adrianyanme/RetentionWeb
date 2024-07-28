<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $_SESSION['token'] = $token;
    echo 'Token saved in session';
}
?>