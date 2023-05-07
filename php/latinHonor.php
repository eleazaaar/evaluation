<?php
    include_once "../connections/connection.php";
    include_once "../configurations/sy_sem.php";
    include_once "home.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $sql = "SELECT * FROM `ems_latin_honor`";
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
    <link rel="stylesheet" href="../css/table.css">
  </head>
<body>
<br>
<div class='container bg-light p-3' style='width:70%'>
  <h1 style='text-align: center'>Latin Honor</h1>
  <table id="tblLatinHonor" class="display" style="width:100%">
    <thead class='bg-dark'>
      <th>Student Number</th>
      <th>Full Name</th>
      <th>Course</th>
      <th>Year</th>
      <th>Section</th>
      <th></th>
    </thead>
    <tbody>
      <?php if ($data) {
        do {
          echo "<tr>
            <td>".$data['db_studNo']."</td>              
            <td style='text-align: left;'>".$data['db_Sname'].", ".$data['db_Fname']." ".$data['db_Mname']."</td>
            <td>".$data['db_course']."</td>
            <td>".$data['db_year']."</td>
            <td>".$data['db_section']."</td>
            <td><a href='grade.php?studNo=".$data['db_studNo']."' target='_blank' rel='noopener noreferrer' class='btn btn-dark'>View Grades</a></td>
            </tr>";
        } while($data = $student->fetch_assoc());
      }
      ?>
    </tbody>
    <tfoot>
      <th>Student Number</th>
      <th>Full Name</th>
      <th>Course</th>
      <th>Year</th>
      <th>Section</th>
      <th></th>
    </tfoot>
  </table>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script>
  $(document).ready( function () {
    $('#tblLatinHonor').DataTable({});
  });
  </script>
  <script src="../js/hideHome.js"></script>
</html>