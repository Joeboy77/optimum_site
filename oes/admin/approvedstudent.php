<?php
include('includes/header.php');
include('includes/navbar.php');

?> 

  <main class="mt-5 pt-3">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i>Approved Student</span> 
                <div class="text-xs font-weight-bold">
                  <a href="student.php" class="btn btn-danger"><i class="bi bi-plus"></i> Back</a>
                </div>
              </div>
              <div>

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

              </div>
              
          </div>
        </div>

        <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <table id="example" class="table table-striped table-hover text-center">
                      <thead class="table-success">
                        <tr>
                          <th hidden>S. No.</th>
                          <th>S. No.</th>
                          <th>Index No.</th>
                          <th>Firstname</th>
                          <th>Lastname</th>
                          <th>Nationality</th>
                          <th>View</th>
                          <th class="no-sort" style="width: 160px;">Actions</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          $hasFees = false; $hasActive = false;
                          $desc = mysqli_query($con, "SHOW COLUMNS FROM student_registration");
                          if ($desc) { while ($c = mysqli_fetch_assoc($desc)) { if ($c['Field']==='fees') $hasFees=true; if ($c['Field']==='active') $hasActive=true; } }
                          $where = [];
                          if ($hasActive) { $where[] = "(active IS NULL OR active != 'Blocked')"; }
                          if ($hasFees) { $where[] = "(fees != '' AND fees IS NOT NULL)"; }
                          $query = "SELECT * FROM student_registration ".(!empty($where)?("WHERE ".implode(' AND ', $where)) : '')." ORDER BY id DESC";
                          $query_run = mysqli_query($con, $query);
                          if($query_run && mysqli_num_rows($query_run) > 0){
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
                          <td>
                            <a href="approvedstudentdetails.php?id=<?php echo $row["id"];?>" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i></a>
                          </td>
                          <td>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editStudent<?php echo $row['id']; ?>"><i class="bi bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteStudent<?php echo $row['id']; ?>"><i class="bi bi-trash"></i></button>
                            <?php if ($hasActive && ($row['active']==='Blocked')) { ?>
                              <form action="approvedstudent.php" method="POST" class="d-inline">
                                <input type="hidden" name="student_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="unblock_student" class="btn btn-secondary btn-sm"><i class="bi bi-unlock"></i></button>
                              </form>
                            <?php } elseif ($hasActive) { ?>
                              <form action="approvedstudent.php" method="POST" class="d-inline">
                                <input type="hidden" name="student_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="block_student" class="btn btn-secondary btn-sm"><i class="bi bi-lock"></i></button>
                              </form>
                            <?php } ?>
                          </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editStudent<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editStudentLabel<?php echo $row['id']; ?>" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="editStudentLabel<?php echo $row['id']; ?>">Edit Student</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form action="approvedstudent.php" method="POST">
                                <div class="modal-body text-start">
                                  <input type="hidden" name="student_id" value="<?php echo $row['id']; ?>">
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
                                        <label class="form-label">Nationality</label>
                                        <input type="text" class="form-control" name="nationality" value="<?php echo htmlspecialchars($row['nationality']); ?>">
                                      </div>
                                    </div>
                                    <div class="col-6">
                                      <div class="mb-2">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary" name="update_student">Save Changes</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteStudent<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteStudentLabel<?php echo $row['id']; ?>" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="deleteStudentLabel<?php echo $row['id']; ?>">Delete Student</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form action="approvedstudent.php" method="POST">
                                <div class="modal-body">
                                  <input type="hidden" name="student_id" value="<?php echo $row['id']; ?>">
                                  <p>Are you sure you want to delete <strong><?php echo htmlspecialchars($row['firstname'].' '.$row['lastname']); ?></strong>?</p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                  <button type="submit" class="btn btn-danger" name="delete_student">Yes, Delete</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

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
    </main>

<?php
include('includes/footer.php');
?>

<?php
// Handlers for student actions on approved list
if (isset($_POST['update_student'])) {
  $sid = mysqli_real_escape_string($con, $_POST['student_id']);
  $fname = mysqli_real_escape_string($con, $_POST['fname']);
  $lname = mysqli_real_escape_string($con, $_POST['lname']);
  $nationality = mysqli_real_escape_string($con, $_POST['nationality']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  if ($fname === '' || $lname === '') { $_SESSION['status'] = 'Firstname and Lastname are required'; echo '<script type="text/javascript">window.location="approvedstudent.php"</script>'; exit(); }
  $upd = mysqli_query($con, "UPDATE student_registration SET firstname='".$fname."', lastname='".$lname."', nationality='".$nationality."', email='".$email."' WHERE id='".$sid."' LIMIT 1");
  $_SESSION['success'] = $upd ? 'Student updated successfully' : 'Error updating student';
  echo '<script type="text/javascript">window.location="approvedstudent.php"</script>'; exit();
}
if (isset($_POST['delete_student'])) {
  $sid = mysqli_real_escape_string($con, $_POST['student_id']);
  $del = mysqli_query($con, "DELETE FROM student_registration WHERE id='".$sid."' LIMIT 1");
  $_SESSION['success'] = $del ? 'Student deleted successfully' : 'Error deleting student';
  echo '<script type="text/javascript">window.location="approvedstudent.php"</script>'; exit();
}
if (isset($_POST['block_student'])) {
  $sid = mysqli_real_escape_string($con, $_POST['student_id']);
  $hasActive = false; $d = mysqli_query($con, "SHOW COLUMNS FROM student_registration"); if ($d) { while ($r = mysqli_fetch_assoc($d)) { if ($r['Field']==='active') $hasActive=true; } }
  if ($hasActive) { mysqli_query($con, "UPDATE student_registration SET active='Blocked' WHERE id='".$sid."' LIMIT 1"); }
  $_SESSION['success'] = 'Student blocked'; echo '<script type="text/javascript">window.location="approvedstudent.php"</script>'; exit();
}
if (isset($_POST['unblock_student'])) {
  $sid = mysqli_real_escape_string($con, $_POST['student_id']);
  $hasActive = false; $d = mysqli_query($con, "SHOW COLUMNS FROM student_registration"); if ($d) { while ($r = mysqli_fetch_assoc($d)) { if ($r['Field']==='active') $hasActive=true; } }
  if ($hasActive) { mysqli_query($con, "UPDATE student_registration SET active='Yes' WHERE id='".$sid."' LIMIT 1"); }
  $_SESSION['success'] = 'Student unblocked'; echo '<script type="text/javascript">window.location="approvedstudent.php"</script>'; exit();
}
?>

