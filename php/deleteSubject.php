<?php
    include_once "../connections/connection.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

        $id = $_GET['ID'];
        $subCode = $_GET['subCode'];

        $sqlDelete = "DELETE FROM `ems_subject` WHERE db_subID = '$id' AND db_subCode = '$subCode'";
        $conn->query($sqlDelete) or die ($conn->error);

        echo header("Location: curriculum.php");
?>