<?php
include "header.php";
include __DIR__ . '/../config.php';

$sql = "SELECT * FROM interdepartment ORDER BY id DESC";
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
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f1f3f5;
        color: #333;
        border: none;
        padding: 8px 18px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.88rem;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.2s;
    }

    .btn-back:hover {
        background: #e2e6ea;
        color: #333;
    }

    .data-table {
        width: 100%;
        table-layout: fixed;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 14px rgba(0, 0, 0, 0.06);
        border-collapse: collapse;
        overflow: hidden;
    }

    .data-table col.col-num {
        width: 38px;
    }

    .data-table col.col-name {
        width: 11%;
    }

    .data-table col.col-dept {
        width: 11%;
    }

    .data-table col.col-college {
        width: 12%;
    }

    .data-table col.col-email {
        width: 18%;
    }

    .data-table col.col-mobile {
        width: 10%;
    }

    .data-table col.col-ev1 {
        width: 10%;
    }

    .data-table col.col-ev2 {
        width: 10%;
    }

    .data-table col.col-edit {
        width: 7%;
    }

    .data-table col.col-del {
        width: 7%;
    }

    .data-table thead tr {
        background: #1C1C1C;
        color: white;
    }

    .data-table thead th {
        padding: 11px 8px;
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 0.02em;
        border: none;
        text-align: left;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .data-table tbody tr {
        border-bottom: 1px solid #f2f2f2;
        transition: background 0.15s;
    }

    .data-table tbody tr:hover {
        background: #fafafa;
    }

    .data-table tbody td {
        padding: 10px 8px;
        font-size: 0.84rem;
        color: #444;
        vertical-align: middle;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .btn-edit {
        display: inline-block;
        padding: 5px 14px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.82rem;
        text-decoration: none;
        background: #e3f2fd;
        color: #1565c0;
        transition: background 0.2s;
    }

    .btn-edit:hover {
        background: #bbdefb;
        color: #1565c0;
    }

    .btn-del {
        display: inline-block;
        padding: 5px 14px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.82rem;
        text-decoration: none;
        background: #fdecea;
        color: #b71c1c;
        transition: background 0.2s;
    }

    .btn-del:hover {
        background: #ffcdd2;
        color: #b71c1c;
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
    </div>

    <div class="page-view-header">
        <h2>Inter Department &mdash; All participants</h2>
        <span id="count-badge" style="font-size:0.9rem;color:#888;"></span>
    </div>

    <table class="data-table" id="participantTable">
        <colgroup>
            <col class="col-num">
            <col class="col-name">
            <col class="col-dept">
            <col class="col-college">
            <col class="col-email">
            <col class="col-mobile">
            <col class="col-ev1">
            <col class="col-ev2">
            <col class="col-edit">
            <col class="col-del">
        </colgroup>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Department</th>
                <th>College</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Event 1</th>
                <th>Event 2</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 0;
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $count++;
                    echo "<tr>
                        <td><span style='color:#aaa;font-size:0.82rem;'>" . $count . "</span></td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['department']) . "</td>
                        <td>" . htmlspecialchars($row['college']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>" . htmlspecialchars($row['mobile']) . "</td>
                        <td>" . htmlspecialchars($row['event1']) . "</td>
                        <td>" . htmlspecialchars($row['event2']) . "</td>
                        <td><a class='btn-edit' href='i_update.php?id=" . $row['id'] . "'>Edit</a></td>
                        <td><a class='btn-del' href='i_delete.php?id=" . $row['id'] . "' onclick=\"return confirm('Delete this participant?')\">Delete</a></td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='10' class='empty-state'>No participants found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        const rows = document.querySelectorAll('#participantTable tbody tr');
        document.getElementById('count-badge').innerText = rows.length + ' participants';
    </script>
</div>

<?php include 'footer.php'; ?>