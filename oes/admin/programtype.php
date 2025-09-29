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
        <!-- Page Header -->
        <div class="row mb-3">
          <div class="col-12 d-flex align-items-center justify-content-between">
            <div>
              <h4 class="mb-0">Programs</h4>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Programs</li>
                </ol>
              </nav>
            </div>
            <div>
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus-lg me-1"></i>Add Program</button>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-sm-flex align-items-center justify-content-between">
                  <span class="fw-semibold"><i class="bi bi-table me-2"></i>Create Program</span> 
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
                              <th>Program Name</th>
                              <th>Cost</th>
                              <th class="no-sort" style="width: 120px;">Actions</th>
                            </tr>
                          </thead>
                          <tbody id="data">
                            <?php
                              $query = "SELECT * FROM programtype";
                              $query_run = mysqli_query($con, $query);
                              if(mysqli_num_rows($query_run) > 0){
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($query_run)){
                            ?>
                            <tr>
                              <td class="d-none"><?php echo $row["id"];?></td>
                              <td><?php echo $no;?></td>
                              <td class="text-start">
                                <span class="fw-semibold"><?php echo $row["program"];?></span>
                              </td>
                              <td>
                                <span class="text-dark">Gh&cent; <?php echo number_format($row["cost"], 2);?></span>
                              </td>
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
                                    <h5 class="modal-title" id="editModalLabel<?php echo $row['id']; ?>">Edit Program</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form action="" method="POST">
                                    <div class="modal-body">
                                      <input type="hidden" name="program_id" value="<?php echo $row['id']; ?>">
                                      <div class="mb-2">
                                        <label class="form-label">Program Name</label>
                                        <input type="text" class="form-control" name="program_name" value="<?php echo htmlspecialchars($row['program']); ?>" placeholder="e.g. Software Engineering" required>
                                        <div class="form-text">Give the program a clear, descriptive name.</div>
                                      </div>
                                      <div class="mb-2">
                                        <label class="form-label">Cost (Gh&cent;)</label>
                                        <input type="number" step="0.01" class="form-control" name="cost" value="<?php echo htmlspecialchars($row['cost']); ?>" placeholder="e.g. 2500.00" required>
                                        <div class="form-text">Enter total fee for the program.</div>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary" name="update_program">Save Changes</button>
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
                                    <h5 class="modal-title" id="deleteModalLabel<?php echo $row['id']; ?>">Delete Program</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form action="" method="POST">
                                    <div class="modal-body">
                                      <input type="hidden" name="program_id" value="<?php echo $row['id']; ?>">
                                      <p>Are you sure you want to delete <strong><?php echo htmlspecialchars($row['program']); ?></strong>? This action cannot be undone.</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <button type="submit" class="btn btn-danger" name="delete_program">Yes, Delete</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>

                            <?php
                            $no++;
                            }
                          }else{
                            echo "<tr><td class='d-none'></td><td colspan='4' class='text-center py-4'>No programs found. Click <span class=\"fw-semibold\">Add Program</span> to create your first one.</td></tr>";
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

<!-- Add Program Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Program</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="POST">
      <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <label class="form-label">Program Name</label>
                <input type="text" class="form-control" name="program_name" placeholder="e.g. Graphic / Web Design" required>
                <div class="form-text">Give the program a clear, descriptive name.</div>
              </div>
            </div>
            <div class="col-12">
              <div class="mb-2">
                <label class="form-label">Cost (Gh&cent;)</label>
                <input type="number" step="0.01" class="form-control" name="cost" placeholder="e.g. 1500.00" required>
                <div class="form-text">Enter total fee for the program.</div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="tripsubmit">Add Program</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
if (isset($_POST["tripsubmit"])) {
  // code...
  $program_name = mysqli_real_escape_string($con, $_POST["program_name"]);
  $cost = mysqli_real_escape_string($con, $_POST["cost"]);

  //Code for validation
    if (empty($program_name)) {
        $_SESSION['status'] = "Please Enter Program Name";
        echo '<script type="text/javascript">window.location="programtype.php"</script>';
        exit();
    }
    if (empty($cost)) {
        $_SESSION['status'] = "Please Enter Cost of Program";
        echo '<script type="text/javascript">window.location="programtype.php"</script>';
        exit();
    }

    $query = "SELECT * FROM programtype WHERE program = '$program_name' AND cost = '$cost' LIMIT 1";
    $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run) === 1){
      $_SESSION['status'] = "Error!! Program Name entered exist already";
      echo '<script type="text/javascript">window.location="programtype.php"</script>';
      exit();
    }else{
      $query = "INSERT INTO programtype (program, cost) VALUES ('$program_name', '$cost')";
      $query_run = mysqli_query($con, $query);
      if ($query_run) {
          $_SESSION['success'] = "Success!! Information Saved Successfully";
          echo '<script type="text/javascript">window.location="programtype.php"</script>';
          exit();
      }else{
          $_SESSION['status'] = "Error!! Information not Saved Successfully";
          echo '<script type="text/javascript">window.location="programtype.php"</script>';
          exit();
      }
    }
}

// Update Program
if (isset($_POST['update_program'])) {
    $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
    $program_name = mysqli_real_escape_string($con, $_POST['program_name']);
    $cost = mysqli_real_escape_string($con, $_POST['cost']);

    if (empty($program_name)) {
        $_SESSION['status'] = "Please Enter Program Name";
        echo '<script type="text/javascript">window.location="programtype.php"</script>';
        exit();
    }
    if ($cost === '' || !is_numeric($cost)) {
        $_SESSION['status'] = "Please Enter Cost of Program";
        echo '<script type="text/javascript">window.location="programtype.php"</script>';
        exit();
    }

    $check = mysqli_query($con, "SELECT id FROM programtype WHERE program = '$program_name' AND cost = '$cost' AND id != '$program_id' LIMIT 1");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['status'] = "Another program with same name and cost exists";
        echo '<script type="text/javascript">window.location="programtype.php"</script>';
        exit();
    }

    $update = mysqli_query($con, "UPDATE programtype SET program = '$program_name', cost = '$cost' WHERE id = '$program_id' LIMIT 1");
    if ($update) {
        $_SESSION['success'] = "Program updated successfully";
    } else {
        $_SESSION['status'] = "Error updating program";
    }
    echo '<script type="text/javascript">window.location="programtype.php"</script>';
    exit();
}

// Delete Program
if (isset($_POST['delete_program'])) {
    $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
    $delete = mysqli_query($con, "DELETE FROM programtype WHERE id = '$program_id' LIMIT 1");
    if ($delete) {
        $_SESSION['success'] = "Program deleted successfully";
    } else {
        $_SESSION['status'] = "Error deleting program";
    }
    echo '<script type="text/javascript">window.location="programtype.php"</script>';
    exit();
}
?>