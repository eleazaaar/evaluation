<?php
    include_once "../connections/connection.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    if (isset($_POST['saveUpdate'])) {
        $id = $_POST['subID'];

        $preCode = $_POST['preCode'];
        $subCode = $_POST['subCode'];
        $subDes = $_POST['subDes'];
        $subUnit = $_POST['subUnit'];
        $subCourse = $_POST['subCourse'];
        $subYear = $_POST['subYear'];
        $subSem = $_POST['subSem'];
        $subSyear = $_POST['subSyear'];
        $subStatus = $_POST['subStatus'];

        $sqlUpdateSubject = "UPDATE `ems_subject` SET `db_preCode`='$preCode',`db_subCode`='$subCode',`db_subDes`='$subDes',`db_subUnit`='$subUnit',`db_subCourse`='$subCourse',`db_subYear`='$subYear',`db_subSem`='$subSem',`db_subSyear`='$subSyear',`db_status`='$subStatus' WHERE db_subID = '$id'";
        $conn->query($sqlUpdateSubject) or die($conn->error);

        header("Location: subjectDetails.php?ID=$id");
    }
?>