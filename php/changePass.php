<?php
    include_once "../connections/connection.php";
    include_once "home.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $username = $_SESSION['User'];

    $sql = "SELECT * FROM ems_users WHERE `db_user` = '$username'";
    $user  = $conn->query($sql) or die ($conn->error);
    $data = $user->fetch_assoc();

    if (isset($_POST['changePass'])) {
        if (password_verify($_POST['oldPass'], $data['db_pass'])) {
            $newPass = password_hash($_POST['newPass'], PASSWORD_DEFAULT);
            if (!isset($_POST['email'])) {
                $sqlChangePass = "UPDATE `ems_users` SET `db_pass` = '$newPass' WHERE `db_user` = '$username'";
                $conn->query($sqlChangePass) or die($conn->error);
                echo "<h1>SUCESS</h1>";
            } else {
                $email = $_POST['email'];
                $sqlChangePass = "UPDATE `ems_users` SET `db_pass` = '$newPass',  `db_email` ='$email' WHERE `db_user` = '$username'";
                $conn->query($sqlChangePass) or die($conn->error);
                echo "<h1>SUCESS</h1>";
            }
        } else {
            echo "<h1>FAILED</h1>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css'>
    <link rel="stylesheet" href="../css/home.css">
</head>
<body><br><br><br>
    <center>
        <div class="container form-group form-control mt-1 p-2" style="background-color: #EEE;">
            <h3>User Accounts</h3>
            <center>
            <br>
                <div class="container p-2" style="background-color: #AAA;">
                    <h4>Account Details</h4>
                    <form action="" method="post">
                        <input type="text" name="usertype" id="usertype" value="<?php echo $data['db_type']; ?>" hidden>
                        <div class="container p-3 btn" style="background-color: #AAA;" id="userInfo">
                            <label>Username</label>
                            <input type="text" name="username" id="username" value="<?php echo $data['db_user']; ?>" disabled><br>
                            <label class="mt-3">Old Password</label>
                            <input type="password" name="oldPass" id="oldPassword"><br>
                            <label class="mt-3">New Password</label>
                            <input type="password" name="newPass" id="newPassword" required><br>
                            <label class="mt-3">Email</label>
                            <input type="email" name="email" id="email" value="<?php echo $data['db_email']; ?>" disabled>
                            <button type="button" onclick="enableEmail();" class="btn btn-warning btn-sm">Change</button><br>
                            <button type="submit" name="changePass" class="btn btn-success btn-sm mt-2">Save</button>
                            <button type="submit" onclick="document.location='account.php'" class="btn btn-danger btn-sm mt-2">Cancel</button>
                        </div>
                    </form>
                </div>
            </center>
        </div>
    </center>
</body>
<script type="text/javascript" src="../js/clock.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="js/sweetalert.min.js"></script>
    <?php
        if(isset($_POST['changePass'])) {
            if (password_verify($_POST['oldPass'], $data['db_pass'])) {
    ?>
            <script>
                swal({
                    text: "Password Changed!",
                    button: "Okay!",
                    timer: 3000,
                }).then(function() {
                    window.location.href = "account.php";
                });
            </script>
    <?php
            } else {
    ?>
            <script>
                swal({
                    text: "Incorrect Old Password!",
                    button: "Okay!",
                    timer: 3000,
                }).then(function() {
                    window.location.href = "account.php";
                });
            </script>
    <?php
            }
        }
	?>
            

<script>
    var user=document.getElementById('usertype').value;
    if(user!='1'){
        document.getElementById('accList').hidden = true;
    }
    function enableEmail() {
        document.getElementById('email').disabled = false;
    }
</script>
<script src="../js/hideHome.js"></script>
</html>