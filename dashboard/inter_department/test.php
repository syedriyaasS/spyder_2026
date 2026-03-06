<?php
include 'header.php';
?> 
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="../home.css">
</head>
<body>

<div class="sidenav">
  <a href="../home.php">Home</a>
  <a href="../inter_college/inter_college_home.php">Inter College</a>
  <a href="inter_department_home.php" class="active">Inter Department</a>
</div>

<div class="main">
<div class="header">
<?php
    echo '<nav class="navbar navbar-light bg-light">
            <div class="container-fluid d-flex justify-content-between">
                <img class="navbar-brand" src="../../assets/img/logo/logo.png"height=25px>
                <div class="d-flex">
                    <div class="nav-link"><i class="fas fa-user"></i>&nbsp' . $user . '</div> 
                    <a class="btn btn-danger" href="../../logout.php">Logout</a>
                </div>
            </div>
        </nav>';
?>

   
</body>
</html> 
