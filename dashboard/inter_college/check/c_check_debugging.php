<?php
include 'header.php';
// Check if a deletion request has been sent
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['participants']) && isset($_POST['event'])) {
    $selectedparticipants = json_decode($_POST['participants']);
    $event = $_POST['event'];
    // Prepare the SQL statement to update the specified event fields of participants to NULL for the Debugging event
    $column = ($event === 'event1') ? 'event1' : 'event2';
    $sql = "UPDATE `participants` SET `$column` = NULL WHERE `$column` = 'Debugging' AND `id` IN (" . implode(',', $selectedparticipants) . ")";
    if ($conn->query($sql) !== TRUE) {
        echo "Error updating record: " . $conn->error;
        exit();
    }
    echo "Deletion successful"; // Send a response back
    exit(); // Stop further execution
}
// Filter participants by the 'Debugging' event in event1 and event2 respectively
$sqlEvent1 = "SELECT `id`, `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `participants` WHERE `event1` = 'Debugging'";
$resultEvent1 = $conn->query($sqlEvent1);

$sqlEvent2 = "SELECT `id`, `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `participants` WHERE `event2` = 'Debugging'";
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
        <h2>Debugging participants</h2>
        <!-- Event 1 participants -->
        <div class="event-container">
            <h3>Event 1 participants</h3>
            <button onclick="deleteparticipants('event1')" class="btn btn-danger delete-button">Remove Selected</button>
            <table class="table">
                <!-- Table content for Event 1 -->
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>College</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Event 1</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultEvent1->num_rows > 0) {
                        while ($row = $resultEvent1->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['department']; ?></td>
                                <td><?php echo $row['college']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['mobile']; ?></td>
                                <td><?php echo $row['event1']; ?></td>
                                <td><input type="checkbox" name="delete_checkbox_event1" value="<?php echo $row['id']; ?>"></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='7'>No participants found for Event 1</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Event 2 participants -->
        <div class="event-container">
            <h3>Event 2 participants</h3>
            <button onclick="deleteparticipants('event2')" class="btn btn-danger delete-button">Remove Selected</button>
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
                        echo "<tr><td colspan='7'>No participants found for Event 2</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
// Closing the connection (don't forget to close the connection when done)
$conn->close();
?>


<?php include 'footer.php'; ?>