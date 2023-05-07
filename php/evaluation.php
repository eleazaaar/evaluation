<?php
    include_once "../connections/connection.php";
    include_once "../configurations/sy_sem.php";
    include_once "updateDeanLister.php";
    include_once "updateLatinHonor.php";
    include_once "updateINCorUD.php";
    include_once "computeOverAllGWA.php";
    include_once "computeGrade.php";
    include_once "computeUnits.php";
    include_once "home.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    
    $conn = connection();

    $studNo = $_GET['studNo'];

    //======================================SELECT STUDENT======================================
    $sql = "SELECT * FROM `ems_student` WHERE db_studNo = '$studNo' AND rtrim(db_sem) = '$SEMESTER' AND rtrim(db_syear) = '$SYEAR'";
    $student  = $conn->query($sql) or die ($conn->error);
    $data = $student->fetch_assoc();

    $studID = $data['db_studID'];
    $course = $data['db_course'];
    $year = $data['db_year'];
    $section = $data['db_section'];
    $sem = $data['db_sem'];
    $syear = $data['db_syear'];

    //======================================SELECT SUBJECT======================================
    $sqlSelectSubject = "SELECT * FROM `ems_subject` WHERE `db_subCourse` = '$course' AND `db_subYear` = '$year' AND rtrim(db_subSem) = '$SEMESTER' AND rtrim(db_subSyear) =  '$SYEAR' AND db_status = 'open'";
    $subjects = $conn->query($sqlSelectSubject) or die($conn->error);
    $subjectData = $subjects->fetch_assoc();

    //======================================PUSH SUBJECT TO ARRAY======================================
    $subID = $subjectData['db_subID'];
    $subCode = $subjectData['db_subCode'];
    $subDes = $subjectData['db_subDes'];
    $subUnit = $subjectData['db_subUnit'];
    $subCodes = [];
    $subDess = [];
    $subUnits = [];
    $subjectCount = 0;

    do {
        $sqlSelectSubject = "SELECT * FROM `ems_subject` WHERE `db_subCourse` = '$course' AND `db_subYear` = '$year' AND rtrim(db_subSem) = '$SEMESTER' AND rtrim(db_subSyear) =  '$SYEAR' AND db_status = 'open' AND `db_subID` = '$subID'";
        $selectedSubject = $conn->query($sqlSelectSubject) or die ($conn->error);
        $subjectData = $selectedSubject->fetch_assoc();

        $subDes = $subjectData['db_subDes'];
        $subCode = $subjectData['db_subCode'];
        $subUnit = $subjectData['db_subUnit'];

        array_push($subDess, $subDes);
        array_push($subCodes, $subCode);
        array_push($subUnits, $subUnit);
        
        $subjectCount++;
        $subID++;
    } while($subjectData = $subjects->fetch_assoc());


    //======================================PUSH GRADES TO ARRAY======================================
    $sqlSelectGrade = "SELECT * FROM `ems_grades` WHERE `db_studID` = '$studID' AND `db_subYear` = '$year' AND rtrim(db_subSem) = '$SEMESTER' AND rtrim(db_subSyear) =  '$SYEAR'";
    $selectedGrade = $conn->query($sqlSelectGrade) or die ($conn->error);
    $gradeData = $selectedGrade->fetch_assoc();

    $grades = [];

    if ($gradeData!=null) {
        do {
            $grade = $gradeData['db_subGrade'];
            array_push($grades, $grade);
        } while ($gradeData = $selectedGrade->fetch_assoc());    
    }

    //======================================EVALUATE======================================
    if (isset($_POST['evaluate'])) {
        $sqlDeleteGrades = "DELETE FROM `ems_grades` WHERE db_studId = '$studID'";
        $conn->query($sqlDeleteGrades) or die($conn->error);

        $grades = [];

        for ($i=1; $i<=$subjectCount; $i++) {
            $grade = $_POST["subj$i"];
            array_push($grades, $grade);
        }

        for ($i=0; $i<$subjectCount; $i++) {
            $sqlAddGrades = "INSERT INTO `ems_grades` (`db_studID`, `db_studNo`, `db_subCode`, `db_subDes`, `db_subUnit`, `db_subGrade`, `db_subYear`, `db_subSem`, `db_subSyear`) VALUES ('$studID', '$studNo','$subCodes[$i]', '$subDess[$i]', '$subUnits[$i]', '$grades[$i]', '$year', '$sem', '$syear')";
            $conn->query($sqlAddGrades) or die($conn->error);
        }

        $gwa = computeGrade();
        $totalUnits = computeUnits();

        if ($gwa<=2.25) {
            $remarks = "PASSED";
        } else {
            $remarks = "FAILED";
        }

        $sqlUpdateGrades = "UPDATE ems_student SET db_units = '$totalUnits', db_gwa = '$gwa', db_remarks = '$remarks' WHERE db_studId = '$studID' AND `db_year` = '$year' AND `db_sem` = '$sem'";
        $conn->query($sqlUpdateGrades) or die($conn->error);

        // updateLatinHonor();
        updateDeanLister();
        // header("Location: grades.php?studNo=$studNo");
        // location.href("grades.php?studNo=$studNo");

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/home.css">
</head>
<body><br><br>
    <center>
    <div id="addForm" class="container form-group form-control mt-4 p-3">
        <h3>EVALUATE STUDENT</h3>
        <form method="post" id="flex-container">
            <h5><?php echo $data['db_Sname'].", ". $data['db_Fname']." ".$data['db_Mname'];?></h5>
            <h6><?php echo $data['db_course']." ".$data['db_year']."-".$data['db_section'];?></h6>
            <table>
            <?php
                $i=0;
                do {
            ?>
                    <tr style="border: 2px solid black;">
                        <td class="p-2"><label><?php echo $subCodes[$i]?></label></td>
                        <td class="p-2"><label><?php echo $subDess[$i]?></label></td>
                        <td class="p-2"><label><?php echo $subUnits[$i]?></label></td>
                        <td class="p-2">
                            <select name="subj<?php echo $i+1?>" required>
                                <option value="<?php if ($grades!=null) { echo $grades[$i];}?>"><?php if ($grades!=null) { echo $grades[$i];}?></option>
                                <option value="1.00">1.00</option>
                                <option value="1.25">1.25</option>
                                <option value="1.50">1.50</option>
                                <option value="1.75">1.75</option>
                                <option value="2.00">2.00</option>
                                <option value="2.25">2.25</option>
                                <option value="2.50">2.50</option>
                                <option value="2.75">2.75</option>
                                <option value="3.00">3.00</option>
                                <option value="INC">INC</option>
                                <option value="UD">UD</option>
                            </select><br>
                        </td>
                    </tr>
            <?php
                    $i++;
                    $subjectCount--;
                } while($subjectCount>0);
            ?>
            </table><br>
            <button type="submit" name="evaluate" class="btn btn-success" id="evaluate">Save</button>
            <a href="details.php?studNo=<?php echo $data['db_studNo'];?>" class="btn btn-danger">CANCEL</a>
        </form>
    </div>
    </center>
</body>
<script type="text/javascript" src="../js/clock.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="../js/sweetalert.min.js"></script>
    <?php
        if(isset($_POST['evaluate'])) {
    ?>
            <script>
                swal({
                    text: "Evaluated Successfully",
                    icon: "success",
                    button: "Okay",
                    timer: 3000,
                }).then(function() {
                    // window.location.href = "grades.php?studNo=<?php echo $studNo ?>";
                    window.open('grade.php?studNo=<?php echo $studNo ?>');
                    window.location.href = "home.php"
                });
            </script>
    <?php
        }
    ?>
    <script src="../js/hideHome.js"></script>
</html>

