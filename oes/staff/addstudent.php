<?php
include('includes/header.php');
include('includes/navbar.php');

$id = $_GET["id"];
$_SESSION['id'] = $_GET['id'];
$sql = "SELECT * FROM tutorclass WHERE id = '$_GET[id]'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
// session names for them
$_SESSION['classname'] = $row["classname"];
$_SESSION['course_name'] = $row["course_name"];
$_SESSION['course_code'] = $row["course_code"];

?> 

  <main class="mt-5 pt-3">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i>Add Student</span> 
                <div class="text-xs font-weight-bold">
                  <a href="classstudentadmission.php?id=<?php echo $row["id"];?>" class="btn btn-danger"><i class="bi bi-plus"></i> Back</a>
                  <!-- <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal1"><i class="bi bi-plus"></i>
                    Add Student
                  </button> -->
                </div>
              </div>
              <div>

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

              </div>
              
          </div>
        </div>

        <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <form action="" method="POST">
                    <table id="example" class="table table-striped table-hover align-middle">
                      <thead class="table-success">
                        <tr>
                          <th class="no-sort" style="width: 40px;"><input type="checkbox" id="checkAll"></th>
                          <th style="width: 70px;">#</th>
                          <th class="text-start">StudentID</th>
                          <th class="text-start">Name</th>
                          <th>Program</th>
                          <th>Course</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          // Optional selection column check
                          $hasSelection = false;
                          $col = mysqli_query($con, "SHOW COLUMNS FROM student_registration LIKE 'selection'");
                          if ($col && mysqli_num_rows($col) > 0) { $hasSelection = true; }

                          $program = mysqli_real_escape_string($con, $_SESSION['course_name']);
                          $course  = mysqli_real_escape_string($con, $_SESSION['course_code']);
                          $where   = "programType = '".$program."' AND courseSelected = '".$course."'";
                          if ($hasSelection) { $where .= " AND (selection = '' OR selection IS NULL)"; }

                          $query = "SELECT * FROM student_registration WHERE $where ORDER BY id DESC";
                          $query_run = mysqli_query($con, $query);
                          if(mysqli_num_rows($query_run) > 0){
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query_run)){
                        ?>
                        <tr>
                          <td><input type="checkbox" name="student_ids[]" value="<?php echo (int)$row['id']; ?>" class="row-check"></td>
                          <td><?php echo $no;?></td>
                          <td class="text-start"><?php echo htmlspecialchars($row["indexnumber"]);?></td>
                          <td class="text-start"><?php echo htmlspecialchars($row["firstname"].' '.$row["lastname"]);?></td>
                          <td><?php echo htmlspecialchars($row["programType"]);?></td>
                          <td><?php echo htmlspecialchars($row["courseSelected"]);?></td>
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
                    <div class="d-flex justify-content-between">
                      <a href="classstudentadmission.php?id=<?php echo $row["id"];?>" class="btn btn-outline-secondary">Back</a>
                      <button type="submit" name="bulk_add" class="btn btn-success">Add Selected Students</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>

        
      </div>
    </main>

<?php
include('includes/footer.php');
?>

<script>
  // Check/uncheck all for bulk selection
  document.addEventListener('DOMContentLoaded', function() {
    var checkAll = document.getElementById('checkAll');
    if (checkAll) {
      checkAll.addEventListener('change', function() {
        var checks = document.querySelectorAll('.row-check');
        checks.forEach(function(c) { c.checked = checkAll.checked; });
      });
    }
  });
</script>

<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="code.php" method="POST">
        <div class="modal-body">
          <div class="form-group mb-3">
             <label> Select Program </label>
              <select class="form-control" name="program">
                  <option value="Select Program">Select Program</option>
                  <?php
                  // $res = mysqli_query($con, "SELECT * FROM region ORDER BY name ASC");
                  $res = mysqli_query($con, "SELECT * FROM programtype");
                 while ($row= mysqli_fetch_array($res)){
                     ?>
                <option value="<?php echo $row["id"];?>"><?php echo $row["program"];?></option>
                <?php
                }
                ?>
            </select>
        </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="makepayment">Make Payment</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
  if (isset($_POST['addstudent'])) {
  $id = mysqli_real_escape_string($con, $_POST["id"]);
  $query = "SELECT * FROM student_registration WHERE id = '$id' LIMIT 1";
  $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run) === 1){
      // Update selection if column exists
      $hasSelection = false;
      $col = mysqli_query($con, "SHOW COLUMNS FROM student_registration LIKE 'selection'");
      if ($col && mysqli_num_rows($col) > 0) { $hasSelection = true; }
      $classId = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0);
      $selectionValue = $classId > 0 ? (string)$classId : 'Yes';
      $query1 = $hasSelection ? "UPDATE student_registration SET selection = '".$selectionValue."' WHERE id = '$id' LIMIT 1" : "UPDATE student_registration SET courseSelected = courseSelected WHERE id = '$id' LIMIT 1";
      $query_run1 = mysqli_query($con, $query1);
      if ($query_run1) {
        echo '<script type="text/javascript">window.location="classstudentadmission.php?id='.(isset($_GET['id']) ? (int)$_GET['id'] : 0).'"</script>';
        exit();
      }
    }
}

// Bulk add selected students
if (isset($_POST['bulk_add']) && !empty($_POST['student_ids'])) {
  $ids = array_map('intval', $_POST['student_ids']);
  if (!empty($ids)) {
    $idList = implode(',', $ids);
    $hasSelection = false;
    $col = mysqli_query($con, "SHOW COLUMNS FROM student_registration LIKE 'selection'");
    if ($col && mysqli_num_rows($col) > 0) { $hasSelection = true; }
    if ($hasSelection) {
      $classId = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0);
      $selectionValue = $classId > 0 ? (string)$classId : 'Yes';
      mysqli_query($con, "UPDATE student_registration SET selection = '".$selectionValue."' WHERE id IN ($idList)");
    }
  }
  $_SESSION['success'] = 'Selected students added to class';
  echo '<script type="text/javascript">window.location="classstudentadmission.php?id='.(isset($_GET['id']) ? (int)$_GET['id'] : 0).'"</script>';
  exit();
}
// if (isset($_POST["update"])) {
//   // code...
//   $id = mysqli_real_escape_string($con, $_POST["id"]);
//   $name = mysqli_real_escape_string($con, $_POST["name"]);
//   $amount = mysqli_real_escape_string($con, $_POST["amount"]);
//   $contact = mysqli_real_escape_string($con, $_POST["contact"]);
//   $location = mysqli_real_escape_string($con, $_POST["location"]);

//   if (empty($name)) {
//       $_SESSION['status'] = "Please Enter Name of Person";
//       echo '<script type="text/javascript">window.location="editcashindebt.php"</script>';
//       exit();
//   }

//   if (empty($amount)) {
//       $_SESSION['status'] = "Please Enter Amount Owned";
//       echo '<script type="text/javascript">window.location="editcashindebt.php"</script>';
//       exit();
//   }

//   if (empty($contact)) {
//       $_SESSION['status'] = "Please Enter Contact Number";
//       echo '<script type="text/javascript">window.location="editcashindebt.php"</script>';
//       exit();
//   }

//   $query = "UPDATE cashindebt SET name='$name', amount='$amount', contact='$contact', location='$location' WHERE id = '$id'";
//   $query_run = mysqli_query($con, $query);
//   if ($query_run) {
//       $_SESSION['success'] = "Success!! Information Updated Successfully";
//       echo '<script type="text/javascript">window.location="cashindebt.php"</script>';
//       exit();
//   }else{
//       $_SESSION['status'] = "Error!! Information not Updated Successfully";
//       echo '<script type="text/javascript">window.location="editcashindebt.php"</script>';
//       exit();
//   }
// }

    // $query = "SELECT * FROM cashindebt WHERE id = '$id' LIMIT 1";
    // $query_run = mysqli_query($con, $query);
    // if(mysqli_num_rows($query_run) === 1){
    //     $row = mysqli_fetch_assoc($query_run);
    //     $_SESSION["name"] = $row["name"];
    //     $_SESSION["amount_paid"] = $row["amount_paid"];
    //     $_SESSION["balance"] = $row["balance"];
    //     $currentamountpaid = $amount + $_SESSION['amount_paid'];
    //     $currentbalaceremaining = $_SESSION['balance'] - $currentamountpaid;
    //     // Query to update current record
    //     $query = "UPDATE cashindebt SET amount_paid='$currentamountpaid', balance='$currentbalaceremaining' WHERE id = '$id'";
    //     $query_run = mysqli_query($con, $query);
    //     if ($query_run){
    //         $query = "INSERT INTO paymentdetails (name, paymentid, amountowed, payment, balance, work_unit, track) VALUES ('$_SESSION[name]', '$id', '$_SESSION[balance]', '$amount', '$currentbalaceremaining', '$_SESSION[work_unit]', '$_SESSION[track]')";
    //         $query_run = mysqli_query($con, $query);
    //         if ($query_run){
    //             $_SESSION['success'] = "Payment Successful";
    //             echo '<script type="text/javascript">window.location="cashretrieve.php"</script>';
    //             exit();
    //         }
    //     }
    // }else{
    //     $_SESSION['status'] = "Please Reselect Person";
    //     echo '<script type="text/javascript">window.location="cashpayment.php"</script>';
    //     exit();
    // }
?>

