<?php
include('includes/header.php');
include('includes/navbar.php');

// Handle POST requests at the top
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['add_exam'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $course = mysqli_real_escape_string($con, $_POST['course']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $timelimit = mysqli_real_escape_string($con, $_POST['timelimit']);
    $totalmarks = mysqli_real_escape_string($con, $_POST['totalmarks']);
    $total_questions = mysqli_real_escape_string($con, $_POST['total_questions']);
    $start_at = mysqli_real_escape_string($con, $_POST['start_at']);
    $end_at = mysqli_real_escape_string($con, $_POST['end_at']);
    
    if (empty($title) || empty($category) || empty($course)) {
      $_SESSION['status'] = 'Title, Category, and Course are required';
    } else {
      $query = "INSERT INTO exams_setting (title, category, course, semester, timelimit, totalmarks, total_questions, start_at, end_at, created_by) VALUES ('$title', '$category', '$course', '$semester', '$timelimit', '$totalmarks', '$total_questions', '$start_at', '$end_at', 'Admin')";
      if (mysqli_query($con, $query)) {
        $_SESSION['success'] = 'Exam created successfully';
      } else {
        $_SESSION['status'] = 'Error creating exam';
      }
    }
    header('Location: exams.php');
    exit();
  }
  
  if (isset($_POST['edit_exam'])) {
    $id = mysqli_real_escape_string($con, $_POST['exam_id']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $course = mysqli_real_escape_string($con, $_POST['course']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $timelimit = mysqli_real_escape_string($con, $_POST['timelimit']);
    $totalmarks = mysqli_real_escape_string($con, $_POST['totalmarks']);
    $total_questions = mysqli_real_escape_string($con, $_POST['total_questions']);
    $start_at = mysqli_real_escape_string($con, $_POST['start_at']);
    $end_at = mysqli_real_escape_string($con, $_POST['end_at']);
    
    if (empty($title) || empty($category) || empty($course)) {
      $_SESSION['status'] = 'Title, Category, and Course are required';
    } else {
      $query = "UPDATE exams_setting SET title='$title', category='$category', course='$course', semester='$semester', timelimit='$timelimit', totalmarks='$totalmarks', total_questions='$total_questions', start_at='$start_at', end_at='$end_at' WHERE id='$id'";
      if (mysqli_query($con, $query)) {
        $_SESSION['success'] = 'Exam updated successfully';
      } else {
        $_SESSION['status'] = 'Error updating exam';
      }
    }
    header('Location: exams.php');
    exit();
  }
  
  if (isset($_POST['delete_exam'])) {
    $id = mysqli_real_escape_string($con, $_POST['exam_id']);
    // Delete related questions first
    mysqli_query($con, "DELETE FROM exam_questions WHERE exam_id='$id'");
    // Delete exam
    $query = "DELETE FROM exams_setting WHERE id='$id'";
    if (mysqli_query($con, $query)) {
      $_SESSION['success'] = 'Exam deleted successfully';
    } else {
      $_SESSION['status'] = 'Error deleting exam';
    }
    header('Location: exams.php');
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
          <span><i class="bi bi-table me-2"></i>Manage Exams</span> 
          <div class="text-xs font-weight-bold">
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addExamModal">
              <i class="bi bi-plus"></i> Create Exam
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
                    <th>Title</th>
                    <th>Category</th>
                    <th>Course</th>
                    <th>Semester</th>
                    <th>Duration</th>
                    <th>Questions</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Created By</th>
                    <th class="no-sort" style="width: 160px;">Actions</th>
                  </tr>
                </thead>
                <tbody id="data">
                  <?php
                  $query = "SELECT e.*, c.name as category_name FROM exams_setting e LEFT JOIN exam_categories c ON e.category = c.name ORDER BY e.created_at DESC";
                  $query_run = mysqli_query($con, $query);
                  if($query_run && mysqli_num_rows($query_run) > 0){
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($query_run)){
                  ?>
                  <tr>
                    <td hidden><?php echo $row["id"];?></td>
                    <td><?php echo $no;?></td>
                    <td><?php echo $row["title"];?></td>
                    <td><?php echo $row["category_name"] ?: $row["category"];?></td>
                    <td><?php echo $row["course"];?></td>
                    <td><?php echo $row["semester"];?></td>
                    <td><?php echo $row["timelimit"];?> min</td>
                    <td><?php echo $row["total_questions"];?></td>
                    <td><?php echo $row["start_at"] ? date('M d, Y H:i', strtotime($row["start_at"])) : 'Not set';?></td>
                    <td><?php echo $row["end_at"] ? date('M d, Y H:i', strtotime($row["end_at"])) : 'Not set';?></td>
                    <td><?php echo $row["created_by"];?></td>
                    <td>
                      <a href="examquestions.php?exam_id=<?php echo $row['id'];?>" class="btn btn-info btn-sm" title="Manage Questions">
                        <i class="bi bi-question-circle"></i>
                      </a>
                      <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editExamModal<?php echo $row['id']; ?>" title="Edit Exam">
                        <i class="bi bi-pencil-square"></i>
                      </button>
                      <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteExamModal<?php echo $row['id']; ?>" title="Delete Exam">
                        <i class="bi bi-trash"></i>
                      </button>
                    </td>
                  </tr>

                  <!-- Edit Modal -->
                  <div class="modal fade" id="editExamModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editExamModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="editExamModalLabel<?php echo $row['id']; ?>">Edit Exam</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="exams.php" method="POST">
                          <div class="modal-body text-start">
                            <input type="hidden" name="exam_id" value="<?php echo $row['id']; ?>">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="mb-3">
                                  <label class="form-label">Exam Title</label>
                                  <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="mb-3">
                                  <label class="form-label">Category</label>
                                  <select name="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <?php
                                    $catQuery = "SELECT * FROM exam_categories ORDER BY name ASC";
                                    $catResult = mysqli_query($con, $catQuery);
                                    while ($cat = mysqli_fetch_assoc($catResult)) {
                                      $selected = ($cat['name'] == $row['category']) ? 'selected' : '';
                                      echo "<option value='".$cat['name']."' $selected>".$cat['name']."</option>";
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="mb-3">
                                  <label class="form-label">Course</label>
                                  <select name="course" class="form-control" required>
                                    <option value="">Select Course</option>
                                    <?php
                                    $courseQuery = "SELECT * FROM courses ORDER BY course_name ASC";
                                    $courseResult = mysqli_query($con, $courseQuery);
                                    while ($course = mysqli_fetch_assoc($courseResult)) {
                                      $selected = ($course['course_name'] == $row['course']) ? 'selected' : '';
                                      echo "<option value='".$course['course_name']."' $selected>".$course['course_name']."</option>";
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="mb-3">
                                  <label class="form-label">Semester</label>
                                  <select name="semester" class="form-control">
                                    <option value="Semester 1" <?php echo ($row['semester'] == 'Semester 1') ? 'selected' : ''; ?>>Semester 1</option>
                                    <option value="Semester 2" <?php echo ($row['semester'] == 'Semester 2') ? 'selected' : ''; ?>>Semester 2</option>
                                    <option value="Semester 3" <?php echo ($row['semester'] == 'Semester 3') ? 'selected' : ''; ?>>Semester 3</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-4">
                                <div class="mb-3">
                                  <label class="form-label">Duration (minutes)</label>
                                  <input type="number" name="timelimit" class="form-control" value="<?php echo $row['timelimit']; ?>" required>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="mb-3">
                                  <label class="form-label">Total Marks</label>
                                  <input type="number" name="totalmarks" class="form-control" value="<?php echo $row['totalmarks']; ?>" required>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="mb-3">
                                  <label class="form-label">Total Questions</label>
                                  <input type="number" name="total_questions" class="form-control" value="<?php echo $row['total_questions']; ?>" required>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="mb-3">
                                  <label class="form-label">Start Date & Time</label>
                                  <input type="datetime-local" name="start_at" class="form-control" value="<?php echo $row['start_at'] ? date('Y-m-d\TH:i', strtotime($row['start_at'])) : ''; ?>">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="mb-3">
                                  <label class="form-label">End Date & Time</label>
                                  <input type="datetime-local" name="end_at" class="form-control" value="<?php echo $row['end_at'] ? date('Y-m-d\TH:i', strtotime($row['end_at'])) : ''; ?>">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="edit_exam">Save Changes</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <!-- Delete Modal -->
                  <div class="modal fade" id="deleteExamModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteExamModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteExamModalLabel<?php echo $row['id']; ?>">Delete Exam</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="exams.php" method="POST">
                          <div class="modal-body">
                            <input type="hidden" name="exam_id" value="<?php echo $row['id']; ?>">
                            <p>Are you sure you want to delete <strong><?php echo htmlspecialchars($row['title']); ?></strong>?</p>
                            <p class="text-danger">This will also delete all questions and results for this exam.</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" name="delete_exam">Yes, Delete</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <?php
                  $no++;
                  }
                }else{
                  // No exams yet; render no rows so DataTables can handle empty state
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

<!-- Add Exam Modal -->
<div class="modal fade" id="addExamModal" tabindex="-1" aria-labelledby="addExamModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addExamModalLabel">Create New Exam</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="exams.php" method="POST">
        <div class="modal-body text-start">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Exam Title</label>
                <input type="text" name="title" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category" class="form-control" required>
                  <option value="">Select Category</option>
                  <?php
                  $catQuery = "SELECT * FROM exam_categories ORDER BY name ASC";
                  $catResult = mysqli_query($con, $catQuery);
                  while ($cat = mysqli_fetch_assoc($catResult)) {
                    echo "<option value='".$cat['name']."'>".$cat['name']."</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Course</label>
                <select name="course" class="form-control" required>
                  <option value="">Select Course</option>
                  <?php
                  $courseQuery = "SELECT * FROM courses ORDER BY course_name ASC";
                  $courseResult = mysqli_query($con, $courseQuery);
                  while ($course = mysqli_fetch_assoc($courseResult)) {
                    echo "<option value='".$course['course_name']."'>".$course['course_name']."</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Semester</label>
                <select name="semester" class="form-control">
                  <option value="Semester 1">Semester 1</option>
                  <option value="Semester 2">Semester 2</option>
                  <option value="Semester 3">Semester 3</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Duration (minutes)</label>
                <input type="number" name="timelimit" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Total Marks</label>
                <input type="number" name="totalmarks" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Total Questions</label>
                <input type="number" name="total_questions" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Start Date & Time</label>
                <input type="datetime-local" name="start_at" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">End Date & Time</label>
                <input type="datetime-local" name="end_at" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="add_exam">Create Exam</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
include('includes/footer.php');
?>