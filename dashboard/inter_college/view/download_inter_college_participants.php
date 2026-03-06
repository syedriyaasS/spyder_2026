<?php
include __DIR__ . '/../../../config.php';

$event_name = $_GET['event'] ?? 'No Event Specified';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="InterCollege_' . $event_name . '_participants.csv"');

$output = fopen("php://output", "w");

fputcsv($output, array('Name', 'Department', 'College', 'Email', 'Mobile', 'Event1 Selection', 'Event2 Selection', 'Attendance', 'Signature'));

$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `participants` WHERE `event1` = ? OR `event2` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $event_name, $event_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['attendance'] = '';
        $row['signature'] = '';
        fputcsv($output, array_values($row));
    }
} else {
    fputcsv($output, array('No data found'));
}

fclose($output);
$conn->close();
exit();
