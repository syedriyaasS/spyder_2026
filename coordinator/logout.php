<?php
session_start();

// Unset all coordinator-related session variables
unset($_SESSION['coordinator_logged_in']);
unset($_SESSION['coordinator_id']);
unset($_SESSION['coordinator_name']);
unset($_SESSION['event_name']);
unset($_SESSION['username']);

// Alternatively, completely destroy the session
session_unset();
session_destroy();

// Prevent caching to prevent "go-back" functionality
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redirect to coordinator login page
header("Location: index.php");
exit();
