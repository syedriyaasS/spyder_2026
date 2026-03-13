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
    $identifier = $conn->real_escape_string($_POST["identifier"]);
    $sql = "SELECT * FROM `interdepartment` WHERE `email` = '$identifier' OR `mobile` = '$identifier'";
    
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
            // Clean output buffer at the start to ensure no corruption
            if (ob_get_level() > 0) ob_clean();

            if ($has_event1 && $has_event2) {
                // Check if ZipArchive is enabled on the server
                if (class_exists('ZipArchive')) {
                    // Generate event1 PDF
                    $pdf1 = new FPDF('L');
                    $pdf1->AddPage();
                    $pdf1->SetDisplayMode('fullpage');
                    $pdf1->SetFont('Arial', 'B', 16);
                    $pdf1->Image('./spyder_2026_certificate.jpg', 0, 0, 300, 210);
                    $pdf1->SetTextColor(0, 0, 0);
                    $pdf1->SetXY(140, 134);
                    $pdf1->Cell(90, 1, $name, 0, 1, 'C');
                    $pdf1->SetXY(100, 144);
                    $pdf1->Cell(60, 1, $event1, 0, 1, 'C');
                    $pdf1Content = $pdf1->Output('S');

                    // Generate event2 PDF
                    $pdf2 = new FPDF('L');
                    $pdf2->AddPage();
                    $pdf2->SetDisplayMode('fullpage');
                    $pdf2->SetFont('Arial', 'B', 16);
                    $pdf2->Image('./spyder_2026_certificate.jpg', 0, 0, 300, 210);
                    $pdf2->SetTextColor(0, 0, 0);
                    $pdf2->SetXY(140, 134);
                    $pdf2->Cell(90, 1, $name, 0, 1, 'C');
                    $pdf2->SetXY(100, 144);
                    $pdf2->Cell(60, 1, $event2, 0, 1, 'C');
                    $pdf2Content = $pdf2->Output('S');

                    // Create ZIP
                    $zip = new ZipArchive();
                    $zipFileName = "Certificates_{$identifier}.zip";
                    $zipFilePath = sys_get_temp_dir() . '/' . $zipFileName;

                    if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                        $zip->addFromString("event1_certificate.pdf", $pdf1Content);
                        $zip->addFromString("event2_certificate.pdf", $pdf2Content);
                        $zip->close();

                        // Final buffer clean before headers
                        if (ob_get_level() > 0) ob_end_clean();

                        header('Content-Type: application/zip');
                        header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
                        header('Content-Length: ' . filesize($zipFilePath));
                        header('Pragma: no-cache');
                        header('Expires: 0');
                        readfile($zipFilePath);
                        unlink($zipFilePath);
                        exit();
                    }
                }
                
                // Fallback: Generate a single multi-page PDF if ZipArchive is missing or creation fails
                $pdf = new FPDF('L');
                
                // Page for event1
                $pdf->AddPage();
                $pdf->SetDisplayMode('fullpage');
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Image('./spyder_2026_certificate.jpg', 0, 0, 300, 210);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetXY(140, 134);
                $pdf->Cell(90, 1, $name, 0, 1, 'C');
                $pdf->SetXY(100, 144);
                $pdf->Cell(60, 1, $event1, 0, 1, 'C');

                // Page for event2
                $pdf->AddPage();
                $pdf->SetDisplayMode('fullpage');
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Image('./spyder_2026_certificate.jpg', 0, 0, 300, 210);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetXY(140, 134);
                $pdf->Cell(90, 1, $name, 0, 1, 'C');
                $pdf->SetXY(100, 144);
                $pdf->Cell(60, 1, $event2, 0, 1, 'C');

                // Final buffer clean before headers
                if (ob_get_level() > 0) ob_end_clean();

                $fileName = "Certificates_{$identifier}.pdf";
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                $pdf->Output('D', $fileName);
                exit();
            } else {
                // Generate a single PDF
                $pdf = new FPDF('L');
                $pdf->AddPage();
                $pdf->SetDisplayMode('fullpage');
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Image('./spyder_2026_certificate.jpg', 0, 0, 300, 210);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetXY(140, 134);
                $pdf->Cell(90, 1, $name, 0, 1, 'C');
                $pdf->SetXY(100, 144);
                
                $actual_event = $has_event1 ? $event1 : $event2;
                $pdf->Cell(60, 1, $actual_event, 0, 1, 'C');

                // Final buffer clean before headers
                if (ob_get_level() > 0) ob_end_clean();

                $fileName = "Certificate_{$identifier}.pdf";
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                $pdf->Output('D', $fileName);
                exit();
            }
        } else {
            if (ob_get_level() > 0) ob_end_clean();
            header("Location: interdepartment_certificate.html?error=not_attended");
            exit();
        }
    } else {
        if (ob_get_level() > 0) ob_end_clean();
        header("Location: interdepartment_certificate.html?error=not_found");
        exit();
    }
} else {
    if (ob_get_level() > 0) ob_end_clean();
    header("Location: interdepartment_certificate.html");
    exit();
}

$conn->close();

