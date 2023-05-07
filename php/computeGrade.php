<?php
    function computeGrade() {
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
        $totalGradesXUnits = 0;

        do {
            $tmpSubject = $data['db_subCode'];
            $tmpGrade = $data['db_subGrade'];
            if (trim($tmpSubject) != 'NSTP 111' && trim($tmpSubject) != 'NSTP 122') {
                if ($tmpGrade == 'INC' || $tmpGrade == '' || strtoupper($tmpGrade) == 'NOT TAKEN' || empty($tmpGrade)) {
                    $grade = 3.00;
                } else if ($tmpGrade == 'UD' || $tmpGrade == 'U.D') {
                    $grade = 5.00;
                } else {
                    $grade = floatval($tmpGrade);
                }
    
                $units = $data['db_subUnit'];
                $totalUnits += $units;
                $gradeXUnits = $grade * $units;
                $totalGradesXUnits +=  $gradeXUnits;              
            }
        } while ($data = $student->fetch_assoc());
        try {
            $gwa = round(($totalGradesXUnits / $totalUnits), 2);
            return strval($gwa);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
?>