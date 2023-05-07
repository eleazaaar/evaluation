<?php
    include_once "../connections/connection.php";
    include_once "../configurations/sy_sem.php";
    include_once "home.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $sql = "SELECT * FROM `ems_course`";
    $student  = $conn->query($sql) or die ($conn->error);
    $data = $student->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstdap@5.0.0-beta1/dist/css/bootstdap.min.css'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css'>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/table.css">
</head>
<body>
<center>
<div class='container bg-light p-3' style="width:50%">
    <h1>Course/Year/Section</h1>
    <table id="tblCourse" class="container">
        <thead class='bg-dark'>
            <th>Course</th>
            <th>Year</th>
            <th>Section</th>
            <th></th>
        </thead>
        <tbody>
            <?php if ($data) { 
                    do {
                        echo "<tr>
                            <td>".$data['db_course']."</td>
                            <td>".$data['db_year']."</td>
                            <td>".$data['db_section']."</td>
                            <td><button onclick=\"document.location='deleteCourse.php?ID=".$data['db_courseID']."'\" class='btn btn-danger'>DELETE</button></td>
                        </tr>";
                    } while($data = $student->fetch_assoc());
                }
            ?>
        </tbody>
        <tfoot>
            <th>Course</th>
            <th>Year</th>
            <th>Section</th>
            <th></th>
        </tfoot>
    </table>
</div>
</body>
<script src="../js/details.js"></script>
<script src="../js/hideHome.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script>
$(document).ready( function () {
    $('#tblCourse').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Add Course/Year/Section',
                action: function() {
                    document.location='addYear.php'
                }
            }
        ]
    });
  });
</script>
</html>