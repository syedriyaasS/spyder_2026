<?php
/**
 * Coordinator Login
 * - Always reads status live from DB
 * - Does NOT store status in session
 * - Shows popup for invalid credentials or disabled account
 */

session_start();
require_once __DIR__ . '/../config.php';

// If already have a valid session, verify status from DB (never trust cache)
if (isset($_SESSION['coordinator_logged_in'])) {
    $cid = (int)($_SESSION['coordinator_id'] ?? 0);
    $chk = $conn->prepare("SELECT login_status FROM coordinators WHERE id = ?");
    $chk->bind_param("i", $cid);
    $chk->execute();
    $chkRow = $chk->get_result()->fetch_assoc();
    $chk->close();

    if ($chkRow && $chkRow['login_status'] === 'active') {
        // Still active – skip login page
        header("Location: dashboard.php");
        exit();
    } else {
        // Disabled after last login – destroy session, show login page
        session_unset();
        session_destroy();
        session_start();
    }
}

$error = "";

// Show message when redirected from dashboard due to disable
if (isset($_GET['error']) && $_GET['error'] === 'disabled') {
    $error = "Your access has been disabled by admin. Please contact admin for approval.";
}

// Handle login form submission
if (isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = "Please enter username and password.";
    } else {
        // Step 1: Find coordinator by username
        $sql = "SELECT id, name, event_name, username, password, login_status FROM coordinators WHERE username = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $coord = $result->fetch_assoc();
        $stmt->close();

        if (!$coord) {
            // Step 1 failed: username not found
            $error = "Invalid Credentials";
        } elseif (!password_verify($password, $coord['password'])) {
            // Step 2 failed: wrong password
            $error = "Invalid Credentials";
        } elseif ($coord['login_status'] !== 'active') {
            // Step 3 failed: account disabled
            $error = "Your access has been disabled. Please contact admin for approval.";
        } else {
            // All checks passed — login successful
            // Store only identity, NOT status (always re-check from DB)
            $_SESSION['coordinator_logged_in'] = true;
            $_SESSION['coordinator_id']        = (int)$coord['id'];
            $_SESSION['coordinator_name']      = $coord['name'];
            $_SESSION['event_name']            = $coord['event_name'];
            $_SESSION['username']              = $coord['username'];

            header("Location: dashboard.php");
            exit();
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coordinator Login - Spyder</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f4f7f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-logo {
            max-width: 180px;
            height: auto;
            margin-bottom: 15px;
        }
        .login-card {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 400px;
        }
        .btn-login {
            background: #851428;
            color: white;
            width: 100%;
            padding: 12px;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn-login:hover { background: #6a1020; }

        /* Error Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.show { display: flex; }
        .modal-box {
            background: #fff;
            border-radius: 12px;
            padding: 36px 32px;
            max-width: 380px;
            width: 90%;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        }
        .modal-icon { font-size: 2.5rem; color: #c0392b; margin-bottom: 10px; }
        .modal-box h4 { font-weight: 700; color: #c0392b; margin-bottom: 8px; }
        .modal-box p  { color: #666; font-size: 0.9rem; margin-bottom: 20px; }
        .modal-close-btn {
            background: #851428;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 8px 24px;
            font-weight: 600;
            cursor: pointer;
        }
        /* Password Toggle */
        .password-wrap { position: relative; }
        .password-wrap .eye-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            z-index: 10;
        }
    </style>
</head>
<body>

    <!-- Error Popup -->
    <?php if ($error): ?>
    <div id="errorModal" class="modal-overlay show" onclick="this.classList.remove('show')">
        <div class="modal-box" onclick="event.stopPropagation()">
            <div class="modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <h4>Access Denied</h4>
            <p><?php echo htmlspecialchars($error); ?></p>
            <button class="modal-close-btn" onclick="document.getElementById('errorModal').classList.remove('show')">
                Try Again
            </button>
        </div>
    </div>
    <?php endif; ?>

    <div class="login-card">
        <div class="text-center mb-4">
            <img src="../assets/img/logo/logo.png" alt="Spyder Logo" class="login-logo">
            <h3>Coordinator Login</h3>
        </div>
        <form method="post" id="loginForm">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required
                       placeholder="Enter username"
                       value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="password-wrap">
                    <input type="password" name="password" id="loginPassword"
                           class="form-control" required placeholder="Enter password">
                    <i class="fa-solid fa-eye eye-toggle" id="eyeIcon"
                       onclick="togglePassword()"></i>
                </div>
            </div>
            <button type="submit" name="login" class="btn-login">Login</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('loginPassword');
            const icon  = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>
