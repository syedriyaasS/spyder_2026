<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');
include __DIR__ . '/../config.php';

// --- Auth check ---
if (!isset($_SESSION['coordinator_logged_in'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$coordinator_name = $_SESSION['coordinator_name'] ?? '';
if (empty($coordinator_name)) {
    echo json_encode(['success' => false, 'message' => 'Incomplete session data']);
    exit();
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$limit = 10;
$offset = ($page - 1) * $limit;

$search_query = "%$search%";

try {
    // 1. Get total count for pagination with search
    $count_sql = "SELECT COUNT(*) as total FROM (
        SELECT id FROM participants WHERE event1_validated_by = ? AND event_attendance = 1 AND (name LIKE ? OR mobile LIKE ? OR college LIKE ?)
        UNION ALL
        SELECT id FROM interdepartment WHERE event1_validated_by = ? AND event1_attendance = 1 AND (name LIKE ? OR mobile LIKE ? OR college LIKE ?)
        UNION ALL
        SELECT id FROM interdepartment WHERE event2_validated_by = ? AND event2_attendance = 1 AND (name LIKE ? OR mobile LIKE ? OR college LIKE ?)
    ) combined";
    
    $count_stmt = $conn->prepare($count_sql);
    $count_stmt->bind_param("ssssssssssss", 
        $coordinator_name, $search_query, $search_query, $search_query,
        $coordinator_name, $search_query, $search_query, $search_query,
        $coordinator_name, $search_query, $search_query, $search_query
    );
    $count_stmt->execute();
    $total_records = $count_stmt->get_result()->fetch_assoc()['total'];
    $count_stmt->close();

    $total_pages = ceil($total_records / $limit);

    // 2. Fetch paginated participants with search
    $data_sql = "SELECT name, mobile_number, college, timestamp FROM (
        SELECT name, mobile as mobile_number, college, event1_validation_time as timestamp FROM participants WHERE event1_validated_by = ? AND event_attendance = 1 AND (name LIKE ? OR mobile LIKE ? OR college LIKE ?)
        UNION ALL
        SELECT name, mobile as mobile_number, college, event1_timestamp as timestamp FROM interdepartment WHERE event1_validated_by = ? AND event1_attendance = 1 AND (name LIKE ? OR mobile LIKE ? OR college LIKE ?)
        UNION ALL
        SELECT name, mobile as mobile_number, college, event2_timestamp as timestamp FROM interdepartment WHERE event2_validated_by = ? AND event2_attendance = 1 AND (name LIKE ? OR mobile LIKE ? OR college LIKE ?)
    ) combined 
    ORDER BY timestamp DESC 
    LIMIT ? OFFSET ?";

    $stmt = $conn->prepare($data_sql);
    $stmt->bind_param("ssssssssssssii", 
        $coordinator_name, $search_query, $search_query, $search_query,
        $coordinator_name, $search_query, $search_query, $search_query,
        $coordinator_name, $search_query, $search_query, $search_query,
        $limit, $offset
    );
    $stmt->execute();
    $res = $stmt->get_result();
    
    $participants = [];
    while ($row = $res->fetch_assoc()) {
        $participants[] = $row;
    }
    $stmt->close();

    echo json_encode([
        'success' => true,
        'participants' => $participants,
        'pagination' => [
            'total_records' => $total_records,
            'total_pages' => $total_pages,
            'current_page' => $page,
            'limit' => $limit,
            'search' => $search
        ]
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}

$conn->close();
?>
