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

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i>School File Attachment</span> 
                <div class="text-xs font-weight-bold">
                  <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i>
                    Add School File
                  </button>
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
                          <th>File Title</th>
                          <th>File Attachment</th>
                          <th class="no-sort" style="width: 160px;">Actions</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          $query = "SELECT * FROM files_upload";
                          $query_run = mysqli_query($con, $query);
                          if(mysqli_num_rows($query_run) > 0){
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query_run)){
                              $path = $row['file_attachment'];
                              // Normalize legacy path values stored with ../ prefix
                              if (strpos($path, '../') === 0) {
                                // Try to map to project root relative path
                                $path = substr($path, 3); // remove ../
                                $path = 'oes/admin/' . ltrim($path, '/');
                              }
                              $ext = strtoupper(pathinfo($path, PATHINFO_EXTENSION));
                        ?>
                        <tr>
                          <td hidden><?php echo $row["id"];?></td>
                          <td><?php echo $no;?></td>
                          <td class="text-start"><?php echo $row["file_title"];?></td>
                          <td>
                            <span class="badge bg-secondary"><?php echo $ext ? $ext : 'FILE';?></span>
                            <span class="ms-2 text-muted small"><?php echo basename($path);?></span>
                          </td>
                          <td>
                            <a href="/<?php echo htmlspecialchars($path);?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary btn-sm me-1" title="View"><i class="bi bi-eye"></i></a>
                            <a href="/<?php echo htmlspecialchars($path);?>" download class="btn btn-outline-secondary btn-sm" title="Download"><i class="bi bi-download"></i></a>
                          </td>
                        </tr>
                        <?php
                        $no++;
                        }
                      }else{
                        echo "<tr><td hidden></td><td colspan='4' class='text-center py-3'>No files found</td></tr>";
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
        <h5 class="modal-title" id="exampleModalLabel">Add School File</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <label class="form-label">File Name</label>
                <input type="text" class="form-control" name="program_name">
              </div>
            </div>

            <div class="col-12">
              <div class="mb-2">
                <label class="form-label">File Attachment</label>
                <input type="file" class="form-control" name="lessonpic" required>
                <div class="form-text">Allowed types: pdf, doc, docx, xls, xlsx, ppt, pptx (max 18MB)</div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="tripsubmit">Add School File</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
if (isset($_POST["tripsubmit"])) {
  $program_name = mysqli_real_escape_string($con, $_POST["program_name"]);

  if (empty($program_name)) {
      $_SESSION['status'] = "File Name should not be empty";
      echo '<script type="text/javascript">window.location="schoolfiles.php"</script>';
      exit();
  }

  $filename = $_FILES["lessonpic"]["name"];
  $tempname = $_FILES["lessonpic"]["tmp_name"];
  $filesize = $_FILES["lessonpic"]["size"];
  $filError = $_FILES["lessonpic"]["error"];
  $fileExt = explode('.', $filename);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array('doc','docx','pdf','xls','xlsx','ppt','pptx');
  if(in_array($fileActualExt, $allowed)){
    if($filError === 0){
      if($filesize < 18000000){
        // Shared uploads directory at project root: /uploads/schoolfiles/
        $root = dirname(dirname(__DIR__)); // project root
        $uploadDir = $root . '/uploads/schoolfiles/';
        if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0775, true); }
        $safeName = preg_replace('/[^A-Za-z0-9_\.-]/', '_', $filename);
        $targetPath = $uploadDir . $safeName;
        $webPath = 'uploads/schoolfiles/' . $safeName; // path saved in DB and used in href (prefixed with /)
        if (!move_uploaded_file($tempname, $targetPath)) {
          $_SESSION['status'] = "Error!! Could not save uploaded file.";
          echo '<script type="text/javascript">window.location="schoolfiles.php"</script>';
          exit();
        }
      } else {
        $_SESSION['status'] = "Error!! Your file is too big.";
        echo '<script type="text/javascript">window.location="schoolfiles.php"</script>';
        exit();
      }
    } else {
      $_SESSION['status'] = "Error!! There was an error uploading this file.";
      echo '<script type="text/javascript">window.location="schoolfiles.php"</script>';
      exit();
    }
  } else {
    $_SESSION['status'] = "Error!! You cannot upload files of this type Here!.";
    echo '<script type="text/javascript">window.location="schoolfiles.php"</script>';
    exit();
  }

  $query = "SELECT * FROM files_upload WHERE file_title = '$program_name' LIMIT 1";
  $query_run = mysqli_query($con, $query);
  if(mysqli_num_rows($query_run) <= 0){
      $query = "INSERT INTO files_upload (file_title, file_attachment) VALUES ('$program_name', '$webPath')";
      $query_run = mysqli_query($con, $query);
      if ($query_run) {
           $_SESSION['success'] = "Success!! File Uploaded Successfully";
           echo '<script type="text/javascript">window.location="schoolfiles.php"</script>';
           exit();
      }else{
          $_SESSION['status'] = "Error!! File not Uploaded";
          echo '<script type="text/javascript">window.location="schoolfiles.php"</script>';
          exit();
      }
  } else{
    $_SESSION['status'] = "Error!! File Title exist already";
    echo '<script type="text/javascript">window.location="schoolfiles.php"</script>';
    exit();
  }
}
?>