<?php
include('includes/header.php');
include('includes/navbar.php');

// Handle POST requests at the top
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['add_category'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    
    if (empty($name)) {
      $_SESSION['status'] = 'Category name is required';
    } else {
      $query = "INSERT INTO exam_categories (name, description) VALUES ('$name', '$description')";
      if (mysqli_query($con, $query)) {
        $_SESSION['success'] = 'Category added successfully';
      } else {
        $_SESSION['status'] = 'Error adding category';
      }
    }
    header('Location: examcategories.php');
    exit();
  }
  
  if (isset($_POST['edit_category'])) {
    $id = mysqli_real_escape_string($con, $_POST['category_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    
    if (empty($name)) {
      $_SESSION['status'] = 'Category name is required';
    } else {
      $query = "UPDATE exam_categories SET name='$name', description='$description' WHERE id='$id'";
      if (mysqli_query($con, $query)) {
        $_SESSION['success'] = 'Category updated successfully';
      } else {
        $_SESSION['status'] = 'Error updating category';
      }
    }
    header('Location: examcategories.php');
    exit();
  }
  
  if (isset($_POST['delete_category'])) {
    $id = mysqli_real_escape_string($con, $_POST['category_id']);
    $query = "DELETE FROM exam_categories WHERE id='$id'";
    if (mysqli_query($con, $query)) {
      $_SESSION['success'] = 'Category deleted successfully';
    } else {
      $_SESSION['status'] = 'Error deleting category';
    }
    header('Location: examcategories.php');
    exit();
  }
}

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
          <span><i class="bi bi-table me-2"></i>Exam Categories</span> 
          <div class="text-xs font-weight-bold">
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
              <i class="bi bi-plus"></i> Add Category
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
                    <th>Name</th>
                    <th>Description</th>
                    <th>Created</th>
                    <th class="no-sort" style="width: 120px;">Actions</th>
                  </tr>
                </thead>
                <tbody id="data">
                  <?php
                  $query = "SELECT * FROM exam_categories ORDER BY created_at DESC";
                  $query_run = mysqli_query($con, $query);
                  if($query_run && mysqli_num_rows($query_run) > 0){
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($query_run)){
                  ?>
                  <tr>
                    <td hidden><?php echo $row["id"];?></td>
                    <td><?php echo $no;?></td>
                    <td><?php echo $row["name"];?></td>
                    <td><?php echo $row["description"];?></td>
                    <td><?php echo date('M d, Y', strtotime($row["created_at"]));?></td>
                    <td>
                      <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCategoryModal<?php echo $row['id']; ?>">
                        <i class="bi bi-pencil-square"></i>
                      </button>
                      <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal<?php echo $row['id']; ?>">
                        <i class="bi bi-trash"></i>
                      </button>
                    </td>
                  </tr>

                  <!-- Edit Modal -->
                  <div class="modal fade" id="editCategoryModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editCategoryModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="editCategoryModalLabel<?php echo $row['id']; ?>">Edit Category</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="examcategories.php" method="POST">
                          <div class="modal-body text-start">
                            <input type="hidden" name="category_id" value="<?php echo $row['id']; ?>">
                            <div class="mb-3">
                              <label class="form-label">Category Name</label>
                              <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                            </div>
                            <div class="mb-3">
                              <label class="form-label">Description</label>
                              <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($row['description']); ?></textarea>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="edit_category">Save Changes</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <!-- Delete Modal -->
                  <div class="modal fade" id="deleteCategoryModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteCategoryModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteCategoryModalLabel<?php echo $row['id']; ?>">Delete Category</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="examcategories.php" method="POST">
                          <div class="modal-body">
                            <input type="hidden" name="category_id" value="<?php echo $row['id']; ?>">
                            <p>Are you sure you want to delete <strong><?php echo htmlspecialchars($row['name']); ?></strong>?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" name="delete_category">Yes, Delete</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <?php
                  $no++;
                  }
                }else{
                  // No categories yet; render no rows so DataTables can handle empty state
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

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="examcategories.php" method="POST">
        <div class="modal-body text-start">
          <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="add_category">Add Category</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
include('includes/footer.php');
?>