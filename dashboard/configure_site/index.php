<?php
include '../header.php';
?>

<style>
    .page-section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 6px;
    }

    .page-section-subtitle {
        color: #888;
        font-size: 0.92rem;
        margin-bottom: 22px;
    }

    .config-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 14px rgba(0, 0, 0, 0.06);
        padding: 30px 25px;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        border: 1px solid #f2f2f2;
        text-align: center;
    }

    .config-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.1);
    }

    .config-card .card-icon {
        font-size: 3rem;
        color: #851428;
        margin-bottom: 20px;
    }

    .config-card .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 10px;
    }

    .config-card .card-desc {
        color: #666;
        font-size: 0.95rem;
        flex: 1;
        margin-bottom: 25px;
        line-height: 1.5;
    }

    .card-btn {
        display: inline-block;
        background-color: #851428;
        color: white;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        align-self: center;
        transition: background 0.2s;
    }

    .card-btn:hover {
        background-color: #6a0f20;
        color: white;
    }
</style>

<div class="container-fluid">
    <h2 class="page-section-title">Configure Website</h2>
    <p class="page-section-subtitle">Manage dynamic settings and behavior for different event categories</p>

    <div class="row g-4 mt-2">
        <!-- Inter College Config -->
        <div class="col-md-6">
            <div class="config-card">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-title">Inter College</div>
                <div class="card-desc">Control registration status, redirection links, and certificate availability for Inter College events.</div>
                <a href="inter_college_config.php" class="card-btn">View Settings</a>
            </div>
        </div>

        <!-- Inter Department Config -->
        <div class="col-md-6">
            <div class="config-card">
                <div class="card-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="card-title">Inter Department</div>
                <div class="card-desc">Manage settings and configurations specific to internal department symposium events.</div>
                <a href="inter_department_config.php" class="card-btn">View Settings</a>
            </div>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>