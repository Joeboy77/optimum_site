<?php
include('includes/header.php');
include('includes/navbar.php');

// $query = mysqli_query($con, "select * from registration order by id desc limit 1");
// $line = mysqli_fetch_array($query);
// $num = $line['id'];
// $num++;

// $indexnumber = date("y").'COTVI'.str_pad($num++, 4, '0', STR_PAD_LEFT);
// $_SESSION['indexnumber'] = $indexnumber;
?> 

  <main class="mt-5 pt-3">
      <div class="container-fluid">
        <?php
       if (isset($_SESSION["status"]) && $_SESSION["status"] != '') {
         
         ?>
         <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Hey!</strong> <?php echo $_SESSION["status"];?>.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
          
         <?php
         unset($_SESSION["status"]);
         }

         if (isset($_SESSION["success"]) && $_SESSION["success"] != '') {
           
           ?>
           <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Hey!</strong> <?php echo $_SESSION["success"];?>.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
           </div>
            
           <?php
           unset($_SESSION["success"]);
         }
         ?>

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i>Student Registration</span> 
                <!-- <div class="text-xs font-weight-bold">
                  <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i>
                    Add New Student
                  </button>
                </div> -->
              </div>
              <div class="card-body">
                <form action="proceedregistration.php" method="POST">
                <div class="row d-flex">
                  
                  <div class="col-6">
                    <p class="text-center text-danger">Personal Detail</p>
                    <div class="row mb-2">
                      <div class="col-4">Place of Birth</div>
                      <div class="col-8"><input type="text" class="form-control" name="placeofbirth" value="" ></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-4">Hometown</div>
                      <div class="col-8"><input type="text" class="form-control" name="hometown" value="" ></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-4">Region</div>
                      <div class="col-8"><input type="text" class="form-control" name="region" value="" ></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-4">Nationality</div>
                      <div class="col-8"><input type="text" class="form-control" name="nationality" value="" ></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-4">Date of Admission</div>
                      <div class="col-8"><input type="date" class="form-control" name="dateofadmission" value="" ></div>
                    </div>
                  </div>
                  <div class="col-6">
                    <p class="text-center text-danger">Course Detail</p>
                    <div class="row mb-2">
                      <div class="col-4">Program Type</div>
                      <div class="col-8">
                        <select id="programdd" onchange="change_program()" class="form-control" name="programtype">
                           <option value="Select Program">Select Program</option>
                           <?php                           $res = mysqli_query($con, "SELECT * FROM programtype");
                          while ($row= mysqli_fetch_array($res)){
                              ?>
                          <option value="<?php echo $row["id"];?>"><?php echo $row["program"];?></option>
                          <?php
                          }
                          ?>
                      </select>
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-4">Course Selected</div>
                      <div class="col-8" id="course">
                          <select class="form-control" name='courseselected' onchange="change_course()">
                              <option value="Select Course">Select Course</option>
                          </select>
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-4">Course Duration</div>
                      <div class="col-8">
                        <select class="form-control" name="courseduration">
                          <option value="Please Select">Please Select</option>
                          <option value="Six months">Six months</option>
                          <option value="One year">One year</option>
                        </select>
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-4">Choice of Session</div>
                      <div class="col-8">
                        <select class="form-control" name="choiceofsession">
                          <option value="Please Select">Please Select</option>
                          <option value="Regular">Regular</option>
                          <option value="Weekend">Weekend</option>
                          <option value="Online">Online</option>
                        </select>
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-4">Residency Type</div>
                      <div class="col-8">
                        <select class="form-control" name="recidency">
                          <option value="Please Select">Please Select</option>
                          <option value="Residence">Residence</option>
                          <option value="Non Residence">Non Residence</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  
      <div class="modal-footer">
          <a href="addstudent.php" class="btn btn-danger" >Back</a>
          <button type="submit" class="btn btn-primary" name="proceed">Proceed</button>
        </div>
      </form>
                  </div>
                </div>
              </div>
          </div>
        </div>

        
      </div>
    </main>

<?php
include('includes/footer.php');
?>

<script type="text/javascript">
    function change_program(){
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET", "ajax.php?programtype="+document.getElementById("programdd").value,false);
        xmlhttp.send(null);
        document.getElementById("course").innerHTML=xmlhttp.responseText;
    }
</script>


<?php
if (isset($_POST["proceed"])) {
  // code...
  $placeofbirth = mysqli_real_escape_string($con, $_POST["placeofbirth"]);
  $hometown = mysqli_real_escape_string($con, $_POST["hometown"]);
  $region = mysqli_real_escape_string($con, $_POST["region"]);
  $nationality = mysqli_real_escape_string($con, $_POST["nationality"]);
  $dateofadmission = mysqli_real_escape_string($con, $_POST["dateofadmission"]);
  $programtype = mysqli_real_escape_string($con, $_POST["programtype"]);
  $courseselected = mysqli_real_escape_string($con, $_POST["courseselected"]);
  $courseduration = mysqli_real_escape_string($con, $_POST["courseduration"]);
  $choiceofsession = mysqli_real_escape_string($con, $_POST["choiceofsession"]);
  $recidency = mysqli_real_escape_string($con, $_POST["recidency"]);

  //Code for validation
    if ($programtype === "Please Select") {
        $_SESSION['status'] = "Please Select Type of Program";
        echo '<script type="text/javascript">window.location="proceedregistration.php"</script>';
        exit();
    }elseif ($courseduration === "Please Select") {
        $_SESSION['status'] = "Please Select Course Duration";
        echo '<script type="text/javascript">window.location="proceedregistration.php"</script>';
        exit();
    }elseif (empty($choiceofsession)) {
        $_SESSION['status'] = "Please Select Choice of Session";
        echo '<script type="text/javascript">window.location="proceedregistration.php"</script>';
        exit();
    }elseif (empty($recidency)) {
        $_SESSION['status'] = "Please Select Residency";
        echo '<script type="text/javascript">window.location="proceedregistration.php"</script>';
        exit();
    }else{

      // Code to select id representing names 1
      $query = "SELECT * FROM programtype WHERE id = '$programtype' LIMIT 1";
      $query_run = mysqli_query($con, $query);
      if(mysqli_num_rows($query_run) === 1){
        $row = mysqli_fetch_assoc($query_run);
        $_SESSION['program'] = $row['program'];
        if ($query_run) {
          // code to selecting name 2
          $query1 = "SELECT * FROM courses WHERE id = '$courseselected' LIMIT 1";
          $query_run1 = mysqli_query($con, $query1);
          if(mysqli_num_rows($query_run1) === 1){
            $row1 = mysqli_fetch_assoc($query_run1);
            $_SESSION['course_name'] = $row1['course_name'];

            $query = "SELECT * FROM registration WHERE indexnumber = '$_SESSION[indexnumber]' LIMIT 1";
            $query_run = mysqli_query($con, $query);
            if(mysqli_num_rows($query_run) === 1){
              $_SESSION['status'] = "Unsuccessful!! Index Number exist already. Please try again";
              echo '<script type="text/javascript">window.location="proceedregistration.php"</script>';
              exit();
            }else{
              $query = "INSERT INTO registration (indexnumber, firstname, lastname, dob, gender, nationality, email, maritalstatus, contact, address, doappoinment, status) VALUES ('$_SESSION[indexnumber]', '$_SESSION[fname]', '$_SESSION[lname]', '$_SESSION[dob]', '$_SESSION[gender]', '$nationality', '$_SESSION[email]', '$_SESSION[maritalstatus]', $_SESSION[contact], '$_SESSION[address]', '$dateofadmission', 'Student')";
              $query_run = mysqli_query($con, $query);
              if ($query_run) {
                $query1 = "INSERT INTO student_registration (indexnumber, firstname, lastname, email, contact, placeOfBirth, Hometown, region, nationality, dateOfAdmission, active, programType, courseSelected, courseDuration, courseSession, residency) VALUES ('$_SESSION[indexnumber]', '$_SESSION[fname]', '$_SESSION[lname]', '$_SESSION[email]', '$_SESSION[contact]', '$placeofbirth', '$hometown', '$region', '$nationality', '$dateofadmission', 'Yes', '$_SESSION[program]', '$_SESSION[course_name]', '$courseduration', '$choiceofsession', '$recidency')";
                $query_run1 = mysqli_query($con, $query1);
                  $_SESSION['success'] = "Success!! Information Saved Successfully";
                  echo '<script type="text/javascript">window.location="addstudent.php"</script>';
                  exit();
              }else{
                  $_SESSION['status'] = "Error!! Information not Saved Successfully";
                  echo '<script type="text/javascript">window.location="proceedregistration.php"</script>';
                  exit();
              }
              
              echo '<script type="text/javascript">window.location="proceedregistration.php"</script>';
              exit();
            }

          }
        }
      }
    }
}


