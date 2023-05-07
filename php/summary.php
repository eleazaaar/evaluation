<?php
    include_once "../connections/connection.php";
    include_once "home.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    if (isset($_POST['viewSummary'])) {
        $studNo = $_POST['studNo'];
        $year = $_POST['year'];
        $sem = $_POST['sem'];

        // header("Location: gradeSummary.php?studNo=$studNo&year=$year&sem=$sem");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstdap@5.0.0-beta1/dist/css/bootstdap.min.css'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css'>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../css/summary.css">
</head>
<body>
    <center><br>
    <div id="addForm" class="display form-group form-control mt-4 p-3">
        <h1>Summary of Grades</h1>
        <form method="post" id="flex-container">
            <table>
                <tr>
                    <td><h3>Student Number</h3></td>
                    <td><input type="text" name="studNo" class="btn btn-secondary m-1" required><br></td>
                </tr>
                <tr>
                    <td><h3>Year</h3></td>
                    <td>
                        <select name="year" id="year" class="main-unit-options reset"required>
                            <optgroup>
                                <option class='service-small' value="ALL">ALL</option>
                                <option class='service-small' value="1ST">1ST</option>
                                <option class='service-small' value="2ND">2ND</option>
                                <option class='service-small' value="3RD">3RD</option>
                                <option class='service-small' value="4TH">4TH</option>
                            </optgroup>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><h3>Semester</h3></td>
                    <td>
                        <select name="sem" id="semester" class="main-unit-options reset" required>
                            <optgroup>
                                <option class='service-small' value="ALL">ALL</option>
                                <option class='service-small' value="1ST">1ST</option>
                                <option class='service-small' value="2ND">2ND</option>
                                <option class='service-small' value="SUMMER">SUMMER</option>
                            </optgroup>
                        </select>
                    </td>
                </tr>
            </table>
            <button id="submit" type="submit" class="btn btn-dark mt-3" name="viewSummary">View</button>
        </form>
    </div>
    </center>
</body>
<script type="text/javascript" src="../js/clock.js"></script>
<script src="../js/hideHome.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="../js/sweetalert.min.js"></script>
    <?php
        if(isset($_POST['viewSummary'])) {
            if ($_POST['year'] == 'ALL') {
    ?>
            <script>
                window.open("grade.php?<?php echo 'studNo='.$studNo?>");
            </script>
    <?php          
            } else {
    ?>
            <script>
                window.open("gradeSummary.php?<?php echo 'studNo='.$studNo.'&year='.$year.'&sem='.$sem ?>");
            </script>
    <?php
            }
        }
    ?>
</html>