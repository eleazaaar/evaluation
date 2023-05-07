<?php
    include_once "../connections/connection.php";
    include_once "../configurations/sy_sem.php";
    include_once "../xlsx/xlsx.php";
    include_once "home.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $sql = "SELECT * FROM ems_subject WHERE `db_subSem` = '$SEMESTER' AND db_subSyear = '$SYEAR'";
    $subject  = $conn->query($sql) or die ($conn->error);
    $data = $subject->fetch_assoc();
    
    if (isset($_POST['add'])) {
        $preCode = $_POST['preCode'];
        $subCode = $_POST['subCode'];
        $subDes = $_POST['subDes'];
        $subUnit = $_POST['subUnit'];
        $subCourse = $_POST['subCourse'];
        $subYear = $_POST['subYear'];
        $subStatus = $_POST['subStatus'];

        $sql = "SELECT * FROM ems_subject WHERE `db_subCode` = '$subCode' AND db_subCourse = '$subCourse' AND `db_subSem` = '$SEMESTER' AND db_subSyear = '$SYEAR'";
        $subject  = $conn->query($sql) or die ($conn->error);
        $data = $subject->fetch_assoc();

        if($data==null){
            $sqlAddSubject = "INSERT INTO `ems_subject` (`db_preCode`, `db_subCode`, `db_subDes`, `db_subUnit`, `db_subCourse`, `db_subYear`, `db_subSem`, `db_subSyear`, `db_status`) VALUES ('$preCode', '$subCode', '$subDes', '$subUnit', '$subCourse', '$subYear', '$SEMESTER', '$SYEAR', '$subStatus')";
            $conn->query($sqlAddSubject) or die($conn->error);
        }
    }

    if (isset($_POST['addFile'])) {
        $excel=SimpleXLSX::parse($_FILES['excel']['tmp_name']);
        $i=0;
        foreach ($excel->rows() as $key => $row) {
            $q="";
            foreach ($row as $key => $cell) {
                if($i>=1){
                    $q.="'".$cell. "',";
                }
                $sql = "INSERT INTO `ems_subject` (`db_preCode`, `db_subCode`, `db_subDes`, `db_subUnit`, `db_subCourse`, `db_subYear`, `db_subSem`, `db_subSyear`, `db_status`) VALUES (".rtrim($q,",").")";
                if(mysqli_query($conn,$sql)){}
            }
            $i++;
        }
        //header("Location: curriculum.php");
    }

    $sql = "SELECT * FROM ems_course";
    $courseAvailable  = $conn->query($sql) or die ($conn->error);
    $courseData = $courseAvailable->fetch_assoc();

    $courses = [];
    $years = [];
    do {
        $course = $courseData['db_course'];
        if (!in_array($course, $courses)) {
            array_push($courses, $course);
        }
        $year = $courseData['db_year'];
        if (!in_array($year, $years)) {
            array_push($years, $year);
        }
    } while ($courseData = $courseAvailable->fetch_assoc());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/subjectDetails.css">
    <link rel="stylesheet" href="../css/home.css">
</head>
<body><br><br><br><br>
<center>
    <div id="info" class="p-3 form-group form-control mb-3 mt-3">
        <h1>Add Subject</h1>
        <!--FORM-->
        <center>
            <form method="post" class="mt-3" id="flex-container">
                <table>
                    <tr>
                        <th>Pre-Requisite Code</th>
                        <th>Subject Code</th>
                        <th>Subject Description</th>
                        <th>Units</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td><input type="text" class="col0" id="col0" name="preCode"></td>
                        <td><input type="text" class="col1" id="col1" name="subCode" required></td>
                        <td><input type="text" class="col2" id="col2" name="subDes" required></td>
                        <td><input type="text" class="col3" id="col3" name="subUnit" required></td>
                        <td><select class="col4" id="col4" name="subCourse">
                                <optgroup>
                                <?php
                                    $i=0;
                                    do {
                                        echo "<option class='service-small' value='$courses[$i]'>$courses[$i]</option>";
                                        $i++;
                                    } while($i<sizeof($courses));
                                ?>
                                </optgroup>
                        </select></td>
                        <td><select class="col5" id="col5" name="subYear">
                                <optgroup>
                                <?php
                                    $i=0;
                                    do {
                                        echo "<option class='service-small' value='$years[$i]'>$years[$i]</option>";
                                        $i++;
                                    } while($i<sizeof($years));
                                ?>
                                </optgroup>
                        </select></td>
                        <td><select class="col6" id="col6" name="subYear">
                                <optgroup>
                                    <option class='service-small' value="OPEN">OPEN</option>
                                    <option class='service-small' value="CLOSE">CLOSE</option>
                                </optgroup>
                        </select></td>
                    </tr>
                </table>
                <button type="submit" name="add" class="btn btn-success m-3" id="submit" >Save</button> 
                <a href="curriculum.php" class="btn btn-danger">Cancel</a>
            </form>

            <form method="post" enctype="multipart/form-data">
                <input type="file" class="btn btn-dark mt-4" name="excel">
                <button type="submit" name="addFile" class="btn btn-dark mt-4">SUBMIT</button>
            </form>
        </center>
    </div>
</center>
</body>
<script type="text/javascript" src="../js/clock.js"></script>
<script type="text/javascript" src="../js/subjectDetails.js"></script>
<script src="../js/sweetalert.min.js"></script>
    <?php
        if(isset($_POST['add']) || isset($_POST['addFile'])) {
    ?>
            <script>
                swal({
                    text: "Added Successfully",
                    icon: "success",
                    button: "Go to Curriculum tab",
                }).then(function() {
                    window.location.href = "curriculum.php";
        });
            </script>
   <?php
        }
    ?>
    <script src="../js/hideHome.js"></script>
</html>