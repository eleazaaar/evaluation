<?php
  function updateLatinHonor() {
    include_once "../connections/connection.php";
    include_once "../configurations/sy_sem.php";
    include_once "updateINCorUD.php";
    include_once "computeOverAllGWA.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $studID = $_GET['studID'];
    $studNo = $_GET['studNo'];
    $overAllGwa = computeAllGWA();

    $sqlSelectStudent = "SELECT * FROM ems_student WHERE db_studNo = '$studNo'";
    $student = $conn->query($sqlSelectStudent) or die($conn->error);
    $data = $student->fetch_assoc();
    $Sname = $data['db_Sname'];
    $Fname = $data['db_Fname'];
    $Mname = $data['db_Mname'];
    $course = $data['db_course'];
    $year = $data['db_year'];
    $section = $data['db_section'];

    $sqlSelectHonorRecord = "SELECT * FROM ems_latin_honor WHERE db_studNo = '$studNo' AND db_studID = '$studID'";
    $honorStudent = $conn->query($sqlSelectHonorRecord) or die($conn->error);
    $honorStudentData = $honorStudent->fetch_assoc();
    
    $currentYear = $honorStudentData['db_year'];

    if ($honorStudentData != null && $currentYear == '4TH') {
      $sqlUpdateHonors = "UPDATE ems_latin_honor SET db_gwa = '$overAllGwa' WHERE db_studNo = '$studNo'";
      $conn->query($sqlUpdateHonors) or die($conn->error);
    } else {
      $sqlInsertHonors = "INSERT INTO `ems_latin_honor` (`db_studID`, `db_studNo`, `db_Sname`, `db_Fname`, `db_Mname`, `db_course`, `db_year`, `db_section`, `db_gwa`) VALUES ('$studID', '$studNo', '$Sname', '$Fname', '$Mname', '$course', '$year', '$section', '$overAllGwa')";
      $conn->query($sqlInsertHonors) or die($conn->error);
    }
    updateINCorUDs();
  }
?>