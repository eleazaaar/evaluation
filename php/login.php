<?php
    include_once "../connections/connection.php";
    $conn = connection();

	if (!isset($_SESSION)) {
		session_start();
	}
	
	if (isset($_SESSION['User'])) {
		header("Location: home.php");
	}

    if (isset($_POST['login'])) {
      $username = $_POST['username'];

      $sql = "SELECT * FROM ems_users WHERE db_user = '$username'";
      $user = $conn->query($sql) or die ($conn->error);
      $data = $user->fetch_assoc();

      if ($data) {
        if (password_verify($_POST['password'], $data['db_pass'])) {
          $_SESSION['User'] = $data['db_user'];
          $_SESSION['Type'] = $data['db_type'];
          echo header("Location: ../index.php");
        }
      }
    }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="../images/it.png" type="image/png">
  <script>document.getElementsByTagName("html")[0].className += " js";</script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  <link rel="stylesheet" href="../css/login.css">
  <title>Evaluation Management System</title>
</head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="" class="sign-in-form" method="post">
            <h2 class="title">Sign in</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="username" placeholder="Username" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Password" required/>
            </div>
            <input type="submit" name="login" value="Login" class="btn solid" onclick="showAdmin();"/>
            
            <button class="btn-1" id="">
              <a href="../apk/Evaluation.apk" download="Evaluation123123123" class="a">Download APP</a></button>
          </form>
        </div>
      </div>
        <center>
      <form action="checkIfStudentExist.php" method="post">
          <div class="panels-container">
        <div class="panel left-panel">
            <div class="content">
              <h3>Student Search</h3>
              <div class="input-field">
                <i class="fas fa-search"></i>
                <input type="text" name="studNo" placeholder="Student Number" required/>
              </div>
              <button type="submit" class="btn transparent" id="" name="check">Search</button>
            </div>
            
          <img src="../images/it.png" class="image" alt="" />
        </div>
      </div></form></center>
    </div>

  </body>
  <script src="app.js"></script>

<!-- Login Script -->
<script src="../js/login.js"></script>

<!-- General Script -->
<script src="../js/util.js"></script>
<script src="../js/main.js"></script>
<script src="../js/index.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="js/sweetalert.min.js"></script>
    <?php
        if(isset($_POST['login'])) {
          if ($data==null) {
      ?>
            <script>
                swal({
                    text: "No User Found",
                    button: "Okay!",
                    timer: 3000,
                });
            </script>
      <?php
          }
			// if ($status=='online') {
	?>
			<script>
				// swal({
				// 	text: "User is Online",
				// 	button: "Okay!",
				// 	timer: 3000,
				// });
			</script>
	<?php
			// }
        }
    ?>
</html>