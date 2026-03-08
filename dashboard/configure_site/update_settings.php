<?php
session_start();
include_once __DIR__ . '/../../config.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION["user"])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $key = isset($_POST['key']) ? $_POST['key'] : '';
    $value = isset($_POST['value']) ? $_POST['value'] : '';

    // Validate key
    $allowed_keys = [
        'registration_status', 'switch_registration', 'certificate_status',
        'dept_registration_status', 'dept_certificate_status'
    ];
    if (!in_array($key, $allowed_keys)) {
        echo json_encode(['success' => false, 'message' => 'Invalid setting key.']);
        exit();
    }

    // Sanitize value (basic)
    $value = htmlspecialchars(strip_tags($value));

    // Update DB
    $stmt = $conn->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?");
    $stmt->bind_param("ss", $value, $key);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Setting "' . $key . '" updated to "' . $value . '".']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed: ' . $conn->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
