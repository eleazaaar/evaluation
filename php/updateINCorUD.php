<?php
function updateINCorUDs() {
    include_once "../connections/connection.php";
    include_once "../configurations/sy_sem.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $studNo = $_GET['studNo'];

    $sql = "SELECT * FROM ems_grades WHERE db_studNo = '$studNo'";
    $grade = $conn->query($sql) or die($conn->error);
    $data = $grade->fetch_assoc();

    $grades = [];
    do {
        array_push($grades, $data['db_subGrade']);
    } while ($data = $grade->fetch_assoc());

    // DEAN LIST DELETE
    if (in_array("INC", $grades) || in_array("UD", $grades) || in_array("U.D", $grades)) {
        $sqlDeleteDeanLister = "DELETE FROM ems_dean_lister WHERE db_studNo = '$studNo'";
        $conn->query($sqlDeleteDeanLister) or die($conn->error);
    }

    // LATIN HONOR DELETE
    if (in_array("INC", $grades) || in_array("UD", $grades) || in_array("U.D", $grades) || in_array('2.25', $grades) || in_array('3.00', $grades) || in_array('5.00', $grades)) {
        $sqlDeleteLatinHonor = "DELETE FROM ems_latin_honor WHERE db_studNo = '$studNo'";
        $conn->query($sqlDeleteLatinHonor) or die($conn->error);
    }
}
?>