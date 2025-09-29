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
            <strong>Hey!</strong> <?php echo $_SESSION["status"]; ?>.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
          
         <?php
         unset($_SESSION["status"]);
         }

         if (isset($_SESSION["success"]) && $_SESSION["success"] != '') {
           
           ?>
           <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Hey!</strong> <?php echo $_SESSION["success"]; ?>.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
           </div>
            
           <?php
           unset($_SESSION["success"]);
         }
         ?>

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
                    <table id="example" class="table table-striped table-hover text-center">
                      <thead class="table-success">
                        <tr>
                          <th class="d-none">S. No.</th>
                          <th>S. No.</th>
                          <th>Index No.</th>
                          <th>Firstname</th>
                          <th>Lastname</th>
                          <th>Nationality</th>
                          <th>Qualification</th>
                          <th>Marriage Status</th>
                          <th class="no-sort" style="width: 160px;">Actions</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          $query = "SELECT * FROM registration WHERE status = 'Staff'";
                          $query_run = mysqli_query($con, $query);
                          if($query_run && mysqli_num_rows($query_run) > 0){
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query_run)){
                        ?>
                        <tr>
                          <td class="d-none"><?php echo $row["id"];?></td>
                          <td><?php echo $no;?></td>
                          <td><?php echo $row["indexnumber"];?></td>
                          <td><?php echo $row["firstname"];?></td>
                          <td><?php echo $row["lastname"];?></td>
                          <td><?php echo $row["nationality"];?></td>
                          <td><?php echo $row["qualification"];?></td>
                          <td><?php echo $row["maritalstatus"];?></td>
                          <td>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>"><i class="bi bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['id']; ?>"><i class="bi bi-trash"></i></button>
                            <?php if ($row['position']==='Blocked') { ?>
                              <form action="staff.php" method="POST" class="d-inline">
                                <input type="hidden" name="staff_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="unblock_staff" class="btn btn-secondary btn-sm"><i class="bi bi-unlock"></i></button>
                              </form>
                            <?php } else { ?>
                              <form action="staff.php" method="POST" class="d-inline">
                                <input type="hidden" name="staff_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="block_staff" class="btn btn-secondary btn-sm"><i class="bi bi-lock"></i></button>
                              </form>
                            <?php } ?>
                          </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel<?php echo $row['id']; ?>">Edit Staff</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form action="staff.php" method="POST">
                                <div class="modal-body text-start">
                                  <input type="hidden" name="staff_id" value="<?php echo $row['id']; ?>">
                                  <div class="row">
                                    <div class="mb-2 col-md-6">
                                      <label>First Name</label>
                                      <input type="text" name="fname" class="form-control" value="<?php echo htmlspecialchars($row['firstname']); ?>" required>
                                    </div>
                                    <div class="mb-2 col-md-6">
                                      <label>Last Name</label>
                                      <input type="text" name="lname" class="form-control" value="<?php echo htmlspecialchars($row['lastname']); ?>" required>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-6">
                                      <div class="mb-2">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" name="dob" value="<?php echo htmlspecialchars($row['dob']); ?>">
                                      </div>
                                    </div>
                                    <div class="col-6">
                                      <div class="mb-2">
                                        <label class="form-label">Nationality</label>
                                        <input type="text" class="form-control" name="nationality" value="<?php echo htmlspecialchars($row['nationality']); ?>">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12">
                                      <div class="mb-2">
                                        <label class="form-label">Qualification</label>
                                        <input type="text" class="form-control" name="qualification" value="<?php echo htmlspecialchars($row['qualification']); ?>">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12">
                                      <div class="mb-2">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-6">
                                      <div class="mb-2">
                                        <label class="form-label">Marital Status</label>
                                        <select class="form-control" name="marriagestatus">
                                          <option value="Single" <?php echo ($row['maritalstatus']==='Single')?'selected':''; ?>>Single</option>
                                          <option value="Married" <?php echo ($row['maritalstatus']==='Married')?'selected':''; ?>>Married</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-6">
                                      <div class="mb-2">
                                        <label class="form-label">Contact No</label>
                                        <input type="text" class="form-control" name="contactno" value="<?php echo htmlspecialchars($row['contact']); ?>">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="mb-2">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address"><?php echo htmlspecialchars($row['address']); ?></textarea>
                                  </div>
                                  <div class="row">
                                    <div class="col-6">
                                      <div class="mb-2">
                                        <label class="form-label">Date of Appointment</label>
                                        <input type="date" class="form-control" name="appointmentdate" value="<?php echo htmlspecialchars($row['doappoinment']); ?>">
                                      </div>
                                    </div>
                                    <div class="col-6">
                                      <div class="mb-2">
                                        <label class="form-label">Position</label>
                                        <select class="form-control" name="position">
                                          <option value="Tutor" <?php echo ($row['position']==='Tutor')?'selected':''; ?>>Tutor</option>
                                          <option value="Receptionist" <?php echo ($row['position']==='Receptionist')?'selected':''; ?>>Receptionist</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary" name="update_staff">Save Changes</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel<?php echo $row['id']; ?>">Delete Staff</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form action="staff.php" method="POST">
                                <div class="modal-body">
                                  <input type="hidden" name="staff_id" value="<?php echo $row['id']; ?>">
                                  <p>Are you sure you want to delete <strong><?php echo htmlspecialchars($row['firstname'].' '.$row['lastname']); ?></strong>?</p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                  <button type="submit" class="btn btn-danger" name="delete_staff">Yes, Delete</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                        <?php
                        $no++;
                        }
                      }else{
                        echo "<tr>".
                             "<td class='d-none'></td>".
                             "<td class='text-center'>No staff found</td>".
                             "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>".
                             "</tr>";
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
                <label class="form-label">Position</label>
                <select class="form-control" name="position">
                    <option value="Please Select">Please Select</option>
                    <option value="Tutor">Tutor</option>
                    <option value="Receptionist">Receptionist</option>
                    
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
  $position = mysqli_real_escape_string($con, $_POST["position"]);

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
      $query = "SELECT * FROM registration WHERE email = '$email' AND status = 'Staff' LIMIT 1";
      $query_run = mysqli_query($con, $query);
      if(mysqli_num_rows($query_run) === 1){
        $_SESSION['status'] = "Unsuccessful!! Email entered exist already";
        echo '<script type="text/javascript">window.location="staff.php"</script>';
        exit();
      }else{
        $query = "INSERT INTO registration (indexnumber, firstname, lastname, dob, nationality, qualification, email, maritalstatus, contact, address, doappoinment, position, status) VALUES ('$_SESSION[indexunmber]', '$fname', '$lname', '$dob', '$nationality', '$qualification', '$email', '$marriagestatus', '$contactno', '$address', '$appointmentdate', '$position', 'Staff')";
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

if (isset($_POST['update_staff'])) {
  $staff_id = mysqli_real_escape_string($con, $_POST['staff_id']);
  $fname = mysqli_real_escape_string($con, $_POST['fname']);
  $lname = mysqli_real_escape_string($con, $_POST['lname']);
  $dob = mysqli_real_escape_string($con, $_POST['dob']);
  $nationality = mysqli_real_escape_string($con, $_POST['nationality']);
  $qualification = mysqli_real_escape_string($con, $_POST['qualification']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $marriagestatus = mysqli_real_escape_string($con, $_POST['marriagestatus']);
  $contactno = mysqli_real_escape_string($con, $_POST['contactno']);
  $address = mysqli_real_escape_string($con, $_POST['address']);
  $appointmentdate = mysqli_real_escape_string($con, $_POST['appointmentdate']);
  $position = mysqli_real_escape_string($con, $_POST['position']);

  if (empty($fname) || empty($lname)) {
    $_SESSION['status'] = "Firstname and Lastname are required";
    echo '<script type="text/javascript">window.location="staff.php"</script>';
    exit();
  }

  $upd = mysqli_query($con, "UPDATE registration SET firstname='$fname', lastname='$lname', dob='$dob', nationality='$nationality', qualification='$qualification', email='$email', maritalstatus='$marriagestatus', contact='$contactno', address='$address', doappoinment='$appointmentdate', position='$position' WHERE id='$staff_id' AND status='Staff' LIMIT 1");
  if ($upd) {
    $_SESSION['success'] = "Staff updated successfully";
  } else {
    $_SESSION['status'] = "Error updating staff";
  }
  echo '<script type="text/javascript">window.location="staff.php"</script>';
  exit();
}

if (isset($_POST['delete_staff'])) {
  $staff_id = mysqli_real_escape_string($con, $_POST['staff_id']);
  $del = mysqli_query($con, "DELETE FROM registration WHERE id='$staff_id' AND status='Staff' LIMIT 1");
  if ($del) {
    $_SESSION['success'] = "Staff deleted successfully";
  } else {
    $_SESSION['status'] = "Error deleting staff";
  }
  echo '<script type="text/javascript">window.location="staff.php"</script>';
  exit();
}

// Block/Unblock handlers: use position column as a simple flag when Active column not available
if (isset($_POST['block_staff'])) {
  $staff_id = mysqli_real_escape_string($con, $_POST['staff_id']);
  // Prefer an active column if present; else fallback to position flag change to "Blocked"
  $hasActive = false; $d = mysqli_query($con, "SHOW COLUMNS FROM registration"); if ($d) { while ($r = mysqli_fetch_assoc($d)) { if ($r['Field']==='active') $hasActive=true; } }
  if ($hasActive) {
    mysqli_query($con, "UPDATE registration SET active='Blocked' WHERE id='".$staff_id."' AND status='Staff' LIMIT 1");
  } else {
    mysqli_query($con, "UPDATE registration SET position='Blocked' WHERE id='".$staff_id."' AND status='Staff' LIMIT 1");
  }
  $_SESSION['success'] = 'Staff blocked'; echo '<script type="text/javascript">window.location="staff.php"</script>'; exit();
}
if (isset($_POST['unblock_staff'])) {
  $staff_id = mysqli_real_escape_string($con, $_POST['staff_id']);
  $hasActive = false; $d = mysqli_query($con, "SHOW COLUMNS FROM registration"); if ($d) { while ($r = mysqli_fetch_assoc($d)) { if ($r['Field']==='active') $hasActive=true; } }
  if ($hasActive) {
    mysqli_query($con, "UPDATE registration SET active='Yes' WHERE id='".$staff_id."' AND status='Staff' LIMIT 1");
  } else {
    // default previous position to Tutor if blocked; keep simple
    mysqli_query($con, "UPDATE registration SET position='Tutor' WHERE id='".$staff_id."' AND status='Staff' LIMIT 1");
  }
  $_SESSION['success'] = 'Staff unblocked'; echo '<script type="text/javascript">window.location="staff.php"</script>'; exit();
}
?>