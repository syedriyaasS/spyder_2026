<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> Spyder </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo/loder.png">

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="assets/css/register.css">
    <style>
        .closed-container {
            border-radius: 0px;
            box-shadow: none;
            padding: 0px;
        }

        .closed {
            display: flex;
            flex-direction: row;
            justify-content: center;
        }

        .blinking-text {
            justify-content: center;
        }

        .blinking-text h2 {
            color: #851428;
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50%;
            animation: blink 1s infinite;
            justify-content: center;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <!--? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="assets/img/logo/loder.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <header>
        <!--? Header Start -->
        <div class="header-area bg-light">
            <div class="main-header header-sticky">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <!-- Logo -->
                        <div class="col-xl-2 col-lg-2 col-md-1">
                            <div class="logo">
                                <a href="index.html"><img src="assets/img/logo/logo.png" alt=""></a>
                            </div>
                        </div>
                        <div class="col-xl-10 col-lg-10 col-md-10">
                            <div class="menu-main d-flex align-items-center justify-content-end">
                                <!-- Main-menu -->
                                <div class="main-menu f-right d-none d-lg-block">
                                    <nav class="bg-light">
                                        <ul id="navigation">
                                            <li><a href="index.html">Home</a></li>
                                            <li><a href="events.html">Events</a></li>
                                            <li><a href="gallery.html">Gallery</a></li>
                                            <li><a href="./mailer/certificate.html">Certificates</a></li>
                                            <li><a href="contact.html">Contact Us</a></li>
                                        </ul>
                                    </nav>
                                </div>
                                <div class="header-right-btn f-right d-none d-lg-block ml-30">
                                    <a href="https://forms.gle/qmus4TLbyPdAAcv3A" target="_blank"
                                        class="btn header-btn nav-button">Register now</a>
                                </div>
                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
    <main>
        <div class="row">
            <div class="container closed-container">
                <div class="closed">
                    <div class="blinking-text">
                        <h2>Registration Closed</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="row container">
            <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                <h2 class="display-4 mb-3 text-center">Event Registration</h2>
                <p class="lead text-center mb-10">All participants should register individually!</p>
                <form class=" needs-validation" novalidate method="post" id="myForm" action="register.php">

                    <div class="row gx-4">
                        <div class="col-md-6">
                            <div class="form-floating mb-4 form-field">
                                <input id="name" name="name" type="text" class="form-control" placeholder="your name"
                                    required>
                                <label>Name</label>
                                <div class="error-message"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-4 form-field">
                                <input id="department" name="department" type="text" class="form-control"
                                    placeholder="Information Technology" required>
                                <label>Department</label>
                                <div class="error-message"></div>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating mb-4 form-field">
                                <input id="college" name="college" type="text" class="form-control"
                                    placeholder="college Name" required>
                                <label>College Name</label>
                                <div class="error-message"></div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-4 form-field">
                                <input id="email" name="email" type="email" class="form-control"
                                    placeholder="karthick@example.com" required>
                                <label>Email</label>
                                <div class="error-message"></div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-4 form-field">
                                <input id="mobile" name="mobile" type="text" class="form-control"
                                    placeholder="Mobile Number" required>
                                <label>Mobile Number</label>
                                <div class="error-message"></div>

                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <p class="display-4 mb-3 text-center event1-selection-heading">Select an Event</p>

                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="register-label1 mb-0" for="ppt1">Paper Presentation</label>&nbsp;
                                    <input type="radio" id="ppt" name="event1" value="Paper Presentation">

                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="register-label1 mb-0" for="ppt1">Ideathon</label>&nbsp;
                                    <input type="radio" id="ideathon" name="event1" value="Ideathon">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="register-label1 mb-0" for="debugging1">Debugging</label>&nbsp;
                                    <input type="radio" id="debugging" name="event1" value="Debugging">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="register-label1 mb-0" for="webdesign1">Web Designing</label>&nbsp;
                                    <input type="radio" id="webdesign" name="event1" value="Web Designing">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="register-label1 mb-0" for="posterdesign1">Poster
                                        Designing</label>&nbsp;
                                    <input type="radio" id="posterdesign" name="event1" value="Poster Designing">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="register-label1 mb-0" for="Marketing">Marketing</label>&nbsp;
                                    <input type="radio" id="Marketing" name="event1" value="Marketing">
                                </div>
                            </div>
                            <p id="checkboxer"></p>
                        </div>
                        <div class="col-lg-6 col-sm-12 d-none">
                            <p class="display-4 mb-3 tex  t-center event2-selection-heading">Select another Event
                                (OPTIONAL)</p>

                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="register-label1 mb-0" for="ppt">Paper Presentation</label>&nbsp;
                                    <input type="radio" id="ppt" name="event2" value="Paper Presentation">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="register-label1 mb-0" for="ideathon">Ideathon</label>&nbsp;
                                    <input type="radio" id="ideathon" name="event2" value="Ideathon">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="register-label1 mb-0" for="debugging">Debugging</label>&nbsp;
                                    <input type="radio" id="debugging" name="event2" value="Debugging">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="register-label1 mb-0" for="webdesign">Web Designing</label>&nbsp;
                                    <input type="radio" id="webdesign" name="event2" value="Web Designing">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="register-label1 mb-0" for="posterdesign">Poster
                                        Designing</label>&nbsp;
                                    <input type="radio" id="posterdesign" name="event2" value="Poster Designing">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="register-label1 mb-0" for="Marketing">Marketing</label>&nbsp;
                                    <input type="radio" id="Marketing" name="event2" value="Marketing">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <input type="submit" name="submit" class="btn rounded-pill register-page-button mb-3"
                                value="submit">
                        </div>
                </form>
            </div>
        </div> -->
    </main>
    <!-- Scroll Up -->
    <div id="back-top">
        <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
    </div>

    <!-- JS here -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize jQuery Validation
            $("#myForm").validate({
                errorPlacement: function(error, element) {
                    // Place the error message below the input field
                    error.appendTo(element.siblings(".error-message"));
                },
                rules: {
                    name: {
                        required: true,
                    },
                    department: {
                        required: true,
                    },
                    college: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    mobile: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                    },



                },
                messages: {
                    name: {
                        required: "Please enter your name",
                    },
                    department: {
                        required: "Please enter your department",
                    },
                    college: {
                        required: "Please enter your college",
                    },
                    email: {
                        required: "Please enter your email",
                    },
                    mobile: {
                        required: "Please enter your mobile",
                        minlength: "mobile number is less then 10 numbers",
                        maxlength: "mobile number is more then 10 numbers",
                    },

                },

                submitHandler: function(form) {
                    if ($("input[name='event1']:checked").length == 0) {
                        $("#checkboxer").html("Please select event");
                        return false;
                    } else {
                        $("#checkboxer").html("");
                    }
                    form.submit();
                },
            });
        });
    </script>

    <script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <!-- Jquery Mobile Menu -->
    <script src="./assets/js/jquery.slicknav.min.js"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="./assets/js/owl.carousel.min.js"></script>
    <script src="./assets/js/slick.min.js"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="./assets/js/wow.min.js"></script>
    <script src="./assets/js/animated.headline.js"></script>

    <!-- Nice-select, sticky -->
    <script src="./assets/js/jquery.nice-select.min.js"></script>
    <script src="./assets/js/jquery.sticky.js"></script>
    <script src="./assets/js/jquery.magnific-popup.js"></script>

    <!-- contact js -->
    <script src="./assets/js/contact.js"></script>
    <script src="./assets/js/jquery.form.js"></script>
    <script src="./assets/js/jquery.validate.min.js"></script>
    <script src="./assets/js/jquery.ajaxchimp.min.js"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="./assets/js/plugins.js"></script>
    <script src="./assets/js/main.js"></script>

</body>

</html>

<!-- PHP code -->

<?php

include __DIR__ . '/config.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $department = $_POST['department'];
    $college = $_POST['college'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $event1 = $_POST['event1'];
    $event2 = $_POST['event2'];

    // Check if participant mobile number or email ID already registered
    $checkSql = "SELECT COUNT(*) as count FROM `participants` WHERE `email` = '$email' OR `mobile` = '$mobile'";
    $checkResult = $conn->query($checkSql);
    $row = $checkResult->fetch_assoc();

    if ($row['count'] > 0) {
        echo '<script>';
        echo 'alert("This Mobile number or Email already registered. Please choose different email or Mobile number.");';
        echo 'window.location.href = "register.php";';
        echo '</script>';
    } else {
        $sql = "INSERT INTO `participants`(`name`,`department`,`college`,`email`,`mobile`,`event1`,`event2`)
                VALUES ('$name','$department','$college','$email','$mobile','$event1','$event2')";

        $result = $conn->query($sql);

        if ($result == TRUE) {
            echo '<script>';
            echo 'alert("Registered Successfully");';
            echo 'window.location.href = "register.php";';
            echo '</script>';
        } else {
            echo "Error:" . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>