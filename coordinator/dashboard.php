<?php

/**
 * Coordinator Dashboard
 * - session_start() is FIRST
 * - Status always re-checked from DB (never trusted from session)
 */
session_start();
require_once __DIR__ . '/../config.php';

// Prevent caching to disable "go-back" after logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Step 1: Must be logged in
if (!isset($_SESSION['coordinator_logged_in'])) {
    header("Location: index.php");
    exit();
}

// Step 2: Re-verify status directly from DB (do NOT use session status)
$coord_id = (int)($_SESSION['coordinator_id'] ?? 0);
$stmt = $conn->prepare("SELECT login_status FROM coordinators WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $coord_id);
$stmt->execute();
$dbCoord = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$dbCoord || $dbCoord['login_status'] !== 'active') {
    // Admin disabled this account — force logout immediately
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
    <title>Coordinator Dashboard - Spyder</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/fontawesome-all.min.css">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
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
            gap: 12px;
            font-size: 1.4rem;
            color: var(--text-main);
        }

        .page-title img {
            height: 32px;
        }

        .welcome-text {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 5px;
        }

        .welcome-text strong {
            color: var(--text-main);
            font-weight: 700;
        }

        .event-badge {
            background: #ffe4e6;
            color: var(--primary-color);
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .scanner-container {
            max-width: 650px;
            margin: 0 auto;
            background: #fff;
            padding: 0;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid #eee;
        }

        .scanner-header {
            background: #f8fafc;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            font-weight: 600;
            color: var(--text-main);
            text-align: center;
        }

        #reader {
            width: 100%;
            border: none !important;
            padding: 10px;
        }

        #reader__dashboard_section_csr span {
            font-family: 'Inter', sans-serif !important;
        }

        .participant-info {
            display: none;
            padding: 30px;
            background: #fff;
        }

        .participant-name {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 25px;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 15px;
        }

        .info-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .btn-confirm {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 14px 24px;
            border-radius: 8px;
            width: 100%;
            margin-top: 15px;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 1.05rem;
            box-shadow: 0 4px 12px rgba(133, 20, 40, 0.2);
        }

        .btn-confirm:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(133, 20, 40, 0.3);
            color: white;
        }

        @keyframes pulse-green {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.6);
            }

            70% {
                transform: scale(1.02);
                box-shadow: 0 0 0 15px rgba(25, 135, 84, 0);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(25, 135, 84, 0);
            }
        }

        .btn-pulse-confirm {
            animation: pulse-green 1.5s infinite;
            background: #198754 !important;
            border: 2px solid #a3e6cd !important;
            font-size: 1.15rem !important;
            padding: 16px 20px !important;
            color: white !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2) !important;
        }

        .btn-pulse-confirm:hover {
            background: #157347 !important;
            transform: translateY(-2px);
        }

        .action-required-banner {
            background: #fff3cd;
            color: #856404;
            border: 2px solid #ffeeba;
            padding: 15px;
            border-radius: 8px;
            font-weight: 800;
            text-align: center;
            margin-bottom: 25px;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.15);
        }

        .action-required-banner i {
            color: #ffc107;
            font-size: 1.3rem;
            margin-right: 8px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        }

        .btn-back-small {
            background: transparent;
            color: #6c757d;
            border: 1px solid #dee2e6;
            padding: 6px 16px;
            border-radius: 5px;
            font-size: 0.9rem;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-back-small:hover {
            background: #f8f9fa;
            color: #343a40;
        }

        .scan-notification {
            display: none;
            padding: 16px 20px;
            border-radius: 12px;
            margin: 0 auto 20px auto;
            max-width: 650px;
            font-weight: 600;
            font-size: 1rem;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .scan-notification.success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .scan-notification.error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .btn-scan-again {
            background-color: #1f2937;
            color: #fff;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            max-width: 350px;
            margin: 0 auto;
        }

        .btn-scan-again:hover {
            background-color: #111827;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .logout-btn {
            background: #fff;
            color: #dc3545;
            border: 1px solid #fecaca;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background: #fef2f2;
            color: #b02a37;
        }
    </style>
</head>

<body>
    <div class="container">
        <div id="scanNotification" class="scan-notification"></div>

        <div class="header-section">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="page-title">
                    <img src="../assets/img/logo/white-logo-font.png" style="filter: brightness(0) invert(0);" alt="Spyder">
                    <span>Scanner</span>
                </h2>
                <a href="logout.php" class="logout-btn text-decoration-none">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            </div>
            <div class="d-flex justify-content-between align-items-end flex-wrap">
                <div>
                    <div class="welcome-text" style="font-size: 1rem;">Welcome, <strong style="font-size: 1.05rem;"><?php echo htmlspecialchars($_SESSION['coordinator_name']); ?></strong></div>
                </div>
                <div class="event-badge mt-2 mt-md-0" style="padding: 4px 10px; font-size: 0.8rem;">
                    <i class="fas fa-bookmark"></i> <?php echo htmlspecialchars($_SESSION['event_name']); ?>
                </div>
            </div>
        </div>

        <div class="text-center mb-4 px-2">
            <button id="resetScanner" class="btn btn-scan-again" style="display:none;">
                <i class="fas fa-qrcode"></i> Scan Another Participant
            </button>
        </div>

        <div class="scanner-container">
            <div class="scanner-header" id="scannerHeader">
                <i class="fas fa-camera text-muted me-2"></i> Point camera at the QR code
            </div>
            <div id="reader"></div>

            <div id="result" class="participant-info" style="display:none;">
                <div id="actionBanner" class="action-required-banner" style="display:none;">
                    <i class="fas fa-exclamation-triangle"></i> ACTION REQUIRED: Mark Attendance Below
                </div>
                <h4 class="participant-name mb-3 d-flex align-items-center">
                    <span id="pName"></span>
                    <i class="fas fa-info-circle ms-3 text-primary" style="font-size: 1.1rem; cursor: pointer; border: 1px solid #cce5ff; background: #e6f2ff; padding: 6px; border-radius: 50%; opacity: 0.9;" onclick="toggleDetails()" title="View Details"></i>
                </h4>

                <div class="row" id="pDetailsRow" style="display:none; transition: all 0.3s ease;">
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="info-label">College</div>
                        <div id="pCollege" class="info-value"></div>
                    </div>
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="info-label">Department</div>
                        <div id="pDept" class="info-value"></div>
                    </div>
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="info-label">Email</div>
                        <div id="pEmail" class="info-value" style="word-break: break-all;"></div>
                    </div>
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="info-label">Phone</div>
                        <div id="pPhone" class="info-value"></div>
                    </div>
                </div>

                <div id="pEvents" class="mt-2 mb-4 p-3 bg-light rounded" style="border: 1px solid #eee;"></div>

                <hr id="confirmDivider" style="display:none; border-color: #eee; margin: 20px 0;">
                <div id="eventButtons" class="row justify-content-center">
                    <!-- Dynamic buttons will be injected here -->
                </div>

                <div class="text-center mt-4" id="cancelScanContainer" style="display:none;">
                    <button class="btn-back-small" onclick="restartScanner()">
                        <i class="fas fa-arrow-left"></i> Cancel & Back
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentToken = null;
        const html5QrCode = new Html5Qrcode("reader");
        const config = {
            fps: 10,
            qrbox: {
                width: 250,
                height: 250
            }
        };

        function toggleDetails() {
            const detailsRow = document.getElementById('pDetailsRow');
            if (detailsRow.style.display === 'none') {
                detailsRow.style.display = 'flex';
            } else {
                detailsRow.style.display = 'none';
            }
        }

        function toggleDetails() {
            const detailsRow = document.getElementById('pDetailsRow');
            if (detailsRow.style.display === 'none') {
                detailsRow.style.display = 'flex';
            } else {
                detailsRow.style.display = 'none';
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            currentToken = decodedText;
            html5QrCode.stop().then(() => {
                fetchParticipant(currentToken);
            });
        }

        html5QrCode.start({
            facingMode: "environment"
        }, config, onScanSuccess);

        function fetchParticipant(token) {
            // Added timestamp to URL for cache busting
            const cacheBust = new Date().getTime();
            fetch('../api/verify_qr.php?v=' + cacheBust, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'qr_token=' + encodeURIComponent(token)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.disabled) {
                        Swal.fire({
                            title: 'Account Disabled',
                            html: `⚠️ ${data.message}<br><br><b>You will be logged out now.</b>`,
                            icon: 'error',
                            confirmButtonColor: '#851428',
                            allowOutsideClick: false
                        }).then(() => {
                            window.location.href = 'logout.php';
                        });
                        return;
                    }

                    if (data.success) {
                        document.getElementById('pName').innerText = data.participant.name;
                        document.getElementById('pCollege').innerText = data.participant.college;
                        document.getElementById('pDept').innerText = data.participant.department;
                        document.getElementById('pEmail').innerText = data.participant.email;
                        document.getElementById('pPhone').innerText = data.participant.mobile;

                        let eventsHtml = '';
                        let buttonsHtml = '';
                        let hasActions = false;
                        let registeredForMyEvent = false;
                        const myEventName = <?php echo json_encode(strtolower(trim($_SESSION['event_name'] ?? ''))); ?>;

                        if (data.events && data.events.length > 0) {
                            data.events.forEach(event => {
                                const eventNameLower = event.event_name.toLowerCase().trim();
                                const isPresent = event.attendance_status === 1;
                                const isMyEvent = eventNameLower === myEventName;

                                if (isMyEvent) registeredForMyEvent = true;

                                eventsHtml += `<div class="mb-2"><strong>${event.event_name}:</strong> ${isPresent ? '<span class="badge badge-success">Present</span>' : '<span class="badge badge-warning">Not Verified</span>'}</div>`;

                                if (!isPresent && isMyEvent) {
                                    hasActions = true;
                                    buttonsHtml += `
                                    <div class="col-12 col-md-8 mb-3">
                                        <button onclick="confirmAttendance('${event.event_key}', '${event.event_name}')" class="btn btn-confirm btn-pulse-confirm">
                                            <i class="fas fa-check-circle me-1"></i> Confirm Participation
                                        </button>
                                    </div>`;
                                } else if (isPresent && isMyEvent) {
                                    buttonsHtml += `
                                    <div class="col-md-6 mb-3">
                                        <div class="alert alert-success py-2 text-center h-100 d-flex align-items-center justify-content-center" style="font-size: 0.9em; margin-bottom: 0;">
                                            <i class="fas fa-check-circle mr-2"></i> Present - ${event.event_name}
                                        </div>
                                    </div>`;
                                }
                            });
                        }

                        // Strict Event Check: If not registered for this coordinator's event
                        if (!registeredForMyEvent) {
                            Swal.fire({
                                title: 'Invalid Participant',
                                html: `This participant is <b>NOT</b> registered for your event (<?php echo htmlspecialchars($_SESSION['event_name']); ?>).<br><br>They appear to be registered for:<br><b>${data.events.map(e => e.event_name).join(', ')}</b>`,
                                icon: 'warning',
                                confirmButtonColor: '#851428'
                            }).then(() => {
                                restartScanner();
                            });
                            return;
                        }

                        document.getElementById('pEvents').innerHTML = eventsHtml;
                        document.getElementById('eventButtons').innerHTML = buttonsHtml;

                        document.getElementById('actionBanner').style.display = hasActions ? 'block' : 'none';
                        document.getElementById('confirmDivider').style.display = hasActions ? 'block' : 'none';

                        document.getElementById('scannerHeader').style.display = 'none';
                        document.getElementById('result').style.display = 'block';

                        // Logic for bottom buttons based on state
                        if (hasActions) {
                            // Needs confirmation: hide main scan button, show small cancel button
                            document.getElementById('resetScanner').style.display = 'none';
                            document.getElementById('cancelScanContainer').style.display = 'block';
                        } else {
                            // Already confirmed/marked logic: show big scan again button, hide cancel
                            document.getElementById('resetScanner').style.display = 'inline-flex';
                            document.getElementById('cancelScanContainer').style.display = 'none';
                        }
                    } else {
                        Swal.fire({
                            title: 'Scan Error',
                            text: data.message,
                            icon: 'error',
                            confirmButtonColor: '#851428'
                        }).then(() => {
                            restartScanner();
                        });
                    }
                });
        }

        function showNotification(message, type) {
            const notif = document.getElementById('scanNotification');
            notif.className = 'scan-notification ' + type;
            notif.innerText = message;
            notif.style.display = 'block';
            setTimeout(() => {
                notif.style.display = 'none';
            }, 5000);
        }

        function confirmAttendance(eventKey, eventName) {
            Swal.fire({
                title: 'Confirm Attendance',
                text: `Mark attendance for ${eventName}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Mark Present'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('../api/confirm_attendance.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `qr_token=${encodeURIComponent(currentToken)}&event_name=${eventKey}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.disabled) {
                                Swal.fire({
                                    title: 'Account Disabled',
                                    html: `⚠️ ${data.message}<br><br><b>You will be logged out now.</b>`,
                                    icon: 'error',
                                    confirmButtonColor: '#851428',
                                    allowOutsideClick: false
                                }).then(() => {
                                    window.location.href = 'logout.php';
                                });
                                return;
                            }

                            if (data.success) {
                                showNotification('✅ ' + data.message, 'success');
                                fetchParticipant(currentToken); // refresh to show Present badge
                            } else {
                                showNotification('⚠️ ' + data.message, 'error');
                            }
                        })
                        .catch(() => {
                            showNotification('❌ Network error. Please try again.', 'error');
                        });
                }
            });
        }

        function restartScanner() {
            document.getElementById('result').style.display = 'none';
            document.getElementById('scannerHeader').style.display = 'block';
            document.getElementById('pDetailsRow').style.display = 'none'; // reset details toggler
            document.getElementById('resetScanner').style.display = 'none';
            document.getElementById('cancelScanContainer').style.display = 'none';
            html5QrCode.start({
                facingMode: "environment"
            }, config, onScanSuccess);
        }

        document.getElementById('resetScanner').addEventListener('click', restartScanner);
    </script>
</body>

</html>