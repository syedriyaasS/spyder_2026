<?php
include "header.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['interdepartment']) && isset($_POST['event'])) {
    $selectedinterdepartment = json_decode($_POST['interdepartment']);
    $event = $_POST['event'];
    $column = ($event === 'event1') ? 'event1' : 'event2';
    $sql = "UPDATE `interdepartment` SET `$column` = NULL WHERE `$column` = 'Group Singing' AND `id` IN (" . implode(',', $selectedinterdepartment) . ")";
    if ($conn->query($sql) !== TRUE) {
        echo "Error updating record: " . $conn->error;
        exit();
    }
    echo "Deletion successful"; // Send a response back
    exit(); // Stop further execution
}
$sqlEvent1 = "SELECT `id`, `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `interdepartment` WHERE `event1` = 'Group Singing'";
$resultEvent1 = $conn->query($sqlEvent1);
$sqlEvent2 = "SELECT `id`, `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `interdepartment` WHERE `event2` = 'Group Singing'";
$resultEvent2 = $conn->query($sqlEvent2);
?>

<div class="container">
    <div class="current-page-content">
        <button onclick="goBack()" class="btn btn-primary mt-2">Back</button>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
        <h2>Group-Singing interdepartment participants</h2>
        <!-- Event 2 interdepartment -->
        <div class="event-container">
            <button onclick="deleteinterdepartment('event2')" class="btn btn-danger delete-button">Remove
                Selected</button>
            <table class="table">
                <!-- Table content for Event 2 -->
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>College</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Event 2</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultEvent2->num_rows > 0) {
                        while ($row = $resultEvent2->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['department']; ?></td>
                                <td><?php echo $row['college']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['mobile']; ?></td>
                                <td><?php echo $row['event2']; ?></td>
                                <td><input type="checkbox" name="delete_checkbox_event2" value="<?php echo $row['id']; ?>"></td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='7'>No interdepartment found for Event 2</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$conn->close();
?>


<?php include 'footer.php'; ?>