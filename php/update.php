<?php
    include_once "../connections/connection.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    if (isset($_POST['saveUpdate'])) {
        $studNo = $_POST['studNo'];
        $studID = $_POST['studID'];
        $Sname = $_POST['Sname'];
        $Fname = $_POST['Fname'];
        $Mname = $_POST['Mname'];
        $gender = $_POST['gender'];
        $course = $_POST['course'];
        $year = $_POST['year'];
        $section = $_POST['section'];
        $status = $_POST['status'];

        $sqlUpdate = "UPDATE `ems_student` SET `db_studNo`='$studNo',`db_Sname`='$Sname',`db_Fname`='$Fname',`db_Mname`='$Mname',`db_sex`='$gender',`db_course`='$course',`db_year`='$year',`db_section`='$section',`db_status`='$status' WHERE db_studNo = '$studNo' AND db_studID = '$studID'";
        $conn->query($sqlUpdate) or die ($conn->error);

        echo header("Location: details.php?studNo=".$studNo."");
    }
?>