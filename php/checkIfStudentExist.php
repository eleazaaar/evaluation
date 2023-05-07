<?php
include_once "../connections/connection.php";
include_once "../configurations/sy_sem.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$conn = connection();

if (isset($_POST['check'])) {
    $studNo = $_POST['studNo'];

    $sql = "SELECT * FROM ems_student WHERE db_studNo = '$studNo' AND db_sem = '$SEMESTER' AND db_syear = '$SYEAR'";
    $student  = $conn->query($sql) or die ($conn->error);
    $data = $student->fetch_assoc();

    if ($data) {
        header("Location:submitOrViewGrades.php?view=true&studNo=$studNo");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
</head>
<body>
    
</body>
<script type="text/javascript" src="js/clock.js"></script>
<script src="../js/sweetalert.min.js"></script>
    <?php
        if(!$data) {
    ?>
            <script>
                swal({
                    text: "No Student Found",
                    icon: "warning",
                    button: "Go to Student search",
                }).then(function() {
                    window.location.href = "login.php";
                });
            </script>
    <?php
            }
    ?>
</html>
