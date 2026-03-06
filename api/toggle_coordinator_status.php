<?php
/**
 * Toggle Coordinator Login Status
 * Called via AJAX from manage_coordinators.php (admin only)
 * 
 * Security: session_start() is FIRST. Checks $_SESSION['user'] for admin auth.
 * Updates login_status in DB: 'active' or 'disabled'
 */
session_start();
header('Content-Type: application/json');

// Admin auth check
if (!isset($_SESSION['user'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized. Please log in as admin.']);
    exit();
}

require_once __DIR__ . '/../config.php';

$id     = (int)($_POST['id']     ?? 0);
$status =       $_POST['status'] ?? '';   // 'active' or 'disabled'

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid coordinator ID.']);
    exit();
}

if (!in_array($status, ['active', 'disabled'], true)) {
    echo json_encode(['success' => false, 'message' => 'Invalid status value.']);
    exit();
}

// Update login_status in DB
$stmt = $conn->prepare("UPDATE coordinators SET login_status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Status updated to ' . $status,
        'new_status' => $status
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}

$stmt->close();
$conn->close();
