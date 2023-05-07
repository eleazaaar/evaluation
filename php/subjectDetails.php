<?php
    include_once "../connections/connection.php";
    include_once "home.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $id = $_GET['subID'];

    $sql = "SELECT * FROM `ems_subject` WHERE db_subID = '$id'";
    $subject  = $conn->query($sql) or die ($conn->error);
    $data = $subject->fetch_assoc();

    $subCode = $data['db_subCode'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Management System</title>
    <link rel="icon" href="../images/it.png" type="image/png">
    <link rel="stylesheet" href="../css/subjectDetails.css">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body><br><br><br><br>
<center>
    <div id="info" class="p-3 form-group form-control mb-3 mt-3">
        <button type="submit" onclick="enableEdit()" class="btn btn-dark btn btn-primary btn-md">EDIT</button>
        <button type="submit" onclick="showDeleteForm()" class="btn btn-dark btn btn-primary btn-md">DELETE</button>

        <!--FORM-->
        <center>
            <form action="updateSubject.php" method="post" class="mt-3" id="flex-container">
                <table>
                    <tr>
                        <th>Pre-Requisite Code</th>
                        <th>Subject Code</th>
                        <th>Subject Description</th>
                        <th>Units</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Semester</th>
                        <th>School Year</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td><input disabled type="text" class="col0" id="col0" name="preCode" value="<?php echo $data['db_preCode'];?>"></td>
                        <td><input disabled type="text" class="col1" id="col1" name="subCode" value="<?php echo $data['db_subCode'];?>"></td>
                        <td><input disabled type="text" class="col2" id="col2" name="subDes" value="<?php echo $data['db_subDes'];?>"></td>
                        <td><input disabled type="text" class="col3" id="col3" name="subUnit" value="<?php echo $data['db_subUnit'];?>"></td>
                        <td><input disabled type="text" class="col4" id="col4" name="subCourse" value="<?php echo $data['db_subCourse'];?>"></td>
                        <td><input disabled type="text" class="col5" id="col5" name="subYear" value="<?php echo $data['db_subYear'];?>"></td>
                        <td><input disabled type="text" class="col6" id="col6" name="subSem" value="<?php echo $data['db_subSem'];?>"></td>
                        <td><input disabled type="text" class="col7" id="col7" name="subSyear" value="<?php echo $data['db_subSyear'];?>"></td>
                        <td><input disabled type="text" class="col8" id="col8" name="subStatus" value="<?php echo $data['db_status'];?>"></td>
                    </tr>
                </table>
                <input type="text" name="subID" value="<?php echo $data['db_subID'];?>" hidden>
                <button type="submit" name="saveUpdate" class="btn btn-success m-3" id="submit" disabled>Save</button> 
                <a href="curriculum.php" class="btn btn-danger">Cancel</a>
            </form>
        </center>
    </div>
</center>
</body>
<script type="text/javascript" src="../js/clock.js"></script>
<script type="text/javascript" src="../js/subjectDetails.js"></script>
<script src="../js/sweetalert.min.js"></script>
<script>
    function showDeleteForm() {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will need to add the subject again!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                window.location.href = "deleteSubject.php?ID=<?php echo $id."&subCode=".$subCode;?>";
                swal("Subject has been deleted!", {
                    icon: "success",
                });
            } else {
                swal("Curriculum not updated!");
            }
        });
    }
</script>
<script src="../js/hideHome.js"></script>
</html>