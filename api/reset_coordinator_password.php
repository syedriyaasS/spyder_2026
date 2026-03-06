<?php
session_start();
header('Content-Type: application/json');

// Admin auth check
if (!isset($_SESSION['user'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized. Please log in as admin.']);
    exit();
}

require_once __DIR__ . '/../config.php';

$id = (int)($_POST['id'] ?? 0);
$new_password = $_POST['new_password'] ?? '';

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid coordinator ID.']);
    exit();
}

if (empty($new_password)) {
    echo json_encode(['success' => false, 'message' => 'Password cannot be empty.']);
    exit();
}

$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE coordinators SET password = ? WHERE id = ?");
$stmt->bind_param("si", $hashed_password, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Password reset successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}

$stmt->close();
$conn->close();
