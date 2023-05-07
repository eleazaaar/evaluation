<?php
    include_once "../connections/connection.php";
    include_once "../configurations/sy_sem.php";
    include_once "home.php";
    include_once "../xlsx/xlsx.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $studNo = $_GET['studNo'];
    $view = $_GET['view'];
  
    $sql = "SELECT * FROM ems_student WHERE db_studNo = '$studNo' AND db_sem = '$SEMESTER' AND db_syear = '$SYEAR'";
    $student  = $conn->query($sql) or die ($conn->error);
    $data = $student->fetch_assoc();

    $studID = $data['db_studID'];
    $year = $data['db_year'];
    $pending = $data['db_pending'];

    if(isset($_FILES['excel']['name'])) {
        $sqlSelectGrade = "SELECT * FROM `ems_pending_grades` WHERE db_studID = '$studID' AND db_studNo = '$studNo'";
        $sqlGrade = $conn->query($sqlSelectGrade) or die($conn->error);
        $grades = $sqlGrade->fetch_assoc();

        if ($grades!=null) {
            $sqlDelete = "DELETE FROM `ems_pending_grades` WHERE db_studID = '$studID' AND db_studNo = '$studNo'";
            $conn->query($sqlDelete) or die($conn->error);
        } else {
            $pending++;
        }
        $excel=SimpleXLSX::parse($_FILES['excel']['tmp_name']);
        $i=0;

        foreach ($excel->rows() as $key => $row) {
            $q="";
            foreach ($row as $key => $cell) {
                if($i>=9){
                    $q.="'".$cell. "',";
                    $sql = "INSERT INTO `ems_pending_grades` VALUES ('$studID','$studNo',".rtrim($q,",").",'$year','$SEMESTER','$SYEAR');";
                    if(mysqli_query($conn,$sql)){}
                }
            }
            $i++;
        }

        $sqlUpdatePendingStatus = "UPDATE `ems_student` SET db_pending = '$pending' WHERE db_studNo = '$studNo' AND `db_sem` = '$SEMESTER' AND db_syear = '$SYEAR'";
        $conn->query($sqlUpdatePendingStatus) or die($conn->error);

        //header("Location: login.php?view=true&studNo=".$data['db_studNo']."");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/grade.css">
    <script>
        function hideSomething() {
            document.getElementById('header-toggle').hidden = true;
            document.getElementById('nav-bar').hidden = true;
        }
        hideSomething();
    </script>
</head>
<body>
    <br><br><br><br>
<center>
    <button type="button" class="btn btn-dark" onclick="document.location='login.php'">LOG IN</button>

    <div class="container form-group form-control m-4 p-3">
        <h5><?php if ($data!=null) { echo $data['db_studNo']; } ?></h5>
        <h5><?php if ($data!=null) { echo $data['db_Sname'].", ". $data['db_Fname']." ".$data['db_Mname']; } ?></h5>
        <h5><?php if ($data!=null) { echo $data['db_course']." ".$data['db_year']." ".$data['db_section']; } ?></h5>

        <form method="post" enctype="multipart/form-data">
            <input type="file" class="btn btn-dark mt-3" name="excel" required>
            <button type="submit" name="submit" class="btn btn-dark mt-3">Submit Grades</button>
        </form>
        
        <a href="template.php?year=<?php echo $data['db_year']."&status=".$data['db_status'];?>" class="btn btn-dark m-3" download>Download Template</a>
        <a href="grade.php?studNo=<?php echo $data['db_studNo'];?>" class="btn btn-dark m-3" download>Download Grades</a>
    </div>
</center>
</body>
<script type="text/javascript" src="js/clock.js"></script>
<script src="../js/sweetalert.min.js"></script>
    <?php
        if(isset($_FILES['excel']['name'])) {
    ?>
            <script>
                swal({
                    text: "Added Successfully",
                    icon: "success",
                    button: "Go to Student search",
                }).then(function() {
                    window.location.href = "login.php";
                });
            </script>
    <?php
            }
    ?>
    <script src="../js/hideHome.js"></script>
</html>
