<?php
    include_once "../connections/connection.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $id = $_GET['ID'];

    $sqlDeleteAccount = "DELETE FROM `ems_users` WHERE `db_id` = '$id'";
    $conn->query($sqlDeleteAccount) or die($conn->error);

    header("Location: accountList.php");
?>