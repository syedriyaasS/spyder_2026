<?php
$current_page = basename($_SERVER['PHP_SELF']);

// Define groups for active states
$clg_pages = ['inter_college_home.php', 'c_all.php', 'c_update.php'];
$dept_pages = ['inter_department_home.php', 'i_all.php', 'i_update.php'];
$create_ach_pages = ['create_achievement.php'];
$view_ach_pages = ['view_achievements.php', 'update_achievement.php'];
$coord_pages = ['manage_coordinators.php'];
$config_pages = ['index.php', 'inter_college_config.php', 'inter_department_config.php'];

// Helper to determine active state
$home_active = ($current_page == 'home.php') ? 'active' : '';
$coord_active = (in_array($current_page, $coord_pages)) ? 'active' : '';
$clg_active = (in_array($current_page, $clg_pages) || strpos($current_page, 'c_') === 0 || strpos($_SERVER['PHP_SELF'], 'inter_college') !== false) ? 'active' : '';
$dept_active = (in_array($current_page, $dept_pages) || strpos($current_page, 'i_') === 0 || strpos($_SERVER['PHP_SELF'], 'inter_department') !== false) ? 'active' : '';
$create_active = (in_array($current_page, $create_ach_pages)) ? 'active' : '';
$view_active = (in_array($current_page, $view_ach_pages)) ? 'active' : '';
$config_active = (in_array($current_page, $config_pages) && strpos($_SERVER['PHP_SELF'], 'configure_site') !== false) ? 'active' : '';
?>

<style>
    /* Fixed Sidebar Styling for Absolute Consistency Across All Pages */
    .sidebar {
        background-color: #1C1C1C !important;
        min-height: 100vh;
        width: 260px;
        position: fixed !important;
        left: 0;
        top: 0;
        z-index: 2500 !important;
        transition: all 0.3s;
        overflow-y: auto;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    }

    .sidebar .nav-logo {
        padding: 30px 20px !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .sidebar .nav-logo img {
        max-width: 140px !important;
        height: auto !important;
    }

    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.76) !important;
        padding: 16px 25px !important;
        font-size: 0.98rem !important;
        font-weight: 500 !important;
        display: flex !important;
        align-items: center !important;
        text-decoration: none !important;
        transition: all 0.2s ease !important;
        border-left: 4px solid transparent !important;
        line-height: 1.25 !important;
    }

    .sidebar .nav-link i {
        width: 25px !important;
        height: 25px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin-right: 15px !important;
        font-size: 1.15rem !important;
        opacity: 0.9;
        flex-shrink: 0 !important;
    }

    .sidebar .nav-link span {
        display: inline-block !important;
        width: 100%;
    }

    .sidebar .nav-link:hover {
        color: #FFFFFF !important;
        background-color: rgba(255, 255, 255, 0.05) !important;
        text-decoration: none !important;
    }

    .sidebar .nav-link.active {
        color: #FFFFFF !important;
        background-color: rgba(255, 255, 255, 0.08) !important;
        border-left-color: #851428 !important;
        font-weight: 600 !important;
    }

    .sidebar .nav-link.active i {
        opacity: 1;
        color: #FFFFFF !important;
    }

    /* Fixed alignment for multi-line menu items like "Managing Coordinators" */
    .sidebar .nav-link span {
        white-space: normal;
        word-wrap: break-word;
    }

    @media (max-width: 992px) {
        .sidebar {
            margin-left: -260px;
        }
        .sidebar.active {
            margin-left: 0;
            box-shadow: 4px 0 15px rgba(0,0,0,0.3);
        }
    }
</style>

<div class="sidebar" id="sidebar">
    <div class="nav-logo">
        <a href="<?php echo BASE_URL; ?>dashboard/home.php">
            <img src="<?php echo BASE_URL; ?>assets/img/logo/white-logo.png" alt="SPYDER">
        </a>
    </div>
    <nav class="nav flex-column mt-2">
        <a class="nav-link <?php echo $home_active; ?>" href="<?php echo BASE_URL; ?>dashboard/home.php">
            <i class="fas fa-home"></i> <span>Dashboard</span>
        </a>
        <a class="nav-link <?php echo $coord_active; ?>" href="<?php echo BASE_URL; ?>dashboard/manage_coordinators.php">
            <i class="fas fa-user-shield"></i> <span>Managing Coordinators</span>
        </a>
        <a class="nav-link <?php echo $clg_active; ?>" href="<?php echo BASE_URL; ?>dashboard/inter_college/inter_college_home.php">
            <i class="fas fa-users"></i> <span>Inter College</span>
        </a>
        <a class="nav-link <?php echo $dept_active; ?>" href="<?php echo BASE_URL; ?>dashboard/inter_department/inter_department_home.php">
            <i class="fas fa-building"></i> <span>Inter Department</span>
        </a>
        <a class="nav-link <?php echo $create_active; ?>" href="<?php echo BASE_URL; ?>dashboard/create_achievement.php">
            <i class="fas fa-plus-circle"></i> <span>Create Achievement</span>
        </a>
        <a class="nav-link <?php echo $view_active; ?>" href="<?php echo BASE_URL; ?>dashboard/view_achievements.php">
            <i class="fas fa-cog"></i> <span>View Achievements</span>
        </a>
        <a class="nav-link <?php echo $config_active; ?>" href="<?php echo BASE_URL; ?>dashboard/configure_site/index.php">
            <i class="fas fa-sliders-h"></i> <span>Configure Website</span>
        </a>
    </nav>
</div>
