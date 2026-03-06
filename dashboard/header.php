<?php
session_start();
include_once __DIR__ . '/../config.php';

// Prevent caching to ensure back button doesn't access protected pages after logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

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
    <title>Admin Dashboard - Spyder</title>
    <script>
        // Force reload if page is loaded from back-forward cache (BFCache)
        window.addEventListener("pageshow", function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #851428;
            --sidebar-bg: #1C1C1C;
            --text-color: #333;
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-color);
            margin: 0;
            overflow-x: hidden;
        }


        /* Main Content & Navbar */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: all 0.3s;
            box-sizing: border-box !important;
            max-width: 100% !important;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 15px 30px;
            height: 75px;
            position: sticky;
            top: 0;
            z-index: 2000 !important;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
        }

        .user-name {
            font-weight: 600;
            color: #444;
        }

        .logout-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: background 0.2s;
            margin-left: 10px;
        }

        .logout-btn:hover {
            background-color: #6a0f20;
            color: white;
        }

        .content-body {
            padding: 30px;
            overflow-x: hidden;
        }

        /* Responsive Improvements */
        @media (max-width: 992px) {
            .sidebar {
                margin-left: -260px;
            }

            .sidebar.active {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
                box-sizing: border-box !important;
                max-width: 100% !important;
            }

            .navbar {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <?php include_once __DIR__ . '/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid p-0">
                <button class="btn d-lg-none me-3"
                    onclick="document.getElementById('sidebar').classList.toggle('active')">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="ms-auto d-flex align-items-center">
                    <div class="user-info">
                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="user-name d-none d-md-inline"><?php echo htmlspecialchars($user); ?></span>
                    </div>
                    <a href="<?php echo BASE_URL; ?>logout.php" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </nav>

        <div class="content-body">
            <!-- Content starts here -->