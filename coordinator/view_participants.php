<?php
session_start();
require_once __DIR__ . '/../config.php';

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Auth check
if (!isset($_SESSION['coordinator_logged_in'])) {
    header("Location: index.php");
    exit();
}

$coord_id = (int)($_SESSION['coordinator_id'] ?? 0);
$stmt = $conn->prepare("SELECT login_status FROM coordinators WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $coord_id);
$stmt->execute();
$dbCoord = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$dbCoord || $dbCoord['login_status'] !== 'active') {
    session_unset();
    session_destroy();
    header("Location: index.php?error=disabled");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Participants - Spyder</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome-all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --primary-color: #851428;
            --primary-dark: #6a1020;
            --secondary-color: #f4f7f6;
            --text-main: #1a1a1a;
            --text-muted: #6b7280;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--secondary-color);
            padding-top: 30px;
            padding-bottom: 50px;
        }

        .header-section {
            background: #fff;
            padding: 20px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            margin-bottom: 30px;
        }

        .page-title {
            font-weight: 800;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1.4rem;
            color: var(--text-main);
        }

        .page-title img {
            height: 32px;
        }

        .btn-scan-qr {
            background: var(--primary-color);
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(133, 20, 40, 0.2);
        }

        .btn-scan-qr:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            color: #fff;
        }

        .search-container {
            margin-bottom: 30px;
        }

        .search-wrapper {
            position: relative;
            max-width: 650px;
            margin: 0 auto;
        }

        .search-input {
            width: 100%;
            padding: 16px 20px 16px 50px;
            border-radius: 15px;
            border: 1px solid #e2e8f0;
            background: #fff;
            font-size: 1rem;
            font-weight: 500;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 4px 20px rgba(133, 20, 40, 0.08);
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.1rem;
        }

        .list-wrapper {
            max-width: 650px;
            margin: 0 auto;
        }

        .section-header {
            margin-bottom: 20px;
            padding: 0 10px;
            border-left: 5px solid var(--primary-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-header h3 {
            font-size: 1.1rem;
            font-weight: 800;
            margin: 0;
            color: var(--text-main);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .count-badge {
            background: #f1f5f9;
            color: var(--primary-color);
            padding: 4px 12px;
            border-radius: 6px;
            font-weight: 800;
            font-size: 0.75rem;
            border: 1px solid #e2e8f0;
        }

        .participant-card {
            background: #fff;
            border: 1px solid #f1f5f9;
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 16px;
            transition: all 0.3s ease;
            display: grid;
            grid-template-columns: 60px 1fr;
            gap: 20px;
            align-items: start;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .participant-card:hover {
            border-color: var(--primary-color);
            background: #fafafa;
            box-shadow: 0 8px 20px rgba(0,0,0,0.04);
        }

        .p-card-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%);
            color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 800;
            border: 2px solid #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .p-card-body {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .p-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .p-card-name {
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--text-main);
            margin: 0;
        }

        .status-pill {
            background: #d1fae5;
            color: #065f46;
            font-size: 0.65rem;
            padding: 4px 12px;
            border-radius: 50px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .p-card-info-row {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #4b5563;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .info-item i {
            color: var(--primary-color);
            font-size: 1rem;
            width: 20px;
            text-align: center;
        }

        .info-label {
            color: #9ca3af;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-right: 5px;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 30px;
        }

        .pg-btn {
            background: #fff;
            border: 1px solid #e2e8f0;
            color: #4b5563;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s;
            cursor: pointer;
        }

        .pg-btn:hover:not(:disabled) {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background: #fff5f5;
        }

        .pg-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pg-btn.active {
            background: var(--primary-color);
            color: #fff;
            border-color: var(--primary-color);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #fff;
            border-radius: 20px;
            border: 2px dashed #e2e8f0;
        }

        /* Mobile Responsive Adjustments */
        @media (max-width: 576px) {
            body {
                padding-top: 10px;
            }

            .container {
                padding-left: 10px;
                padding-right: 10px;
                overflow-x: hidden;
            }

            .header-section {
                padding: 15px;
                margin-bottom: 20px;
                border-radius: 10px;
            }

            .page-title {
                font-size: 0.9rem;
                flex-direction: row;
                justify-content: flex-start;
                width: auto;
                gap: 6px;
            }

            .page-title span {
                white-space: nowrap;
                overflow: visible;
                max-width: none;
            }

            .page-title img {
                height: 18px;
            }

            .btn-scan-qr {
                padding: 6px 10px;
                font-size: 0.65rem;
                gap: 5px;
                border-radius: 8px;
                white-space: nowrap;
                margin-left: auto;
            }

            .search-wrapper, .list-wrapper {
                max-width: 100%;
            }

            .search-input {
                padding: 12px 15px 12px 40px;
                font-size: 0.9rem;
                height: 48px;
            }

            .section-header {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                border-left-width: 4px;
            }

            .section-header h3 {
                font-size: 0.9rem;
            }

            .count-badge {
                padding: 2px 8px;
                font-size: 0.7rem;
            }

            .participant-card {
                padding: 15px;
                grid-template-columns: 45px 1fr;
                gap: 12px;
                border-radius: 15px;
            }

            .p-card-avatar {
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
            }

            .p-card-name {
                font-size: 1.05rem;
                width: 100%;
                display: block;
            }

            .p-card-header {
                align-items: flex-start;
                gap: 5px;
            }

            .status-pill {
                padding: 2px 8px;
                font-size: 0.6rem;
            }

            .info-item {
                font-size: 0.85rem;
                align-items: flex-start;
            }

            .info-item i {
                margin-top: 3px;
                font-size: 0.9rem;
            }

            .info-label {
                font-size: 0.65rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="page-title">
                    <img src="../assets/img/logo/white-logo-font.png" style="filter: brightness(0) invert(0);" alt="Spyder">
                    <span>Attendance List</span>
                </h2>
                <a href="dashboard.php" class="btn-scan-qr text-decoration-none">
                    <i class="fas fa-qrcode"></i> Scan QR
                </a>
            </div>
        </div>

        <div class="search-container">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchInput" class="search-input" placeholder="Search by name, mobile, or college..." autocomplete="off">
            </div>
        </div>

        <div class="list-wrapper">
            <div class="section-header">
                <h3>Marked Participants</h3>
                <span class="count-badge" id="participantCount">0 Students</span>
            </div>
            
            <div id="participantsList">
                <!-- Cards injected here -->
            </div>

            <div id="paginationControls" class="pagination-container">
                <!-- Pagination injected here -->
            </div>
        </div>
    </div>

    <script>
        let currentPage = 1;
        let searchTimeout = null;

        document.getElementById('searchInput').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                loadParticipants(1);
            }, 300);
        });

        function loadParticipants(page = 1) {
            const search = document.getElementById('searchInput').value;
            const listDiv = document.getElementById('participantsList');
            const countBadge = document.getElementById('participantCount');
            const pgControls = document.getElementById('paginationControls');

            fetch(`../api/get_marked_participants.php?page=${page}&search=${encodeURIComponent(search)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        countBadge.innerText = `${data.pagination.total_records} Student${data.pagination.total_records !== 1 ? 's' : ''}`;
                        
                        if (data.participants.length === 0) {
                            listDiv.innerHTML = `
                            <div class="empty-state">
                                <i class="fas fa-search"></i>
                                <p>No participants found matching your criteria.</p>
                            </div>`;
                            pgControls.innerHTML = '';
                            return;
                        }

                        let html = '';
                        data.participants.forEach(p => {
                            const initial = p.name.charAt(0).toUpperCase();
                            html += `
                            <div class="participant-card">
                                <div class="p-card-avatar">${initial}</div>
                                <div class="p-card-body">
                                    <div class="p-card-header">
                                        <h4 class="p-card-name">${p.name}</h4>
                                        <span class="status-pill">
                                            <i class="fas fa-check-circle"></i> Verified
                                        </span>
                                    </div>
                                    <div class="p-card-info-row">
                                        <div class="info-item">
                                            <i class="fas fa-mobile-alt"></i>
                                            <span><span class="info-label">Mobile</span>${p.mobile_number}</span>
                                        </div>
                                        <div class="info-item">
                                            <i class="fas fa-university"></i>
                                            <span><span class="info-label">College</span>${p.college}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        });
                        listDiv.innerHTML = html;
                        renderPagination(data.pagination);
                    }
                })
                .catch(err => console.error('Error:', err));
        }

        function renderPagination(pagination) {
            const pgControls = document.getElementById('paginationControls');
            if (pagination.total_pages <= 1) {
                pgControls.innerHTML = '';
                return;
            }

            let html = '';
            html += `<button class="pg-btn" ${pagination.current_page === 1 ? 'disabled' : ''} onclick="loadParticipants(${pagination.current_page - 1})"><i class="fas fa-chevron-left"></i></button>`;

            for (let i = 1; i <= pagination.total_pages; i++) {
                if (i === 1 || i === pagination.total_pages || (i >= pagination.current_page - 1 && i <= pagination.current_page + 1)) {
                    html += `<button class="pg-btn ${i === pagination.current_page ? 'active' : ''}" onclick="loadParticipants(${i})">${i}</button>`;
                } else if (i === pagination.current_page - 2 || i === pagination.current_page + 2) {
                    html += `<span class="px-2 text-muted">...</span>`;
                }
            }

            html += `<button class="pg-btn" ${pagination.current_page === pagination.total_pages ? 'disabled' : ''} onclick="loadParticipants(${pagination.current_page + 1})"><i class="fas fa-chevron-right"></i></button>`;
            pgControls.innerHTML = html;
        }

        // Initial load
        loadParticipants(1);
    </script>
</body>
</html>
