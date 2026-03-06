<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/../config.php';

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
         overflow-x: hidden; }

        /* Sidebar Styling */
        .sidebar {
            background-color: var(--sidebar-bg);
            min-height: 100vh;
            width: 260px;
             position: fixed !important;
            left: 0;
            top: 0;
            z-index: 2000 !important;
            transition: all 0.3s;
            overflow: hidden;
        }

        

        .sidebar img {
            max-width: 150px;
            height: auto;
        }

        

        .sidebar img {
            max-width: 150px;
            height: auto;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 14px 25px;
            font-size: 1.05rem;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            border-left: 4px solid transparent;
        }

        .sidebar .nav-link i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.08);
            border-left-color: var(--primary-color);
        }

        /* Main Content & Navbar */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: all 0.3s;
         box-sizing: border-box !important; max-width: 100% !important; }

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
         overflow-x: hidden; }

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
             box-sizing: border-box !important; max-width: 100% !important; }

            .navbar {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php
    $current_page = basename($_SERVER['PHP_SELF']);
    $home_active = ($current_page == 'home.php') ? 'active' : '';
    $clg_active = (strpos($current_page, 'inter_college') !== false || strpos($current_page, 'c_') === 0) ? 'active' : '';
    $dept_active = (strpos($current_page, 'inter_department') !== false || strpos($current_page, 'i_') === 0) ? 'active' : '';
    $create_active = ($current_page == 'create_achievement.php') ? 'active' : '';
    $view_active = ($current_page == 'view_achievements.php' || $current_page == 'update_achievement.php') ? 'active' : '';
    ?>

    <div class="sidebar" id="sidebar">
        <div class="nav-logo">
            <a href="<?php echo BASE_URL; ?>dashboard/home.php">
                <img src="<?php echo BASE_URL; ?>assets/img/logo/white-logo.png" alt="SPYDER">
            </a>
        </div>
        <nav class="nav flex-column mt-2">
            <a class="nav-link <?php echo $home_active; ?>" href="<?php echo BASE_URL; ?>dashboard/home.php">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a class="nav-link <?php echo $clg_active; ?>"
                href="<?php echo BASE_URL; ?>dashboard/inter_college/inter_college_home.php">
                <i class="fas fa-users"></i> Inter College
            </a>
            <a class="nav-link <?php echo $dept_active; ?>"
                href="<?php echo BASE_URL; ?>dashboard/inter_department/inter_department_home.php">
                <i class="fas fa-building"></i> Inter Department
            </a>
            <a class="nav-link <?php echo $create_active; ?>"
                href="<?php echo BASE_URL; ?>dashboard/create_achievement.php">
                <i class="fas fa-plus-circle"></i> Create Achievement
            </a>
            <a class="nav-link <?php echo $view_active; ?>"
                href="<?php echo BASE_URL; ?>dashboard/view_achievements.php">
                <i class="fas fa-cog"></i> View Achievements
            </a>
        </nav>
    </div>

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











