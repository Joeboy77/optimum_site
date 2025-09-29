<?php
include('includes/header.php');
include('includes/navbar.php');

$query = mysqli_query($con, "select * from courses order by id desc limit 1");
$line = mysqli_fetch_array($query);
$num = isset($line['id']) ? $line['id'] : 0;
$num++;

$course_code = 'C'.str_pad($num++, 3, '0', STR_PAD_LEFT);
$_SESSION['course_code'] = $course_code;
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
        <!-- Page Header -->
        <div class="row mb-3">
          <div class="col-12 d-flex align-items-center justify-content-between">
            <div>
              <h4 class="mb-0">Courses</h4>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Courses</li>
                </ol>
              </nav>
            </div>
            <div>
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus-lg me-1"></i>Add Course</button>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-sm-flex align-items-center justify-content-between">
                  <span class="fw-semibold"><i class="bi bi-table me-2"></i>Courses</span> 
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <div class="table-responsive">
                        <table id="example" class="table table-striped table-hover align-middle">
                          <thead class="table-success">
                            <tr>
                              <th class="d-none">S. No.</th>
                              <th style="width: 90px;">S. No.</th>
                              <th>Program</th>
                              <th>Course Name</th>
                              <th>Course Code</th>
                              <th class="no-sort" style="width: 120px;">Actions</th>
                            </tr>
                          </thead>
                          <tbody id="data">
                            <?php
                              $query = "SELECT * FROM courses";
                              $query_run = mysqli_query($con, $query);
                              if(mysqli_num_rows($query_run) > 0){
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($query_run)){
                            ?>
                            <tr>
                              <td class="d-none"><?php echo $row["id"];?></td>
                              <td><?php echo $no;?></td>
                              <td class="text-start"><?php echo $row["programType"];?></td>
                              <td class="text-start fw-semibold"><?php echo $row["course_name"];?></td>
                              <td><span class="text-dark"><?php echo $row["course_code"];?></span></td>
                              <td>
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>"><i class="bi bi-pencil-square"></i></button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['id']; ?>"><i class="bi bi-trash"></i></button>
                              </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?php echo $row['id']; ?>">Edit Course</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form action="courses.php" method="POST">
                                    <div class="modal-body">
                                      <input type="hidden" name="course_id" value="<?php echo $row['id']; ?>">
                                      <div class="mb-2">
                                        <label class="form-label">Program</label>
                                        <select class="form-control" name="program" required>
                                          <option value="">Please Select</option>
                                          <?php
                                            $res = mysqli_query($con, "SELECT * FROM programtype");
                                            while ($prow= mysqli_fetch_array($res)){
                                              $sel = ($prow['program'] === $row['programType']) ? 'selected' : '';
                                              echo '<option value="'.htmlspecialchars($prow['program']).'" '.$sel.'>'.htmlspecialchars($prow['program'])."</option>";
                                            }
                                          ?>
                                        </select>
                                      </div>
                                      <div class="mb-2">
                                        <label class="form-label">Course Name</label>
                                        <input type="text" class="form-control" name="course_name" value="<?php echo htmlspecialchars($row['course_name']); ?>" placeholder="e.g. Network Administration" required>
                                      </div>
                                      <div class="mb-2">
                                        <label class="form-label">Course Code</label>
                                        <input type="text" class="form-control" name="course_code" value="<?php echo htmlspecialchars($row['course_code']); ?>" readonly>
                                        <div class="form-text">Course code is auto-generated and cannot be changed.</div>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary" name="update_course">Save Changes</button>
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
                                    <h5 class="modal-title" id="deleteModalLabel<?php echo $row['id']; ?>">Delete Course</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form action="courses.php" method="POST">
                                    <div class="modal-body">
                                      <input type="hidden" name="course_id" value="<?php echo $row['id']; ?>">
                                      <p>Are you sure you want to delete <strong><?php echo htmlspecialchars($row['course_name']); ?></strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <button type="submit" class="btn btn-danger" name="delete_course">Yes, Delete</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>

                            <?php
                            $no++;
                            }
                          }else{
                            echo "<tr><td class='d-none'></td><td colspan='5' class='text-center py-4'>No courses found. Click <span class=\"fw-semibold\">Add Course</span> to create your first one.</td></tr>";
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
        </div>

        
      </div>
    </main>

<?php
include('includes/footer.php');
?>

<!-- Add Course Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Course</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="courses.php" method="POST">
      <div class="modal-body">
        <div class="row">
            <h6 class="text-center text-primary">Course Code: <?php echo $course_code;?></h6>
          </div>
          <hr>
          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <label class="form-label">Select Program</label>
                <select class="form-control" name="program" required>
                    <option value="">Please Select</option>
                    <?php
                    $res = mysqli_query($con, "SELECT * FROM programtype");
                    while ($row= mysqli_fetch_array($res)){
                        ?>
                    <option value="<?php echo $row['program'];?>"><?php echo $row["program"];?></option>
                    <?php
                    }
                    ?>
                </select>
              </div>
            </div>
            <div class="col-12">
              <div class="mb-2">
                <label class="form-label">Course Name</label>
                <input type="text" class="form-control" name="course_name" placeholder="e.g. Network Administration" required>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="tripsubmit">Add Course</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
if (isset($_POST["tripsubmit"])) {
  $program = mysqli_real_escape_string($con, $_POST["program"]);
  $course_name = mysqli_real_escape_string($con, $_POST["course_name"]);

  if ($program === '' ) {
      $_SESSION['status'] = "Please Select";
      echo '<script type="text/javascript">window.location="courses.php"</script>';
      exit();
  }

  if (empty($course_name)) {
      $_SESSION['status'] = "Please Enter Course Name";
      echo '<script type="text/javascript">window.location="courses.php"</script>';
      exit();
  }

  // code to select programtypeID
  $query1 = "SELECT * FROM programtype WHERE program = '$program' LIMIT 1";
  $query_run1 = mysqli_query($con, $query1);
  if(mysqli_num_rows($query_run1) === 1){
    $row = mysqli_fetch_assoc($query_run1);
    $_SESSION['programTypeID'] = $row['id'];
    if ($query_run1) {
      // code to check same course not inserted twice
      $query = "SELECT * FROM courses WHERE programtype = '$program' AND course_name = '$course_name' LIMIT 1";
      $query_run = mysqli_query($con, $query);
      if(mysqli_num_rows($query_run) === 1){
        $_SESSION['status'] = "Error!! Course Name entered exist already";
        echo '<script type="text/javascript">window.location="courses.php"</script>';
        exit();
      }else{
        $query = "INSERT INTO courses (programType, course_name, programTypeID, course_code) VALUES ('$program', '$course_name', '$_SESSION[programTypeID]', '$course_code')";
        $query_run = mysqli_query($con, $query);
        if ($query_run) {
            $_SESSION['success'] = "Success!! Information Saved Successfully";
            echo '<script type="text/javascript">window.location="courses.php"</script>';
            exit();
        }else{
            $_SESSION['status'] = "Error!! Information not Saved Successfully";
            echo '<script type="text/javascript">window.location="courses.php"</script>';
            exit();
        }
      }
    }
  }
}

// Update Course
if (isset($_POST['update_course'])) {
  $course_id = mysqli_real_escape_string($con, $_POST['course_id']);
  $program = mysqli_real_escape_string($con, $_POST['program']);
  $course_name = mysqli_real_escape_string($con, $_POST['course_name']);

  if ($program === '' ) {
      $_SESSION['status'] = "Please Select";
      echo '<script type="text/javascript">window.location="courses.php"</script>';
      exit();
  }

  if (empty($course_name)) {
      $_SESSION['status'] = "Please Enter Course Name";
      echo '<script type="text/javascript">window.location="courses.php"</script>';
      exit();
  }

  $query1 = "SELECT * FROM programtype WHERE program = '$program' LIMIT 1";
  $query_run1 = mysqli_query($con, $query1);
  if(mysqli_num_rows($query_run1) === 1){
    $row = mysqli_fetch_assoc($query_run1);
    $programTypeID = $row['id'];

    // Prevent duplicates (same program + course name on different id)
    $dup = mysqli_query($con, "SELECT id FROM courses WHERE programtype = '$program' AND course_name = '$course_name' AND id != '$course_id' LIMIT 1");
    if (mysqli_num_rows($dup) > 0) {
      $_SESSION['status'] = "Another course with same name exists under this program";
      echo '<script type="text/javascript">window.location="courses.php"</script>';
      exit();
    }

    $update = mysqli_query($con, "UPDATE courses SET programType = '$program', course_name = '$course_name', programTypeID = '$programTypeID' WHERE id = '$course_id' LIMIT 1");
    if ($update) {
      $_SESSION['success'] = "Course updated successfully";
    } else {
      $_SESSION['status'] = "Error updating course";
    }
    echo '<script type="text/javascript">window.location="courses.php"</script>';
    exit();
  }
}

// Delete Course
if (isset($_POST['delete_course'])) {
  $course_id = mysqli_real_escape_string($con, $_POST['course_id']);
  $delete = mysqli_query($con, "DELETE FROM courses WHERE id = '$course_id' LIMIT 1");
  if ($delete) {
    $_SESSION['success'] = "Course deleted successfully";
  } else {
    $_SESSION['status'] = "Error deleting course";
  }
  echo '<script type="text/javascript">window.location="courses.php"</script>';
  exit();
}
?>