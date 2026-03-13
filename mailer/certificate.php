<?php
require('fpdf/fpdf.php');
include __DIR__ . '/../config.php';

// Disable error reporting output to avoid corrupting PDF binary streams
ini_set('display_errors', 0);
error_reporting(0);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST["email"]);
    $sql = "SELECT name, event1, event_attendance FROM `participants` WHERE `email` = '$email'";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        $name = $row["name"];
        $event1 = $row["event1"];
        $attended = (int)$row["event_attendance"];

        if ($attended === 1 && !empty($event1)) {
            // Clean output buffer to ensure no corruption
            if (ob_get_level() > 0) ob_clean();
            
            // Create and download a PDF
            $pdf1 = new FPDF('L');
            $pdf1->AddPage();
            $pdf1->SetDisplayMode('fullpage');
            $pdf1->SetFont('Arial', 'B', 16);
            $pdf1->Image('./spyder_2026_certificate.jpg', 0, 0, 300, 210);
            $pdf1->SetTextColor(0, 0, 0);
            $pdf1->SetXY(140, 134);
            $pdf1->Cell(90, 1, $name, 0, 1, 'C');
            $pdf1->SetXY(100, 144);
            $pdf1->SetFont('Arial', 'B', 16);
            $pdf1->Cell(60, 1, $event1, 0, 1, 'C');

            // Force download for event
            $fileName1 = "Certificate_{$email}.pdf";
            
            // Final clean before headers
            if (ob_get_level() > 0) ob_end_clean();
            
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $fileName1 . '"');
            $pdf1->Output('D', $fileName1);
            exit();
        } else {
            if (ob_get_level() > 0) ob_end_clean();
            header("Location: certificate.html?error=not_attended");
            exit();
        }
    } else {
        if (ob_get_level() > 0) ob_end_clean();
        header("Location: certificate.html?error=not_found");
        exit();
    }
} else {
    if (ob_get_level() > 0) ob_end_clean();
    header("Location: certificate.html");
    exit();
}
$conn->close();
?>