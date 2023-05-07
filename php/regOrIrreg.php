<?php
    $studNo = $_GET['studNo'];
    $status = $_GET['status'];
    $id = $_GET['ID'];
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    if ($status == 'REGULAR') {
        header("Location: evaluation.php?studID=$id&studNo=$studNo");
    } else {
        header("Location: irregEvaluation.php?studID=$id&studNo=$studNo");
    }
?>