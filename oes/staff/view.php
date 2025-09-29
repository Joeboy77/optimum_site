<?php
include('includes/header.php');
include('includes/navbar.php');

?> 

    <main class="mt-5 pt-3">
      <div class="container-fluid">

        <div class="row">

          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i> Exams Details</span> 
                <a href="viewquestions.php" class="btn btn-danger"><i class="bi bi-chevron-bar-left me-2"></i>Back</a>
              </div>
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
              <div class="card-body">
                  <form action="" method="POST" enctype="multipart/form-data">
                  <div class="row">
                  <div class="col-xl-4 col-md-5">
                    <div class="card shadow h-100 py-2">
                      <div class="card-header d-sm-flex align-items-center justify-content-between">
                        <h5 class="text-xs font-weight-bold text-primary text-uppercase">Exams Information</h5>
                        <!-- <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal1"><i class="bi bi-plus"></i>
                            Add Recuring Expenses
                          </button> -->
                      </div>
                      <?php
                        $sql = "SELECT * FROM exams_setting WHERE id = '$_SESSION[id]' LIMIT 1";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_assoc($result);
                      ?>
                      <div class="card-body">
                          <div class="mb-3">
                            <label class="form-label">Course:</label>
                            <input type="text" class="form-control" name="course" value="<?php echo $row['course']?>" readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Title:</label>
                            <input type="text" class="form-control" name="title" value="<?php echo $row['title']?>" readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Semester:</label>
                            <input type="text" class="form-control" name="itemname" value="<?php echo $row['semester']?>" readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Time Limit:</label>
                            <input type="text" class="form-control" name="itemname" value="<?php echo $row['timelimit']?>" readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Total Marks:</label>
                            <input type="text" class="form-control" name="itemname" value="<?php echo $row['totalmarks']?>" readonly>
                          </div>
                      </div>
                    </div>
                  </div>

                    <div class="col-xl-8 col-md-7">
                    <div class="card shadow h-100 py-2">
                      <div class="card-header d-sm-flex align-items-center justify-content-between">
                        <h5 class="text-xs font-weight-bold text-primary text-uppercase">Exams Questions</h5>
                        <span>
                          <form action="" method="POST">
                            <input type="hidden" class="form-control" name="courseID" value="<?php echo $_SESSION['id'];?>" >
                            <button type="submit" name="viewquestion" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> View Question</button>
                            <button type="submit" name="addquestion" class="btn btn-success btn-sm"><i class="bi bi-plus"></i> Add Question</button>
                          </form>
                        </span>
                        <!-- <div class="text-xs font-weight-bold">
                          <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i> Add Questions</button>
                        </div> -->
                      </div>
                      <div class="card-body" style="height: 420px; overflow: hidden; overflow-y: scroll;">
                        <table class="table">
                          <thead class="table-success">
                            <tr>
                              <th hidden>S. No.</th>
                              <th>No.</th>
                              <th>Question</th>
                              <th>Answer</th>
                              <th>Active?</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="data">
                            <?php
                              $query = "SELECT * FROM exams_questions WHERE questionID = '$_SESSION[id]'";
                              $query_run = mysqli_query($con, $query);
                              if(mysqli_num_rows($query_run) > 0){
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($query_run)){
                            ?>
                            <tr>
                              <td hidden><?php echo $row["id"];?></td>
                              <td><?php echo $no;?></td>
                              <td><?php echo $row["question"];?></td>
                              <td><?php echo $row["correct_answer"];?></td>
                              <td></td>
                              <td>
                                <a href="editquestion.php?id=<?php echo $row["id"];?>" class="btn btn-primary"><i class="bi bi-eye"></i></a>
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
                  </form>
                  

                </div>
                
              </div>
          </div>
        </div>
    </main>

<?php
include('includes/footer.php');
?>

<?php
if (isset($_POST['addquestion'])) {
  // echo '<script type="text/javascript">alert("You cannot proceed")</script>';
  $courseID = mysqli_real_escape_string($con, $_POST["courseID"]);

  $_SESSION['courseID'] = $courseID;

  $query = "SELECT * FROM exams_setting WHERE id = '$courseID' LIMIT 1";
  $query_run = mysqli_query($con, $query);
  if(mysqli_num_rows($query_run) === 1){
       $row = mysqli_fetch_assoc($query_run);
       $_SESSION['id'] = $row['id'];
       $_SESSION['no_of_questions'] = $row['no_of_questions'];
       $_SESSION['course'] = $row['course'];
       $_SESSION['semester'] = $row['semester'];

       echo '<script type="text/javascript">window.location="startexams.php"</script>';
       exit();
  }
}

if (isset($_POST['viewquestion'])) {
  // echo '<script type="text/javascript">alert("You cannot proceed")</script>';
  $courseID = mysqli_real_escape_string($con, $_POST["courseID"]);

  $_SESSION['courseID'] = $courseID;

  $query = "SELECT * FROM exams_setting WHERE id = '$courseID' LIMIT 1";
  $query_run = mysqli_query($con, $query);
  if(mysqli_num_rows($query_run) === 1){
       $row = mysqli_fetch_assoc($query_run);
       $_SESSION['id'] = $row['id'];
       $_SESSION['no_of_questions'] = $row['no_of_questions'];
       $_SESSION['course'] = $row['course'];
       $_SESSION['semester'] = $row['semester'];
       $_SESSION['title'] = $row['title'];

       echo '<script type="text/javascript">window.location="viewquestionpaper.php"</script>';
       exit();
  }
}
?>

<!-- Modal -->
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Incidental Expenses</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="code.php" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Item Name:</label>
            <input type="text" class="form-control" name="itemname">
          </div>
          <div class="mb-3">
            <label class="form-label">Item Amount</label>
            <input type="text" class="form-control" name="itemamount">
          </div>
          <div class="mb-3">
            <label class="form-label">Supporting Pic</label>
            <input type="file" class="form-control" name="pic">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="tripsubmit">Submit Information</button>
        </div>
      </form>
    </div>
  </div>
</div>
 -->
<!-- Modal -->
<!-- <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Recuring Expenses</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="code.php" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Feeding Fee:</label>
            <input type="text" class="form-control" name="feedingfee">
          </div>
          <div class="mb-3">
            <label class="form-label">Fuel Cost per Litre</label>
            <input type="text" class="form-control" name="fuelprice">
          </div>
          <div class="mb-3">
            <label class="form-label">No. of Litres</label>
            <input type="text" class="form-control" name="nooflitres">
          </div>
          <div class="mb-3">
            <label class="form-label">Supporting Pic</label>
            <input type="file" class="form-control" name="pic">
          </div>
          <div class="mb-3">
            <label class="form-label">Daily Remark</label>
            <textarea class="form-control" placeholder="Enter day's remark" name="dailyremark"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="regularexpensessubmit">Submit Information</button>
        </div>
      </form>
    </div>
  </div>
</div> -->

