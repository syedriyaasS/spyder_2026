<?php
include 'header.php';
?>

<style>
    .page-wrapper {
        padding: 30px 35px;
        padding-top: 90px;
    }

    .page-section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 6px;
    }

    .page-section-subtitle {
        color: #888;
        font-size: 0.92rem;
        margin-bottom: 22px;
    }

    .section-divider {
        border: none;
        border-top: 2px solid #f0f0f0;
        margin: 35px 0;
    }

    .event-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 14px rgba(0, 0, 0, 0.06);
        padding: 24px 20px 20px 20px;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        border: 1px solid #f2f2f2;
    }

    .event-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.1);
    }

    .event-card .card-icon {
        width: 52px;
        height: 52px;
        object-fit: contain;
        margin-bottom: 14px;
    }

    .event-card .card-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 6px;
    }

    .event-card .card-desc {
        color: #888;
        font-size: 0.88rem;
        flex: 1;
        margin-bottom: 18px;
        line-height: 1.5;
    }

    .card-btn {
        display: inline-block;
        background-color: #851428;
        color: white;
        padding: 8px 22px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.88rem;
        text-decoration: none;
        align-self: flex-start;
        transition: background 0.2s;
    }

    .card-btn:hover {
        background-color: #6a0f20;
        color: white;
    }

    .card-btn-validate {
        background-color: #2c3e50;
    }

    .card-btn-validate:hover {
        background-color: #1a252f;
    }

    .form-section-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #851428;
        margin-bottom: 28px;
        text-align: center;
    }

    .form-container {
        background: white;
        padding: 40px 50px;
        border-radius: 16px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.06);
    }
</style>

<div class="page-wrapper">

    <!-- View participants Section -->
    <p class="page-section-title">View participants</p>
    <p class="page-section-subtitle">Browse registered inter-college event participants</p>
    <div class="row g-4">
        <?php
        $events = [
            ['title' => 'Paper Presentation', 'icon' => 'ppt.png', 'link' => 'view/c_paper_presentation.php'],
            ['title' => 'Poster Designing', 'icon' => 'poster_design.png', 'link' => 'view/c_poster_designing.php'],
            ['title' => 'Marketing', 'icon' => 'marketing.png', 'link' => 'view/c_marketing.php'],
            ['title' => 'Ideathon', 'icon' => 'ideathon.png', 'link' => 'view/c_ideathon.php'],
            ['title' => 'Debugging', 'icon' => 'debugging.png', 'link' => 'view/c_debugging.php'],
            ['title' => 'Web Designing', 'icon' => 'web_designing.png', 'link' => 'view/c_web_designing.php'],
        ];
        foreach ($events as $event) {
            echo '
            <div class="col-xl-4 col-md-6">
                <div class="event-card">
                    <img class="card-icon" src="../icons/' . $event['icon'] . '" alt="' . $event['title'] . '">
                    <div class="card-title">' . $event['title'] . '</div>
                    <div class="card-desc">View all registered participants for ' . $event['title'] . '</div>
                    <a href="./' . $event['link'] . '" class="card-btn">View</a>
                </div>
            </div>';
        }
        ?>
    </div>

    <hr class="section-divider">

    <!-- Validate participants Section -->
    <p class="page-section-title">Validate participants</p>
    <p class="page-section-subtitle">Mark attendance & validate participant registrations</p>
    <div class="row g-4">
        <?php
        foreach ($events as $event) {
            $check_link = str_replace('view/c_', 'check/c_check_', $event['link']);
            echo '
            <div class="col-xl-4 col-md-6">
                <div class="event-card">
                    <img class="card-icon" src="../icons/' . $event['icon'] . '" alt="' . $event['title'] . '">
                    <div class="card-title">' . $event['title'] . '</div>
                    <div class="card-desc">Validate & mark attendance for ' . $event['title'] . ' participants</div>
                    <a href="./' . $check_link . '" class="card-btn card-btn-validate">Validate</a>
                </div>
            </div>';
        }
        ?>
    </div>

    <hr class="section-divider">

    <!-- Add New Participant Section -->
    <div class="row justify-content-center pb-4">
        <div class="col-lg-10 col-xl-8">
            <div class="form-container">
                <h2 class="form-section-title">Add New Participant</h2>
                <form method="post" id="myForm" action="inter_college_home.php" class="needs-validation" novalidate>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input name="name" type="text" class="form-control form-control-lg" placeholder="Enter name"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Department</label>
                            <input name="department" type="text" class="form-control form-control-lg"
                                placeholder="Enter department" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">College Name</label>
                            <input name="college" type="text" class="form-control form-control-lg"
                                placeholder="Enter college name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input name="email" type="email" class="form-control form-control-lg"
                                placeholder="email@example.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Mobile Number</label>
                            <input name="mobile" type="text" class="form-control form-control-lg"
                                placeholder="10-digit number" required>
                        </div>

                        <div class="col-12 mt-2">
                            <label class="form-label fw-semibold">Select Event</label>
                            <div class="row g-2 mt-1">
                                <?php
                                $check_events = ['Paper Presentation', 'Ideathon', 'Debugging', 'Web Designing', 'Poster Designing', 'Marketing'];
                                foreach ($check_events as $ce) {
                                    echo '
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="event1" value="' . $ce . '" id="event_' . str_replace(' ', '_', $ce) . '">
                                            <label class="form-check-label" for="event_' . str_replace(' ', '_', $ce) . '">' . $ce . '</label>
                                        </div>
                                    </div>';
                                }
                                ?>
                            </div>
                            <div id="checkboxer" class="text-danger mt-2 small"></div>
                        </div>

                        <div class="col-12 text-center mt-4">
                            <button type="submit" name="submit" class="card-btn py-3 px-5 border-0"
                                style="font-size:1rem;">Register Participant</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $("#myForm").validate({
            submitHandler: function(form) {
                if ($("input[name='event1']:checked").length == 0) {
                    $("#checkboxer").html("Please select an event");
                    return false;
                }
                form.submit();
            }
        });
    });
</script>

<?php include 'footer.php'; ?>

<?php
if (isset($_POST['submit'])) {
    include_once __DIR__ . '/../../config.php';
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $college = mysqli_real_escape_string($conn, $_POST['college']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $event1 = mysqli_real_escape_string($conn, $_POST['event1']);
    $event2 = "";

    $checkSql = "SELECT COUNT(*) as count FROM `participants` WHERE `email` = '$email' OR `mobile` = '$mobile'";
    $checkResult = $conn->query($checkSql);
    $row = $checkResult->fetch_assoc();

    if ($row['count'] > 0) {
        echo '<script>alert("This Mobile number or Email is already registered."); window.location.href = "inter_college_home.php";</script>';
    } else {
        $sql = "INSERT INTO `participants`(`name`,`department`,`college`,`email`,`mobile`,`event1`,`event2`)
                VALUES ('$name','$department','$college','$email','$mobile','$event1','$event2')";
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Registered Successfully"); window.location.href = "inter_college_home.php";</script>';
        } else {
            echo "Error: " . $conn->error;
        }
    }
    $conn->close();
}
?>