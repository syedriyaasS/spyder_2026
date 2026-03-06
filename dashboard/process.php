<?php
include __DIR__ . '/../config.php';

function uploadImage($file)
{
    $upload_dir = __DIR__ . "/uploads/"; // Update the upload directory path to the correct location
    $uploaded_file = "";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true); // Create the uploads directory if it doesn't exist
    }

    if ($file['error'] == 0) {
        $name = $file['name'];
        $temp_name = $file['tmp_name'];
        $file_type = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $path = $upload_dir . uniqid() . "_" . basename($name);

        // Validate file type - Accept only JPG, JPEG, PNG, GIF files
        if (!in_array($file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            return "";
        }

        // Validate file size (5MB limit)
        if ($file['size'] > 5000000) {
            echo "Sorry, your file is too large.";
            return "";
        }

        // Upload file
        if (move_uploaded_file($temp_name, $path)) {
            $uploaded_file = "uploads/" . basename($path); // Save the relative path
        } else {
            echo "Sorry, there was an error uploading your file: " . htmlspecialchars($name);
        }
    } else {
        echo "Error with the file upload.";
    }
    return $uploaded_file;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $imagePath = uploadImage($_FILES['image']); // Upload only a single image

    if (!empty($imagePath)) {
        // Serialize the image path (although you are uploading only one image, it's still serialized)
        $imagePathSerialized = serialize([$imagePath]);

        // Insert into the database
        $sql = "INSERT INTO achievement (title, date, description, image) VALUES (?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssss", $title, $date, $description, $imagePathSerialized);
            if ($stmt->execute()) {
                echo "Record created successfully.";
                header("Location: ./view_achievements.php"); // Redirect to view achievements
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "No image uploaded or an error occurred.";
    }
}
$conn->close();
?>
