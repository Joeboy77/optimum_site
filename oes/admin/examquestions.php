<?php
include('includes/header.php');
include('includes/navbar.php');

$exam_id = isset($_GET['exam_id']) ? $_GET['exam_id'] : '';

// Handle POST requests at the top
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['add_question'])) {
    $exam_id = mysqli_real_escape_string($con, $_POST['exam_id']);
    $question = mysqli_real_escape_string($con, $_POST['question']);
    $option_a = mysqli_real_escape_string($con, $_POST['option_a']);
    $option_b = mysqli_real_escape_string($con, $_POST['option_b']);
    $option_c = mysqli_real_escape_string($con, $_POST['option_c']);
    $option_d = mysqli_real_escape_string($con, $_POST['option_d']);
    $correct_option = mysqli_real_escape_string($con, $_POST['correct_option']);
    $marks = mysqli_real_escape_string($con, $_POST['marks']);
    
    if (empty($question) || empty($option_a) || empty($option_b) || empty($option_c) || empty($option_d) || $correct_option === 'Please Select') {
      $_SESSION['status'] = 'All fields are required';
    } else {
      // Handle file upload
      $attachment = '';
      if (!empty($_FILES['attachment']['name'])) {
        $uploadDir = __DIR__ . '/../uploads/exams';
        if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0775, true); }
        $origName = basename($_FILES['attachment']['name']);
        $ext = pathinfo($origName, PATHINFO_EXTENSION);
        $safeName = uniqid('q_').'.'.$ext;
        $targetFsPath = $uploadDir . '/' . $safeName;
        $webPath = 'uploads/exams/' . $safeName;
        if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFsPath)) {
          $attachment = $webPath;
        }
      }
      
      $query = "INSERT INTO exam_questions (exam_id, question, option_a, option_b, option_c, option_d, correct_option, marks, attachment) VALUES ('$exam_id', '$question', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_option', '$marks', '$attachment')";
      if (mysqli_query($con, $query)) {
        $_SESSION['success'] = 'Question added successfully';
      } else {
        $_SESSION['status'] = 'Error adding question';
      }
    }
    header('Location: examquestions.php?exam_id='.$exam_id);
    exit();
  }
  
  if (isset($_POST['edit_question'])) {
    $id = mysqli_real_escape_string($con, $_POST['question_id']);
    $question = mysqli_real_escape_string($con, $_POST['question']);
    $option_a = mysqli_real_escape_string($con, $_POST['option_a']);
    $option_b = mysqli_real_escape_string($con, $_POST['option_b']);
    $option_c = mysqli_real_escape_string($con, $_POST['option_c']);
    $option_d = mysqli_real_escape_string($con, $_POST['option_d']);
    $correct_option = mysqli_real_escape_string($con, $_POST['correct_option']);
    $marks = mysqli_real_escape_string($con, $_POST['marks']);
    
    if (empty($question) || empty($option_a) || empty($option_b) || empty($option_c) || empty($option_d) || $correct_option === 'Please Select') {
      $_SESSION['status'] = 'All fields are required';
    } else {
      $query = "UPDATE exam_questions SET question='$question', option_a='$option_a', option_b='$option_b', option_c='$option_c', option_d='$option_d', correct_option='$correct_option', marks='$marks' WHERE id='$id'";
      if (mysqli_query($con, $query)) {
        $_SESSION['success'] = 'Question updated successfully';
      } else {
        $_SESSION['status'] = 'Error updating question';
      }
    }
    header('Location: examquestions.php?exam_id='.$exam_id);
    exit();
  }
  
  if (isset($_POST['delete_question'])) {
    $id = mysqli_real_escape_string($con, $_POST['question_id']);
    $query = "DELETE FROM exam_questions WHERE id='$id'";
    if (mysqli_query($con, $query)) {
      $_SESSION['success'] = 'Question deleted successfully';
    } else {
      $_SESSION['status'] = 'Error deleting question';
    }
    header('Location: examquestions.php?exam_id='.$exam_id);
    exit();
  }
}

// Get exam details
$exam = null;
if ($exam_id) {
  $examQuery = "SELECT * FROM exams_setting WHERE id='$exam_id'";
  $examResult = mysqli_query($con, $examQuery);
  if ($examResult && mysqli_num_rows($examResult) > 0) {
    $exam = mysqli_fetch_assoc($examResult);
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
          <span><i class="bi bi-table me-2"></i>Exam Questions</span> 
          <div class="text-xs font-weight-bold">
            <?php if ($exam): ?>
              <span class="me-3"><?php echo $exam['title']; ?> - <?php echo $exam['course']; ?></span>
              <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                <i class="bi bi-plus"></i> Add Question
              </button>
            <?php endif; ?>
          </div>
        </div>
        <div class="card-body">
          <?php if (!$exam): ?>
            <div class="alert alert-info">
              <h5>Select an Exam</h5>
              <p>Please select an exam from the <a href="exams.php">Manage Exams</a> page to view and manage questions.</p>
            </div>
          <?php else: ?>
            <div class="row">
              <div class="col-12">
                <table id="example" class="table table-striped table-hover text-center">
                  <thead class="table-success">
                    <tr>
                      <th hidden>S. No.</th>
                      <th>S. No.</th>
                      <th>Question</th>
                      <th>Options</th>
                      <th>Correct Answer</th>
                      <th>Marks</th>
                      <th>Attachment</th>
                      <th class="no-sort" style="width: 120px;">Actions</th>
                    </tr>
                  </thead>
                  <tbody id="data">
                    <?php
                    $query = "SELECT * FROM exam_questions WHERE exam_id='$exam_id' ORDER BY id ASC";
                    $query_run = mysqli_query($con, $query);
                    if($query_run && mysqli_num_rows($query_run) > 0){
                      $no = 1;
                      while ($row = mysqli_fetch_assoc($query_run)){
                    ?>
                    <tr>
                      <td hidden><?php echo $row["id"];?></td>
                      <td><?php echo $no;?></td>
                      <td class="text-start"><?php echo substr(strip_tags($row["question"]), 0, 100); ?>...</td>
                      <td class="text-start">
                        <small>
                          A. <?php echo substr($row["option_a"], 0, 30); ?>...<br>
                          B. <?php echo substr($row["option_b"], 0, 30); ?>...<br>
                          C. <?php echo substr($row["option_c"], 0, 30); ?>...<br>
                          D. <?php echo substr($row["option_d"], 0, 30); ?>...
                        </small>
                      </td>
                      <td><?php echo strtoupper($row["correct_option"]);?></td>
                      <td><?php echo $row["marks"];?></td>
                      <td>
                        <?php if ($row["attachment"]): ?>
                          <a href="../<?php echo $row['attachment']; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-paperclip"></i>
                          </a>
                        <?php else: ?>
                          <span class="text-muted">None</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editQuestionModal<?php echo $row['id']; ?>">
                          <i class="bi bi-pencil-square"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteQuestionModal<?php echo $row['id']; ?>">
                          <i class="bi bi-trash"></i>
                        </button>
                      </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editQuestionModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editQuestionModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="editQuestionModalLabel<?php echo $row['id']; ?>">Edit Question</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="examquestions.php" method="POST">
                            <div class="modal-body text-start">
                              <input type="hidden" name="question_id" value="<?php echo $row['id']; ?>">
                              <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
                              <div class="mb-3">
                                <label class="form-label">Question</label>
                                <textarea name="question" class="form-control" rows="3" required><?php echo htmlspecialchars($row['question']); ?></textarea>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label class="form-label">Option A</label>
                                    <input type="text" name="option_a" class="form-control" value="<?php echo htmlspecialchars($row['option_a']); ?>" required>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label class="form-label">Option B</label>
                                    <input type="text" name="option_b" class="form-control" value="<?php echo htmlspecialchars($row['option_b']); ?>" required>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label class="form-label">Option C</label>
                                    <input type="text" name="option_c" class="form-control" value="<?php echo htmlspecialchars($row['option_c']); ?>" required>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label class="form-label">Option D</label>
                                    <input type="text" name="option_d" class="form-control" value="<?php echo htmlspecialchars($row['option_d']); ?>" required>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label class="form-label">Correct Answer</label>
                                    <select name="correct_option" class="form-control" required>
                                      <option value="Please Select">Please Select</option>
                                      <option value="a" <?php echo ($row['correct_option'] == 'a') ? 'selected' : ''; ?>>A</option>
                                      <option value="b" <?php echo ($row['correct_option'] == 'b') ? 'selected' : ''; ?>>B</option>
                                      <option value="c" <?php echo ($row['correct_option'] == 'c') ? 'selected' : ''; ?>>C</option>
                                      <option value="d" <?php echo ($row['correct_option'] == 'd') ? 'selected' : ''; ?>>D</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label class="form-label">Marks</label>
                                    <input type="number" name="marks" class="form-control" value="<?php echo $row['marks']; ?>" required>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary" name="edit_question">Save Changes</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteQuestionModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteQuestionModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="deleteQuestionModalLabel<?php echo $row['id']; ?>">Delete Question</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="examquestions.php" method="POST">
                            <div class="modal-body">
                              <input type="hidden" name="question_id" value="<?php echo $row['id']; ?>">
                              <p>Are you sure you want to delete this question?</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-danger" name="delete_question">Yes, Delete</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>

                    <?php
                    $no++;
                    }
                  }else{
                    // No questions yet; render no rows so DataTables can handle empty state
                  }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Add Question Modal -->
<?php if ($exam): ?>
<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addQuestionModalLabel">Add New Question</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="examquestions.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body text-start">
          <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
          <div class="mb-3">
            <label class="form-label">Question</label>
            <textarea name="question" class="form-control" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Attachment (Optional)</label>
            <input type="file" name="attachment" class="form-control" accept="image/*,application/pdf,video/*">
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Option A</label>
                <input type="text" name="option_a" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Option B</label>
                <input type="text" name="option_b" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Option C</label>
                <input type="text" name="option_c" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Option D</label>
                <input type="text" name="option_d" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Correct Answer</label>
                <select name="correct_option" class="form-control" required>
                  <option value="Please Select">Please Select</option>
                  <option value="a">A</option>
                  <option value="b">B</option>
                  <option value="c">C</option>
                  <option value="d">D</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Marks</label>
                <input type="number" name="marks" class="form-control" value="1" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="add_question">Add Question</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<?php
include('includes/footer.php');
?>