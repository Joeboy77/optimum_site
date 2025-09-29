<?php
include('includes/header.php');
include('includes/navbar.php');

$teacher_name = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];

// Handle POST requests at the top
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
      $query = "UPDATE exams_setting SET title='$title', category='$category', course='$course', semester='$semester', timelimit='$timelimit', totalmarks='$totalmarks', total_questions='$total_questions', start_at='$start_at', end_at='$end_at' WHERE id='$id' AND created_by='$teacher_name'";
      if (mysqli_query($con, $query)) {
        $_SESSION['success'] = 'Exam updated successfully';
      } else {
        $_SESSION['status'] = 'Error updating exam';
      }
    }
    header('Location: myexams.php');
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
          <span><i class="bi bi-table me-2"></i>My Exams</span> 
          <div class="text-xs font-weight-bold">
            <a href="createexam.php" class="btn btn-success btn-sm">
              <i class="bi bi-plus"></i> Create New Exam
            </a>
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
                    <th class="no-sort" style="width: 160px;">Actions</th>
                  </tr>
                </thead>
                <tbody id="data">
                  <?php
                  $query = "SELECT e.*, c.name as category_name FROM exams_setting e LEFT JOIN exam_categories c ON e.category = c.name WHERE e.created_by='$teacher_name' ORDER BY e.created_at DESC";
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
                    <td>
                      <a href="myquestions.php?exam_id=<?php echo $row['id'];?>" class="btn btn-info btn-sm" title="Manage Questions">
                        <i class="bi bi-question-circle"></i>
                      </a>
                      <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editExamModal<?php echo $row['id']; ?>" title="Edit Exam">
                        <i class="bi bi-pencil-square"></i>
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
                        <form action="myexams.php" method="POST">
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

                  <?php
                  $no++;
                  }
                }else{
                  echo "<tr><td hidden></td><td colspan='10' class='text-center'>No exams found. <a href='createexam.php'>Create your first exam</a></td></tr>";
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