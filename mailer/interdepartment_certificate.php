<?php
require('fpdf/fpdf.php'); // Include the FPDF library
include __DIR__ . '/../config.php';

// Enable error reporting during initialization
ini_set('display_errors', 0);
error_reporting(0);

// Ensure output buffer is active
if (ob_get_level() === 0) ob_start();

// Handle Direct Certificate Generation (Download / Preview)
if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'direct_generate' || isset($_REQUEST['direct_download'])) {
    $name = isset($_REQUEST['name']) ? trim($_REQUEST['name']) : '';
    $event = isset($_REQUEST['event']) ? trim($_REQUEST['event']) : 'Technical Symposium';
    $date = isset($_REQUEST['date']) && !empty($_REQUEST['date']) ? trim($_REQUEST['date']) : '09-09-2026';

    if (empty($name)) {
        $name = 'Participant Name';
    }

    if (ob_get_level() > 0) ob_clean();

    $pdf = new FPDF('L', 'mm', array(300, 210));
    $pdf->AddPage();
    $pdf->SetDisplayMode('fullpage');
    $pdf->Image(__DIR__ . '/spyder_2026_certificate.jpg', 0, 0, 300, 210);
    
    // Dynamic Participant Name
    $pdf->SetTextColor(15, 23, 42);
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->SetXY(118, 126.5);
    $pdf->Cell(133, 6, strtoupper($name), 0, 1, 'C');

    // Dynamic Event Name
    $pdf->SetXY(93, 136.8);
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(83, 6, $event, 0, 1, 'C');

    $safeName = preg_replace('/[^A-Za-z0-9_-]/', '_', $name);
    $fileName = "InterDept_Certificate_{$safeName}.pdf";

    if (ob_get_level() > 0) ob_end_clean();

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    $pdf->Output('D', $fileName);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = isset($_POST["identifier"]) ? $conn->real_escape_string($_POST["identifier"]) : '';
    
    if (empty($identifier)) {
        if (ob_get_level() > 0) ob_end_clean();
        header("Location: interdepartment_certificate.html");
        exit();
    }

    $sql = "SELECT * FROM `interdepartment` WHERE `email` = '$identifier' OR `mobile` = '$identifier'";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row["name"];
        $event1 = $row["event1"];
        $event2 = $row["event2"];
        $event1_attended = isset($row["event1_attendance"]) ? (int)$row["event1_attendance"] : 0;
        $event2_attended = isset($row["event2_attendance"]) ? (int)$row["event2_attendance"] : 0;

        $has_event1 = (!empty($event1) && $event1_attended === 1);
        $has_event2 = (!empty($event2) && $event2_attended === 1);

        if ($has_event1 || $has_event2) {
            if (ob_get_level() > 0) ob_clean();

            if ($has_event1 && $has_event2) {
                // Check if ZipArchive is enabled on the server
                if (class_exists('ZipArchive')) {
                    // Generate event1 PDF
                    $pdf1 = new FPDF('L', 'mm', array(300, 210));
                    $pdf1->AddPage();
                    $pdf1->SetDisplayMode('fullpage');
                    $pdf1->SetFont('Arial', 'B', 16);
                    $pdf1->Image(__DIR__ . '/spyder_2026_certificate.jpg', 0, 0, 300, 210);
                    $pdf1->SetTextColor(15, 23, 42);
                    $pdf1->SetXY(118, 126.5);
                    $pdf1->Cell(133, 6, strtoupper($name), 0, 1, 'C');
                    $pdf1->SetXY(93, 136.8);
                    $pdf1->SetFont('Arial', 'B', 15);
                    $pdf1->Cell(83, 6, $event1, 0, 1, 'C');
                    $pdf1Content = $pdf1->Output('S');

                    // Generate event2 PDF
                    $pdf2 = new FPDF('L', 'mm', array(300, 210));
                    $pdf2->AddPage();
                    $pdf2->SetDisplayMode('fullpage');
                    $pdf2->SetFont('Arial', 'B', 16);
                    $pdf2->Image(__DIR__ . '/spyder_2026_certificate.jpg', 0, 0, 300, 210);
                    $pdf2->SetTextColor(15, 23, 42);
                    $pdf2->SetXY(118, 126.5);
                    $pdf2->Cell(133, 6, strtoupper($name), 0, 1, 'C');
                    $pdf2->SetXY(93, 136.8);
                    $pdf2->SetFont('Arial', 'B', 15);
                    $pdf2->Cell(83, 6, $event2, 0, 1, 'C');
                    $pdf2Content = $pdf2->Output('S');

                    // Create ZIP
                    $zip = new ZipArchive();
                    $zipFileName = "Certificates_{$identifier}.zip";
                    $zipFilePath = sys_get_temp_dir() . '/' . $zipFileName;

                    if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                        $zip->addFromString("event1_certificate.pdf", $pdf1Content);
                        $zip->addFromString("event2_certificate.pdf", $pdf2Content);
                        $zip->close();

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
                
                // Fallback: Generate a single multi-page PDF
                $pdf = new FPDF('L', 'mm', array(300, 210));
                
                // Page for event1
                $pdf->AddPage();
                $pdf->SetDisplayMode('fullpage');
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Image(__DIR__ . '/spyder_2026_certificate.jpg', 0, 0, 300, 210);
                $pdf->SetTextColor(15, 23, 42);
                $pdf->SetXY(118, 126.5);
                $pdf->Cell(133, 6, strtoupper($name), 0, 1, 'C');
                $pdf->SetXY(93, 136.8);
                $pdf->SetFont('Arial', 'B', 15);
                $pdf->Cell(83, 6, $event1, 0, 1, 'C');

                // Page for event2
                $pdf->AddPage();
                $pdf->SetDisplayMode('fullpage');
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Image(__DIR__ . '/spyder_2026_certificate.jpg', 0, 0, 300, 210);
                $pdf->SetTextColor(15, 23, 42);
                $pdf->SetXY(118, 126.5);
                $pdf->Cell(133, 6, strtoupper($name), 0, 1, 'C');
                $pdf->SetXY(93, 136.8);
                $pdf->SetFont('Arial', 'B', 15);
                $pdf->Cell(83, 6, $event2, 0, 1, 'C');

                if (ob_get_level() > 0) ob_end_clean();

                $fileName = "Certificates_{$identifier}.pdf";
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                $pdf->Output('D', $fileName);
                exit();
            } else {
                // Generate a single PDF
                $pdf = new FPDF('L', 'mm', array(300, 210));
                $pdf->AddPage();
                $pdf->SetDisplayMode('fullpage');
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Image(__DIR__ . '/spyder_2026_certificate.jpg', 0, 0, 300, 210);
                $pdf->SetTextColor(15, 23, 42);
                $pdf->SetXY(118, 126.5);
                $pdf->Cell(133, 6, strtoupper($name), 0, 1, 'C');
                $pdf->SetXY(93, 136.8);
                $pdf->SetFont('Arial', 'B', 15);
                
                $actual_event = $has_event1 ? $event1 : $event2;
                $pdf->Cell(83, 6, $actual_event, 0, 1, 'C');

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
?>
