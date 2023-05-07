<?php
    include_once "../connections/connection.php";
    include_once "home.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $sql = "SELECT * FROM `ems_sy_sem`";
    $sy_sem = $conn->query($sql) or die($conn->error);
    $data = $sy_sem->fetch_assoc();

    $syears = [];
    do {
        $syear = $data['school_year'];
        if (!in_array($syear, $syears)) {
            array_push($syears, $syear);
        }
    } while ($data = $sy_sem->fetch_assoc());

    if (isset($_POST['syear'])) {
        $selectedSyear = $_POST['syear'];

        $sql = "SELECT * FROM `ems_sy_sem` WHERE `school_year` = '$selectedSyear'";
        $sy_sem = $conn->query($sql) or die($conn->error);
        $datas = $sy_sem->fetch_assoc();

        $sems = [];
        do {
            $sem = $datas['semester'];
            if (!in_array($sem, $sems)) {
                array_push($sems, $sem);
            }
        } while ($datas = $sy_sem->fetch_assoc());
    }

    if (isset($_POST['config'])) {
        $syear = $_POST['syear'];
        $sem = $_POST['sem'];

        $sql = "UPDATE `ems_sy_sem` SET current_status = 0";
        $conn->query($sql) or die($conn->error);

        $sqlSet = "UPDATE `ems_sy_sem` SET current_status = 1 WHERE `semester` = '$sem' AND `school_year` = '$syear'";
        $conn->query($sqlSet) or die($conn->error);
    }

    if (isset($_POST['addCurriculum'])) {
        $syears = $_POST['addSYears'];
        $sems = $_POST['addSems'];

        $sqlSelectSYSEM = "SELECT * FROM `ems_sy_sem` WHERE semester = '$sems' AND school_year = '$syears'";
        $row  = $conn->query($sqlSelectSYSEM) or die ($conn->error);
        $data = $row->fetch_assoc();

        if ($data==null) {
            $sqlAdd = "INSERT INTO `ems_sy_sem` (semester, school_year, current_status) VALUES ('$sems', '$syears', 0)";
            $conn->query($sqlAdd) or die($conn->error);   
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/home.css">
    <script src="../js/hideHome.js"></script>
</head>
<body><br>
    <center>
    <div id="addForm" class="container form-group form-control mt-4 p-3" style="background-color: #aaa;">
        <h3>ADD NEW</h3>
        <form method="post" id="flex-container">
            <table>
                <tr>
                    <td class="p-1">SCHOOL YEAR</td>
                    <td class="pl-3">
                        <input type="text" name="addSYears" placeholder="2021-2022">     
                    </td>
                </tr>
                <tr>
                    <td class="p-1">SEMESTER</td>
                    <td class="pl-3">
                        <select name="addSems" id="">
                            <option value="1ST">1ST</option>
                            <option value="2ND">2ND</option>
                            <option value="SUMMER">SUMMER</option>
                        </select>
                    </td>
                </tr>
            </table>
            <button type="submit" class="btn btn-dark mt-3" name="addCurriculum">SAVE</button>
        </form>
    </div>

    <div id="addForm" class="container form-group form-control mt-4 p-3" style="background-color: #aaa;">
        <h3>VALIDATE</h3>
        <form method="post" id="flex-container">
            <table>
                <tr>
                    <td class="p-1">SCHOOL YEAR</td>
                    <td class="pl-3">
                        <select name="syear" id="syear" class="main-unit-options reset" onchange="this.form.submit()" required>
                            <option value="<?php if (isset($_POST['syear'])) echo $selectedSyear ?>"><?php if (isset($_POST['syear'])) echo $selectedSyear ?></option>
                            <?php 
                                $i=0;
                                do {
                                    echo "<option value='$syears[$i]'>$syears[$i]</option>";
                                    $i++;
                                } while ($i<sizeof($syears));
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="p-1">SEMESTER</td>
                    <td class="pl-3">
                        <select name="sem" id="sem" class="main-unit-options reset" required>
                        <?php 
                                $i=0;
                                do {
                                    echo "<option value='$sems[$i]'>$sems[$i]</option>";
                                    $i++;
                                } while ($i<sizeof($sems));
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
            <button type="submit" class="btn btn-dark mt-3" name="config">SAVE</button>
        </form>
    </div>
    </center>
    
</body>
<script src="../js/sweetalert.min.js"></script>
    <?php
        if(isset($_POST['config'])) {
    ?>
            <script>
                swal({
                    text: "Table updated",
                    icon: "success",
                    button: "Go to Student tab",
                }).then(function() {
                    window.location.href = "student.php";
                });
            </script>
    <?php
            }
    ?>
    <?php
        if(isset($_POST['addCurriculum'])) {
    ?>
            <script>
                swal({
                    text: "Added Successfully",
                    icon: "success",
                    button: "Go to Student tab",
                }).then(function() {
                    window.location.href = "student.php";
                });
            </script>
    <?php
            }
    ?>
</html>