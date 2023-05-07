<?php
    include_once "../connections/connection.php";
    include_once "../configurations/sy_sem.php";
    include_once "home.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $sql = "SELECT * FROM ems_course";
    $row = $conn->query($sql) or die($conn->error);
    $data = $row->fetch_assoc();

    $years = [];
    $sections = [];

    do {
      $year = $data['db_year'];
      if (!in_array($year, $years)) {
        array_push($years, $year);
      }

      $sql = "SELECT * FROM ems_course WHERE db_year = '$year'";
      $selectedYear = $conn->query($sql) or die($conn->error);
      $selectedData = $selectedYear->fetch_assoc();

      do {
        $section = $data['db_section'];
        if (!in_array($section, $sections)) {
          array_push($sections, $section);
        }
      } while ($selectedData = $selectedYear->fetch_assoc());
    } while ($data = $row->fetch_assoc());
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
<div class='container bg-light p-3' style='width:70%'>
  <h1 style='text-align: center'>Dean's Lister</h1>
  <table id="tblDeansList" class="display" style="width:100%">
    <thead class='bg-dark'>
      <th>Student Number</th>
      <th>Full Name</th>
      <th>Course</th>
      <th>Year</th>
      <th>Section</th>
      <th></th>
    </thead>
    <tbody>
      <?php
      $i=0;
      $j=0;
      $x=0;
      $y=0;
      do {
        do {
          $sql = "SELECT * FROM `ems_dean_lister` WHERE db_year = '$years[$x]' AND db_section = '$sections[$y]' ORDER BY db_gwa ASC LIMIT 5";
          $student  = $conn->query($sql) or die ($conn->error);
          $data = $student->fetch_assoc();

          if ($data) {
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
          $j++;
          $y++;
        } while($j<sizeof($sections));
        $j=0;
        $x++;
        $y=0;
        $i++;
      } while($i<sizeof($years));
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
<script src="../js/hideHome.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script>
  $(document).ready( function () {
    $('#tblDeansList').DataTable({});
  });
  </script>
</html>