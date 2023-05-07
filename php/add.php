<?php
    include_once "../connections/connection.php";
    include_once "../configurations/sy_sem.php";
    include_once "home.php";
    include_once "../xlsx/xlsx.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    ini_set('memory_limit', '128M');
    ini_set('max_execution_time', 1800);
    $conn = connection();

    if(isset($_POST['add'])) {
        $studNo = $_POST['studNo'];
        $Lname = $_POST['Lname'];
        $Fname = $_POST['Fname'];
        $Mname = $_POST['Mname'];
        $gender = $_POST['gender'];
        $course = $_POST['course'];
        $year = $_POST['year'];
        $section = $_POST['section'];
        $status = $_POST['status'];

        $sql = "SELECT * FROM ems_student WHERE db_studNo = '$studNo' AND `db_sem` = '$SEMESTER' AND db_syear = '$SYEAR'";
        $student  = $conn->query($sql) or die ($conn->error);
        $data = $student->fetch_assoc();

        if ($data==null) {
            $sql = "INSERT INTO `ems_student` (`db_studNo`, `db_Sname`, `db_Fname`, `db_Mname`, `db_sex`, `db_course`, `db_year`, `db_section`, `db_status`, `db_sem`, `db_syear`, `db_gwa`, `db_units`, `db_remarks`, `db_pending`) VALUES ('$studNo', '$Lname', '$Fname', '$Mname', '$gender', '$course', '$year', '$section', '$status', '$SEMESTER', '$SYEAR', '', 0.00, '', 0)";
            $conn->query($sql) or die ($conn->error);
        } else {
            // STUDENT NUMBER ALREADY EXISTS
        }
        header("Location: Student.php");
    }

    if (isset($_POST['addFile'])) {
        $excel=SimpleXLSX::parse($_FILES['excel']['tmp_name']);
        $i=0;
        foreach ($excel->rows() as $key => $row) {
            $q="";
            $j=1;
            $studNo = '';
            $sem = '';
            $syear = '';
            foreach ($row as $key => $cell) {
                
                if($i>=1 && $j>1){
                    if ($j==2) {
                        $q.="'".$cell. "-M',";
                        $studNo = $cell."-M";
                    } else {
                        $q.="'".$cell. "',";
                    }
                    if ($j==11) {
                        $sem = $cell;
                    }
                    if ($j==12) {
                        $syear = $cell;
                    }
                }
                $sqlSelectStudent = "SELECT * FROM ems_student WHERE db_studNo = '$studNo' AND `db_sem` = '$sem' AND db_syear = '$syear'";
                $selectedStudent  = $conn->query($sqlSelectStudent) or die ($conn->error);
                $selectedData = $selectedStudent->fetch_assoc();

                if ($selectedData==null) {
                    $sql = "INSERT INTO `ems_student` (`db_studNo`, `db_Sname`, `db_Fname`, `db_Mname`, `db_sex`, `db_course`, `db_year`, `db_section`, `db_status`, `db_sem`, `db_syear`, `db_units`, `db_gwa`, `db_remarks`, `db_pending`) VALUES (".rtrim($q,",").", '', 0.00, '', 0)";
                    if(mysqli_query($conn,$sql)){}
                    $j++;
                }
            }
            $i++;
        }
        // header("Location: Student.php");
    }

    $sql = "SELECT * FROM ems_course";
    $courseAvailable  = $conn->query($sql) or die ($conn->error);
    $courseData = $courseAvailable->fetch_assoc();

    $courses = [];
    $years = [];
    $sections = [];
    do {
        $course = $courseData['db_course'];
        if (!in_array($course, $courses)) {
            array_push($courses, $course);
        }
    } while ($courseData = $courseAvailable->fetch_assoc());

    if (isset($_POST['course'])) {
        $selectedCourse = $_POST['course'];

        $sql = "SELECT * FROM ems_course WHERE db_course = '$selectedCourse'";
        $yearAvailable  = $conn->query($sql) or die ($conn->error);
        $yearData = $yearAvailable->fetch_assoc();
        
        do {
            $year = $yearData['db_year'];
            if (!in_array($year, $years)) {
                array_push($years, $year);
            }
        } while ($yearData = $yearAvailable->fetch_assoc());
    }
    
    if (isset($_POST['year']) && !empty($_POST['year'])) {
        $selectedYear = $_POST['year'];

        $sql = "SELECT * FROM ems_course WHERE db_year = '$selectedYear'";
        $sectionAvailable  = $conn->query($sql) or die ($conn->error);
        $sectionData = $sectionAvailable->fetch_assoc();

        do {
            $section = $sectionData['db_section'];
            if (!in_array($section, $sections)) {
                array_push($sections, $section);
            }
        } while($sectionData = $sectionAvailable->fetch_assoc());
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css'>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/add.css">
    <link rel="stylesheet" href="../css/nav-bar.css">
</head>
<body>
    <center><br><br>
        <div id="addForm" class="container form-group form-control mt-4 p-3">
            <h3>ADD STUDENT</h3> <br>
            <form action="" method="post" id="flex-container">
                <table>
                    <tr>
                        <td><label for="studNo">Student No.</label></td>
                        <td><input type="text" name="studNo" value="<?php if (isset($_POST['studNo'])) { echo $_POST['studNo'];}?>"></td>
                    </tr>
                    <tr>
                        <td><label for="Lname">Last Name</label></td>
                        <td><input type="text" name="Lname" value="<?php if (isset($_POST['Lname'])) { echo $_POST['Lname'];}?>"></td>
                    </tr>
                    <tr>
                        <td><label for="Fname">First Name</label></td>
                        <td><input type="text" name="Fname" value="<?php if (isset($_POST['Fname'])) { echo $_POST['Fname'];}?>"></td>
                    </tr>
                    <tr>
                        <td><label for="Mname">Middle Name</label></td>
                        <td><input type="text" name="Mname" value="<?php if (isset($_POST['Mname'])) { echo $_POST['Mname'];}?>"></td>
                    </tr>
                    <tr>
                        <td><label for="gender">Gender</label></td>
                        <td>
                            <select name="gender" id="gender" class="main-unit-options reset" required>
                                <optgroup>
                                    <option class='service-small'><?php if (isset($_POST['gender'])) { echo $_POST['gender'];}?></option>
                                    <option class='service-small' value="MALE">MALE</option>
                                    <option class='service-small' value="FEMALE">FEMALE</option>
                                </optgroup>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="course">Course</label></td>
                        <td>
                            <select name="course" id="course" class="main-unit-options reset" onchange="this.form.submit()" required>
                                <optgroup>
                                    <option value="<?php if (isset($_POST['course'])) echo $selectedCourse ?>"><?php if (isset($_POST['course'])) echo $selectedCourse ?></option>
                                <?php
                                    $i=0;
                                    do {
                                        echo "<option class='service-small' value='$courses[$i]'>$courses[$i]</option>";
                                        $i++;
                                    } while($i<sizeof($courses));
                                ?>
                                </optgroup>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="year">Year</label></td>
                        <td>
                            <select name="year" id="year" class="main-unit-options reset" onchange="this.form.submit()" required>
                                    <optgroup>
                                        <option value="<?php if (isset($_POST['year']) && !empty($_POST['year'])) echo $selectedYear ?>"><?php if (isset($_POST['year']) && !empty($_POST['year'])) echo $selectedYear ?></option>
                                    <?php
                                        $i=0;
                                        do {
                                            echo "<option class='service-small' value='$years[$i]'>$years[$i]</option>";
                                            $i++;
                                        } while($i<sizeof($years));
                                    ?>
                                    </optgroup>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="section">Section</label></td>
                        <td>
                            <select name="section" id="section" class="main-unit-options reset" required>
                                    <optgroup>
                                    <?php
                                        $i=0;
                                        do {
                                            echo "<option class='service-small' value='$sections[$i]'>$sections[$i]</option>";
                                            $i++;
                                        } while($i<sizeof($sections));
                                    ?>
                                    </optgroup>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="status">Status</label></td>
                        <td>
                            <select name="status" id="status" class="main-unit-options reset" required>
                                <optgroup>
                                    <option class='service-small' value="REGULAR">REGULAR</option>
                                    <option class='service-small' value="IRREGULAR">IRREGULAR</option>
                                </optgroup>
                            </select>
                        </td>
                    </tr>
                </table>
                <br>
                <button type="submit" name="add" value="SAVE" class="btn btn-success">Save</button>
                <a href="student.php" class="btn btn-danger">Cancel</a>
            </form>

            <form method="post" enctype="multipart/form-data">
                <input type="file" class="btn btn-dark mt-4" name="excel">
                <button type="submit" name="addFile" class="btn btn-dark mt-4">SUBMIT</button>
            </form>
        </div>
    </center>
</body>
<script type="text/javascript" src="../js/clock.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <?php
        if(isset($_POST['add']) || isset($_POST['addFile'])) {
            if ($data==null) {
    ?>
            <script>
                swal({
                    text: "Added Successfully",
                    icon: "success",
                    button: "Okay",
                    timer: 3000,
                });
            </script>
    <?php
            } else {    
    ?>
                <script>
                swal({
                    text: "Student Number Already Exist",
                    icon: "warning",
                    button: "Okay",
                    timer: 3000,
                });
            </script>
    <?php
            }
        }
    ?>
    <script src="../js/hideHome.js"></script>
</html>
