<?php
session_start();
include __DIR__ . '/../../../config.php';

// Check if user is logged in
if (!isset($_SESSION["user"])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $participant_id = isset($_POST['participant_id']) ? intval($_POST['participant_id']) : 0;
    $event_type = isset($_POST['event_type']) ? $_POST['event_type'] : '';

    if ($participant_id <= 0 || !in_array($event_type, ['event1', 'event2'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
        exit();
    }

    $column = ($event_type === 'event1') ? 'event1_attendance' : 'event2_attendance';

    // Update attendance using prepared statements
    $stmt = $conn->prepare("UPDATE interdepartment SET $column = 1 WHERE id = ?");
    $stmt->bind_param("i", $participant_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Attendance marked successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update attendance: ' . $conn->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
