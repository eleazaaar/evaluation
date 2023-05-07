<?php
    include_once "../connections/connection.php";
    include_once "home.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    $conn = connection();

    $sql = "SELECT * FROM ems_users";
    $user  = $conn->query($sql) or die ($conn->error);
    $data = $user->fetch_assoc();

    $id = $data['db_id'];
    $username = $data['db_user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css'>
    <link rel="stylesheet" href="../css/home.css">    
    <link rel="stylesheet" href="../css/clock.css">
</head>
<body><br><br><br>
<center>
    <div class="container form-group form-control mt-1 p-2" style="background-color: #EEE;">
        <h3>Account List</h3>
        <div class="container p-2" style="background-color: #AAA;">
            <a type="button" class="btn btn-info btn-sm m-2" href="addAccount.php">Add Account</a>
    
            <table class="table table-bordered" style="width: 50%;">
                <tr>
                    <th>User Type</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Email</th>
                    <th></th>
                </tr>
            <?php
                do{
                    if($data['db_type'] == 1) {
                        $type = 'ADMIN';
                    } else if ($data['db_type'] == 2) { 
                        $type = 'COORDINATOR';
                    } else {
                        $type = 'STUDENT ASSISTANT';
                    }
            ?>
                <tr>
                    <th><input type="text" value="<?php echo $type ?>" disabled></th>
                    <td><input type="text" value="<?php echo $data['db_user'];?>" disabled></td>
                    <td><input type="password" value="<?php echo $data['db_pass'];?>" disabled></td>
                    <td><input type="text" value="<?php echo $data['db_email'];?>" disabled></td>
                    <td><a href="deleteAccount.php?ID=<?php echo $data['db_id'];?>" class="btn btn-danger">DELETE</a></td>
                </tr>
            <?php
                } while($data = $user->fetch_assoc());
            ?>
            </table>
        </div>
    </div>
</center>
</div>
</body>
<script type="text/javascript" src="../js/clock.js"></script>
<script type="text/javascript" src="../js/details.js"></script>
<script src="../js/sweetalert.min.js"></script>
<script>
    function deleteAccount() {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will need to create the account again!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                window.document.location = "deleteAccount.php?ID=<?php echo $id."&user=".$username;?>";
                swal("Account has been deleted!", {
                    icon: "success",
                });
            } else {
                swal("Cancelled!");
            }
        });
    }
</script>
<script src="../js/hideHome.js"></script>
</html>