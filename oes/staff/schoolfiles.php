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
                         <!-- <table class="table table-striped table-hover text-center">
                          <thead class="table-success">
                            <tr>
                              <th>S. No.</th>
                              <th>File Name</th>
                              <th>File Attached</th>
                              <th>View</th>
                            </tr>
                          </thead>
                          <tbody id="data">
                            <tr>
                              <td>1</td>
                              <td><p>Code of Conduct For Student</p></td>
                              <td><iframe src="images/Optimum Training Institute Code of Conduct for Staff and Students.pdf" style="width: 60px; height: 40px;"></iframe></td>
                              <td>
                                <a href="images/Optimum Training Institute Code of Conduct for Staff and Students.pdf" target="_blank" rel="noopener noreferrer" class="btn btn-primary"><i class="bi bi-eye"></i></a>
                              </td>
                            </tr>
                            <tr>
                              <td>2</td>
                              <td><p>ICT lab Guidelines</p></td>
                              <td><iframe src="images/ICT LAB GUIDELINES.pdf" style="width: 60px; height: 40px;"></iframe></td>
                              <td>
                                <a href="images/ICT LAB GUIDELINES.pdf" target="_blank" rel="noopener noreferrer" class="btn btn-primary"><i class="bi bi-eye"></i></a>
                              </td>
                            </tr>
                            <tr>
                              <td>3</td>
                              <td><p>Time Table</p></td>
                              <td><iframe src="images/Optimum Time Table.pdf" style="width: 60px; height: 40px;"></iframe></td>
                              <td>
                                <a href="images/Optimum Time Table.pdf" target="_blank" rel="noopener noreferrer" class="btn btn-primary"><i class="bi bi-eye"></i></a>
                              </td>
                            </tr>
                          </tbody>
                        </table> -->

                        <table id="example" class="table table-striped table-hover align-middle">
                      <thead class="table-success">
                        <tr>
                          <th hidden>#</th>
                          <th style="width: 70px;">#</th>
                          <th class="text-start">File Title</th>
                          <th style="width: 100px;">Type</th>
                          <th style="width: 140px;">Size</th>
                          <th style="width: 180px;">Actions</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          $query = "SELECT * FROM files_upload";
                          $query_run = mysqli_query($con, $query);
                          if(mysqli_num_rows($query_run) > 0){
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query_run)){
                        ?>
                        <tr>
                          <td hidden><?php echo (int)$row['id'];?></td>
                          <td><?php echo $no;?></td>
                          <td class="text-start"><?php echo htmlspecialchars($row['file_title']);?></td>
                          <td><?php echo pathinfo($row['file_attachment'], PATHINFO_EXTENSION); ?></td>
                          <td>
                            <?php
                              $filePath = dirname(__DIR__) . '/../images/' . $row['file_attachment'];
                              if (file_exists($filePath)) {
                                $sizeKb = round(filesize($filePath) / 1024, 2);
                                echo $sizeKb . ' KB';
                              } else {
                                echo 'Unavailable';
                              }
                            ?>
                          </td>
                          <td>
                            <a href="../images/<?php echo rawurlencode($row['file_attachment']);?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-primary me-1" title="View">
                              <i class="bi bi-eye"></i>
                            </a>
                            <a href="../images/<?php echo rawurlencode($row['file_attachment']);?>" download class="btn btn-sm btn-success" title="Download">
                              <i class="bi bi-download"></i>
                            </a>
                          </td>
                        </tr>
                        <?php
                        $no++;
                        }
                      } else {
                        // Let DataTables handle empty state
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

