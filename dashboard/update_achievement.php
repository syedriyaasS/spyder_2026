<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Achievement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>

<body>
    <div class="container">
        <div class="current-page-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./view_achievements.php">View Achievements</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update</li>
                </ol>
            </nav>
            <h1 class="mb-4">Update Achievement</h1>
            <?php
            include("../config.php"); // Include your database configuration file
            
            function uploadImage($file)
            {
                $upload_dir = __DIR__ . "/uploads/";
                if ($file['error'] === 0) {
                    $file_path = $upload_dir . basename($file['name']);
                    if (move_uploaded_file($file['tmp_name'], $file_path)) {
                        return "uploads/" . basename($file['name']);
                    } else {
                        echo "Failed to upload file: " . htmlspecialchars($file['name']);
                    }
                }
                return '';
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
                $id = $_POST['id'];
                $title = $_POST['title'];
                $date = $_POST['date'];
                $description = $_POST['description'];
                $existingImages = $_POST['existingImages'] ?? [];
                $deleteImages = $_POST['deleteImages'] ?? [];

                // Filter out images marked for deletion
                $filteredImages = array_filter($existingImages, function ($path) use ($deleteImages) {
                    return !in_array($path, $deleteImages);
                });

                // Delete the files from the server
                foreach ($deleteImages as $path) {
                    $file_path = __DIR__ . "/" . $path;
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }

                $newImage = uploadImage($_FILES['image']);
                $finalImages = $newImage ? array_merge($filteredImages, [$newImage]) : $filteredImages;
                $imagesSerialized = serialize($finalImages);

                $sql = "UPDATE achievement SET title = ?, date = ?, description = ?, image = ? WHERE id = ?";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("ssssi", $title, $date, $description, $imagesSerialized, $id);
                    if ($stmt->execute()) {
                        echo '<div class="alert alert-success">Achievement updated successfully!</div>';
                        echo '<script>
                        setTimeout(function() {
                            window.location.href = "view_achievements.php";
                        }, 4000); // Redirect after 4 seconds
                    </script>';
                    } else {
                        echo '<div class="alert alert-danger">Update failed: ' . htmlspecialchars($conn->error) . '</div>';
                    }
                    $stmt->close();
                } else {
                    echo '<div class="alert alert-danger">Error preparing statement: ' . htmlspecialchars($conn->error) . '</div>';
                }

            }

            if (isset($_GET['id']) || isset($_POST['id'])) {
                $id = $_GET['id'] ?? $_POST['id'];
                $sql = "SELECT * FROM achievement WHERE id = ?";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($row = $result->fetch_assoc()) {
                        ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title:</label>
                                <input type="text" class="form-control" name="title" id="title"
                                    value="<?php echo htmlspecialchars($row['title']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date:</label>
                                <input type="date" class="form-control" name="date" id="date"
                                    value="<?php echo htmlspecialchars($row['date']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea name="description" class="form-control" id="description" rows="4"
                                    required><?php echo htmlspecialchars($row['description']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Current Image:</label>
                                <?php
                                // Unserialize the image data from the database
                                $existingImages = unserialize($row['image']);

                                // Ensure images are available and iterate through them
                                if (!empty($existingImages) && is_array($existingImages)) {
                                    foreach ($existingImages as $image) {
                                        echo '<div class="mb-2">';
                                        echo '<img src="' . htmlspecialchars($image) . '" class="img-thumbnail" width="100">'; // Correct image path
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<div class="text-muted">No images available.</div>';
                                }
                                ?>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">New Image:</label>
                                <input type="file" name="image" class="form-control" id="image">
                            </div>
                            <button type="submit" name="update" class="btn btn-primary">Update Achievement</button>
                        </form>
                        <?php
                    }
                }
                $stmt->close();
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

