<?php
// Handle submission BEFORE output so we can do a clean header redirect
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['proceed'])) {
  require_once '../../config.php';
  if (session_status() === PHP_SESSION_NONE) { session_start(); }

  $fname = mysqli_real_escape_string($con, $_POST["fname"] ?? '');
  $lname = mysqli_real_escape_string($con, $_POST["lname"] ?? '');
  $gender = mysqli_real_escape_string($con, $_POST["gender"] ?? '');
  $maritalstatus = mysqli_real_escape_string($con, $_POST["maritalstatus"] ?? '');
  $address = mysqli_real_escape_string($con, $_POST["address"] ?? '');
  $dob = mysqli_real_escape_string($con, $_POST["dob"] ?? '');
  $contact = mysqli_real_escape_string($con, $_POST["contact"] ?? '');
  $email = mysqli_real_escape_string($con, $_POST["email"] ?? '');

  if ($gender === "" || $gender === "Please Select") {
    $_SESSION['status'] = "Please Select Gender";
    header('Location: addstudent.php'); exit();
  } elseif ($maritalstatus === "" || $maritalstatus === "Please Select") {
    $_SESSION['status'] = "Please Select Marital Status";
    header('Location: addstudent.php'); exit();
  } elseif ($email === "") {
    $_SESSION['status'] = "Please Enter Email";
    header('Location: addstudent.php'); exit();
  } else {
    // Ensure an index number exists and is unique
    $maxQ = mysqli_query($con, "SELECT MAX(id) AS maxid FROM registration");
    $maxRow = mysqli_fetch_assoc($maxQ);
    $next = (int)$maxRow['maxid'] + 1;
    $indexnumber = date('y').'COTVI'.str_pad($next, 4, '0', STR_PAD_LEFT);

    // Double-check uniqueness
    $exists = mysqli_query($con, "SELECT id FROM registration WHERE indexnumber='".mysqli_real_escape_string($con, $indexnumber)."' LIMIT 1");
    if ($exists && mysqli_num_rows($exists) === 1) {
      $next++;
      $indexnumber = date('y').'COTVI'.str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    $_SESSION['indexnumber'] = $indexnumber;
    $_SESSION["fname"] = $fname;
    $_SESSION["lname"] = $lname;
    $_SESSION["gender"] = $gender;
    $_SESSION["maritalstatus"] = $maritalstatus;
    $_SESSION["address"] = $address;
    $_SESSION["dob"] = $dob;
    $_SESSION["contact"] = $contact;
    $_SESSION["email"] = $email;

    // Log and use absolute path to avoid relative redirect issues
    if (function_exists('error_log')) { error_log("[admin/addstudent] proceeding to /oes/admin/proceedregistration.php\n", 3, __DIR__ . '/../../error.log'); }
    header('Location: /oes/admin/proceedregistration.php');
    exit();
  }
}

include('includes/header.php');
include('includes/navbar.php');

// Generate index number for display only
$query = mysqli_query($con, "select * from registration order by id desc limit 1");
$line = mysqli_fetch_array($query);
$num = isset($line['id']) ? ((int)$line['id'] + 1) : 1;
$indexnumber = date("y").'COTVI'.str_pad($num, 4, '0', STR_PAD_LEFT);
?> 

  <main class="mt-5 ">
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
            <div class="card shadow-sm border-0">
              <div class="card-header bg-white d-sm-flex align-items-center justify-content-between">
                <span class="fw-semibold"><i class="bi bi-person-plus me-2"></i>Add New Student</span>
                <span class="text-muted">Student ID: <?php echo $indexnumber;?></span>
              </div>
              <div class="card-body">
                <form action="addstudent.php" method="POST">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label">First Name</label>
                      <input type="text" name="fname" class="form-control" placeholder="First name" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Last Name</label>
                      <input type="text" name="lname" class="form-control" placeholder="Last name" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Gender</label>
                      <select class="form-control" name="gender" required>
                        <option value="">Please Select</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Marital Status</label>
                      <select class="form-control" name="maritalstatus" required>
                        <option value="">Please Select</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <label class="form-label">Address</label>
                      <textarea class="form-control" name="address" rows="2" placeholder="Residential address" required></textarea>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Date of Birth</label>
                      <input type="date" class="form-control" name="dob" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Contact No.</label>
                      <input type="text" class="form-control" name="contact" placeholder="e.g. 0241234567" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Email</label>
                      <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
                    </div>
                  </div>
                  <div class="mt-3 d-flex justify-content-end gap-2">
                    <a href="student.php" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary" name="proceed">Proceed</button>
                  </div>
                </form>
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
    }elseif (empty($email)) {
        $_SESSION['status'] = "Please Enter Email";
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