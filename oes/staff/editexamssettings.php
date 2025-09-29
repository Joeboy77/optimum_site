<?php
include('includes/header.php');
include('includes/navbar.php');

?> 

  <main class="mt-5 pt-3">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i> Edit Exams Settings</span> 
                <!-- <div class="text-xs font-weight-bold">No. of Rooms: ... </div> -->
                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-pencil-square me-2"></i>Edit</button>
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
                 ?>
              </div>

              <?php
                $id = $_GET["id"];
                $sql = "SELECT * FROM exams_setting WHERE id = '$_GET[id]'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($result);
              ?>
              <form action="" method="POST">
              <div class="card-body">
                <!-- <h3 class="text-danger text-center" id="para">Not Found</h3> -->
                <div class="row">
                  <div>
                    <div class="card shadow h-100 py-2">
                      <div class="card-header">
                        <h5 class="text-xs font-weight-bold text-primary text-uppercase">Exams Settings</h5>
                      </div>
                      <div class="card-body">
                        <div>
                          <div class="row mb-2">
                            <div class="col-4">Course Name</div>
                            <div class="col-8">
                              <input type="hidden" class="form-control" name="id" value="<?php echo $row['id']?>">
                              <input type="text" class="form-control" name="course" value="<?php echo $row['course']?>" readonly>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Exams Title</div>
                            <div class="col-8">
                              <input type="text" class="form-control" name="title" value="<?php echo $row['title'];?>" readonly>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Semester</div>
                            <div class="col-8"><input type="text" class="form-control" name="semester" value="<?php echo $row['semester'];?>" readonly></div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Time Alocation</div>
                            <div class="col-8">
                              <input type="text" class="form-control" name="timelimit" value="<?php echo $row['timelimit'];?>" readonly>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">No of Questions</div>
                            <div class="col-8">
                              <input type="text" class="form-control" name="no_of_questions" value="<?php echo $row['no_of_questions'];?>" readonly>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Total Marks</div>
                            <div class="col-8">
                              <input type="text" class="form-control" name="totalmarks" value="<?php echo $row['totalmarks'];?>" readonly>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-body">
                        <div class="col-12">
                          <a href="examsetting.php" class="btn btn-danger" type="submit"><i class="bi bi-chevron-bar-left me-2"></i>Back</a>
                          <!-- <button class="btn btn-success" type="submit" name="update">Update</button> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </form>
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
        <h5 class="modal-title" id="exampleModalLabel">Update Exams Settings</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="editexamssettings.php" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
          <div class="mb-2">
            <label class="form-label">Course Name</label>
            <input type="hidden" class="form-control" name="id" value="<?php echo $row['id']?>">
            <input type="text" class="form-control" name="course"  value="<?php echo $row['course']?>" readonly>
          </div>
          <div class="mb-2">
            <label class="form-label">Exams Title</label>
            <input type="text" class="form-control" name="title" value="<?php echo $row['title'];?>">
          </div>
          <div class="mb-2">
            <label class="form-label">Semester</label>
            <select name="semester" class="form-control">
              <option value="<?php echo $row['semester'];?>"><?php echo $row['semester'];?></option>
              <option value="Semeter 1">Semeter 1</option>
              <option value="Semeter 2">Semeter 2</option>
              <option value="Semeter 3">Semeter 3</option>
            </select>
          </div>
          <div class="mb-2">
            <label class="form-label">Time Alocation</label>
            <input type="text" class="form-control" name="timelimit" value="<?php echo $row['timelimit'];?>">
          </div>
          <div class="mb-2">
            <label class="form-label">No of Questions</label>
            <input type="text" class="form-control" name="no_of_questions" value="<?php echo $row['no_of_questions'];?>">
          </div>
          <div class="mb-2">
            <label class="form-label">Total Marks</label>
            <input type="text" class="form-control" name="totalmarks" value="<?php echo $row['totalmarks'];?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="Update">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
if (isset($_POST["Update"])) {
  // code...
  $id = mysqli_real_escape_string($con, $_POST["id"]);
  $course = mysqli_real_escape_string($con, $_POST["course"]);
  $title = mysqli_real_escape_string($con, $_POST["title"]);
  $semester = mysqli_real_escape_string($con, $_POST["semester"]);
  $timelimit = mysqli_real_escape_string($con, $_POST["timelimit"]);
  $no_of_questions = mysqli_real_escape_string($con, $_POST["no_of_questions"]);
  $totalmarks = mysqli_real_escape_string($con, $_POST["totalmarks"]);

  if (empty($semester)) {
      $_SESSION['status'] = "Please Select Semester";
      echo '<script type="text/javascript">window.location="editexamssettings.php"</script>';
      exit();
  }

  if (empty($timelimit)) {
      $_SESSION['status'] = "Please Select Time Limit";
      echo '<script type="text/javascript">window.location="editexamssettings.php"</script>';
      exit();
  }

  if (empty($no_of_questions)) {
      $_SESSION['status'] = "Please Enter Number of Question";
      echo '<script type="text/javascript">window.location="editexamssettings.php"</script>';
      exit();
  }

  if (empty($totalmarks)) {
      $_SESSION['status'] = "Please Enter Total Number";
      echo '<script type="text/javascript">window.location="editexamssettings.php"</script>';
      exit();
  }

  $query = "UPDATE exams_setting SET course='$course', title='$title', semester='$semester', no_of_questions='$no_of_questions', totalmarks='$totalmarks' WHERE id = '$id'";
  $query_run = mysqli_query($con, $query);
  if ($query_run) {
      $_SESSION['success'] = "Success!! Information Updated Successfully";
      echo '<script type="text/javascript">window.location="examsetting.php"</script>';
      exit();
  }else{
      $_SESSION['status'] = "Error!! Information not Updated Successfully";
      echo '<script type="text/javascript">window.location="editexamssettings.php"</script>';
      exit();
  }
}
?>

