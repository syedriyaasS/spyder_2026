<?php
include_once __DIR__ . '/../config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow local development frontend to fetch

$settings = [];
$sql = "SELECT setting_key, setting_value FROM site_settings";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
}

// Ensure defaults for critical keys
if (!isset($settings['registration_status'])) $settings['registration_status'] = 'open';
if (!isset($settings['switch_registration'])) $settings['switch_registration'] = 'local';
if (!isset($settings['certificate_status'])) $settings['certificate_status'] = 'disabled';

echo json_encode($settings);
?>
