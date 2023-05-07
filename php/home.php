<?php
  include_once "../connections/connection.php";
  include_once "../configurations/sy_sem.php";
  include_once "userStatus.php";
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  $conn = connection();

  if (!isset($_SESSION)) {
		session_start();
	}

  if (isset($_SESSION['User'])) {
    $user = $_SESSION['User'];
  } elseif (isset($_GET['view'])) {
  
  } else {
    echo header("Location: login.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Management System</title>
    <link rel="icon" href="../images/it.png" type="image/png">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css'>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/nav-bar.css">
</head>
<body oncontextmenu='return false' class='snippet-body'>
  <body id="body-pd">
    <header class="header" id="header">
      <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <a><b>ACADEMIC YEAR <?php echo $SYEAR ?></b></a>
        <a><?php echo $SEMESTER ?> SEM</a>
        <div class="datetime">
          <div class="date">
            <span id="dayname">Day</span>,
            <span id="month">Month</span>
            <span id="daynum">00</span>,
            <span id="year">Year</span>
          </div>
          <div class="time">
            <span id="hour">00</span>:
            <span id="minutes">00</span>:
            <span id="seconds">00</span>
            <span id="period">AM</span>
          </div>
        </div>
    </header>

    <div class="l-navbar" id="nav-bar">
      <nav class="nav">
        <div>
          <a class="nav_logo">
            <i class='bx bx-layer nav_logo-icon'></i>
            <span class="nav_logo-name">EVALUATION</span>
          </a>
        <div class="nav_list">
          <a href="home.php" class="nav_link">
            <i class='bx bx-home nav_icon'></i>
            <span class="nav_name">Home</span>
          </a>
          <a href="student.php" class="nav_link">
            <i class='bx bx-user nav_icon'></i>
            <span class="nav_name">Student Information</span>
          </a>
          <a href="summary.php" class="nav_link">
            <i class='bx bx-message-square-detail nav_icon'></i>
            <span class="nav_name">Summary of Grades</span>
          </a>
          <a href="deanLister.php" class="nav_link">
            <i class='bx bx-award nav_icon'></i>
            <span class="nav_name">Dean's Lister</span>
          </a>
          <a href="latinHonor.php" class="nav_link">
            <i class='bx bx-award nav_icon'></i>
            <span class="nav_name">Latin Honor</span>
          </a>
          <a href="pending.php" class="nav_link">
            <i class='bx bx-bookmark nav_icon'></i>
            <span class="nav_name">Pending Grades</span>
          </a>
          <!-- <a href="#" class="nav_link">
            <i class='bx bx-data nav_icon'></i>
            <span class="nav_name">Database</span>
          </a> -->
          <a href="curriculum.php" class="nav_link">
            <i class='bx bx-bar-chart-alt-2 nav_icon'></i>
            <span class="nav_name">Curriculum</span>
          </a>
          <a href="course.php" class="nav_link">
            <i class='bx bx-bar-chart-alt-2 nav_icon'></i>
            <span class="nav_name">Course</span>
          </a>
          <a href="account.php" class="nav_link">
            <i class='bx bxs-user-account nav_icon'></i>
            <span class="nav_name">Account</span>
          </a>
          <a href="configure.php" class="nav_link">
            <i class='bx bx-info-circle nav_icon'></i>
            <span class="nav_name">Validate</span>
          </a>
          <a href="logout.php" class="nav_link">
          <i class='bx bx-log-out nav_icon'></i>
          <span class="nav_name">Log Out</span>
        </a>
        </div>
      </div>     
      </nav>
    </div>
    <br>
    <div class="display" id="homePanel">
      <h1>Student Evaluation System</h1>
      <div class="display" id="btnPanel">
        <div id="studInfo" onclick="document.location='student.php'">Student Information</div>
        <div id="deanList" onclick="document.location='deanLister.php'">Dean's Lister</div>
        <div id="curriculum" onclick="document.location='curriculum.php'">Curriculum</div>
        <div id="courses" onclick="document.location='course.php'">Course</div>
        <div id="configure" onclick="document.location='configure.php'">Configure</div>
      </div>
    </div>
</body>
<!-- Background Scripts -->
<script src="../js/particles.js"></script>
<script src="../js/app.js"></script>
<script src="../js/nav-bar.js"></script>
<script src="../js/clock.js"></script>
<script src="../js/details.js"></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js'></script>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<!-- <script>
  window.onload = function() {
    window.addEventListener("unload", function(){
      <?php 
          // $user = $_SESSION['User'];
          // $sqlUpdateStatus = "UPDATE `ems_users` SET `db_status` = 'offline' WHERE `db_user` = '$user'";
          // $conn->query($sqlUpdateStatus) or die($conn->error);

          // unset($_SESSION['User']);
          // unset($_SESSION['Type']);
        ?>
    });
  }
</script>
</html> -->