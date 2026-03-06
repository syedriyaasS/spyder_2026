<?php

include __DIR__ . '/config.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $department = $_POST['department'];
    $college = $_POST['college'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $event1 = $_POST['event1'];
    $event2 = $_POST['event2'];

    // Check if participant mobile number or email ID already registered
    $checkSql = "SELECT COUNT(*) as count FROM `interdepartment` WHERE `email` = '$email' OR `mobile` = '$mobile'";
    $checkResult = $conn->query($checkSql);
    $row = $checkResult->fetch_assoc();

    if ($row['count'] > 0) {
        header("Location: interdept_register.html?status=exists");
        exit();
    } else {
        $sql = "INSERT INTO `interdepartment`(`name`,`department`,`college`,`email`,`mobile`,`event1`,`event2`)
                VALUES ('$name','$department','$college','$email','$mobile','$event1','$event2')";

        $result = $conn->query($sql);

        if ($result == TRUE) {
            header("Location: interdept_register.html?status=success");
            exit();
        } else {
            header("Location: interdept_register.html?status=error");
            exit();
        }
    }

    $conn->close();
}
