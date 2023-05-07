<?php
    include_once "../connections/connection.php";
    include_once "../configurations/sy_sem.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $studNo = $_GET['studNo'];
    $id = $_GET['studID'];
    
    $sql = "SELECT * FROM `ems_student` WHERE db_studNo = '$studNo' AND `db_sem` = '$SEMESTER' AND db_syear = '$SYEAR'";
    $student = $conn->query($sql) or die($conn->error);
    $data = $student->fetch_assoc();

    $pendingCount = $data['db_pending'];
    if ($pendingCount>0) {
        $pendingCount--;
    }

    $sqlUpdatePendingStatus = "UPDATE `ems_student` SET db_pending = '$pendingCount' WHERE db_studNo = '$studNo' AND `db_sem` = '$SEMESTER' AND db_syear = '$SYEAR'";
    $conn->query($sqlUpdatePendingStatus) or die ($conn->error);

    $sqlDeletePendingGrades = "DELETE FROM `ems_pending_grades` WHERE db_studID = '$id' AND `db_subSem` = '$SEMESTER' AND db_subSyear = '$SYEAR'";
    $conn->query($sqlDeletePendingGrades) or die($conn->error);

    header("Location: pending.php");
?>