<?php    
    include_once "../connections/connection.php";
    include_once "../configurations/sy_sem.php";
    include_once "updateDeanLister.php";
    include_once "updateLatinHonor.php";
    include_once "updateINCorUD.php";
    include_once "computeOverAllGWA.php";
    include_once "computeGradesALL.php";
    include_once "computeUnits.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    $conn = connection();

    $sql = "SELECT * FROM ems_student WHERE db_pending > 0 AND db_sem = '$SEMESTER' AND db_syear = '$SYEAR'";
    $students = $conn->query($sql) or die($conn->error);
    $datas = $students->fetch_assoc();

    do {
        $studID = strval($datas['db_studID']);
        $studNo = $datas['db_studNo'];
        
        $sqlDeleteGrades = "DELETE FROM `ems_grades` WHERE db_studNo = '$studNo' AND `db_subSem` = '$SEMESTER' AND `db_subSyear` = '$SYEAR'";
        $conn->query($sqlDeleteGrades) or die($conn->error);

        $sqlInsertApproved = "INSERT INTO `ems_grades` SELECT * FROM `ems_pending_grades` WHERE db_studNo = '$studNo' AND `db_subSem` = '$SEMESTER' AND `db_subSyear` = '$SYEAR'";
        $conn->query($sqlInsertApproved) or die($conn->error);

        $sqlDeletePendingGrades = "DELETE FROM `ems_pending_grades` WHERE db_studNo = '$studNo' AND `db_subSem` = '$SEMESTER' AND `db_subSyear` = '$SYEAR'";
        $conn->query($sqlDeletePendingGrades) or die($conn->error);

        $sql = "SELECT * FROM ems_student WHERE db_studID = '$studID' AND db_studNo = '$studNo' AND `db_sem` = '$SEMESTER' AND db_syear = '$SYEAR'";
        $student  = $conn->query($sql) or die ($conn->error);
        $data = $student->fetch_assoc();

        $pendingCount = $data['db_pending'];

        if ($pendingCount>0) {
            $pendingCount--;
        }

        $sqlUpdatePendingStatus = "UPDATE `ems_student` SET db_pending = '$pendingCount' WHERE db_studNo = '$studNo' AND `db_sem` = '$SEMESTER' AND db_syear = '$SYEAR'";
        $conn->query($sqlUpdatePendingStatus) or die ($conn->error);
        
        $gwa = computeGradesAll($studID);
        $totalUnits = computeUnits();

        if ($gwa<=2.25) {
            $remarks = "PASSED";
        } else {
            $remarks = "FAILED";
        }

        $sqlUpdateGrades = "UPDATE ems_student SET db_units = '$totalUnits', db_gwa = '$gwa', db_remarks = '$remarks' WHERE db_studId = '$studID'  AND `db_sem` = '$SEMESTER' AND `db_syear` = '$SYEAR'";
        $conn->query($sqlUpdateGrades) or die($conn->error);

        // updateLatinHonor();
        updateDeanLister();
    } while ($datas = $students->fetch_assoc());
    header("Location: pending.php");
?>