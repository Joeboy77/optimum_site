<?php
include('includes/header.php');
include('includes/navbar.php');

// Load student info safely to avoid undefined index warnings
$studentRow = null;
$query = "SELECT * FROM student_registration WHERE indexnumber = '".$_SESSION['schoolID']."' LIMIT 1";
$query_result = mysqli_query($con, $query);
if ($query_result && mysqli_num_rows($query_result) > 0) {
    $studentRow = mysqli_fetch_assoc($query_result);
}

// Set only what we need with safe fallbacks
$_SESSION['programType'] = $studentRow['programType'] ?? ($_SESSION['programType'] ?? '');
$_SESSION['courseSelected'] = $studentRow['courseSelected'] ?? ($_SESSION['courseSelected'] ?? '');
$_SESSION['courseDuration'] = $studentRow['courseDuration'] ?? ($_SESSION['courseDuration'] ?? '');
$_SESSION['courseSession'] = $studentRow['courseSession'] ?? ($_SESSION['courseSession'] ?? '');
$_SESSION['residency'] = $studentRow['residency'] ?? ($_SESSION['residency'] ?? '');
$_SESSION['entrydate'] = $studentRow['entrydate'] ?? ($_SESSION['entrydate'] ?? '');

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
                <span><i class="bi bi-table me-2"></i>Course Upload</span>
                <span>Course: <b><?php echo $_SESSION['courseSelected']?></b></span>
                <!-- <div class="text-xs font-weight-bold">
                	<button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i>
        					  Add Debtor Information
        					</button>
                </div> -->
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <table class="table table-striped table-hover text-center">
                      <thead class="table-success">
                        <tr>
                          <th hidden>S. No.</th>
                          <th>S. No.</th>
                          <th>Course Name</th>
                          <th>Class</th>
                          <th>Title</th>
                          <th>Note</th>
                          <th>File Attached</th>
                          <th>View</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                        $query = "SELECT * FROM student_registration WHERE indexnumber = '$_SESSION[schoolID]' LIMIT 1";
                        $query_run = mysqli_query($con, $query);
                          if(mysqli_num_rows($query_run) > 0){
                            $row = mysqli_fetch_assoc($query_run);
                            $_SESSION['courseSelected'] = $row["courseSelected"];
                            if ($query_run) {
                              // Fetch uploads for the student's course
                              $courseName = mysqli_real_escape_string($con, $_SESSION['courseSelected'] ?? '');
                              $query1 = "SELECT * FROM lesson_upload WHERE course_name = '".$courseName."' ORDER BY id DESC";
                              $query_run1 = mysqli_query($con, $query1);
                              if(mysqli_num_rows($query_run1) > 0){
                                $no = 1;
                                while ($row1 = mysqli_fetch_assoc($query_run1)){
                        ?>
                        <tr>
                          <td hidden><?php echo $row1["id"];?></td>
                          <td><?php echo $no;?></td>
                          <td><?php echo $row1["course_name"];?></td>
                          <td><?php echo $row1["lesson_class"];?></td>
                          <td><?php echo $row1["lesson_title"];?></td>
                          <td><?php echo $row1["lesson_note"];?></td>
                          <td>
                            <a href="../staff/<?php echo htmlspecialchars($row1['lesson_file']);?>" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                          </td>
                          <td>
                            <a href="../staff/<?php echo htmlspecialchars($row1['lesson_file']);?>" download class="btn btn-sm btn-success">Download</a>
                          </td>
                        </tr>
                        <?php
                        $no++;
                        }
                         }
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


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Debtor Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="cashindebt.php" method="POST">
      <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Name of Debtor</label>
            <input type="text" class="form-control" name="name">
          </div>
          <div class="mb-3">
            <label class="form-label">Amount Owned</label>
            <input type="text" class="form-control" name="amount">
          </div>
          <div class="mb-3">
            <label class="form-label">Contact No.</label>
            <input type="text" class="form-control" name="contact">
          </div>
          <div class="mb-3">
            <label class="form-label">Location</label>
            <textarea class="form-control" placeholder="Enter Location of Debtor" name="location"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="cashindebtsubmit">Submit Information</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
if (isset($_POST["cashindebtsubmit"])) {
  // code...
  $name = mysqli_real_escape_string($con, $_POST["name"]);
  $amount = mysqli_real_escape_string($con, $_POST["amount"]);
  $contact = mysqli_real_escape_string($con, $_POST["contact"]);
  $location = mysqli_real_escape_string($con, $_POST["location"]);

  //Code for validation
    if (empty($name)) {
        $_SESSION['status'] = "Please Enter name of person";
        echo '<script type="text/javascript">window.location="cashindebt.php"</script>';
        exit();
    }
    if (empty($amount)) {
        $_SESSION['status'] = "Please Enter Amount";
        echo '<script type="text/javascript">window.location="cashindebt.php"</script>';
        exit();
    }
    if (empty($contact)) {
        $_SESSION['status'] = "Please Enter Contact Number";
        echo '<script type="text/javascript">window.location="cashindebt.php"</script>';
        exit();
    }

    $query = "INSERT INTO cashindebt (name, amount, contact, location, work_unit, track, balance) VALUES ('$name', '$amount', '$contact', '$location', '$_SESSION[work_unit]', '$_SESSION[track]', '$amount')";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['success'] = "Success!! Information Saved Successfully";
        echo '<script type="text/javascript">window.location="cashindebt.php"</script>';
        exit();
    }else{
        $_SESSION['status'] = "Error!! Information not Saved Successfully";
        echo '<script type="text/javascript">window.location="cashindebt.php"</script>';
        exit();
    }
}
?>