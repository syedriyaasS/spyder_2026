<?php

include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $pass = md5($_POST['pass']);
    $sql = mysqli_query($conn, "SELECT * FROM `admin` WHERE `user`='$user' AND `pass`='$pass'");
    $row = mysqli_fetch_array($sql);

    if (is_array($row)) { // Checks whether variable row is an array or not
        $_SESSION["user"] = $row['user'];
        $_SESSION["id"] = $row['id'];
        header("Location: dashboard/home.php");
        exit(); // Exit to prevent further execution
    } else {
        echo '<script>';
        echo 'alert("Invalid Email or Password !");';
        echo 'window.location.href = "admin-login.html";';
        echo '</script>';
    }
} else {
    header("Location: admin-login.html");
    exit();
}


?>