<?php
    include_once "../connections/connection.php";
    include_once "home.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $conn = connection();

    $studNo = $_GET['studNo'];

    $sql = "SELECT * FROM `ems_student` WHERE db_studNo = '$studNo' AND db_sem = '$SEMESTER' AND db_syear =  '$SYEAR'";
    $student  = $conn->query($sql) or die ($conn->error);
    $data = $student->fetch_assoc();
    
    $id = $data['db_studID'];

    $sql = "SELECT * FROM ems_course";
    $row = $conn->query($sql) or die($conn->error);
    $courseData = $row->fetch_assoc();

    $courses = [];
    $years = [];
    $sections = [];
    $a=0;
    $b=0;
    $c=0;

    do {
        if (!in_array($courseData['db_course'], $courses)) 
            array_push($courses, $courseData['db_course']);
        if (!in_array($courseData['db_year'], $years)) 
            array_push($years, $courseData['db_year']);
        if (!in_array($courseData['db_section'], $sections)) 
            array_push($sections, $courseData['db_section']);
    } while ($courseData = $row->fetch_assoc());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/home.css">
</head>
<body>
  <!--BUTTONS-->
  <center><br><br><br><br>
  <div id="info" class="w-75 p-3  form-group form-control mb-3 mt-3">
        <button type="submit" onclick="enableEdit()" class="btn btn-dark">EDIT</button>
        <button type="submit" name="delete" onclick="showDeleteForm()" class="btn btn-dark btn">DELETE</button>
        <button type="submit" onclick="document.location='regOrIrreg.php?studNo=<?php echo $data['db_studNo'];?>&status=<?php echo $data['db_status'];?>&ID=<?php echo $data['db_studID'];?>'" class="btn btn-dark">EVALUATE</button>
        <a href="grade.php?studNo=<?php echo $data['db_studNo']?>" target="_blank" class="btn btn-dark">VIEW GRADES</a>
        <a href="grade.php?studNo=<?php echo $data['db_studNo']?>" download class="btn btn-dark">DOWNLOAD GRADES</a>
        <!-- <button type="submit" onclick="document.location='pendingGrades.php?studNo=<?php echo $data['db_studNo'];?>'" class="btn btn-dark">VIEW PENDING</button> -->
      <!--FORM-->
      <center><br>
      <form action="update.php" method="post" id="flex-container">
          <input type="text" name="studID" value="<?php echo $data['db_studID'];?>" hidden><br>
          <label class="mt-3">Student No.</label>
          <input type="text" name="studNo" value="<?php echo $data['db_studNo'];?>" id="studNo" required disabled><br>
          <label class="mt-3" >Surname</label>
          <input type="text" name="Sname" value="<?php echo $data['db_Sname'];?>" id="Lname" required disabled>
          <label >First Name</label>
          <input type="text" name="Fname" value="<?php echo $data['db_Fname'];?>" id="Fname" required disabled>
          <label>Middle Name</label>
          <input type="text" name="Mname" value="<?php echo $data['db_Mname'];?>" id="Mname" required disabled><br>
          
          <label class="mt-3">Gender</label>
          <select name="gender" id="gender" required disabled>
              <option value="<?php echo $data['db_sex'];?>"><?php echo $data['db_sex'];?></option>
              <option value="MALE">MALE</option>
              <option value="FEMALE">FEMALE</option>
          </select>
          <label>Course</label>
          <select name="course" id="course" required disabled>
              <option value="<?php echo $data['db_course'];?>"><?php echo $data['db_course'];?></option>
              <?php
                do {
                    echo "<option value='".$courses[$a]."'>".$courses[$a]."</option>";
                    $a++;
                } while ($a<sizeof($courses));
              ?>
          </select>
          <label>Year</label>
          <select name="year" id="years" required disabled>
              <option value="<?php echo $data['db_year'];?>"><?php echo $data['db_year'];?></option>
              <?php
                do {
                    echo "<option value='".$years[$b]."'>".$years[$b]."</option>";
                    $b++;
                } while ($b<sizeof($years));
              ?>
          </select>
          <label>Section</label>
          <select name="section" id="section" required disabled>
              <option value="<?php echo $data['db_section'];?>"><?php echo $data['db_section'];?></option>
              <?php
                do {
                    echo "<option value='".$sections[$c]."'>".$sections[$c]."</option>";
                    $c++;
                } while ($c<sizeof($sections));
              ?>
          </select>  
          <label>Status</label>
          <select name="status" id="status" required disabled>
              <option value="<?php echo $data['db_status'];?>"><?php echo $data['db_status'];?></option>
              <option value="REGULAR">REGULAR</option>
              <option value="IRREGULAR">IRREGULAR</option>
          </select> <br><br><br>
          <button type="submit" name="saveUpdate" onclick="saveDetails()" class="btn btn-success" id="submit" disabled>Save</button> 
          <a href="student.php" class="btn btn-danger">Cancel</a>
      </form>
      </center>
  </div>
  </center>
</body>
<script type="text/javascript" src="../js/clock.js"></script>
<script type="text/javascript" src="../js/details.js"></script>
<script src="../js/hideHome.js"></script>
<script src="../js/sweetalert.min.js"></script>
<script>
    function showDeleteForm() {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will need to add the student information again!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = "delete.php?ID=<?php echo $id."&studNo=".$studNo;?>";
                swal("Student has been deleted!", {
                    icon: "success",
                });
            } else {
                swal("Cancelled!");
            }
        });
    }
    function saveDetails() {
        swal({
            text: "Saved Successfully",
            icon: "success",
            button: "Go to Student tab",
        })
    }
</script>
<?php

?>
</html>