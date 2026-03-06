<?php
include 'header.php';
include 'count.php';
?>

<style>
    .achievements-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        padding-bottom: 16px;
        border-bottom: 2px solid #eee;
    }

    .achievements-header h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1C1C1C;
        margin: 0;
    }

    .btn-create {
        background-color: #198754;
        color: white;
        padding: 10px 22px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        font-size: 0.95rem;
        border: none;
        transition: background 0.2s;
    }

    .btn-create:hover {
        background-color: #157347;
        color: white;
    }

    .achievement-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
        overflow: hidden;
        display: flex;
        flex-direction: row;
    }

    .achievement-card .card-img-wrap {
        flex: 0 0 320px;
        max-width: 320px;
        min-height: 210px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #f0f0f0;
        padding: 12px;
    }

    .achievement-card .card-img-wrap img {
        width: 100%;
        height: 210px;
        object-fit: cover;
        object-position: center;
        display: block;
        border-radius: 8px;
    }

    .achievement-card .card-details {
        flex: 1;
        padding: 24px 28px;
    }

    .achievement-card .card-details h5 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1C1C1C;
        margin-bottom: 10px;
    }

    .achievement-card .card-details p {
        color: #555;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 8px;
    }

    .achievement-card .card-details .text-muted {
        font-size: 0.85rem;
        margin-bottom: 16px;
    }

    .achievement-card .card-actions {
        display: flex;
        gap: 10px;
    }

    .achievement-card .card-actions a {
        padding: 8px 20px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
    }
</style>

<div class="achievements-header">
    <h1>Student Achievements</h1>
    <a href="create_achievement.php" class="btn-create">Create New</a>
</div>

<?php
include __DIR__ . '/../config.php';

$sql = "SELECT * FROM achievement ORDER BY date DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $images = unserialize($row['image']);
        ?>
        <div class="achievement-card">
            <div class="card-img-wrap">
                <?php if (!empty($images)): ?>
                    <img src="<?php echo htmlspecialchars($images[0]); ?>" alt="Achievement Image">
                <?php else: ?>
                    <div
                        style="height:100%;display:flex;align-items:center;justify-content:center;color:#aaa;font-size:0.9rem;padding:20px;">
                        No Image</div>
                <?php endif; ?>
            </div>
            <div class="card-details">
                <h5><?php echo htmlspecialchars($row['title']); ?></h5>
                <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                <p class="text-muted">Achieved on <?php echo date("jS M Y", strtotime($row['date'])); ?></p>
                <div class="card-actions">
                    <a href="update_achievement.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Update</a>
                    <a href="delete_achievement.php?id=<?php echo $row['id']; ?>" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete this?');">Delete</a>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo '<div class="alert alert-info">No achievements to display.</div>';
}
$conn->close();
?>

</div>

<?php include 'footer.php'; ?>