<?php
include "header.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Verify that the ID is a valid integer (to prevent SQL injection)
    if (!is_numeric($id)) {
        // Handle the error or redirect as needed
        echo "Invalid ID provided.";
        exit;
    }
}
// Check if a confirmation action is requested
if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    // This block handles the actual deletion of the record
    // Prepare and execute the SQL DELETE statement
    $sql = "DELETE FROM interdepartment WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        // Deletion was successful
        echo header('location:i_all.php?success=' . $success);
        exit;
    } else {
        // Handle the error or show a message
        echo "Failed to delete interdepartment member.";
    }
} else {
    // Display a confirmation pop-up
    echo "
    <script>
    var confirmed = confirm('Are you sure you want to delete this interdepartment member? This action cannot be undone.');
    if (confirmed) {
        window.location.href = 'i_delete.php?id=$id&confirm=true';
    } else {
        window.location.href = 'i_all.php';
    }
    </script>
    ";
}
?>