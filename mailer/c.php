<?php
require('fpdf/fpdf.php');


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include __DIR__ . '/../config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    $sql = "SELECT * FROM `participants` WHERE `email` = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row["name"];
        $event1 = $row["event1"];
        $event2 = $row["event2"];

        // Create a PDF for event1
        $pdf1 = new FPDF('L');
        $pdf1->AddPage();
        $pdf1->SetDisplayMode('fullpage');
        $pdf1->SetFont('Arial', 'B', 18);
        $pdf1->Image('./certificate-image.jpg', 0, 0, 300, 210);
        $pdf1->SetTextColor(167, 19, 19);
        $pdf1->SetXY(140, 135);
        $pdf1->Cell(90, 1, $name, 0, 1, 'C');
        $pdf1->SetXY(100, 144);
        $pdf1->SetFont('Arial', 'B', 16);
        $pdf1->Cell(60, 1, $event1, 0, 1, 'C');
        $file_path1 = __DIR__ . "/generated-certificates/{$email}_{$event1}.pdf";
        if (!file_exists(dirname($file_path1))) {
            mkdir(dirname($file_path1), 0777, true);
        }
        $pdf1->Output($file_path1, 'F');

        // Create a PDF for event2
        $pdf2 = new FPDF();
        $pdf2->AddPage();
        $pdf2->SetFont('Arial', 'B', 12);
        $pdf2->Image('./certificate-image.jpg', 0, 0, 210, 150);
        $pdf2->SetTextColor(167, 19, 19);
        $pdf2->SetXY(10, 10);
        $pdf2->Cell(0, 10, $name, 0, 1, 'C');
        $pdf2->SetXY(60, 160);
        $pdf2->Cell(0, 10, $event2, 0, 1, 'C');
        $file_path2 = __DIR__ . "/generated-certificates/{$email}_{$event2}.pdf";
        if (!file_exists(dirname($file_path2))) {
            mkdir(dirname($file_path2), 0777, true);
        }
        $pdf2->Output($file_path2, 'F');

        // Send email with attachments
        try {
            $mail = new PHPMailer(true);

            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'syedriyaasS@gmail.com';
            $mail->Password = 'mxcqzwhgcfcocxbm';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('syedriyaasS@gmail.com');
            $mail->addAddress($email);

            // Attach generated PDFs
            // $mail->addAttachment($file_path1, "{$email}_{$event1}.pdf");
            // $mail->addAttachment($file_path2, "{$email}_{$event2}.pdf");

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your Certificates';
            $mail->Body = 'Please find your certificates attached.';

            $mail->send();
            echo "<script>alert('Email sent with attachments.');</script>";
        } catch (Exception $e) {
            echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
        }

        // Clean up: remove the generated PDF files
        unlink($file_path1);
        unlink($file_path2);
    } else {
        echo "<script>alert('No participant found with the email: $email');</script>";
    }
} else {
    header("Location: certificate.html");
    exit();
}

$conn->close();
?>