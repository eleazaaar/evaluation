<?php
    function computeUnits() {
        include_once "../connections/connection.php";
        include_once "../configurations/sy_sem.php";
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        $conn = connection();

        $studID = $_GET['studID'];

        $sql = "SELECT * FROM ems_grades WHERE db_studID = '$studID'";
        $student = $conn->query($sql) or die($conn->error);
        $data = $student->fetch_assoc();

        $totalUnits = 0;

        do {
            $units = $data['db_subUnit'];
            $totalUnits += $units;         
        } while ($data = $student->fetch_assoc());
        return strval($totalUnits);
    }
?>