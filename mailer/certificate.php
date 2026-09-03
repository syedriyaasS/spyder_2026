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

            // Relative positioning calculated from Inter College certificate template dimensions (1024x682)
            $origW = 1024;
            $origH = 682;
            $scaleX = 300 / $origW;
            $scaleY = 210 / $origH;

            // 1. Participant Name: centered inside the blank line after "This certificate is awarded to"
            $nameX = 401 * $scaleX;
            $nameW = (857 - 401) * $scaleX;
            $nameLineY = 427 * $scaleY;

            $nameFontSize = 16;
            $pdf1->SetFont('Arial', 'B', $nameFontSize);
            while ($pdf1->GetStringWidth($name) > ($nameW - 6) && $nameFontSize > 9) {
                $nameFontSize -= 0.5;
                $pdf1->SetFont('Arial', 'B', $nameFontSize);
            }
            $nameBaselineOffset = 0.5 + (0.3 * ($nameFontSize * 25.4 / 72));
            $nameY = ($nameLineY - 1.1) - $nameBaselineOffset;
            $pdf1->SetXY($nameX, $nameY);
            $pdf1->Cell($nameW, 1, $name, 0, 1, 'C');

            // 2. Event Name: centered inside the blank line between "for participating in" and "event organized by Department"
            $eventX = 318 * $scaleX;
            $eventW = (602 - 318) * $scaleX;
            $eventLineY = 461 * $scaleY;

            $eventFontSize = 16;
            $pdf1->SetFont('Arial', 'B', $eventFontSize);
            while ($pdf1->GetStringWidth($event1) > ($eventW - 6) && $eventFontSize > 9) {
                $eventFontSize -= 0.5;
                $pdf1->SetFont('Arial', 'B', $eventFontSize);
            }
            $eventBaselineOffset = 0.5 + (0.3 * ($eventFontSize * 25.4 / 72));
            $eventY = ($eventLineY - 1.1) - $eventBaselineOffset;
            $pdf1->SetXY($eventX, $eventY);
            $pdf1->Cell($eventW, 1, $event1, 0, 1, 'C');

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