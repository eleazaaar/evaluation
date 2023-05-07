<?php
    // include_once "../connections/connection.php";
    // include_once "home.php";
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // $conn = connection();

    // $studNo = $_GET['studNo'];
    // $years = $_GET['year'];
    // $sems = $_GET['sem'];
  
    // $sql = "SELECT * FROM `ems_student` WHERE db_studNo = '$studNo'";
    // $student  = $conn->query($sql) or die ($conn->error);
    // $data = $student->fetch_assoc();

    // $sqlSelectAllGrades = "SELECT * FROM ems_grades WHERE db_studNo = '$studNo'";
    // $grades = $conn->query($sqlSelectAllGrades) or die ($conn->error);
    // $allGrades = $grades->fetch_assoc();

    // if ($years=='ALL' && $sems=='ALL') {
    //     $year = ['1ST', '2ND', '3RD', '4TH'];
    //     $sem = ['1ST', '2ND', 'SUMMER'];
    // } else if ($years!='ALL' && $sems=='ALL') {
    //     $year = [$years];
    //     $sem = ['1ST', '2ND', 'SUMMER'];
    // } else if ($years=='ALL' && $sems!='ALL') {
    //     $year = ['1ST', '2ND', '3RD', '4TH'];
    //     $sem = [$sems];
    // } else {
    //     $year = [$years];
    //     $sem = [$sems];
    // }

    // $hasTotal = false;
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/grade.css">
</head>
<body>
    <center><br><br><br>
    <div id="addForm" class="container form-group form-control mt-4 p-3">
        <h3>STUDENT GRADES</h3>
        <h5><?php //if ($data!=null) { echo $data['db_Sname'].", ". $data['db_Fname']." ".$data['db_Mname']; } ?></h5>

        <?php
            // $i = 0;
            // $j = 0;
            // do {
            //     do {
            //         $sqlSelectGrades = "SELECT * FROM ems_grades WHERE db_studNo = '$studNo' AND db_subYear = '$year[$i]' AND db_subSem = '$sem[$j]'";
            //         $selectedGrades = $conn->query($sqlSelectGrades) or die ($conn->error);
            //         $gradeData = $selectedGrades->fetch_assoc();

            //         $sql = "SELECT * FROM ems_student WHERE db_studNo = '$studNo' AND db_year = '$year[$i]' AND db_sem = '$sem[$j]'";
            //         $student  = $conn->query($sql) or die ($conn->error);
            //         $data = $student->fetch_assoc();

            //         if ($gradeData!=null) {
            //             $hasTotal = true;
        ?>
            <h5 class="mt-3"><?php //if ($hasTotal!=false) { echo $data['db_course']." ".$year[$i]." ".$data['db_section']." - ".$sem[$j]." SEM"; } ?></h5>
                        <table>
                            <tr>
                                <th>Subject Code</th>
                                <th>Subject Description</th>
                                <th>Unit</th>
                                <th>Grade</th>
                            </tr>
        <?php
                    // }
                    // $totalUnits = 0;
                    // do {
                    //     if ($gradeData!=null) {
                    //         echo "<tr>
                    //             <td>".$gradeData['db_subCode']."</td>
                    //             <td>".$gradeData['db_subDes']."</td>
                    //             <td>".$gradeData['db_subUnit']."</td>
                    //             <td>".$gradeData['db_subGrade']."</td>
                    //         </tr>";

                    //         $totalUnits += $gradeData['db_subUnit'];

                    //         $sqlSelectGrade = "SELECT db_gwa FROM ems_student WHERE db_studNo = '$studNo' AND db_year = '$year[$i]' AND db_sem = '$sem[$j]'";
                    //         $selectedGrade = $conn->query($sqlSelectGrade) or die ($conn->error);
                    //         $grade = $selectedGrade->fetch_assoc();
                    //     }
                    // } while ($gradeData = $selectedGrades->fetch_assoc());
                    // $j++;
                    // if ($hasTotal==true) {
        ?>
                        <tr>
                            <td></td>
                            <td style="text-align: right;">TOTAL</td>
                            <td><?php //echo $totalUnits;?></td>
                            <td><?php //if(floatval($grade['db_gwa']) > 1) {echo $grade['db_gwa'];};?></td>
                        </tr>
                    </table>
        <?php
            //         }
            //         $hasTotal=false;
            //     } while ($j<sizeof($sem));
            //     $j=0;
            //     $i++;
            // } while ($i<sizeOf($year));
        ?>
        <br><a href="student.php" class="btn btn-info">BACK</a>
    </div>
    </center>
</body>
<script type="text/javascript" src="../js/clock.js"></script>
<script src="../js/hideHome.js"></script>
</html> -->
