<?php
include __DIR__ . '/../config.php'; // Adjusted to match the folder structure

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // First, fetch the record to get the image file paths
    $sql = "SELECT image FROM achievement WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // If there are images, unserialize and delete them from the server
        if ($row && !empty($row['image'])) {
            $images = unserialize($row['image']);
            foreach ($images as $image) {
                $imagePath = "../uploads/" . basename($image); // Ensure path points to the uploads folder
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Delete the image file
                }
            }
        }

        $stmt->close();
    } else {
        echo "Error preparing fetch statement: " . $conn->error;
        exit;
    }

    // Now, delete the achievement record from the database
    $sql = "DELETE FROM achievement WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Achievement deleted successfully!'); window.location.href='view_achievements.php';</script>";
        } else {
            echo "<script>alert('Error deleting achievement. Please try again.'); window.location.href='view_achievements.php';</script>";
        }
        $stmt->close();
    } else {
        echo "Error preparing delete statement: " . $conn->error;
    }
} else {
    echo "<script>alert('Invalid request. No ID provided.'); window.location.href='view_achievements.php';</script>";
}

$conn->close();
?>
