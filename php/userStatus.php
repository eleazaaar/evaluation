<?php
    include_once "../connections/connection.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    if (!isset($_SESSION)) {
        session_start();
    }

    if (isset($_SESSION['User'])) {
        $user = $_SESSION['User'];

        $sqlUpdateStatus = "UPDATE `ems_users` SET `db_status` = 'online' WHERE `db_user` = '$user'";
        $conn->query($sqlUpdateStatus) or die($conn->error);
    }
?>