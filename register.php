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
        <div class="header-area">
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
                                <div class="main-menu f-right d-none d-lg-block navbar-spacing">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a href="index.html">Home</a></li>
                                            <li><a href="events.html">Events</a></li>
                                            <li><a href="student_achievement.php">Achievements</a></li>
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

        <!-- ============================================================
             OLD REGISTRATION FORM — COMMENTED OUT FOR BACKUP
             (Backend logic in PHP below is still active and unchanged)
        ============================================================= -->
        <section class="registration-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-8">
                        <div class="registration-card">
                            <div class="registration-header">
                                <div class="text-center mb-3" data-aos="fade-up" data-delay=".5s">
                                    <img src="./assets/img/logo/white-logo-font.png" width="250px" height="auto" alt="Spyder Logo">
                                </div>
                                <h2>Event Registration</h2>
                            </div>
                            <div class="registration-body">
                                <p class="sub-text text-center">All participants should register individually!</p>
                                <form class="needs-validation" novalidate method="post" id="myForm" action="register.php">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group custom-input">
                                                <input id="name" name="name" type="text" class="form-control" placeholder="Name" required>
                                                <div class="error-message"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group custom-input">
                                                <input id="department" name="department" type="text" class="form-control" placeholder="Department" required>
                                                <div class="error-message"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group custom-input">
                                                <input id="college" name="college" type="text" class="form-control" placeholder="College Name" required>
                                                <div class="error-message"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group custom-input">
                                                <input id="email" name="email" type="email" class="form-control" placeholder="Email" required>
                                                <div class="error-message"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group custom-input">
                                                <input id="mobile" name="mobile" type="text" class="form-control" placeholder="Mobile Number" required>
                                                <div class="error-message"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="event-selection-section mt-4">
                                        <h3 class="section-title text-center">Select an Event</h3>
                                        <div class="row mt-4">
                                            <div class="col-md-6 mb-3">
                                                <div class="custom-radio">
                                                    <input type="radio" id="paper_presentation" name="event1" value="Paper Presentation">
                                                    <label for="paper_presentation">Paper Presentation</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="custom-radio">
                                                    <input type="radio" id="web_designing" name="event1" value="Web Designing">
                                                    <label for="web_designing">Web Designing</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="custom-radio">
                                                    <input type="radio" id="ideathon" name="event1" value="Ideathon">
                                                    <label for="ideathon">Ideathon</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="custom-radio">
                                                    <input type="radio" id="poster_designing" name="event1" value="Poster Designing">
                                                    <label for="poster_designing">Poster Designing</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="custom-radio">
                                                    <input type="radio" id="debugging" name="event1" value="Debugging">
                                                    <label for="debugging">Debugging</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="custom-radio">
                                                    <input type="radio" id="marketing" name="event1" value="Marketing">
                                                    <label for="marketing">Marketing</label>
                                                </div>
                                            </div>
                                        </div>
                                        <p id="checkboxer" class="text-danger text-center mt-2"></p>
                                    </div>

                                    <div class="text-center mt-5">
                                        <button type="submit" name="submit" class="btn btn-submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END OF OLD FORM BACKUP -->

        <!-- ============================================================
             NEW UI — REGISTRATION CLOSED CARD
        ============================================================= -->
        <!--
        <section class="reg-closed-section">
            <div class="container">
                <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
                    <div class="col-lg-6 col-md-8 col-sm-10">
                        <div class="reg-closed-card">
                            <div class="reg-closed-icon-wrap">
                                <div class="reg-closed-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="44" height="44">
                                        <path d="M18.364 5.636a1 1 0 0 0-1.414 0L12 10.586 7.05 5.636A1 1 0 0 0 5.636 7.05L10.586 12l-4.95 4.95a1 1 0 0 0 1.414 1.414L12 13.414l4.95 4.95a1 1 0 0 0 1.414-1.414L13.414 12l4.95-4.95a1 1 0 0 0 0-1.414z"/>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="reg-closed-title">Registration Closed</h2>
                            <p class="reg-closed-subtitle">We're sorry, registration is now closed for this event.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        -->

        <style>
            /* Registration Closed Section */
            .reg-closed-section {
                background-color: #f4f5f7;
                padding: 60px 15px;
            }

            .reg-closed-card {
                background: #ffffff;
                border-radius: 12px;
                padding: 60px 40px 50px;
                text-align: center;
                box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
            }

            .reg-closed-icon-wrap {
                display: flex;
                justify-content: center;
                margin-bottom: 28px;
            }

            .reg-closed-icon {
                width: 80px;
                height: 80px;
                background-color: #8b1a2b;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 16px rgba(139, 26, 43, 0.35);
            }

            .reg-closed-title {
                color: #8b1a2b;
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 16px;
                font-family: Arial, sans-serif;
            }

            .reg-closed-subtitle {
                color: #888888;
                font-size: 1rem;
                margin: 0;
                line-height: 1.6;
                font-family: Arial, sans-serif;
            }
        </style>

    </main>
    <footer>
        <!-- Footer Start-->
        <div class="footer-area footer-padding">
            <div class="container">
                <div class="row d-flex justify-content-between" data-aos="fade-up">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-footer-caption mb-50">
                            <div class="single-footer-caption mb-30">
                                <div class="footer-tittle">
                                    <h4>About Us</h4>
                                    <div class="footer-pera">
                                        <div class="hicastextlogo" data-animation="fadeInLeft" data-delay=".1s">
                                            <a href="https://www.hicas.ac.in/"><img src="./assets/img/logo/hicas.text.png"
                                                    width="200px" height="auto"></a>
                                        </div>
                                        <p>SPYDER <br>
                                            A National Level Technical Symposium.</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4>Contact Us</h4>
                                <ul>
                                    <li>
                                        <p>Department of Information Technology,<br>

                                            Hindusthan College of Arts & Science (Autonomous),<br>

                                            Coimbatore - 641028</p>
                                    </li>
                                    <li><a href="#">Kavinraj R :<span> 8838345346</span></a></li>
                                    <li><a href="#">Siva Prasad U :<span> 9345613592</span></a></li>
                                    <li><a href="#">Email :<span>itspyder@hicas.ac.in</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4>Quick Link</h4>
                                <ul>
                                    <li><a href="#">Education </a></li>
                                    <li><a href="#">Ethics</a></li>
                                    <li><a href="#">Excellence</a></li>
                                    <li><a href="#">itspyder</a></li>
                                    <li><a href="#">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-5">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">

                                <h4>Students Organisers</h4>
                                <h5 class="footer-UG">UG</h5>
                                <div class="footer-pera footer-pera2">
                                    <ul>
                                        <li>1. Mr. Siva Prasad U - III B.Sc IT </li>
                                        <li>2. Mr. Pradeepkumar. K - III B.Sc IT</li>
                                        <li>3. Mr. Dhilipkumar. G - III B.Sc IT</li>
                                        <li>4. Ms. Preethika S - II B.Sc IT</li>
                                        <li>5. Mr. Pravinth N - I B.Sc IT</li>
                                        <h5>PG</h5>
                                        <li>1. Ms.Sathya. P - II M.Sc IT </li>
                                        <li>2. Mr.Kavinraj. R - II M.Sc IT</li>
                                        <li>3. Mr.Cheralathan. R.V - I M.Sc IT</li>
                                        <li>4. Ms.Vaishnavi. M - I M.Sc IT</li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer end -->
                <div class="row footer-wejed">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <!-- logo -->
                        <div class="footer-logo mb-20 site-name">
                            <a href="index.html"><img src="assets/img/logo/logo2_footer.png" alt=""></a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                        <div class="footer-tittle-bottom">
                            <p class="developer-heading">Website Developers:</p>
                            <!-- <p>Students</p> -->
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                        <div class="footer-tittle-bottom">
                            <!-- <span>77+</span> -->
                            <div class="developers">
                                <a href="https://www.linkedin.com/in/karthick-n-20603b256/" target="_blank">
                                    <p>Mr. N. Karthick</p>
                                </a>
                                <a href="https://www.linkedin.com/in/karthick-n-20603b256/" target="_blank"
                                    class="linkedin-1">
                                    <img src="assets/img/logo/linkedin.logo.png" width="20px" height="auto" alt=""></a>
                                <br>
                            </div>
                            <div class="developers">
                                <a href="https://www.linkedin.com/in/syed-riyaas-91190b268/" target="_blank">
                                    <p>Mr. S. Syed Riyaas</p>
                                </a>
                                <a href="https://www.linkedin.com/in/syed-riyaas-91190b268/" target="_blank">
                                    <img src="assets/img/logo/linkedin.logo.png" width="20px" height="auto" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                        <!-- Footer Bottom Tittle -->
                        <div class="footer-tittle-bottom">
                            <p class="copyrights">© 2026 itspyder Hicas.<br> All rights reserved</p>
                            <!-- <p>Placement </p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
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

    // Generate unique QR token
    $qr_token = bin2hex(random_bytes(16));

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
        // Updated query to use qr_token instead of event2
        $sql = "INSERT INTO `participants`(`qr_token`, `name`, `department`, `college`, `email`, `mobile`, `event1`)
                VALUES ('$qr_token', '$name', '$department', '$college', '$email', '$mobile', '$event1')";

        $result = $conn->query($sql);

        if ($result == TRUE) {
            echo '<script>';
            echo 'window.location.href = "registration_success.php?token=' . $qr_token . '";';
            echo '</script>';
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $conn->close();
}
?>