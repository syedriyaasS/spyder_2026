<?php
require('fpdf/fpdf.php');
include __DIR__ . '/../config.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $sql = "SELECT * FROM `participants` WHERE `email` = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $hasEvents = false; // Flag to check if any event is attended

        while ($row = $result->fetch_assoc()) {
            $name = $row["name"];
            $event1 = $row["event1"];
            $event2 = $row["event2"];

            // Check if either event1 or event2 is not empty
            if (!empty($event1) || !empty($event2)) {
                $hasEvents = true;
            }

            // Create and download a PDF for event1
            if (!empty($event1)) {
                $pdf1 = new FPDF('L');
                $pdf1->AddPage();
                $pdf1->SetDisplayMode('fullpage');
                $pdf1->SetFont('Arial', 'B', 16);
                $pdf1->Image('./spyder_2025_certificate.jpg', 0, 0, 300, 210);
                $pdf1->SetTextColor(0, 0, 0);
                $pdf1->SetXY(140, 134);
                $pdf1->Cell(90, 1, $name, 0, 1, 'C');
                $pdf1->SetXY(100, 144);
                $pdf1->SetFont('Arial', 'B', 16);
                $pdf1->Cell(60, 1, $event1, 0, 1, 'C');

                // Force download for event1
                $fileName1 = "{$email}_{$event1}.pdf";
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $fileName1 . '"');
                $pdf1->Output('D', $fileName1); // Specify the filename in Output()
                exit();
            }

            // Create and download a PDF for event2
            if (!empty($event2)) {
                $pdf2 = new FPDF('L');
                $pdf2->AddPage();
                $pdf2->SetDisplayMode('fullpage');
                $pdf2->SetFont('Arial', 'B', 16);
                $pdf2->Image('./spyder_2025_certificate.jpg', 0, 0, 300, 210);
                $pdf2->SetTextColor(0, 0, 0);
                $pdf2->SetXY(140, 134);
                $pdf2->Cell(90, 1, $name, 0, 1, 'C');
                $pdf2->SetXY(100, 144);
                $pdf2->SetFont('Arial', 'B', 16);
                $pdf2->Cell(60, 1, $event2, 0, 1, 'C');

                // Force download for event2
                $fileName2 = "{$email}_{$event2}.pdf";
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $fileName2 . '"');
                $pdf2->Output('D', $fileName2); // Specify the filename in Output()
                exit();
            }
        }

        if (!$hasEvents) {
            echo "<script>
                    alert('You have not attended the event!');
                    window.location.href = 'certificate.html';
                </script>";
        }
    } else {
        echo "<script>
                alert('No participant found with the email: $email');
                window.location.href = 'certificate.html';
            </script>";
    }
    exit();
} else {
    header("Location: certificate.html");
    exit();
}
$conn->close();
?>