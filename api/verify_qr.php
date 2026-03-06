<?php
// Version: 1.1 - Dynamic Events
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');
include __DIR__ . '/../config.php';

// --- Verify Active Status ---
if (isset($_SESSION['coordinator_logged_in'])) {
    $coord_id = (int)($_SESSION['coordinator_id'] ?? 0);
    $status_stmt = $conn->prepare("SELECT login_status FROM coordinators WHERE id = ? LIMIT 1");
    $status_stmt->bind_param("i", $coord_id);
    $status_stmt->execute();
    $dbCoord = $status_stmt->get_result()->fetch_assoc();
    $status_stmt->close();

    if (!$dbCoord || $dbCoord['login_status'] !== 'active') {
        echo json_encode(['success' => false, 'message' => 'Your account has been disabled by the admin.', 'disabled' => true]);
        exit();
    }
}

$qr_token = $_POST['qr_token'] ?? $_GET['qr_token'] ?? '';

if (empty($qr_token)) {
    echo json_encode(['success' => false, 'message' => 'No token provided']);
    exit();
}

// Check participants table (1 event)
$sql = "SELECT name, email, mobile, college, department, event1, event_attendance FROM participants WHERE qr_token = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $qr_token);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    echo json_encode([
        'success' => true,
        'participant' => [
            'name' => $row['name'],
            'email' => $row['email'] ?? 'N/A',
            'mobile' => $row['mobile'] ?? 'N/A',
            'college' => $row['college'],
            'department' => $row['department'] ?? 'N/A'
        ],
        'events' => [
            [
                'event_name' => $row['event1'],
                'event_key' => 'event1',
                'type' => 'Standard',
                'attendance_status' => (int)($row['event_attendance'] ?? 0)
            ]
        ]
    ]);
    $stmt->close();
    $conn->close();
    exit();
}

// Check interdepartment table
$sql = "SELECT name, email, mobile, college, department, event1, event2, event1_attendance, event2_attendance FROM interdepartment WHERE qr_token = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $qr_token);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $events = [];
    if (!empty($row['event1'])) {
        $events[] = [
            'event_name' => $row['event1'],
            'event_key' => 'event1',
            'type' => 'Inter-Dept',
            'attendance_status' => (int)($row['event1_attendance'] ?? 0)
        ];
    }
    if (!empty($row['event2'])) {
        $events[] = [
            'event_name' => $row['event2'],
            'event_key' => 'event2',
            'type' => 'Inter-Dept',
            'attendance_status' => (int)($row['event2_attendance'] ?? 0)
        ];
    }

    echo json_encode([
        'success' => true,
        'participant' => [
            'name' => $row['name'],
            'email' => $row['email'] ?? 'N/A',
            'mobile' => $row['mobile'] ?? 'N/A',
            'college' => $row['college'],
            'department' => $row['department'] ?? 'N/A'
        ],
        'events' => $events
    ]);
    $stmt->close();
    $conn->close();
    exit();
}

echo json_encode(['success' => false, 'message' => 'Invalid or Unregistered QR Token']);
$conn->close();
