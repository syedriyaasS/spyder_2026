<?php
include "header.php";
$participantDetails = [];
$searchDone = false;
$noResult = false;

if (isset($_GET['mobile']) && !empty(trim($_GET['mobile']))) {
    $searchDone = true;
    $mobile = trim($_GET['mobile']);
    $sql = "SELECT * FROM participants WHERE mobile = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('s', $mobile);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $participantDetails[] = $row;
            }
        } else {
            $noResult = true;
        }
        $result->close();
        $stmt->close();
    }
    $conn->close();
}
?>

<style>
    .search-page-wrapper {
        padding: 90px 35px 40px 35px;
    }

    .search-card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 2px 18px rgba(0, 0, 0, 0.07);
        padding: 36px 40px;
        max-width: 580px;
        margin-bottom: 36px;
    }

    .search-card h2 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 6px;
    }

    .search-card p.subtitle {
        color: #999;
        font-size: 0.9rem;
        margin-bottom: 22px;
    }

    .search-input-group {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .search-input-group input {
        flex: 1;
        padding: 11px 16px;
        border: 1.5px solid #ddd;
        border-radius: 8px;
        font-size: 0.95rem;
        outline: none;
        transition: border 0.2s;
    }

    .search-input-group input:focus {
        border-color: #851428;
    }

    .btn-search {
        background: #851428;
        color: white;
        border: none;
        padding: 11px 24px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.2s;
    }

    .btn-search:hover {
        background: #6a0f20;
    }

    .btn-back-top {
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
        margin-bottom: 20px;
        text-decoration: none;
        transition: background 0.2s;
    }

    .btn-back-top:hover {
        background: #e2e6ea;
        color: #333;
    }

    .results-header {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 14px;
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

    .no-result-box {
        background: #fff8f8;
        border: 1.5px solid #f5c2c7;
        border-radius: 10px;
        padding: 24px 28px;
        color: #842029;
        font-size: 0.95rem;
        max-width: 500px;
    }
</style>

<div class="search-page-wrapper">

    <button class="btn-back-top" onclick="window.history.back()">&#8592; Back</button>

    <div class="search-card">
        <h2>&#128222; Search by Mobile Number</h2>
        <p class="subtitle">Find inter-college participant details using their registered mobile number</p>
        <form action="" method="get">
            <div class="search-input-group">
                <input type="text" id="mobile" name="mobile" placeholder="Enter 10-digit mobile number"
                    value="<?php echo isset($_GET['mobile']) ? htmlspecialchars($_GET['mobile']) : ''; ?>"
                    pattern="[0-9]{10}" maxlength="10" required>
                <button type="submit" class="btn-search">Search</button>
            </div>
        </form>
    </div>

    <?php if ($noResult): ?>
        <div class="no-result-box">
            &#9888; No participant found with mobile number
            <strong><?php echo htmlspecialchars($_GET['mobile']); ?></strong>.
        </div>
    <?php elseif (!empty($participantDetails)): ?>
        <div class="results-header">Results — <?php echo count($participantDetails); ?> participant(s) found</div>
        <table class="data-table">
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
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($participantDetails as $p): ?>
                    <tr>
                        <td><span style="color:#aaa;font-size:0.82rem;"><?php echo $i++; ?></span></td>
                        <td><?php echo htmlspecialchars($p['name']); ?></td>
                        <td><?php echo htmlspecialchars($p['department']); ?></td>
                        <td><?php echo htmlspecialchars($p['college']); ?></td>
                        <td><?php echo htmlspecialchars($p['email']); ?></td>
                        <td><?php echo htmlspecialchars($p['mobile']); ?></td>
                        <td><?php echo htmlspecialchars($p['event1']); ?></td>
                        <td><?php echo htmlspecialchars($p['event2']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

<?php include 'footer.php'; ?>