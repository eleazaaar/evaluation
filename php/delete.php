<?php
    include_once "../connections/connection.php";
    include_once "../configurations/sy_sem.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $id = $_GET['ID'];
    $studNo = $_GET['studNo'];

    $sqlDelete = "DELETE FROM `ems_student` WHERE db_studID = '$id' AND db_studNo = '$studNo' AND `db_sem` = '$SEMESTER' AND db_syear = '$SYEAR'";
    $conn->query($sqlDelete) or die ($conn->error);

    $sqlDelete = "DELETE FROM `ems_grades` WHERE db_studID = '$id' AND db_studNo = '$studNo' AND `db_subSem` = '$SEMESTER' AND db_subSyear = '$SYEAR'";
    $conn->query($sqlDelete) or die ($conn->error);

    $sqlDelete = "DELETE FROM `ems_pending_grades` WHERE db_studID = '$id' AND db_studNo = '$studNo' AND `db_subSem` = '$SEMESTER' AND db_subSyear = '$SYEAR'";
    $conn->query($sqlDelete) or die ($conn->error);

    echo header("Location: student.php");
?>