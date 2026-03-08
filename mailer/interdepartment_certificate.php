<?php
require('fpdf/fpdf.php'); // Include the FPDF library
include __DIR__ . '/../config.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function log_debug($message)
{
    error_log("[DEBUG] " . $message);
}

function handle_download($certificates, $email)
{
    try {
        if (count($certificates) > 0) {
            // Create a ZIP file for the certificates
            $zip_file = __DIR__ . "/interdepartment-generated-certificates/{$email}_certificates.zip";
            log_debug("Creating ZIP file: $zip_file");

            $zip = new ZipArchive();
            if ($zip->open($zip_file, ZipArchive::CREATE) === TRUE) {
                foreach ($certificates as $certificate) {
                    if (file_exists($certificate)) {
                        $zip->addFile($certificate, basename($certificate));
                    } else {
                        log_debug("Certificate file not found: $certificate");
                    }
                }
                $zip->close();
                log_debug("ZIP file created successfully: $zip_file");

                // Serve the ZIP file for download
                header('Content-Type: application/zip');
                header("Content-Disposition: attachment; filename=\"{$email}_certificates.zip\"");
                readfile($zip_file);
                unlink($zip_file); // Optional: Delete the ZIP file after download
            } else {
                throw new Exception("Failed to create ZIP file.");
            }
        } else {
            log_debug("No certificates found to download.");
            throw new Exception("No certificates found to download.");
        }
    } catch (Exception $e) {
        log_debug("Error handling download: " . $e->getMessage());
        echo "<script>alert('An error occurred while processing your request: " . $e->getMessage() . "');</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST["email"]);
    $sql = "SELECT * FROM `interdepartment` WHERE `email` = '$email'";
    
    // Disable error reporting output to avoid corrupting file binaries
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
        $certificates = [];

        // Generate certificate for event1 ONLY if attended
        if (!empty($event1) && $event1_attended === 1) {
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

            $file_path1 = __DIR__ . "/interdepartment-generated-certificates/{$email}_{$event1}.pdf";
            if (!file_exists(dirname($file_path1))) {
                mkdir(dirname($file_path1), 0777, true);
            }
            $pdf1->Output($file_path1, 'F');
            $certificates[] = $file_path1;
        }

        // Generate certificate for event2 ONLY if attended
        if (!empty($event2) && $event2_attended === 1) {
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

            $file_path2 = __DIR__ . "/interdepartment-generated-certificates/{$email}_{$event2}.pdf";
            if (!file_exists(dirname($file_path2))) {
                mkdir(dirname($file_path2), 0777, true);
            }
            $pdf2->Output($file_path2, 'F');
            $certificates[] = $file_path2;
        }

        if (count($certificates) > 0) {
            if (ob_get_length()) ob_clean(); // Prevent output corruption
            handle_download($certificates, $email);
        } else {
            header("Location: interdepartment_certificate.html?error=not_attended");
            exit();
        }
    } else {
        header("Location: interdepartment_certificate.html?error=not_found");
        exit();
    }
} else {
    header("Location: interdepartment_certificate.html");
    exit();
}

$conn->close();

