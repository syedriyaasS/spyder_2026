<?php
    
    session_start();
    unset($_SESSION["user"]);
    unset($_SESSION["pass"]);

    // Prevent caching of the previous page
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    header("Location: admin-login.html");
    
?>