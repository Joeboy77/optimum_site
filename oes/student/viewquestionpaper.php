<?php
include('includes/header.php');
include('includes/navbar.php');

?> 

  <main class="mt-5 pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 mb-1">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i> View Question Paper</span> 
                <!-- <div class="text-xs font-weight-bold">No. of Rooms: ... </div> -->
                <a href="view.php" class="btn btn-danger"><i class="bi bi-chevron-bar-left me-2"></i>Back</a>
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

          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card-header">
              <div class="d-sm-flex align-items-center justify-content-center mb-2">
                <span style="font-size: 20px;"><b>Course: <?php echo $_SESSION['course']?></b></span>
              </div>
              <div class="d-sm-flex align-items-center justify-content-center mb-1">
                <span style="font-size: 18px;"><b>Exam Title: <?php echo $_SESSION['title']?></b></span>
              </div>
              <div class="d-sm-flex align-items-center justify-content-between">
                <span><b>Semester: <?php echo $_SESSION['semester']?></b></span>
                <span><b>Marks: <?php echo $_SESSION['marks']?></b></span>
                <span><b>No. of Rolls: <?php echo $_SESSION['marks']?></b></span>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <table class="table table-striped table-hover ">
                      <!-- <thead class="table-success">
                        <tr>
                          <th>No.</th>
                          <th hidden>ID.</th>
                          <th>Subject</th>
                          <th>Title</th>
                          <th>Semester</th>
                          <th>Status</th>
                          <th>Date Started</th>
                          <th>Action</th>
                        </tr>
                      </thead> -->
                      <tbody id="data">
                        <?php
                          $query = "SELECT * FROM exams_questions WHERE questionID = '$_SESSION[id]'";
                          $query_run = mysqli_query($con, $query);
                          if(mysqli_num_rows($query_run) > 0){
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query_run)){
                        ?>

                        <tr>

                          <td>
                            <div class="row">
                              <div class="d-flex">
                                <div class="col-md-1"><?php echo $no;?></div>
                                <div class="col-md-10">
                                  <div class="row">
                                    <span><b>Question:</b></span> <?php echo $row["question"];?>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-11 img"></div>
                                  </div>
                                  <div class="row">
                                    <span>A. <?php echo $row["option1"];?></span>
                                    <span>B. <?php echo $row["option2"];?></span>
                                    <span>C. <?php echo $row["option3"];?></span>
                                    <span>D. <?php echo $row["option4"];?></span>
                                  </div>
                                </div>
                                <div class="col-md-1">
                                  Marks: <?php echo $row["marks"];?>
                                </div>
                              </div>
                              <hr>
                              <div class="container">
                                <div class="row">
                                  <span><b>Answer:</b> <?php echo $row["correct_answer"];?></span>
                                </div>
                              </div>
                              
                            </div>
                          </td>
                          <!--  -->
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
        <!-- <div class="row">
          div
        </div> -->
        
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
        <h5 class="modal-title" id="exampleModalLabel">Update Clearing Entry</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="editclearing.php" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Type of Load</label>
            <input type="hidden" class="form-control" name="id" value="<?php echo $row['id']?>">
            <input type="text" class="form-control" name="loadtype" value="<?php echo $row['loadtype']?>" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Price Per Acre</label>
            <input type="text" class="form-control" name="loadprice" value="<?php echo $row['loadprice'];?>">
          </div>
          <div class="mb-3">
            <label class="form-label">No. of Acres</label>
            <input type="text" class="form-control" name="noofload" value="<?php echo $row['noofload'];?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="update">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
if (isset($_POST["update"])) {
  // code...
  $id = mysqli_real_escape_string($con, $_POST["id"]);
  $loadtype = mysqli_real_escape_string($con, $_POST["loadtype"]);
  $loadprice = mysqli_real_escape_string($con, $_POST["loadprice"]);
  $noofload = mysqli_real_escape_string($con, $_POST["noofload"]);
  $loadtotalamount = $loadprice * $noofload;

  // if (empty($reason)) {
  //     $_SESSION['status'] = "Please Enter Reason for Update";
  //     echo '<script type="text/javascript">window.location="edittripentry.php"</script>';
  //     exit();
  // }

  $query = "UPDATE loaderinformation SET loadtype='$loadtype', loadprice='$loadprice', noofload='$noofload', loadtotalamount='$loadtotalamount', update_approve='Yes' WHERE id = '$id'";
  $query_run = mysqli_query($con, $query);
  if ($query_run) {
      $_SESSION['success'] = "Success!! Information Updated Successfully";
      echo '<script type="text/javascript">window.location="clearing.php"</script>';
      exit();
  }else{
      $_SESSION['status'] = "Error!! Information not Updated Successfully";
      echo '<script type="text/javascript">window.location="editclearing.php"</script>';
      exit();
  }
}
?>

