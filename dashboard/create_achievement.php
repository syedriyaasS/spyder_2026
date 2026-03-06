<?php
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Achievement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    
</head>

<body>
    <?php
    // Include the config file from the correct directory
    include __DIR__ . '/../config.php';
    ?>
    <div class="current-page-content">
        <div class="container mt-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./view_achievements.php">View Achievements</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
            <h2 class="mb-4">Add New Achievement</h2>
            <form action="./process.php" method="post" enctype="multipart/form-data" class="card card-body">
                <div class="mb-3">
                    <label for="title" class="form-label">Title:</label>
                    <input type="text" class="form-control" name="title" id="title"
                        placeholder="Enter title of the achievement" required>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date:</label>
                    <input type="date" class="form-control" name="date" id="date" value="<?php echo date("Y-m-d"); ?>"
                        required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea name="description" class="form-control" id="description" rows="4"
                        placeholder="Enter a brief description of the achievement" maxlength="750" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="image">Upload Image:</label>
                    <!-- Added 'accept' attribute to restrict file types to images -->
                    <input type="file" class="form-control" name="image" id="image" accept="image/*" required>
                </div>
                <div class="d-grid">
                    <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>

</html>

