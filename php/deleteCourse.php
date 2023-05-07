<?php
    include_once "../connections/connection.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $id = $_GET['ID'];

    $sql = "DELETE FROM `ems_course` WHERE `db_courseID` = '$id'";
    $conn->query($sql) or die($conn->error);

    header("Location: course.php");
?>