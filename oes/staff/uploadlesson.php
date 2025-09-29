<?php
include('includes/header.php');
include('includes/navbar.php');

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
                <span><i class="bi bi-table me-2"></i>Lesson Note</span> 
                <div class="text-xs font-weight-bold">
                  <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i>
                    Upload Lesson Note
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <table id="example" class="table table-striped table-hover align-middle">
                      <thead class="table-success">
                        <tr>
                          <th hidden>#</th>
                          <th style="width: 70px;">#</th>
                          <th>Program</th>
                          <th>Class</th>
                          <th class="text-start">Title</th>
                          <th class="text-start">Note</th>
                          <th style="width: 90px;">Type</th>
                          <th style="width: 120px;">Size</th>
                          <th style="width: 180px;">Actions</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          $query = "SELECT * FROM lesson_upload WHERE staffID = '$_SESSION[schoolID]'";
                          $query_run = mysqli_query($con, $query);
                          if(mysqli_num_rows($query_run) > 0){
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query_run)){
                        ?>
                        <tr>
                          <td hidden><?php echo (int)$row['id']; ?></td>
                          <td><?php echo $no; ?></td>
                          <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                          <td><?php echo htmlspecialchars($row['lesson_class']); ?></td>
                          <td class="text-start">&nbsp;<?php echo htmlspecialchars($row['lesson_title']); ?></td>
                          <td class="text-start">&nbsp;<?php echo htmlspecialchars($row['lesson_note']); ?></td>
                          <td><?php echo pathinfo($row['lesson_file'], PATHINFO_EXTENSION); ?></td>
                          <td>
                            <?php
                              $fsPath = __DIR__ . '/' . $row['lesson_file'];
                              if (file_exists($fsPath)) {
                                echo round(filesize($fsPath) / 1024, 2) . ' KB';
                              } else {
                                echo 'Unavailable';
                              }
                            ?>
                          </td>
                          <td>
                            <a href="<?php echo htmlspecialchars($row['lesson_file']);?>" target="_blank" class="btn btn-sm btn-outline-primary me-1" title="View">
                              <i class="bi bi-eye"></i>
                            </a>
                            <a href="<?php echo htmlspecialchars($row['lesson_file']);?>" download class="btn btn-sm btn-success" title="Download">
                              <i class="bi bi-download"></i>
                            </a>
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
        <h5 class="modal-title" id="exampleModalLabel">Lesson Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <label class="form-label">Select Class</label>
                <select class="form-control" name="lessonclass">
                    <option value="Please Select">Please Select</option>
                    <?php
                    // $res = mysqli_query($con, "SELECT * FROM programtype ORDER BY name ASC");
                    $res = mysqli_query($con, "SELECT * FROM tutorclass WHERE staffID = '$_SESSION[schoolID]'");
                    while ($row= mysqli_fetch_array($res)){
                        ?>
                    <option value="<?php echo $row['classname'];?>"><?php echo $row["classname"];?></option>
                    <?php
                    }
                    ?>
                </select>
              </div>
            </div>
            <div class="col-12">
              <div class="mb-2">
                <label class="form-label">Lesson Title:</label>
                <input type="text" class="form-control" name="lessontitle" required>
              </div>
            </div>
            <div class="col-12">
              <div class="mb-2">
                <label class="form-label">Lesson Note:</label>
                <textarea class="form-control" name="lessonnote" required></textarea>
              </div>
            </div>
            <div class="col-12">
              <div class="mb-2">
                <label class="form-label">Upload File:</label>
                <input type="file" class="form-control" name="lessonpic" required>
              </div>
            </div>
            
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="tripsubmit">Add Lesson</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
if (isset($_POST["tripsubmit"])) {
  // code...
  $lessonclass = mysqli_real_escape_string($con, $_POST["lessonclass"]);
  $lessontitle = mysqli_real_escape_string($con, $_POST["lessontitle"]);
  $lessonnote = mysqli_real_escape_string($con, $_POST["lessonnote"]);
  // $lessonpic = mysqli_real_escape_string($con, $_POST["lessonpic"]);

  //Code for validation
    if ($lessonclass === "Please Select") {
        $_SESSION['status'] = "Please Class not Selected";
        echo '<script type="text/javascript">window.location="uploadlesson.php"</script>';
        exit();
    }

    //Script for selecting image
    $filename = $_FILES["lessonpic"]["name"];
      $tempname = $_FILES["lessonpic"]["tmp_name"];
      $filesize = $_FILES["lessonpic"]["size"];
      $filetype = $_FILES["lessonpic"]["type"];
      $filError = $_FILES["lessonpic"]["error"];
      //Code to restrict the type of file to upload
      $fileExt = explode('.', $filename);
      $fileActualExt = strtolower(end($fileExt));

      $allowed = array('doc', 'docx', 'pdf', 'xls', 'xlsx', 'ppt', 'pptx');
      if(in_array($fileActualExt, $allowed)){
          if($filError === 0){
          //Checking the filesize
            if($filesize < 18000000){
              // Ensure uploads directory exists
              $baseDir = __DIR__ . '/images/uploads/lessons';
              if (!is_dir($baseDir)) { @mkdir($baseDir, 0775, true); }
              $safeName = preg_replace('/[^A-Za-z0-9_\.-]/', '_', $filename);
              $uniqueName = date('Ymd_His') . '_' . $safeName;
              $targetFs = $baseDir . '/' . $uniqueName;
              if (!move_uploaded_file($tempname, $targetFs)) {
                $_SESSION['status'] = "Error!! Could not move uploaded file.";
                echo '<script type="text/javascript">window.location="uploadlesson.php"</script>';
                exit();
              }
              // Web path relative to this script for linking
              $folder = 'images/uploads/lessons/' . $uniqueName;
          } else {
            $_SESSION['status'] = "Error!! Your file is too big.";
            echo '<script type="text/javascript">window.location="uploadlesson.php"</script>';
            exit();
                  }
      } else {
        $_SESSION['status'] = "Error!! There was an error uploading this file.";
        echo '<script type="text/javascript">window.location="uploadlesson.php"</script>';
        exit();
        }
      } else {
        $_SESSION['status'] = "Error!! You cannot upload files of this type Here!.";
        echo '<script type="text/javascript">window.location="uploadlesson.php"</script>';
        exit();
      }

      // Selecting to get the course name
      $query = "SELECT * FROM tutorclass WHERE classname = '$lessonclass' AND staffID = '$_SESSION[schoolID]' LIMIT 1";
      $query_run = mysqli_query($con, $query);
      if(mysqli_num_rows($query_run) > 0){
        $row = mysqli_fetch_assoc($query_run);
        $_SESSION['course_code'] = $row["course_code"];
        $_SESSION['staff_name'] = $row["staff_name"];
        if ($query_run) {
          $query = "INSERT INTO lesson_upload (course_name, lesson_class, lesson_title, lesson_note, lesson_file, staffID, staff_name) VALUES ('$_SESSION[course_code]', '$lessonclass', '$lessontitle', '$lessonnote', '$folder', '$_SESSION[schoolID]', '$_SESSION[staff_name]')";
          $query_run = mysqli_query($con, $query);
          if ($query_run) {
               $_SESSION['success'] = "Success!! Lesson Uploaded Successfully";
               echo '<script type="text/javascript">window.location="uploadlesson.php"</script>';
               exit();
          }else{
              $_SESSION['status'] = "Error!! Lesson not Uploaded";
              echo '<script type="text/javascript">window.location="uploadlesson.php"</script>';
              exit();
          }
        }
      }

      
    
}
?>
