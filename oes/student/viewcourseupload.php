<?php
include('includes/header.php');
include('includes/navbar.php');

?> 

  <main class="mt-5 pt-3">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i> Course Lesson Upload</span> 
                <!-- <div class="text-xs font-weight-bold">No. of Rooms: ... </div> -->
                <!-- <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i> Take a Test</button> -->
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
                $sql = "SELECT * FROM lesson_upload WHERE id = '$_GET[id]'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($result);
              ?>
              <div class="card-body">
                <!-- <h3 class="text-danger text-center" id="para">Not Found</h3> -->
                <div class="row">
                  <div>
                    <div class="card shadow h-100 py-2">
                      <!-- <div class="card-header">
                        <h5 class="text-xs font-weight-bold text-primary text-uppercase">Load Details</h5>
                      </div> -->
                      <div class="card-body">
                        <div>
                          <div class="row mb-2">
                            <div class="col-2">Lesson Title</div>
                            <div class="col-10">
                              <input type="text" class="form-control" name="lesson_title" value="<?php echo $row['lesson_title']?>" readonly>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-2">Lesson Note</div>
                            <div class="col-10">
                              <textarea class="form-control" name="lesson_note" readonly><?php echo $row['lesson_note'];?></textarea>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <iframe src="../staff/<?php echo $row["lesson_file"];?>" style="width: 100%; height: min(400px, 1000px);"></iframe>
                            <!-- <div class="col-4">No. of Load</div>
                            <div class="col-8"><input type="number" class="form-control" name="noofload" value="<?php echo $row['noofload'];?>" readonly></div> -->
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
                          <a href="courseupload.php" class="btn btn-danger" type="submit">Back</a>
                          <!-- <button class="btn btn-success" type="submit" name="update">Update</button> -->
                        </div>
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
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Lesson Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="viewuploadlesson.php" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Lesson Title</label>
            <input type="hidden" class="form-control" name="id" value="<?php echo $row['id']?>">
            <input type="text" class="form-control" name="lesson_title" value="<?php echo $row['lesson_title']?>">            
          </div>
          <div class="mb-3">
            <label class="form-label">Lesson Note</label>
            <textarea class="form-control" name="lesson_note"><?php echo $row['lesson_note'];?></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">File Upload</label>
            <input type="file" class="form-control" name="lessonpic" value="<?php echo $row['noofload'];?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="update">Update</button>
        </div>
      </form>
    </div>
  </div>
</div> -->

<?php
// if (isset($_POST["update"])) {
//   // code...
//   $id = mysqli_real_escape_string($con, $_POST["id"]);
//   $lesson_title = mysqli_real_escape_string($con, $_POST["lesson_title"]);
//   $lesson_note = mysqli_real_escape_string($con, $_POST["lesson_note"]);
//   $lessonpic = mysqli_real_escape_string($con, $_POST["lessonpic"]);

//   if (empty($lesson_title)) {
//       $_SESSION['status'] = "Lesson Title Should Not Be Empty";
//       echo '<script type="text/javascript">window.location="viewuploadlesson.php"</script>';
//       exit();
//   }elseif (empty($lesson_note)) {
//     $_SESSION['status'] = "Lesson Note Should Not Be Empty";
//       echo '<script type="text/javascript">window.location="viewuploadlesson.php"</script>';
//       exit();
//   }

//   if (empty($lessonpic)) {
//     $query = "UPDATE lesson_upload SET lesson_title='$lesson_title', lesson_note='$lesson_note' WHERE id = '$id'";
//     $query_run = mysqli_query($con, $query);
//       $_SESSION['success'] = "Success!! Information Updated Successfully";
//       echo '<script type="text/javascript">window.location="uploadlesson.php"</script>';
//       exit();
//   }else{
//     //Script for selecting image
//     $filename = $_FILES["lessonpic"]["name"];
//       $tempname = $_FILES["lessonpic"]["tmp_name"];
//       $filesize = $_FILES["lessonpic"]["size"];
//       $filetype = $_FILES["lessonpic"]["type"];
//       $filError = $_FILES["lessonpic"]["error"];
//       //Code to restrict the type of file to upload
//       $fileExt = explode('.', $filename);
//       $fileActualExt = strtolower(end($fileExt));

//       $allowed = array('docs', 'docx', 'pdf', 'xlsx', 'pptx');
//       if(in_array($fileActualExt, $allowed)){
//           if($filError === 0){
//           //Checking the filesize
//             if($filesize < 18000000){
//               $folder = "images/".$filename;
//                 move_uploaded_file($tempname, $folder);
//           } else {
//             $_SESSION['status'] = "Error!! Your file is too big.";
//             echo '<script type="text/javascript">window.location="viewuploadlesson.php"</script>';
//             exit();
//                   }
//       } else {
//         $_SESSION['status'] = "Error!! There was an error uploading this file.";
//         echo '<script type="text/javascript">window.location="viewuploadlesson.php"</script>';
//         exit();
//         }
//       } else {
//         $_SESSION['status'] = "Error!! You cannot upload files of this type Here!.";
//         echo '<script type="text/javascript">window.location="viewuploadlesson.php"</script>';
//         exit();
//       }
//   }

//   $query = "UPDATE lesson_upload SET lesson_title='$lesson_title', lesson_note='$lesson_note', lesson_file = '$folder' WHERE id = '$id'";
//   $query_run = mysqli_query($con, $query);
//   if ($query_run) {
//       $_SESSION['success'] = "Success!! Information Updated Successfully";
//       echo '<script type="text/javascript">window.location="uploadlesson.php"</script>';
//       exit();
//   }else{
//       $_SESSION['status'] = "Error!! Information not Updated Successfully";
//       echo '<script type="text/javascript">window.location="viewuploadlesson.php"</script>';
//       exit();
//   }
// }
?>

