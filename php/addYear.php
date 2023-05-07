<?php
    include_once "../connections/connection.php";
    include_once "../configurations/sy_sem.php";
    include_once "../xlsx/xlsx.php";
    include_once "home.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    if (isset($_POST['addYear'])) {
        $course = strtoupper($_POST['course']);
        $year = strtoupper($_POST['year']);
        $section = strtoupper($_POST['section']);

        $sql = "SELECT * FROM `ems_course` WHERE db_course = '$course' AND db_year = '$year' AND db_section = '$section'";
        $courses  = $conn->query($sql) or die ($conn->error);
        $data = $courses->fetch_assoc();

        if ($data==null) {
            $sql = "INSERT INTO `ems_course` (`db_course`, `db_year`, `db_section`) VALUES ('$course', '$year', '$section')";
            $conn->query($sql) or die ($conn->error);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/add.css">
</head>
<body>
<center><br><br><br>
    <div id="info" class="cointainer bg-light p-3" style="width:50%;">
        <h1 style='text-align:center'>Add Course/Year/Section</h1>
        <!--FORM-->
        <center>
            <form method="post" class="container mt-3" id="flex-container">
                <table>
                    <tr>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Section</th>
                    </tr>
                    <tr>
                        <td><input type="text" placeholder="BSIT" name="course" required></td>
                        <td><input type="text" placeholder="1ST" name="year" required></td>
                        <td><input type="text" placeholder="A" name="section" required></td>
                    </tr>
                </table>
                <button type="submit" name="addYear" class="btn btn-success m-3" id="submit" >Save</button> 
                <a href="course.php" class="btn btn-danger">Cancel</a>
            </form>
        </center>
    </div>
</center>
</body>
<script type="text/javascript" src="../js/clock.js"></script>
<script type="text/javascript" src="../js/subjectDetails.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php
        if(isset($_POST['addYear'])) {
            if ($data==null) {
    ?>
            <script>
                swal({
                    text: "Added Successfully",
                    icon: "success",
                    button: "Go to Course tab",
                }).then(function() {
                    window.location.href = "course.php";
        });
            </script>
   <?php
            } else {    
    ?>
                <script>
                swal({
                    text: "Course/Year/Section Already Exist",
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