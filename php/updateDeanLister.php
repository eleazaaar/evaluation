<?php
  function updateDeanLister() {
    include_once "../connections/connection.php";
    include_once "../configurations/sy_sem.php";
    include_once "updateINCorUD.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $studID = $_GET['studID'];
    $studNo = $_GET['studNo'];

    $sqlSelectStudent = "SELECT * FROM ems_student WHERE db_studNo = '$studNo' AND db_studID = '$studID'";
    $student = $conn->query($sqlSelectStudent) or die($conn->error);
    $data = $student->fetch_assoc();

    $studNo = $data['db_studNo'];
    $Sname = $data['db_Sname'];
    $Fname = $data['db_Fname'];
    $Mname = $data['db_Mname'];
    $course = $data['db_course'];
    $year = $data['db_year'];
    $section = $data['db_section'];
    $gwa = $data['db_gwa'];

    $sqlSelectDeanLister = "SELECT * FROM ems_dean_lister WHERE db_studNo = '$studNo'";
    $deanLister = $conn->query($sqlSelectDeanLister) or die($conn->error);
    $deanListerData = $deanLister->fetch_assoc();

    if ($deanListerData) {
      $sqlUpdateDeanList = "UPDATE ems_dean_lister SET db_year = '$year', db_section = '$section', db_gwa = '$gwa' WHERE db_studNo = '$studNo'";
      $conn->query($sqlUpdateDeanList) or die($conn->error);
    } else {
      $sqlInsertDeanLister = "INSERT INTO `ems_dean_lister` (`db_studID`, `db_studNo`, `db_Sname`, `db_Fname`, `db_Mname`, `db_course`, `db_year`, `db_section`, `db_gwa`) VALUES ('$studID', '$studNo', '$Sname', '$Fname', '$Mname', '$course', '$year', '$section', '$gwa')";
      $conn->query($sqlInsertDeanLister) or die($conn->error);
    }
    updateINCorUDs();
  }
?>