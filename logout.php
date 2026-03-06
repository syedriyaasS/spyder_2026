<?php
session_start();

// Clear all session variables for the admin
$_SESSION = array();

// Destroy the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy the session itself
session_destroy();

// Prevent caching of the previous page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Instead of a standard PHP redirect, output a tiny HTML block to forcefully wipe history and refresh
echo "<script>
        // Use replaceState to clear this URL from history
        if (window.history && window.history.replaceState) {
            window.history.replaceState(null, null, 'admin-login.html');
        }
        // Force a completely fresh load by replacing the current state
        window.location.replace('admin-login.html?logout=' + new Date().getTime());
    </script>";
exit();
