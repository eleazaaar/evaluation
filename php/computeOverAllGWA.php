<?php
  function computeAllGWA() {
    include_once "../connections/connection.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();
    
    $studNo = $_GET['studNo'];
    
    $sql = "SELECT * FROM ems_student WHERE db_studNo = '$studNo'";
    $student = $conn->query($sql) or die($conn->error);
    $data = $student->fetch_assoc();

    if ($data != null) {
      $totalGWA = 0;
      $gwas = [];
      $i=0;
      do {
        $gwa = $data['db_gwa'];
        array_push($gwas, number_format($gwa, 2));
        $totalGWA += $gwa;
        $i++;
      } while ($data = $student->fetch_assoc());
      $overAllGWA = number_format($totalGWA/$i, 2);
      return strval($overAllGWA);
    }
  }
?>