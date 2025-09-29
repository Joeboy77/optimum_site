<?php
include('includes/header.php');
include('includes/navbar.php');

?> 

  <main class="mt-5 pt-3">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i> View Question</span> 
                <!-- <div class="text-xs font-weight-bold">No. of Rooms: ... </div> -->
                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i> Edit</button>
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
                $sql = "SELECT * FROM exams_questions WHERE id = '$_GET[id]'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($result);
              ?>
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col-md-8">
                    <form action="" method="POST">
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Question No:</label>
                          <div class="col-sm-9">
                          <input type="text" name="questionno" class="form-control" value="<?php echo $row['question_no'];?>" readonly>
                          </div>
                      </div>
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Question:</label>
                          <div class="col-sm-9">
                            <textarea name="question" class="form-control" id="editor"><?php echo $row['question'];?></textarea>
                          </div>
                      </div>
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Upload Pic (Opt):</label>
                          <div class="col-sm-9">
                          <input type="file" name="pic" class="form-control" value="">
                          </div>
                      </div>
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Option a</label>
                          <div class="col-sm-9">
                          <input type="text" name="optionA" class="form-control" value="<?php echo $row['option1'];?>">
                          </div>
                      </div>
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Option b</label>
                          <div class="col-sm-9">
                          <input type="text" name="optionB" class="form-control" value="<?php echo $row['option2'];?>">
                          </div>
                      </div>
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Option c</label>
                          <div class="col-sm-9">
                          <input type="text" name="optionC" class="form-control" value="<?php echo $row['option3'];?>">
                          </div>
                      </div>
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Option d</label>
                          <div class="col-sm-9">
                          <input type="text" name="optionD" class="form-control" value="<?php echo $row['option4'];?>">
                          </div>
                      </div>
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Correct Answer</label>
                          <div class="col-sm-9">
                          <select class="form-control" name="correct">
                            <option value="<?php echo $row['correct_answer'];?>"><?php echo $row['correct_answer'];?></option>
                            <option value="a">a</option>
                            <option value="b">b</option>
                            <option value="c">c</option>
                            <option value="d">d</option>
                          </select>
                          </div>
                      </div>
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Reason</label>
                          <div class="col-sm-9">
                            <textarea name="reason" class="form-control" id="editor1"><?php echo $row['reason'];?></textarea>
                          </div>
                      </div>
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Marks</label>
                          <div class="col-sm-9">
                          <input type="text" name="mark" class="form-control" value="<?php echo $row['marks'];?>">
                          </div>
                      </div>
                      <hr>
                      <!-- <div class="row-flex text-center">
                        <button type="reset" name="reset" class="btn btn-primary col-md-4">Reset</button>
                        <button type="submit" name="submit" class="btn btn-success col-md-4">Submit</button>
                      </div> -->
                    </form>
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-body">
                        <div class="col-12">
                          <a href="view.php" class="btn btn-danger" type="submit"><i class="bi bi-chevron-bar-left me-2"></i>Back</a>
                          <!-- <button class="btn btn-success" type="submit" name="update">Update</button> -->
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Incidental Expenses</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="editirregularexpenses.php" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Item Name:</label>
            <input type="hidden" class="form-control" name="id" value="<?php echo $row['id']?>">
            <input type="text" class="form-control" name="itemname" value="<?php echo $row['itemname']?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Item Amount</label>
            <input type="text" class="form-control" name="itemamount" value="<?php echo $row['itemamount'];?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Supporting Pic</label>
            <input type="file" class="form-control" name="pic">
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
  $itemname = mysqli_real_escape_string($con, $_POST["itemname"]);
  $itemamount = mysqli_real_escape_string($con, $_POST["itemamount"]);

  if (empty($itemname)) {
      $_SESSION['status'] = "Please Enter Item Name";
      echo '<script type="text/javascript">window.location="editirregularexpenses.php"</script>';
      exit();
  }

  if (empty($itemamount)) {
      $_SESSION['status'] = "Please Enter Item Amount";
      echo '<script type="text/javascript">window.location="editirregularexpenses.php"</script>';
      exit();
  }

  if (isset($_FILES['pic']['name'])) {
      // code...
    //Script for selecting image
    $filename = $_FILES["pic"]["name"];
      $tempname = $_FILES["pic"]["tmp_name"];
      $filesize = $_FILES["pic"]["size"];
      $filetype = $_FILES["pic"]["type"];
      $filError = $_FILES["pic"]["error"];
      //Code to restrict the type of file to upload
      $fileExt = explode('.', $filename);
      $fileActualExt = strtolower(end($fileExt));

      $allowed = array('jpg', 'jpeg', 'png', 'gif');
      if(in_array($fileActualExt, $allowed)){
          if($filError === 0){
          //Checking the filesize
            if($filesize < 18000000){
              $folder = "images/".$filename;
                move_uploaded_file($tempname, $folder);
          } else {
            $_SESSION['status'] = "Error!! Your file is too big.";
            echo '<script type="text/javascript">window.location="editirregularexpenses.php"</script>';
            exit();
                  }
      } else {
        $_SESSION['status'] = "Error!! There was an error uploading this file.";
        echo '<script type="text/javascript">window.location="editirregularexpenses.php"</script>';
        exit();
        }
      } else {
        $query = "UPDATE tripirregularexpenses SET itemname='$itemname', itemamount='$itemamount' WHERE id = '$id'";
        $query_run = mysqli_query($con, $query);
        if ($query_run) {
            $_SESSION['success'] = "Success!! Information Updated Successfully";
            echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
            exit();
        }else{
            $_SESSION['status'] = "Error!! Information not Updated Successfully";
            echo '<script type="text/javascript">window.location="editirregularexpenses.php"</script>';
            exit();
        }
      }

    $query = "UPDATE tripirregularexpenses SET itemname='$itemname', itemamount='$itemamount', itemimage='$folder' WHERE id = '$id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['success'] = "Success!! Information Updated Successfully";
        echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
        exit();
    }else{
        $_SESSION['status'] = "Error!! Information not Updated Successfully";
        echo '<script type="text/javascript">window.location="editirregularexpenses.php"</script>';
        exit();
    }

  }
  
}
?>

