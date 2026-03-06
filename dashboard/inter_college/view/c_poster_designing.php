<?php
include "header.php";
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `participants` WHERE `event1` = 'Poster Designing' OR `event2` = 'Poster Designing'";
$result = $conn->query($sql);
$conn->close();
?>

<style>
    .page-view-wrapper {
        padding: 90px 35px 40px 35px;
    }

    .page-view-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 22px;
        padding-bottom: 14px;
        border-bottom: 2px solid #f0f0f0;
    }

    .page-view-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }

    .action-bar {
        display: flex;
        gap: 10px;
        margin-bottom: 16px;
    }

    .btn-back {
        background: #f1f3f5;
        color: #333;
        border: none;
        padding: 8px 18px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.88rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
        text-decoration: none;
    }

    .btn-back:hover {
        background: #e2e6ea;
        color: #333;
    }

    .btn-download {
        background: #851428;
        color: white;
        border: none;
        padding: 8px 18px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.88rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
        text-decoration: none;
    }

    .btn-download:hover {
        background: #6a0f20;
        color: white;
    }

    .data-table {
        width: 100%;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 14px rgba(0, 0, 0, 0.06);
        border-collapse: collapse;
        overflow: hidden;
    }

    .data-table thead tr {
        background: #1C1C1C;
        color: white;
    }

    .data-table thead th {
        padding: 14px 18px;
        font-size: 0.88rem;
        font-weight: 600;
        letter-spacing: 0.03em;
        border: none;
        text-align: left;
    }

    .data-table tbody tr {
        border-bottom: 1px solid #f2f2f2;
        transition: background 0.15s;
    }

    .data-table tbody tr:hover {
        background: #fafafa;
    }

    .data-table tbody td {
        padding: 13px 18px;
        font-size: 0.9rem;
        color: #444;
        vertical-align: middle;
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #aaa;
        font-size: 1rem;
    }
</style>

<div class="page-view-wrapper">

    <div class="action-bar">
        <button class="btn-back" onclick="window.history.back()">&#8592; Back</button>
        <a href="download_inter_college_participants.php?event=Poster+Designing " class="btn-download">&#8595; Download
            CSV</a>
    </div>

    <div class="page-view-header">
        <h2>Poster Designing &mdash; participants</h2>
        <span id="count-badge" style="font-size:0.9rem;color:#888;"></span>
    </div>

    <table class="data-table" id="participantTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Department</th>
                <th>College</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Event</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $count++;
                    echo "<tr>
                        <td><span style='color:#aaa;font-size:0.82rem;'>" . $count . "</span></td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['department']) . "</td>
                        <td>" . htmlspecialchars($row['college']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>" . htmlspecialchars($row['mobile']) . "</td>
                        <td>" . htmlspecialchars($row['event1'] ?: $row['event2']) . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='empty-state'>No participants found for Poster Designing.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        document.getElementById('count-badge').innerText =
            document.querySelectorAll('#participantTable tbody tr').length + ' participants';
    </script>
</div>

<?php include 'footer.php'; ?>