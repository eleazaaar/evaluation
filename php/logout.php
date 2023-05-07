<?php
    include_once "../connections/connection.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    session_start();
    $user = $_SESSION['User'];
    $sqlUpdateStatus = "UPDATE `ems_users` SET `db_status` = 'offline' WHERE `db_user` = '$user'";
    $conn->query($sqlUpdateStatus) or die($conn->error);

    unset($_SESSION['User']);
    unset($_SESSION['Type']);

    session_destroy();
    echo header("Location: login.php");
?>