<?php
    include_once "../connections/connection.php";
    include_once "../configurations/sy_sem.php";
    include_once "home.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $sql = "SELECT * FROM `ems_student` WHERE db_sem = '$SEMESTER' AND db_syear =  '$SYEAR'";
    $student  = $conn->query($sql) or die ($conn->error);
    $data = $student->fetch_assoc();

    $sqlSelectDeanLister = "SELECT db_studNo FROM ems_dean_lister";
    $deanListers = $conn->query($sqlSelectDeanLister) or die($conn->error);
    $deanListerData = $deanListers->fetch_assoc();

    $arrayDeanList = [];
    do {
      array_push($arrayDeanList, $deanListerData['db_studNo']);
    } while ($deanListerData = $deanListers->fetch_assoc());

    var_dump($arrayDeanList);
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
<div class='display bg-light p-3'>
  <h1 style='text-align: center'>Student Information</h1>
  <div class="studentTable">
    <div class="studentTableData">
    <table id="tblStudent" class="display" style="width:100%">
      <thead class='bg-dark'>
        <th>Student Number</th>
        <th>Full Name</th>
        <th>Course</th>
        <th>Year</th>
        <th>Section</th>
        <th>Status</th>
        <th>Semester</th>
        <th>School-Year</th>
        <th></th>
      </thead>
      <tbody>
        <?php
        if ($data) {
          do {
            echo "<tr id='".$data['db_studNo']."'>
              <td>".$data['db_studNo']."</td>
              <td style='text-align: left;'>".$data['db_Sname'].", ".$data['db_Fname']." ".$data['db_Mname']."</td>
              <td>".$data['db_course']."</td>
              <td>".$data['db_year']."</td>
              <td>".$data['db_section']."</td>
              <td>".$data['db_status']."</td>
              <td>".$data['db_sem']."</td>
              <td>".$data['db_syear']."</td>
              <td><a href='details.php?studNo=".$data['db_studNo']."' class='btn btn-dark'>DETAILS</a></td>
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
        <th>Status</th>
      </tfoot>
    </table>
    </div>
  </div>

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
    $('#tblStudent').DataTable({
      dom: 'Bfrtip',
        columnDefs: [ {
          orderable: false,
          className: 'select-checkbox',
          targets:   0
        }],
        buttons: [
          {
            text: 'Add Student',
            action: function() {
              document.location='add.php'
            }
          },
          {
            extend: 'print',
            title: "<pre>Student List <?php echo "\t S.Y. $SYEAR \t $SEMESTER SEM"; ?></pre>",
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5],
            },
            customize: function ( doc ) {
              $(doc.document.body).find('table').css( 'font-size', '11px');
              $(doc.document.body).find('pre').css('font-size', '18pt');
              $(doc.document.body).find('pre').css('text-align', 'center'); 
            }
          }
        ],
      initComplete: function() {
        this.api().columns().every(function () {
          var column = this;
          var select = $('<select><option value=""></option></select>')
            .appendTo($(column.footer()).empty())
            .on( 'change', function () {
              var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
              );
                column
                .search( val ? '^'+val+'$' : '', true, false )
                .draw();
              });
                column.data().unique().sort().each( function ( d, j ) {
                  select.append( '<option value="'+d+'">'+d+'</option>' )
          });
        });
      }
    });
  });
</script>
</html>