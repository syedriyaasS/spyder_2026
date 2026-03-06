<!-- generate certificate pdf -->

// Create a PDF instance
        $pdf = new FPDF();
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('Arial', 'B', 16);

        // Add background image
        $pdf->Image('./certificate-image.jpg', 0, 0, 210, 297);

        // Set text color
        $pdf->SetTextColor(167, 19, 19);

        // Add name and event to PDF
        $pdf->SetXY(60, 150);
        $pdf->Cell(0, 10, $name, 0, 1, 'C'); // Adjust X, Y, and cell width/height as needed

        $pdf->SetXY(60, 160);
        $pdf->Cell(0, 10, $event1, 0, 1, 'C'); // Adjust X, Y, and cell width/height as needed


        ---------------------------------------------
        