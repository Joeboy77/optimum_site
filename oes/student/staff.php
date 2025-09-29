<?php
include('includes/header.php');
include('includes/navbar.php');

$query = mysqli_query($con, "select * from registration order by id desc limit 1");
$line = mysqli_fetch_array($query);
$num = $line['id'];
$num++;

$indexunmber = date("y").'SOTVI'.str_pad($num++, 4, '0', STR_PAD_LEFT);
$_SESSION['indexunmber'] = $indexunmber;
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
        <!-- <div class="row mb-2">
          <div class="d-sm-flex align-items-center justify-content-between ">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="searchpage.php"><button class="btn btn-primary btn-sm"><i class="bi bi-border-outer me-2"></i>Search Rooms</button></a>
          </div>
        </div> -->

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i>Staff Information</span> 
                <div class="text-xs font-weight-bold">
                	<button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i>
        					  Add New Staff
        					</button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <table class="table table-striped table-hover text-center">
                      <thead class="table-success">
                        <thead class="table-success">
                        <tr>
                          <th hidden>S. No.</th>
                          <th>S. No.</th>
                          <th>Index No.</th>
                          <th>Firstname</th>
                          <th>Lastname</th>
                          <th>Nationality</th>
                          <th>Qualification</th>
                          <th>Marriage Status</th>
                          <th>View</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          $query = "SELECT * FROM registration WHERE status = 'Staff'";
                          $query_run = mysqli_query($con, $query);
                          if(mysqli_num_rows($query_run) > 0){
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query_run)){
                        ?>
                        <tr>
                          <td hidden><?php echo $row["id"];?></td>
                          <td><?php echo $no;?></td>
                          <td><?php echo $row["indexnumber"];?></td>
                          <td><?php echo $row["firstname"];?></td>
                          <td><?php echo $row["lastname"];?></td>
                          <td><?php echo $row["nationality"];?></td>
                          <td><?php echo $row["qualification"];?></td>
                          <td><?php echo $row["maritalstatus"];?></td>
                          <td>
                            <a href="cashpayment.php?id=<?php echo $row["id"];?>" class="btn btn-primary"><i class="bi bi-eye"></i></a>
                          </td>
                        </tr>
                        <?php
                        $no++;
                        }
                      }else{
                        echo "No Record Found";
                      }
                      ?>
                      </tbody>
                    </table>
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

<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Staff Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="staff.php" method="POST">
      <div class="modal-body">
          <div class="row">
            <h5 class="text-center text-primary">Staff ID: <?php echo $indexunmber;?></h5>
          </div>
          <hr>
          <div class="row">
               <div class="mb-2 col-md-6">
                   <label>First Name</label>
                   <input type="text" name="fname" class="form-control" placeholder="First name" aria-label="First name">
              </div>

              <div class="mb-2 col-md-6">
                  <label>Last Name</label>
                  <input type="text" name="lname" class="form-control" placeholder="Last name" aria-label="Last name">
              </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="mb-2">
                <label class="form-label">Date of Birth</label>
                <input type="date" class="form-control" name="dob">
              </div>
            </div>
            <div class="col-6">
              <div class="mb-2">
                <label class="form-label">Nationality</label>
                <input type="text" class="form-control" name="nationality">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <label class="form-label">Qualification</label>
                <select class="form-control" name="qualification">
                  <option>Please Select</option>
                  <option>SHS Graduate</option>
                  <option>Certificate</option>
                  <option>Diploma</option>
                  <option>Degree</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" name="email">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-6">
              <div class="mb-2">
                <label class="form-label">Marital Status</label>
                <select class="form-control" name="marriagestatus">
                  <option value="Please Select">Please Select</option>
                  <option value="Single">Single</option>
                  <option value="Married">Married</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="mb-2">
                <label class="form-label">Contact No</label>
            <input type="text" class="form-control" name="contactno">
              </div>
            </div>
          </div>
          <div class="mb-2">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="address"></textarea>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="mb-2">
                <label class="form-label">Date of Appointment</label>
                <input type="date" class="form-control" name="appointmentdate">
              </div>
            </div>
            <div class="col-6">
              <div class="mb-2">
                <label class="form-label">Subject Assigned</label>
                <select class="form-control" name="subject">
                    <option value="Please Select">Please Select</option>
                    <?php
                    $res = mysqli_query($con, "SELECT * FROM courses ORDER BY course_name ASC");
                    while ($row= mysqli_fetch_array($res)){
                        ?>
                    <option value="<?php echo $row["course_name"];?>"><?php echo $row["course_name"];?></option>
                    <?php
                    }
                    ?>
                </select>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="staffsubmit">Submit Information</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
if (isset($_POST["staffsubmit"])) {
  // code...
  $fname = mysqli_real_escape_string($con, $_POST["fname"]);
  $lname = mysqli_real_escape_string($con, $_POST["lname"]);
  $dob = mysqli_real_escape_string($con, $_POST["dob"]);
  $nationality = mysqli_real_escape_string($con, $_POST["nationality"]);
  $qualification = mysqli_real_escape_string($con, $_POST["qualification"]);
  $email = mysqli_real_escape_string($con, $_POST["email"]);
  $marriagestatus = mysqli_real_escape_string($con, $_POST["marriagestatus"]);
  $contactno = mysqli_real_escape_string($con, $_POST["contactno"]);
  $address = mysqli_real_escape_string($con, $_POST["address"]);
  $appointmentdate = mysqli_real_escape_string($con, $_POST["appointmentdate"]);
  $subject = mysqli_real_escape_string($con, $_POST["subject"]);

  //Code for validation
    if (empty($fname)) {
        $_SESSION['status'] = "Please Enter firstname";
        echo '<script type="text/javascript">window.location="staff.php"</script>';
        exit();
    }elseif (empty($lname)) {
        $_SESSION['status'] = "Please Enter lastname";
        echo '<script type="text/javascript">window.location="staff.php"</script>';
        exit();
    }
    elseif (empty($email)) {
        $_SESSION['status'] = "Please Enter Email";
        echo '<script type="text/javascript">window.location="staff.php"</script>';
        exit();
    }else{
      $query = "SELECT * FROM registration WHERE email = '$email' LIMIT 1";
      $query_run = mysqli_query($con, $query);
      if(mysqli_num_rows($query_run) === 1){
        $_SESSION['status'] = "Unsuccessful!! Email entered exist already";
        echo '<script type="text/javascript">window.location="staff.php"</script>';
        exit();
      }else{
        $query = "INSERT INTO registration (indexnumber, firstname, lastname, dob, nationality, qualification, email, maritalstatus, contact, address, doappoinment, subject, status) VALUES ('$_SESSION[indexunmber]', '$fname', '$lname', '$dob', '$nationality', '$qualification', '$email', '$marriagestatus', '$contactno', '$address', '$appointmentdate', '$subject', 'Staff')";
        $query_run = mysqli_query($con, $query);
        if ($query_run) {
            $_SESSION['success'] = "Success!! Information Saved Successfully";
            echo '<script type="text/javascript">window.location="staff.php"</script>';
            exit();
        }else{
            $_SESSION['status'] = "Error!! Information not Saved Successfully";
            echo '<script type="text/javascript">window.location="staff.php"</script>';
            exit();
        }
      }
    }
}
?>