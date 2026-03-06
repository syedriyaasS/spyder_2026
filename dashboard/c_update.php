<?php
include "header.php";
if (isset($_GET['id'])) {
    $participantId = $_GET['id'];
    // Fetch the participant's data from the database based on the ID
    $sql = "SELECT * FROM participants WHERE id = $participantId";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $department = $row['department'];
        $college = $row['college'];
        $email = $row['email'];
        $mobile = $row['mobile'];
        $event1 = $row['event1'];
        $event2 = $row['event2'];
    }
    // Check if the update form is submitted
    if (isset($_POST['update_participantSql'])) {
        $newname = $_POST['name'];
        $newdepartment = $_POST['department'];
        $newcollege = $_POST['college'];
        $newemail = $_POST['email'];
        $newmobile = $_POST['mobile'];
        $newevent1 = $_POST['event1'];
        $newevent2 = $_POST['event2'];
        // Update the participant's information
        $update_participantSql = "UPDATE participants SET `name` = '$newname',`department` = '$newdepartment',`college` = '$newcollege',`email` = '$newemail',`mobile` = '$newmobile',`event1` = '$newevent1', `event2` = '$newevent2' WHERE id = $participantId";
        $result = $conn->query($update_participantSql);
        if ($result === TRUE) { // Check if the query was executed successfully
            echo "New Participant Record Updated successfully";
        } else {
            echo "Error:" . $update_participantSql . "<br>" . $conn->error;
        }
        header('location:c_all.php?success=' . $success);
        exit;
        // Close the database connection
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <script type="text/javascript">
        //Put the javascript function you want the button to do Here
        function show_alert() {
            alert("Updated Succesfully");
        }
    </script>
    <title>Update</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Update Inter College participant Details</h2>
        <form method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" value="<?php echo ($row['name']); ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" name="department" value="<?php echo ($row['department']); ?>" class="form-control"
                    required>
            </div>
            <div class="form-group">
                <label for="college">College:</label>
                <input type="text" name="college" value="<?php echo ($row['college']); ?>" class="form-control"
                    required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo ($row['email']); ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile:</label>
                <input type="type" name="mobile" value="<?php echo ($row['mobile']); ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="event1">Event1:</label>
                <input type="type" name="event1" value="<?php echo ($row['event1']); ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="event2">Event2:</label>
                <input type="type" name="event2" value="<?php echo ($row['event2']); ?>" class="form-control">
            </div>
            <button type="submit" name="update_participantSql" class="btn btn-primary" onclick="show_alert()"
                value="Submit">Update</button>
        </form>
    </div>
</body>

</html>