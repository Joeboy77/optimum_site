<?php
ob_start();
include('includes/header.php');
include('includes/navbar.php');

$quizId = isset($_GET['quiz_id']) ? (int)$_GET['quiz_id'] : 0;
if ($quizId<=0) { header('Location: myquizzes.php'); exit(); }

// Load quiz
$quiz = null;
$res = mysqli_query($con, "SELECT * FROM exams_setting WHERE id=$quizId AND category='Quiz' AND created_by='".$_SESSION['schoolID']."' LIMIT 1");
if ($res && mysqli_num_rows($res)===1) { $quiz = mysqli_fetch_assoc($res); }
if (!$quiz) { header('Location: myquizzes.php'); exit(); }

// Handle add question
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['save_question'])) {
  $question = mysqli_real_escape_string($con, $_POST['question'] ?? '');
  $a = mysqli_real_escape_string($con, $_POST['option_a'] ?? '');
  $b = mysqli_real_escape_string($con, $_POST['option_b'] ?? '');
  $c = mysqli_real_escape_string($con, $_POST['option_c'] ?? '');
  $d = mysqli_real_escape_string($con, $_POST['option_d'] ?? '');
  $correct = mysqli_real_escape_string($con, $_POST['correct_option'] ?? 'A');
  $marks = (int)($_POST['marks'] ?? 1);

  // Check if we've reached the question limit
  $totalQuestions = (int)($quiz['total_questions'] ?? 0);
  if ($totalQuestions > 0) {
    // Count current questions
    $countQuery = "SELECT COUNT(*) as current_count FROM exam_questions WHERE exam_id = $quizId";
    $countResult = mysqli_query($con, $countQuery);
    if ($countResult && mysqli_num_rows($countResult) > 0) {
      $countData = mysqli_fetch_assoc($countResult);
      $currentCount = (int)$countData['current_count'];
      
      if ($currentCount >= $totalQuestions) {
        $_SESSION['status'] = "You have reached the maximum number of questions ($totalQuestions) for this quiz.";
        header('Location: myquizquestions.php?quiz_id='.$quizId);
        exit();
      }
    }
  }

  $q = "INSERT INTO exam_questions (exam_id, question, option_a, option_b, option_c, option_d, correct_option, marks) VALUES ($quizId, '$question', '$a', '$b', '$c', '$d', '$correct', $marks)";
  if (mysqli_query($con, $q)) {
    $_SESSION['success'] = 'Question added';
    header('Location: myquizquestions.php?quiz_id='.$quizId);
    exit();
  } else {
    $_SESSION['status'] = 'Error adding question';
  }
}

// Handle delete
if (isset($_GET['del'])) {
  $qid = (int)$_GET['del'];
  mysqli_query($con, "DELETE FROM exam_questions WHERE id=$qid AND exam_id=$quizId");
  $_SESSION['success'] = 'Question deleted';
  header('Location: myquizquestions.php?quiz_id='.$quizId);
  exit();
}
?>

<main class="mt-5 pt-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span>Quiz: <?php echo htmlspecialchars($quiz['title']); ?> (<?php echo htmlspecialchars($quiz['course']); ?>)</span>
          <a href="myquizzes.php" class="btn btn-outline-secondary btn-sm">Back</a>
        </div>
        <div class="card-body">
          <?php if(!empty($_SESSION['status'])){ echo '<div class="alert alert-warning">'.$_SESSION['status'].'</div>'; unset($_SESSION['status']); } ?>
          <?php if(!empty($_SESSION['success'])){ echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>'; unset($_SESSION['success']); } ?>

          <form method="POST" class="border p-3 mb-4">
            <div class="mb-2">
              <label class="form-label">Question</label>
              <textarea name="question" class="form-control" <?php echo !$canAddMore ? 'disabled' : ''; ?> required></textarea>
            </div>
            <div class="row">
              <div class="col-md-6 mb-2"><input class="form-control" name="option_a" placeholder="Option A" <?php echo !$canAddMore ? 'disabled' : ''; ?> required></div>
              <div class="col-md-6 mb-2"><input class="form-control" name="option_b" placeholder="Option B" <?php echo !$canAddMore ? 'disabled' : ''; ?> required></div>
              <div class="col-md-6 mb-2"><input class="form-control" name="option_c" placeholder="Option C" <?php echo !$canAddMore ? 'disabled' : ''; ?> required></div>
              <div class="col-md-6 mb-2"><input class="form-control" name="option_d" placeholder="Option D" <?php echo !$canAddMore ? 'disabled' : ''; ?> required></div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-2">
                <label class="form-label">Correct Option</label>
                <select name="correct_option" class="form-control" <?php echo !$canAddMore ? 'disabled' : ''; ?>>
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="C">C</option>
                  <option value="D">D</option>
                </select>
              </div>
              <div class="col-md-6 mb-2">
                <label class="form-label">Marks</label>
                <input type="number" min="1" name="marks" class="form-control" value="1" <?php echo !$canAddMore ? 'disabled' : ''; ?> required>
              </div>
            </div>
            <button type="submit" name="save_question" class="btn <?php echo $canAddMore ? 'btn-primary' : 'btn-secondary'; ?>" <?php echo !$canAddMore ? 'disabled' : ''; ?>>
              <?php echo $canAddMore ? 'Add Question' : 'Limit Reached'; ?>
            </button>
          </form>

          <table id="example" class="table table-striped table-hover align-middle">
            <thead class="table-success">
              <tr>
                <th style="width:70px;">#</th>
                <th class="text-start">Question</th>
                <th>Correct</th>
                <th style="width:120px;">Marks</th>
                <th style="width:120px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $n=1;
              $qs = mysqli_query($con, "SELECT * FROM exam_questions WHERE exam_id=$quizId ORDER BY id DESC");
              if ($qs && mysqli_num_rows($qs)>0) {
                while($qrow = mysqli_fetch_assoc($qs)){
                  echo '<tr>';
                  echo '<td>'.$n++.'</td>';
                  echo '<td class="text-start">'.htmlspecialchars($qrow['question']).'</td>';
                  echo '<td>'.htmlspecialchars($qrow['correct_option']).'</td>';
                  echo '<td>'.(int)$qrow['marks'].'</td>';
                  echo '<td><a href="?quiz_id='.$quizId.'&del='.$qrow['id'].'" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Delete this question?\')">Delete</a></td>';
                  echo '</tr>';
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</main>

<?php
include('includes/footer.php');
ob_end_flush();
?>

