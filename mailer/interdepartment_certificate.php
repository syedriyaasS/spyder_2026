<?php
require('fpdf/fpdf.php'); // Include the FPDF library
include __DIR__ . '/../config.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ensure no accidental output before redirection or headers
if (ob_get_level() === 0) ob_start();

function log_debug($message)
{
    error_log("[DEBUG] " . $message);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST["email"]);
    $sql = "SELECT * FROM `interdepartment` WHERE `email` = '$email'";
    
    // Disable error reporting output to avoid corrupting file binaries during PDF generation
    ini_set('display_errors', 0);
    error_reporting(0);

    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row["name"];
        $event1 = $row["event1"];
        $event2 = $row["event2"];
        $event1_attended = (int)$row["event1_attendance"];
        $event2_attended = (int)$row["event2_attendance"];

        $has_event1 = (!empty($event1) && $event1_attended === 1);
        $has_event2 = (!empty($event2) && $event2_attended === 1);

        if ($has_event1 || $has_event2) {
            $pdf = new FPDF('L');
            
            // Generate page for event1 if attended
            if ($has_event1) {
                $pdf->AddPage();
                $pdf->SetDisplayMode('fullpage');
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Image('./spyder_2026_certificate.jpg', 0, 0, 300, 210);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetXY(140, 134);
                $pdf->Cell(90, 1, $name, 0, 1, 'C');
                $pdf->SetXY(100, 144);
                $pdf->Cell(60, 1, $event1, 0, 1, 'C');
            }

            // Generate another page for event2 if attended
            if ($has_event2) {
                $pdf->AddPage();
                $pdf->SetDisplayMode('fullpage');
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Image('./spyder_2026_certificate.jpg', 0, 0, 300, 210);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetXY(140, 134);
                $pdf->Cell(90, 1, $name, 0, 1, 'C');
                $pdf->SetXY(100, 144);
                $pdf->Cell(60, 1, $event2, 0, 1, 'C');
            }

            // Clean output buffer to ensure clean binary stream
            if (ob_get_length()) ob_clean();
            
            $fileName = "Certificates_{$email}.pdf";
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            $pdf->Output('D', $fileName);
            exit();
        } else {
            if (ob_get_length()) ob_clean();
            header("Location: interdepartment_certificate.html?error=not_attended");
            exit();
        }
    } else {
        if (ob_get_length()) ob_clean();
        header("Location: interdepartment_certificate.html?error=not_found");
        exit();
    }
} else {
    if (ob_get_length()) ob_clean();
    header("Location: interdepartment_certificate.html");
    exit();
}

$conn->close();

