<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');

try {
    include __DIR__ . '/../config.php';

    // --- Auth check ---
    if (!isset($_SESSION['coordinator_logged_in'])) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized - Please log in again', 'disabled' => false]);
        exit();
    }

    // --- Verify Active Status ---
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

    $qr_token   = $_POST['qr_token']   ?? '';
    $event_key  = $_POST['event_name'] ?? ''; // 'event1' or 'event2'

    if (empty($qr_token) || empty($event_key)) {
        echo json_encode(['success' => false, 'message' => 'Missing parameters']);
        exit();
    }

    $coordinator_name  = $_SESSION['coordinator_name'] ?? 'Unknown';
    $coordinator_event = strtolower(trim($_SESSION['event_name'] ?? ''));

    // --- Identify the participant in either table ---
    $participant = null;
    $table_used = '';

    // Check participants table (1 event)
    $stmt = $conn->prepare("SELECT id, name, event1, event_attendance FROM participants WHERE qr_token = ?");
    $stmt->bind_param("s", $qr_token);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        $participant = $res->fetch_assoc();
        $table_used = 'participants';
    } else {
        // Check interdepartment table (2 events)
        $stmt = $conn->prepare("SELECT id, name, event1, event2, event1_attendance, event2_attendance FROM interdepartment WHERE qr_token = ?");
        $stmt->bind_param("s", $qr_token);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $participant = $res->fetch_assoc();
            $table_used = 'interdepartment';
        }
    }

    if (!$participant) {
        echo json_encode(['success' => false, 'message' => 'Participant not found']);
        exit();
    }

    // --- Specific Event Logic ---
    $actual_event_name = '';
    $already_attended = 0;
    $update_sql = '';

    if ($table_used === 'participants') {
        $actual_event_name = $participant['event1'] ?? '';
        $already_attended  = (int)($participant['event_attendance'] ?? 0);
        // Update both event_attendance and event1_validation_time for maximum compatibility
        $update_sql = "UPDATE participants SET event_attendance = 1, event1_validated_by = ?, event1_validation_time = CURRENT_TIMESTAMP WHERE qr_token = ?";
    } else {
        // Interdepartmental
        if ($event_key === 'event1') {
            $actual_event_name = $participant['event1'] ?? '';
            $already_attended  = (int)($participant['event1_attendance'] ?? 0);
            $update_sql = "UPDATE interdepartment SET event1_attendance = 1, event1_validated_by = ?, event1_validation_time = CURRENT_TIMESTAMP WHERE qr_token = ?";
        } else {
            $actual_event_name = $participant['event2'] ?? '';
            $already_attended  = (int)($participant['event2_attendance'] ?? 0);
            $update_sql = "UPDATE interdepartment SET event2_attendance = 1, event2_validated_by = ?, event2_validation_time = CURRENT_TIMESTAMP WHERE qr_token = ?";
        }
    }

    // Verification: Coordinator matches Participant Event
    $coordinator_event_clean = strtolower(trim($coordinator_event));
    $actual_event_name_clean  = strtolower(trim($actual_event_name));

    // Improved log message for debugging
    if ($coordinator_event_clean !== $actual_event_name_clean) {
        echo json_encode([
            'success' => false,
            'message' => "Authorization Error: You are assigned to '{$_SESSION['event_name']}', but you are trying to mark '{$actual_event_name}'."
        ]);
        exit();
    }

    // --- Duplicate Prevention ---
    if ($already_attended === 1) {
        echo json_encode(['success' => false, 'message' => 'Attendance already recorded for this event.']);
        exit();
    }

    // --- Record attendance ---
    $validated_by = $coordinator_name;
    $stmt_update = $conn->prepare($update_sql);
    if (!$stmt_update) {
        throw new Exception("SQL Prepare Failed: " . $conn->error);
    }

    $stmt_update->bind_param("ss", $validated_by, $qr_token);

    if ($stmt_update->execute()) {
        if ($conn->affected_rows > 0) {
            echo json_encode([
                'success'  => true,
                'message'  => 'Attendance confirmed successfully for ' . $actual_event_name
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No changes made. The student might already be marked or the token is invalid.'
            ]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Database Execution Error: ' . $stmt_update->error]);
    }

    $stmt_update->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
} catch (Error $e) {
    echo json_encode(['success' => false, 'message' => 'Fatal error: ' . $e->getMessage()]);
}
