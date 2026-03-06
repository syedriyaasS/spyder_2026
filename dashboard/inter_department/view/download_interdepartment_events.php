<?php
// Include your database connection details
include __DIR__ . '/../../../config.php';

// Get the event name from the URL query parameter
$event_name = $_GET['event'] ?? 'No Event Specified';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $event_name . '_interdepartment_participants.csv"');

$output = fopen("php://output", "w");

// Add the header of the CSV file
fputcsv($output, array('Name', 'Department', 'College', 'Email', 'Mobile', 'Technical Event', 'Non-Technical Event', 'Tech Attendance', 'Non-Tech Attendance', 'Status'));

$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2`, `event1_attendance`, `event2_attendance` FROM `interdepartment` WHERE `event1` = ? OR `event2` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $event_name, $event_name);
$stmt->execute();
$result = $stmt->get_result();

// Loop through the rows and write to the CSV file
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['status'] = ($row['event1_attendance'] || $row['event2_attendance']) ? 'Marked' : 'Pending';
        fputcsv($output, array_values($row));
    }
} else {
    // Optionally handle the case where no rows are found
    fputcsv($output, array('No data found'));
}

fclose($output);
$conn->close();
exit();
