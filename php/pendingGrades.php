<?php
    include_once "../connections/connection.php";
    include_once "home.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $studNo = $_GET['studNo'];
    $studID = $_GET['studID'];
  
    $sql = "SELECT * FROM ems_student WHERE db_studID = '$studID' AND db_studNo = '$studNo' AND `db_sem` = '$SEMESTER' AND db_syear = '$SYEAR'";
    $student  = $conn->query($sql) or die ($conn->error);
    $data = $student->fetch_assoc();

    $pendingCount = $data['db_pending'];
    $name = $data['db_Sname'].", ". $data['db_Fname']." ".$data['db_Mname'];
    $yrsec = $data['db_course']." - ".$data['db_year']."".$data['db_section'];

    $sql = "SELECT * FROM ems_pending_grades WHERE db_studID = '$studID' AND db_studNo = '$studNo' AND `db_subSem` = '$SEMESTER' AND db_subSyear = '$SYEAR'";
    $grades = $conn->query($sql) or die ($conn->error);
    $gradeData = $grades->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css'>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/grade.css">
</head>
<body><br><br><br>
    <center>
    <div id="addForm" class="container form-group form-control mt-4 p-3">
        <h1>Pending Grades</h1><br>
        <h5><?php if ($data!=null) { echo $name; } ?></h5>
        <h5><?php if ($data!=null) { echo $yrsec; } ?></h5>
        <table>
            <tr>
                <th>Subject Code</th>
                <th>Subject Description</th>
                <th>Unit</th>
                <th>Grade</th>
            </tr>
            <?php
                do {
                    echo "<tr>
                        <td>".$gradeData['db_subCode']."</td>
                        <td>".$gradeData['db_subDes']."</td>
                        <td>".$gradeData['db_subUnit']."</td>
                        <td>".$gradeData['db_subGrade']."</td>
                        </tr>";
                } while($gradeData = $grades->fetch_assoc());
            ?>
        </table>
        <button type="button" onclick="approveGrades()" class="btn btn-success">APPROVE</button>
        <button type="button" onclick="disapproveGrades()" class="btn btn-info m-4">DISAPPROVE</button>
        <a href="pending.php" class="btn btn-danger">BACK</a>
    </div>
    </center>
</body>
<script src="../js/sweetalert.min.js"></script>
<script src="../js/clock.js"></script>
<script>
    function approveGrades() {
        swal({
            title: "Are you sure?",
            text: "Once approved, student record will be updated!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = "approve.php?studID=<?php echo $studID.'&studNo='.$studNo?>";
                swal("Student has been approved!", {
                    icon: "success",
                });
            } else {
                swal("Student record not updated");
            }
        });
    }

    function disapproveGrades() {
        swal({
            title: "Are you sure?",
            text: "Once disapproved, student needs to submit the file again!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = "disapprove.php?studID=<?php echo $studID.'&studNo='.$studNo?>";
                swal("Student grade has been disapproved!", {
                    icon: "success",
                });
            } else {
                swal("Student record not updated");
            }
        });
    }
</script>
<script src="../js/hideHome.js"></script>
</html>
