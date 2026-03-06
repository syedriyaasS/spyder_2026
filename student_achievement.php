<!doctype html>
<html class="no-js" lang="zxx">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Spyder</title>
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
	<link rel="stylesheet" href="assets/css/slick.css">
	<link rel="stylesheet" href="assets/css/nice-select.css">
	<link rel="stylesheet" href="assets/css/custom.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<style>
		.line {
			margin: 25px 10px 25px !important;
			border: none !important;
			height: 3px !important;
			background-image: linear-gradient(to right, rgba(0, 0, 0, 0), #851428, rgba(0, 0, 0, 0)) !important;
			border-radius: 0px !important;
			background-color: white !important;
			opacity: 1;
		}

		.ach-image {
			border-radius: 10px;
		}

		.nav-button {
			background: #851428;
			padding: 20px 20px;
			color: #fff;
			cursor: pointer;
			display: inline-block;
			font-size: 16px;
			border-radius: 10px;
			-moz-user-select: none;
			font-weight: 400;
			letter-spacing: 1px;
			line-height: 0;
			margin-bottom: 0;
			margin: 10px;
			cursor: pointer;
			transition: color 0.4s linear;
			position: relative;
			z-index: 1;
			border: 0;
			overflow: hidden;
			margin: 0;
		}

		#navigation {
			margin-top: 15px;
		}

		.footer-area .footer-tittle ul li a {
			text-decoration: none;
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
								<div class="main-menu f-right d-none d-lg-block">
									<nav>
										<ul id="navigation">
											<li><a href="index.html">Home</a></li>
											<li><a href="events.html">Events</a></li>
											<li><a class="active" href="student_achievement.php">Achievements</a></li>
											<li><a href="gallery.html">Gallery</a></li>
											<li><a href="./mailer/certificate.html">Certificates</a></li>
											<li><a href="contact.html">Contact</a></li>
										</ul>
									</nav>
								</div>
								<div class="header-right-btn f-right d-none d-lg-block ml-30">
									<a href="https://docs.google.com/forms/d/e/1FAIpQLSdunW7ZGSgQoE6VaNo4ynI6cXz9kchHnbNK_FsHrBBCxHQaoA/viewform?usp=dialog"
										target="_blank" class="btn header-btn nav-button">Register now</a>
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
		<!--? Hero Start -->
		<div class="slider-area2 events_banner">
			<div class="slider-height2 d-flex align-items-center">
				<div class="container">
					<div class="row">
						<div class="col-xl-12">
							<div class="hero-cap hero-cap2 text-center fade-up">
								<h2>Student Achievements</h2>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Hero End -->
		<!-- Start Sample Area -->
		<div class="container mt-5">
			<div>
				<p class="sample-text topup fade-up">
					This page showcases the outstanding accomplishments of our students across various academic and
					extracurricular activities. It highlights their achievements in competitions, conferences, research
					projects, and other significant endeavors. Through their dedication and hard work, our students have
					consistently demonstrated exceptional talent and brought pride to our department. This page serves
					as a testament to the high-quality education and the supportive environment provided by our college,
					fostering a culture of excellence and inspiring future generations of students.
				</p>
				<hr class="line">
			</div>
			<?php
			// Include the config file from the appropriate directory
			include(__DIR__ . "/config.php");

			// Ensure $conn is initialized correctly
			if ($conn) {
				$sql = "SELECT * FROM achievement ORDER BY date DESC, id DESC";
				$result = $conn->query($sql);

				if ($result && $result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						echo '<div class="row mb-4 mt-4">';
						echo '<div class="col-md-4">';

						// Display the image
						$images = unserialize($row["image"]);
						if ($images && isset($images[0])) {
							echo '<img src="dashboard/' . htmlspecialchars($images[0]) . '" class="d-block w-100 ach-image" alt="Achievement Image">';
						}

						echo '</div>';
						echo '<div class="col-md-8">';
						echo '<h5 class="card-title mt-0">' . htmlspecialchars($row["title"]) . '</h5>';
						echo '<h6 class="card-subtitle mb-2 text-muted">' . date("jS M Y", strtotime($row["date"])) . '</h6>';
						echo '<p class="card-text">' . nl2br(htmlspecialchars($row["description"])) . '</p>';
						echo '</div>';
						echo '</div>';
						echo '<hr class="line">';
					}
				} else {
					echo '<p>No achievements to display.</p>';
				}
			} else {
				echo "<p>Error: Unable to connect to the database.</p>";
			}

			$conn->close();
			?>
		</div>


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
											<a href="https://www.hicas.ac.in/"><img
													src="./assets/img/logo/hicas.text.png" width="200px"
													height="auto"></a>
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
									<li><a href="#">Kavinraj R :<span> 88383435346</span></a></li>
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
		<a title="Go to Top" href="#"> <i class="fas fa-level-up-alt" style="color: #fff;"></i></a>
	</div>

	<!-- JS here -->

	<!-- AOS Animation-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
		crossorigin="anonymous"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		AOS.init();
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
	<script src="./assets/js/jquery.magnific-popup.js"></script>

	<!-- Date Picker -->
	<script src="./assets/js/gijgo.min.js"></script>
	<!-- Nice-select, sticky -->
	<script src="./assets/js/jquery.nice-select.min.js"></script>
	<script src="./assets/js/jquery.sticky.js"></script>

	<!-- counter , waypoint -->
	<script src="./assets/js/jquery.counterup.min.js"></script>
	<script src="./assets/js/waypoints.min.js"></script>
	<script src="./assets/js/jquery.countdown.min.js"></script>
	<!-- contact js -->
	<script src="./assets/js/contact.js"></script>
	<script src="./assets/js/jquery.form.js"></script>
	<script src="./assets/js/jquery.validate.min.js"></script>
	<script src="./assets/js/mail-script.js"></script>
	<script src="./assets/js/jquery.ajaxchimp.min.js"></script>

	<!-- Jquery Plugins, main Jquery -->
	<script src="./assets/js/plugins.js"></script>
	<script src="./assets/js/main.js"></script>

</body>

</html>