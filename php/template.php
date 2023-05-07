<?php 

include_once "../configurations/sy_sem.php";
$year = strtolower($_GET['year']);
$sem = strtolower($SEMESTER);
$status = strtolower($_GET['status']);

if ($status == "regular") {
    $file = "../excel/". $year ." Year ". $sem ." Sem Sample Template.xlsx";
} else {
    $file = "../excel/Irregular Sample Template.xlsx";
}

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
?>