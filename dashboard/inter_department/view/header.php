<?php
session_start();
include __DIR__ . '/../../../config.php';

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
            --text-color: #16161a;
        }

        body {
            color: var(--text-color);
            overflow-x: hidden;
        }

        .sidebar {
            background-color: #1C1C1C;
            min-height: 100vh;
            width: 260px;
            position: fixed !important;
            left: 0;
            top: 0;
            padding-top: 0px;
            transition: all 0.3s;
            overflow: hidden;
        }

        .sidebar .nav-link {
            color: white;
            padding: 15px 25px;
            font-size: 1.1rem;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }

        .main-content {
            margin-left: 260px;
            padding-left: 0;
            transition: all 0.3s;
            box-sizing: border-box !important;
            max-width: 100% !important;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* padding: 15px 30px; */
            padding: 0px 20px 0px 20px;
            height: 75px;
            position: fixed !important;
            width: calc(100% - 260px);
            z-index: 2000 !important;
        }

        .navbar-brand img {
            height: 40px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .content-wrapper {
            padding-top: 90px;
        }

        .stats-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .stats-card h3 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .logout-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            margin-left: 15px;
        }

        .logout-btn:hover {
            background-color: #6a0f20;
            color: white;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
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
                width: 100%;
            }

            .toggle-sidebar {
                display: block !important;
            }
        }

        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            border-left-color: white;
            font-weight: 600;
        }



        .sidebar img {
            max-width: 150px;
            height: auto;
        }

        /* Attendance Modal Styles */
        .attendance-modal {
            display: none;
            position: fixed;
            z-index: 3000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease-in-out;
        }

        .attendance-modal.show {
            display: flex;
        }

        .attendance-modal-content {
            background-color: #fff;
            border-radius: 12px;
            width: 90%;
            max-width: 450px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            position: relative;
            padding: 30px;
            text-align: center;
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .attendance-modal-header {
            margin-bottom: 20px;
        }

        .attendance-modal-header h4 {
            font-weight: 700;
            color: #1a1a1a;
            margin: 0;
        }

        .attendance-modal-close {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 24px;
            color: #aaa;
            cursor: pointer;
            transition: color 0.2s;
        }

        .attendance-modal-close:hover {
            color: #333;
        }

        .attendance-modal-body {
            margin-bottom: 30px;
            color: #555;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .attendance-modal-footer {
            display: flex;
            justify-content: center;
        }

        .btn-confirm-attendance {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 6px;
            font-weight: 600;
            transition: background 0.2s;
        }

        .btn-confirm-attendance:hover {
            background-color: #6a0f20;
        }

        .btn-validate {
            padding: 6px 14px;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 4px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-validate:hover {
            background-color: #6a0f20;
            box-shadow: 0 2px 6px rgba(133, 20, 40, 0.3);
        }

        .btn-validate:disabled {
            background-color: #e9ecef;
            color: #6c757d;
            cursor: not-allowed;
            box-shadow: none;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php
    $current_page = basename($_SERVER['PHP_SELF']);

    $clg_pages = [
        'inter_college_home.php',
        'c_paper_presentation.php',
        'c_poster_designing.php',
        'c_marketing.php',
        'c_ideathon.php',
        'c_debugging.php',
        'c_web_designing.php',
        'c_check_paper_presentation.php',
        'c_check_poster_designing.php',
        'c_check_marketing.php',
        'c_check_ideathon.php',
        'c_check_debugging.php',
        'c_check_web_designing.php'
    ];

    $dept_pages = [
        'inter_department_home.php',
        'i_paper_presentation.php',
        'i_poster_designing.php',
        'i_marketing.php',
        'i_ideathon.php',
        'i_debugging.php',
        'i_web_designing.php',
        'i_check_paper_presentation.php',
        'i_check_poster_designing.php',
        'i_check_marketing.php',
        'i_check_ideathon.php',
        'i_check_debugging.php',
        'i_check_web_designing.php',
        'i_solo_singing.php',
        'i_solo_dance.php',
        'i_group_singing.php',
        'i_group_dance.php',
        'i_mime.php',
        'i_individual_talent.php',
        'i_check_solo_singing.php',
        'i_check_solo_dance.php',
        'i_check_group_singing.php',
        'i_check_group_dance.php',
        'i_check_mime.php',
        'i_check_individual_talent.php'
    ];

    $home_active = $current_page == 'home.php' ? 'active' : '';
    $clg_active = in_array($current_page, $clg_pages) ? 'active' : '';
    $dept_active = in_array($current_page, $dept_pages) ? 'active' : '';
    $create_active = $current_page == 'create_achievement.php' ? 'active' : '';
    $view_active = in_array($current_page, ['view_achievements.php', 'update_achievement.php']) ? 'active' : '';
    ?>

    <?php include_once __DIR__ . '/../../sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation -->
        <nav class="navbar">
            <div class="d-flex justify-content-between w-100">
                <div class="d-flex align-items-center">
                    <button class="btn toggle-sidebar d-md-none me-3">
                        <i class="fas fa-bars"></i>
                    </button>

                </div>
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="d-none d-md-inline"><?php echo ($user) ?></span>
                    <button class="logout-btn" onclick="location.href='<?php echo BASE_URL; ?>logout.php'">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="d-none d-md-inline">Logout</span>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Page Content -->