<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/../../config.php';

if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
} else {
    header('Location: ' . BASE_URL . 'admin-login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #851428;
            --sidebar-bg: #1C1C1C;
            --text-color: #16161a;
        }
        body { color: var(--text-color); overflow-x: hidden; }
        .main-content { margin-left: 260px; transition: all 0.3s; min-height: 100vh; background-color: #f8f9fa; }
        .navbar { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); height: 70px; padding: 0 30px; position: fixed !important; width: calc(100% - 260px); z-index: 999; }
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; }
            .sidebar.active { margin-left: 0; }
            .main-content { margin-left: 0; }
            .navbar { width: 100%; }
        }
    </style>
</head>
<body>
    <?php include_once __DIR__ . '/../sidebar.php'; ?>
    <div class="main-content">
        <nav class="navbar d-flex align-items-center justify-content-between">
            <button class="btn d-md-none toggle-sidebar"><i class="fas fa-bars"></i></button>
            <div class="ms-auto d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 35px; height: 35px; background: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <span class="fw-semibold d-none d-sm-inline"><?php echo htmlspecialchars($user); ?></span>
                </div>
                <a href="<?php echo BASE_URL; ?>logout.php" class="btn btn-sm btn-outline-danger px-3">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            </div>
        </nav>
