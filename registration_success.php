<?php
include __DIR__ . '/config.php';

$token = $_GET['token'] ?? null;

if (!$token) {
    header("Location: register.php");
    exit();
}

// Fetch participant details using the token
$sql = "SELECT * FROM `participants` WHERE `qr_token` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$participant = $stmt->get_result()->fetch_assoc();

if (!$participant) {
    die("Invalid Token or Participant not found.");
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Registration Successful - Spyder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo/loder.png">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        body {
            background-color: #f4f7f6;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        .success-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            flex-direction: column;
        }

        /* Ticket UI styling */
        .ticket-wrapper {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
            position: relative;
            border: 1px solid #ebebeb;
            margin-bottom: 30px;
        }

        .ticket-header {
            background: #851428;
            background: linear-gradient(135deg, #851428 0%, #4a0b16 100%);
            color: white;
            padding: 24px 20px;
            text-align: center;
            border-bottom: 2px dashed rgba(255, 255, 255, 0.4);
        }

        .ticket-header img {
            width: 180px;
            margin-bottom: 12px;
        }

        .ticket-title {
            font-weight: 700;
            font-size: 1.15rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin: 0;
            color: #fff;
        }

        .ticket-body {
            padding: 30px 25px;
            position: relative;
            background: #fff;
        }

        /* Ticket Cutouts */
        .ticket-body::before,
        .ticket-body::after {
            content: '';
            position: absolute;
            width: 30px;
            height: 30px;
            background: #f4f7f6;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.05);
            z-index: 10;
        }

        .ticket-body::before {
            left: -15px;
        }

        .ticket-body::after {
            right: -15px;
        }

        .participant-name {
            font-weight: 800;
            font-size: 1.6rem;
            color: #1a1a1a;
            margin-top: 0;
            margin-bottom: 18px;
            text-align: center;
            text-transform: capitalize;
            line-height: 1.3;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 8px;
        }

        .info-row:last-of-type {
            border-bottom: none;
            margin-bottom: 22px;
        }

        .info-label {
            color: #888;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .info-value {
            color: #333;
            font-weight: 600;
            font-size: 0.95rem;
            text-align: right;
            max-width: 65%;
            word-wrap: break-word;
        }

        .event-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            color: #851428;
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            text-align: center;
            margin-bottom: 25px;
            border: 1px dashed #dcdcdc;
        }

        .ticket-qr-section {
            padding: 15px;
            background: #fff;
            border-radius: 12px;
            border: 2px solid #f0f0f0;
            text-align: center;
            margin: 0 auto;
            width: fit-content;
        }

        #qrcode {
            display: flex;
            justify-content: center;
            align-items: center;
            background: white;
            padding: 5px;
        }

        #qrcode img {
            width: 160px;
            height: 160px;
        }

        .ticket-footer {
            background: #fdfdfd;
            padding: 18px 20px;
            text-align: center;
            border-top: 2px dashed #eee;
        }

        .ticket-footer p {
            margin: 0 0 5px 0;
            color: #555;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .note-small {
            font-size: 0.75rem;
            color: #d9534f;
            line-height: 1.4;
            margin-top: 8px;
            background: #fef2f2;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #fce8e8;
        }

        .btn-download {
            background: #851428;
            color: white;
            border: none;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(133, 20, 40, 0.25);
            display: inline-flex;
            align-items: center;
            gap: 12px;
        }

        .btn-download:hover {
            background: #6a1020;
            transform: translateY(-3px);
            color: white;
            box-shadow: 0 10px 25px rgba(133, 20, 40, 0.35);
        }

        .return-link {
            color: #666;
            font-weight: 600;
            text-decoration: none;
            border-bottom: 2px solid #ccc;
            padding-bottom: 2px;
            transition: all 0.2s;
        }

        .return-link:hover {
            color: #851428;
            border-color: #851428;
        }
    </style>
</head>

<body>
    <div class="success-container">

        <!-- The Ticket to be generated and downloaded -->
        <div class="ticket-wrapper" id="ticketCard">
            <div class="ticket-header">
                <img src="assets/img/logo/white-logo-font.png" alt="Spyder Logo" crossorigin="anonymous">
                <h2 class="ticket-title">Spyder 2026 Venue Pass</h2>
            </div>

            <div class="ticket-body">
                <h3 class="participant-name"><?php echo htmlspecialchars($participant['name']); ?></h3>

                <div class="info-row">
                    <span class="info-label">College</span>
                    <span class="info-value"><?php echo htmlspecialchars($participant['college']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Department</span>
                    <span class="info-value"><?php echo htmlspecialchars($participant['department']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phone</span>
                    <span class="info-value"><?php echo htmlspecialchars($participant['mobile']); ?></span>
                </div>

                <div class="event-badge">
                    <i class="fas fa-calendar-check" style="margin-right: 8px;"></i> <?php echo htmlspecialchars($participant['event1']); ?>
                </div>

                <div class="ticket-qr-section">
                    <div id="qrcode"></div>
                </div>
            </div>

            <div class="ticket-footer">
                <p><i class="fas fa-qrcode"></i> Present this QR code to the event coordinator at the venue.</p>
                <div class="note-small">
                    <strong>Note:</strong> Certificates will be issued exclusively to attendees who physically confirm their participation at the venue.
                </div>
            </div>
        </div>

        <button id="downloadBtn" class="btn btn-download">
            <i class="fas fa-download"></i> Download QR
        </button>

        <div class="mt-4 pt-2">
            <a href="index.html" class="return-link">Return to Home</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = "<?php echo htmlspecialchars($token); ?>";
            const qrContainer = document.getElementById("qrcode");

            // Generate the QR Code payload using the library
            if (typeof QRCode !== 'undefined') {
                const qrcode = new QRCode(qrContainer, {
                    text: token,
                    width: 160,
                    height: 160,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
            } else {
                qrContainer.innerHTML = "<p class='text-danger'>QR library failed to load.</p>";
            }

            // HTML2Canvas logic triggered by the button
            document.getElementById('downloadBtn').addEventListener('click', function() {
                const ticketCard = document.getElementById('ticketCard');
                const btn = this;

                // Show loading state
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating Ticket...';
                btn.disabled = true;

                // Wait a tiny bit for UI update, then capture the card
                setTimeout(() => {
                    html2canvas(ticketCard, {
                        scale: 2, // High resolution for mobile scanning/sharing
                        useCORS: true,
                        backgroundColor: '#ffffff'
                    }).then(canvas => {
                        const link = document.createElement('a');
                        link.download = `Spyder2026_EntryPass_${token.substring(0, 6)}.png`;
                        link.href = canvas.toDataURL("image/png");
                        link.click();

                        // Restore button
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }).catch(err => {
                        console.error("Error generating ticket image:", err);
                        alert("Failed to generate ticket. Please try again or take a screenshot.");
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    });
                }, 300);
            });
        });
    </script>
</body>

</html>