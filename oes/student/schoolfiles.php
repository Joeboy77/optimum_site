<?php
include('includes/header.php');
include('includes/navbar.php');

?> 

  <main class="mt-5 pt-3">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i> School Files</span> 
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

              <div class="card-body">
                <!-- <h3 class="text-danger text-center" id="para">Not Found</h3> -->
                <div class="row">
                  <div>
                    <div class="card shadow h-100 py-2">
                      <!-- <div class="card-header">
                        <h5 class="text-xs font-weight-bold text-primary text-uppercase">Load Details</h5>
                      </div> -->
                      <h5 class="text-center text-xs font-weight-bold text-danger">School Files must be downloaded and read by all Students and Staffs</h5>
                      <div class="card-body">
                    <div>
                    <table id="example" class="table table-striped table-hover text-center">
                      <thead class="table-success">
                        <tr>
                          <th hidden>S. No.</th>
                          <th>S. No.</th>
                          <th>File Title</th>
                          <th>Type</th>
                          <th>Size</th>
                          <th class="no-sort" style="width: 140px;">Actions</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          $query = "SELECT * FROM files_upload";
                          $query_run = mysqli_query($con, $query);
                          if($query_run && mysqli_num_rows($query_run) > 0){
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query_run)){
                              $fileName = $row['file_attachment'];
                              $webPath = '../images/' . $fileName; // web-relative path
                              $fsPath = __DIR__ . '/../images/' . $fileName; // filesystem path
                              $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                              $type = strtoupper($ext ?: 'FILE');
                              $size = file_exists($fsPath) ? filesize($fsPath) : 0;
                              // Human readable size
                              $sizeText = $size > 0 ? ( $size >= 1048576 ? round($size/1048576,2) . ' MB' : ($size >= 1024 ? round($size/1024,2) . ' KB' : $size . ' B') ) : '—';
                        ?>
                        <tr>
                          <td hidden><?php echo $row["id"];?></td>
                          <td><?php echo $no;?></td>
                          <td><?php echo $row["file_title"];?></td>
                          <td><?php echo $type; ?></td>
                          <td><?php echo $sizeText; ?></td>
                          <td>
                            <a href="<?php echo $webPath; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-primary me-1" title="View">
                              <i class="bi bi-eye"></i>
                            </a>
                            <a href="<?php echo $webPath; ?>" download class="btn btn-sm btn-success" title="Download">
                              <i class="bi bi-download"></i>
                            </a>
                          </td>
                        </tr>
                        <?php
                        $no++;
                        }
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

        
      </div>
    </main>

<?php
include('includes/footer.php');
?>

