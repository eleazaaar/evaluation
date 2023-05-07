<?php
    include_once "../connections/connection.php";
    $conn = connection();

    $sql = "SELECT * FROM `ems_sy_sem` WHERE current_status = 1";
    $row = $conn->query($sql) or die($conn->error);
    $data = $row->fetch_assoc();

    $SEMESTER = $data['semester'];
    $SYEAR = $data['school_year'];
?>