<?php
include 'header.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./home.css">
</head>

<body>

    <div class="sidenav">
        <a href="home.php" class="active">Home</a>
        <a href="./inter_college/inter_college_home.php">Inter College</a>
        <a href="./inter_department/inter_department_home.php">Inter Department</a>
    </div>

    <div class="main">
        <div class="header">
            <?php
            echo '<nav class="navbar navbar-light bg-light">
        <div class="container-fluid d-flex justify-content-between">
            <img class="navbar-brand" src="../assets/img/logo/logo.png"height=25px>
            <div class="d-flex">
                <div class="nav-link"><i class="fas fa-user"></i>&nbsp' . $user . '</div> 
                <a class="btn btn-danger" href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>';
            include 'count.php';
            ?>


            <div class="container">
                <div>
                    <h2 class="dashboard" style="color:#841528;">Inter-College Events</h2>
                    <div>
                        <h5 class="home1">All participants</h5>
                        <a class="btn btn-info event1" href="c_all.php">view</a>
                    </div>
                    <div class="mt-5">
                        <h5 class="home2">Search by Mobile Number</h5>
                        <a class="btn btn-info event2" href="./search/c_search_mobile.php">search</a>
                    </div>
                    <div class="mt-5">
                        <h5 class="home3">Search by Email ID</h5>
                        <a class="btn btn-info event3" href="./search/c_search_email.php">search</a>
                    </div>
                    <div class="mt-5">
                        <h5 class="count1">Paper presentation</h5>
                        <h5 class="event6"><?php echo $total_c_paper_presentation; ?></h5>
                    </div>
                    <div class="mt-5">
                        <h5 class="count2">Poster Designing</h5>
                        <h5 class="event6"><?php echo $total_c_poster_designing; ?></h5>
                    </div>
                    <div class="mt-5">
                        <h5 class="count3">Marketing</h5>
                        <h5 class="event6"><?php echo $total_c_marketing; ?></h5>
                    </div>
                    <div class="mt-5">
                        <h5 class="count4">Ideathon</h5>
                        <h5 class="event6"><?php echo $total_c_ideathon; ?></h5>
                    </div>
                    <div class="mt-5">
                        <h5 class="count5">Debugging</h5>
                        <h5 class="event6"><?php echo $total_c_debugging; ?></h5>
                    </div>
                    <div class="mt-5">
                        <h5 class="count6">Web Designing</h5>
                        <h5 class="event6"><?php echo $total_c_web_designing; ?></h5>
                    </div>
                    <hr>
                    <!-- Inter-department -->
                    <div>
                        <h2 class="dashboard" style="color:#841528;">Inter-Department</h2>
                        <div>
                            <h5 class="home1">All participants</h5>
                            <a class="btn btn-info event1" href="i_all.php">view</a>
                        </div>
                        <div class="mt-5">
                            <h5 class="home2">Search by Mobile Number</h5>
                            <a class="btn btn-info event2" href="./search/i_search_mobile.php">search</a>
                        </div>
                        <div class="mt-5">
                            <h5 class="home3">Search by Email ID</h5>
                            <a class="btn btn-info event3" href="./search/i_search_email.php">search</a>
                        </div>
                        <hr>
                        <div class="mt-5">
                            <h5 class="count1">Paper presentation</h5>
                            <h5 class="event6"><?php echo $total_i_paper_presentation; ?></h5>
                        </div>
                        <div class="mt-5">
                            <h5 class="count2">Poster Designing</h5>
                            <h5 class="event6"><?php echo $total_i_poster_designing; ?></h5>
                        </div>
                        <div class="mt-5">
                            <h5 class="count3">Marketing</h5>
                            <h5 class="event6"><?php echo $total_i_marketing; ?></h5>
                        </div>
                        <div class="mt-5">
                            <h5 class="count4">Ideathon</h5>
                            <h5 class="event6"><?php echo $total_i_ideathon; ?></h5>
                        </div>
                        <div class="mt-5">
                            <h5 class="count5">Debugging</h5>
                            <h5 class="event6"><?php echo $total_i_debugging; ?></h5>
                        </div>
                        <div class="mt-5">
                            <h5 class="count6">Web Designing</h5>
                            <h5 class="event6"><?php echo $total_i_web_designing; ?></h5>
                        </div>
                        <hr>
                        <h4>Non-Technical Events</h4>
                        <div class="mt-5">
                            <h5 class="count7">Solo-Singing</h5>
                            <h5 class="event6"><?php echo $total_i_solo_singing; ?></h5>
                        </div>
                        <div class="mt-5">
                            <h5 class="count8">Solo-Dance</h5>
                            <h5 class="event6"><?php echo $total_i_solo_dance; ?></h5>
                        </div>
                        <div class="mt-5">
                            <h5 class="count9">Group-Singing</h5>
                            <h5 class="event6"><?php echo $total_i_group_singing; ?></h5>
                        </div>
                        <div class="mt-5">
                            <h5 class="count10">Group-Dance</h5>
                            <h5 class="event6"><?php echo $total_i_group_dance; ?></h5>
                        </div>
                        <div class="mt-5">
                            <h5 class="count11">Mime</h5>
                            <h5 class="event6"><?php echo $total_i_mime; ?></h5>
                        </div>
                        <div class="mt-5">
                            <h5 class="count12">Individual Talent</h5>
                            <h5 class="event6"><?php echo $total_i_individual_talent; ?></h5>
                        </div>
                    </div>

</body>

</html>