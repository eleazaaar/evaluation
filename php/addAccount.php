<?php
    include_once "../connections/connection.php";
    include_once "../configurations/sy_sem.php";
    include_once "home.php";
    include_once "../xlsx/xlsx.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    if(isset($_POST['addAccount'])) {
        $type = $_POST['userType'];
        $username = $_POST['user'];
        $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $email = $_POST['email'];

        $sql = "SELECT * FROM ems_users WHERE db_user = '$username'";
        $user = $conn->query($sql) or die($conn->error);
        $data = $user->fetch_assoc();

        if ($data==null) {
            $sqlAddAccount = "INSERT INTO ems_users (db_type, db_user, db_pass, db_email, db_status, db_state) VALUES ('$type', '$username', '$password', '$email', 'offline', 'active')";
            $conn->query($sqlAddAccount) or die($conn->error);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/clock.css">
</head>
<body><br><br><br><br>
    <center>
        <div id="addForm" class="container form-group form-control mt-4 p-3">
            <h3>ADD ACCOUNT</h3> <br>
            <form action="" method="post" id="flex-container">
                <label>Username</label>
                <input class="m-1" type="text" name="user" required> <br>
                <label>Password</label>
                <input class="m-1" type="password" name="pass" required> <br>
                <label>Email</label>
                <input class="m-1" type="text" name="email" required><br>
                <label>Type</label>
                <select name="userType" required>
                    <option value="1">ADMIN</option>
                    <option value="2">COORDINATOR</option>
                    <option value="3">STUDENT ASSISTANT</option>
                </select> <br> <br>
                <button type="submit" name="addAccount" value="SAVE" class="btn btn-success">Save</button>
                <a href="accountList.php" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </center>
</body>
<script type="text/javascript" src="../js/clock.js"></script>
<script src="../js/sweetalert.min.js"></script>
    <?php
        if(isset($_POST['addAccount'])) {
            if ($data==null) {
    ?>
            <script>
                swal({
                    text: "Added Successfully",
                    icon: "success",
                    button: "Go to Account List",
                }).then(function() {
                    window.location.href = "accountList.php";
                });
            </script>
    <?php
            } else {
    ?>
                <script>
                swal({
                    text: "Username Already Exist",
                    icon: "warning",
                    button: "Retry",
                });
            </script>
    <?php
            }
        }
    ?>
    <script src="../js/hideHome.js"></script>
</html>
