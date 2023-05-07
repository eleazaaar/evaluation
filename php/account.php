<?php
    include_once "../connections/connection.php";
    include_once "home.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $user = $_SESSION['User'];

    $sql = "SELECT * FROM ems_users WHERE `db_user` = '$user'";
    $user  = $conn->query($sql) or die ($conn->error);
    $data = $user->fetch_assoc();
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
                    <input type="text" name="usertype" id="usertype" value="<?php echo $data['db_type']; ?>" hidden>
                    <a id="accList" type="button" class="btn btn-info btn-sm m-1" href="accountList.php" >Account Lists</a>
                    <div class="container p-3 btn" style="background-color: #AAA;" id="userInfo">
                        <h4>Account Details</h4>
                        <label class="mt-3">Username</label>
                        <input type="text" name="username" id="username" value="<?php echo $data['db_user']; ?>" disabled><br>
                        <label class="mt-3">Password</label>
                        <input type="password" name="password" id="password" value="<?php echo $data['db_pass']; ?>" disabled><br>
                        <label class="mt-3">Email</label>
                        <input type="email" name="email" id="email" value="<?php echo $data['db_email']; ?>" disabled><br>
                        <button type="button" onclick="document.location='changePass.php'" class="btn btn-warning btn-sm mt-2">Change Password</button>
                    </div>
                </div>
            </center>
        </div>
    </center>
</body>
<script type="text/javascript" src="../js/clock.js"></script>
<script type="text/javascript" src="../js/details.js"></script>
<script>
    var user=document.getElementById('usertype').value;
    if(user!='1'){
        document.getElementById('accList').hidden = true;
    }
    function hideSearch() {
        document.getElementById('searchForm').hidden = true;
    }
    hideSearch();
</script>
<script src="../js/hideHome.js"></script>
</html>