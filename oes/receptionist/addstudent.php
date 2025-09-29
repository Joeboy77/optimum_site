o<?php
include('includes/header.php');
include('includes/navbar.php');

$query = mysqli_query($con, "select * from registration order by id desc limit 1");
$line = mysqli_fetch_array($query);
$num = $line['id'];
$num++;

$indexnumber = date("y").'COTVI'.str_pad($num++, 4, '0', STR_PAD_LEFT);
$_SESSION['indexnumber'] = $indexnumber;
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
                <span><i class="bi bi-table me-2"></i>Add New Student</span> 
                <!-- <div class="text-xs font-weight-bold">
                  <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i>
                    Add New Student
                  </button>
                </div> -->
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <form action="addstudent.php" method="POST">
      <div class="modal-body">
          <div class="row">
            <h5 class="text-center text-primary">Student ID: <?php echo $indexnumber;?></h5>
          </div>
          <hr>
          <div class="row">
               <div class="mb-2 col-md-6">
                   <label>First Name</label>
                   <input type="text" name="fname" class="form-control" placeholder="First name" aria-label="First name" required>
              </div>

              <div class="mb-2 col-md-6">
                  <label>Last Name</label>
                  <input type="text" name="lname" class="form-control" placeholder="Last name" aria-label="Last name" required>
              </div>
          </div>
          <div class="row">
               <div class="mb-2 col-md-6">
                   <label>Gender</label>
                   <select class="form-control" name="gender">
                     <option value="Please Select">Please Select</option>
                     <option value="Male">Male</option>
                     <option value="Female">Female</option>
                   </select>
              </div>

              <div class="mb-2 col-md-6">
                  <label>Marital Status</label>
                  <select class="form-control" name="maritalstatus">
                     <option value="Please Select">Please Select</option>
                     <option value="Single">Single</option>
                     <option value="Married">Married</option>
                   </select>
              </div>
          </div>
          <div class="mb-2">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="address" required></textarea>
          </div>

          <div class="row">
            <div class="col-6">
              <div class="mb-2">
                <label class="form-label">Date of Birth</label>
                <input type="date" class="form-control" name="dob" required>
              </div>
            </div>
            <div class="col-6">
              <div class="mb-2">
                <label class="form-label">Contact No.</label>
                <input type="text" class="form-control" name="contact" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
          <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
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


<?php
if (isset($_POST["proceed"])) {
  // code...
  $fname = mysqli_real_escape_string($con, $_POST["fname"]);
  $lname = mysqli_real_escape_string($con, $_POST["lname"]);
  $gender = mysqli_real_escape_string($con, $_POST["gender"]);
  $maritalstatus = mysqli_real_escape_string($con, $_POST["maritalstatus"]);
  $address = mysqli_real_escape_string($con, $_POST["address"]);
  $dob = mysqli_real_escape_string($con, $_POST["dob"]);
  $contact = mysqli_real_escape_string($con, $_POST["contact"]);
  $email = mysqli_real_escape_string($con, $_POST["email"]);

  //Code for validation
    if ($gender === "Please Select") {
        $_SESSION['status'] = "Please Select Gender";
        echo '<script type="text/javascript">window.location="addstudent.php"</script>';
        exit();
    }elseif ($maritalstatus === "Please Select") {
        $_SESSION['status'] = "Please Select Marital Status";
        echo '<script type="text/javascript">window.location="addstudent.php"</script>';
        exit();
    }else{
      $query = "SELECT * FROM registration WHERE indexnumber = '$_SESSION[indexnumber]' LIMIT 1";
      $query_run = mysqli_query($con, $query);
      if(mysqli_num_rows($query_run) === 1){
        $_SESSION['status'] = "Unsuccessful!! Index Number exist already. Please try again";
        echo '<script type="text/javascript">window.location="addstudent.php"</script>';
        exit();
      }else{
        $_SESSION["fname"] = $fname;
        $_SESSION["lname"] = $lname;
        $_SESSION["gender"] = $gender;
        $_SESSION["maritalstatus"] = $maritalstatus;
        $_SESSION["address"] = $address;
        $_SESSION["dob"] = $dob;
        $_SESSION["contact"] = $contact;
        $_SESSION["email"] = $email;
        echo '<script type="text/javascript">window.location="proceedregistration.php"</script>';
        exit();
        
      }
    }
}
?>