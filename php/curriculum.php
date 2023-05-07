<?php
    include_once "../connections/connection.php";
    include_once "../configurations/sy_sem.php";
    include_once "home.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $sql = "SELECT * FROM `ems_subject` WHERE trim(db_subSem) = '$SEMESTER' AND `db_subSyear` = '$SYEAR'";
    $subject  = $conn->query($sql) or die ($conn->error);
    $data = $subject->fetch_assoc();
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
<div class='display bg-light p-3'>
  <h1>Curriculum</h1>
  <table id="tblStudent" class="display" style="width:100%">
    <thead class='bg-dark'>
      <th>Subject Code</th>
      <th>Subject Description</th>
      <th>Units</th>
      <th>Course</th>
      <th>Year</th>
      <th>Semester</th>
      <th>School-Year</th>
      <th>Status</th>
      <th></th>
    </thead>
    <tbody>
      <?php if ($data) {
        do {
          echo "<tr>
            <td>".$data['db_subCode']."</td>
            <td style='text-align: left'>".$data['db_subDes']."</td>
            <td>".$data['db_subUnit']."</td>
            <td>".$data['db_subCourse']."</td>
            <td>".$data['db_subYear']."</td>
            <td>".$data['db_subSem']."</td>
            <td>".$data['db_subSyear']."</td>
            <td>".$data['db_status']."</td>
            <td><a href='subjectDetails.php?subID=".$data['db_subID']."' class='btn btn-dark'>DETAILS</a></td>
            </tr>";
        } while($data = $subject->fetch_assoc());
      }
      ?>
    </tbody>
    <tfoot>
        <th>Subject Code</th>
        <th>Subject Description</th>
        <th>Units</th>
        <th>Course</th>
        <th>Year</th>
        <th>Semester</th>
        <th>School-Year</th>
        <th>Status</th>
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
    $('#tblStudent').DataTable({
      
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
      },
      dom: 'Bfrtip',
      columnDefs: [ {
        orderable: false,
        className: 'select-checkbox',
        targets:   0
      }],
      buttons: [
        {
          text: 'Add Subject',
          action: function() {
            document.location='addSubject.php'
          }
        },
        {
          extend: 'print',
          title: "<pre>Curicculum <?php echo "\t S.Y. $SYEAR \t $SEMESTER SEM"; ?></pre>",
            exportOptions: {
              columns: [0, 1, 2, 3, 4],
            },
            customize: function ( doc ) {
              $(doc.document.body).find('table').css( 'font-size', '11px');
              $(doc.document.body).find('pre').css('font-size', '18pt');
              $(doc.document.body).find('pre').css('text-align', 'center'); 
            }
        }
      ],
    });
  });
</script>
</html>