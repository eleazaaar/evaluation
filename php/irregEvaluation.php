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
    $studID = $_GET['studID'];

    $sql = "SELECT * FROM `ems_student` WHERE db_studNo = '$studNo' AND `db_sem` = '$SEMESTER' AND db_syear = '$SYEAR'";
    $student = $conn->query($sql) or die($conn->error);
    $data = $student->fetch_assoc();

    $course = $data['db_course'];
    $year = $data['db_year'];

    $sqlSelectSubjects = "SELECT * FROM `ems_subject` WHERE `db_subCourse` = '$course'";
    $subject = $conn->query($sqlSelectSubjects) or die($conn->error);
    $subjectData = $subject->fetch_assoc();

    $subCodes = [];
    $subDess = [];
    $subUnits = [];

    do {
        $subCode = $subjectData['db_subCode'];
        $subDes = $subjectData['db_subDes'];
        $subUnit = $subjectData['db_subUnit'];
        array_push($subCodes, $subCode);
        array_push($subDess, $subDes);
        array_push($subUnits, $subUnit);
    } while($subjectData = $subject->fetch_assoc());
    
    for ($i=1; $i<=9; $i++) { 
        if (isset($_POST['subCode'.$i.''])) {
            $subCode = 'subCode'.$i;
            $subValue = $_POST['subCode'.$i];
            
            if (in_array($_POST['subCode'.$i], $subCodes)) {
                $_SESSION[$subCode] = $subValue;
            } else {
                unset($_SESSION["subCode$i"]);
            }
        }
    }

    if (isset($_POST['evaluateIrreg'])) {
        $sql = "SELECT * FROM ems_grades WHERE db_studId = '$studID' AND db_studNo = '$studNo'";
        $grades  = $conn->query($sql) or die ($conn->error);
        $datas = $grades->fetch_assoc();

        if ($datas!=null) {
            $sqlDeleteGrades = "DELETE FROM `ems_grades`WHERE db_studId = '$studID'";
            $conn->query($sqlDeleteGrades) or die($conn->error);
        }
        
        for ($i=1; $i<=9; $i++) {
            if (isset($_SESSION['subCode'.$i])) {
                $keyCode = array_search($_SESSION['subCode'.$i], $subCodes, false);
                
                $subjectCode = strval($_SESSION['subCode'.$i]);
                $subjectGrade = $_POST['subj'.$i];
                $subjectDes = $subDess[$keyCode];
                $subjectUnit = $subUnits[$keyCode];
                
                $sqlAddGrades = "INSERT INTO `ems_grades` (`db_studID`, `db_studNo`, `db_subCode`, `db_subDes`, `db_subUnit`, `db_subGrade`, `db_subYear`, `db_subSem`, `db_subSyear`) VALUES ('$studID', '$studNo', '$subjectCode', '$subjectDes', '$subjectUnit', '$subjectGrade', '$year', '$SEMESTER', '$SYEAR')";
                $conn->query($sqlAddGrades) or die($conn->error);
            }
                unset($_SESSION["subCode".$i]);
        }
        $gwa = computeGrade();

        if ($gwa<=2.25) {
            $remarks = "PASSED";
        } else {
            $remarks = "FAILED";
        }

        $sqlUpdateGrades = "UPDATE ems_student SET db_gwa = '$gwa', db_remarks = '$remarks' WHERE db_studId = '$studID' AND db_studNo = '$studNo'";
        $conn->query($sqlUpdateGrades) or die($conn->error);
        
        unset($_SESSION["subCode".$i+1]);

        // updateLatinHonor();
        updateDeanLister();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/home.css">
</head>
<body><br>
    <center>
        <div id="addForm" class="container form-group form-control mt-4 p-3">
            <h3>EVALUATE STUDENT</h3>
            <form method="post" id="flex-container">
            <h5><?php echo $data['db_Sname'].", ". $data['db_Fname']." ".$data['db_Mname'];?></h5>
            <h6><?php echo $data['db_course']." ".$data['db_year']."-".$data['db_section'];?></h6>
                <table>
                    <th>Subject Code</th>
                    <th style="text-align:center">Subject Description</th>
                    <th>Units</th>
                    <th>Grade</th>
                <?php
                    for ($i=1; $i<=9 ; $i++) {
                ?>
                        <tr style="border: 2px solid black;">
                            <td>
                                <form action="" method="post" name="subC">
                                    <input type="text" class="input1" name="subCode<?php echo $i;?>" onchange="this.form.submit()" value="<?php if (!empty($_SESSION['subCode'.$i]) && in_array($_SESSION['subCode'.$i], $subCodes)) {
                                        echo $_SESSION['subCode'.$i];
                                    }?>">
                                </form>
                            </td>
                            <td><input type="text" class="input2" name="subDes<?php echo $i;?>" value="<?php if (isset($_SESSION['subCode'.$i]) && in_array($_SESSION['subCode'.$i], $subCodes)) {
                                        $key = array_search($_SESSION['subCode'.$i], $subCodes);

                                        echo $subDess[$key];
                                    }?>" disabled></td>
                            <td><input type="text" class="input3" name="subUnit<?php echo $i;?>" value="<?php if (isset($_SESSION['subCode'.$i]) && in_array($_SESSION['subCode'.$i], $subCodes)) {
                                        $key = array_search($_SESSION['subCode'.$i], $subCodes);

                                        echo $subUnits[$key];
                                    }?>" disabled></td>
                            <td class="p-2">
                                <select name="subj<?php echo $i;?>" <?php if (isset($_SESSION['subCode'.$i]) && in_array($_SESSION['subCode'.$i], $subCodes)) { ?> enabled <?php } else { ?> disabled <?php }?> required>
                                    <option></option>
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
                    }
                ?>
                </table><br>
                <!-- <a href="computeIrregGrade.php" class="btn btn-success">SAVE</a> -->
                <button type="submit" name="evaluateIrreg" class="btn btn-success" id="evaluate">Save</button>
                <a href="details.php?studNo=<?php echo $data['db_studNo'];?>" class="btn btn-danger">CANCEL</a>
            </form>
        </div>
    </center>
</body>
<script type="text/javascript" src="../js/clock.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="../js/sweetalert.min.js"></script>
    <?php
        if(isset($_POST['evaluateIrreg'])) {
    ?>
            <script>
                swal({
                    text: "Evaluated Successfully",
                    icon: "success",
                    button: "Okay",
                    timer: 3000,
                }).then(function() {
                    window.location.href = "grade.php?studNo=<?php echo $studNo ?>";
                });
            </script>
    <?php
        }
    ?>
    <script src="../js/hideHome.js"></script>
</html>
