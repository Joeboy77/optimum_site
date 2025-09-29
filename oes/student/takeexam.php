<?php
// Start output buffering to allow redirects after includes output HTML
ob_start();
include('includes/header.php');
include('includes/navbar.php');

$student_id = $_SESSION['indexnumber'] ?? '';
$exam_id = isset($_GET['exam_id']) ? $_GET['exam_id'] : '';
$current_question = isset($_GET['q']) ? (int)$_GET['q'] : 1;

// Validate student session
if (empty($student_id)) {
  $_SESSION['status'] = 'Please log in to take exams';
  header('Location: index.php');
  exit();
}

// Handle answer saving (for navigation between questions)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_answer'])) {
  $exam_id = mysqli_real_escape_string($con, $_POST['exam_id']);
  $question_id = mysqli_real_escape_string($con, $_POST['question_id']);
  $answer = mysqli_real_escape_string($con, $_POST['answer']);
  $next_question = (int)$_POST['next_question'];
  
  // Save answer to session or database
  if (!isset($_SESSION['exam_answers'])) {
    $_SESSION['exam_answers'] = [];
  }
  $_SESSION['exam_answers'][$exam_id][$question_id] = $answer;
  
  // Redirect to next question
  header("Location: takeexam.php?exam_id=$exam_id&q=$next_question");
  exit();
}

// Handle exam submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_exam'])) {
  $exam_id = mysqli_real_escape_string($con, $_POST['exam_id']);
  $answers = $_POST['answers'] ?? [];
  
  // Get saved answers from session if available
  if (isset($_SESSION['exam_answers'][$exam_id])) {
    $answers = array_merge($answers, $_SESSION['exam_answers'][$exam_id]);
  }
  
  // Validate exam_id
  if (empty($exam_id) || !is_numeric($exam_id)) {
    $_SESSION['status'] = 'Invalid exam ID. Please try again.';
    header('Location: availableexams.php');
    exit();
  }
  
  // Get exam details
  $examQuery = "SELECT * FROM exams_setting WHERE id='$exam_id'";
  $examResult = mysqli_query($con, $examQuery);
  if ($examResult && mysqli_num_rows($examResult) > 0) {
    $exam = mysqli_fetch_assoc($examResult);
    
    // Try new questions table first
    $questionsResult = mysqli_query($con, "SELECT id, question, option_a, option_b, option_c, option_d, correct_option, COALESCE(marks,1) AS marks FROM exam_questions WHERE exam_id='$exam_id' ORDER BY id ASC");
    $usingLegacy = false;
    if (!$questionsResult || mysqli_num_rows($questionsResult) === 0) {
      // Fallback to legacy table structure
      $usingLegacy = true;
      $questionsResult = mysqli_query($con, "SELECT id, question, option1, option2, option3, option4, correct_answer, COALESCE(marks,1) AS marks FROM exams_questions WHERE questionID='$exam_id' ORDER BY question_no ASC, id ASC");
    }
    
    $score = 0;
    $total_questions = 0;
    
    while ($question = mysqli_fetch_assoc($questionsResult)) {
      $total_questions++;
      $student_answer = $answers[$question['id']] ?? '';

      // Normalize correct option for legacy rows
      $correct = '';
      if ($usingLegacy) {
        $legacyCorrect = trim(strtolower((string)$question['correct_answer']));
        if (in_array($legacyCorrect, ['a','b','c','d'], true)) {
          $correct = $legacyCorrect;
        } elseif (in_array($legacyCorrect, ['option1','1'], true)) {
          $correct = 'a';
        } elseif (in_array($legacyCorrect, ['option2','2'], true)) {
          $correct = 'b';
        } elseif (in_array($legacyCorrect, ['option3','3'], true)) {
          $correct = 'c';
        } elseif (in_array($legacyCorrect, ['option4','4'], true)) {
          $correct = 'd';
        } else {
          // Try matching by text content
          if ($legacyCorrect === trim(strtolower((string)$question['option1']))) { $correct = 'a'; }
          elseif ($legacyCorrect === trim(strtolower((string)$question['option2']))) { $correct = 'b'; }
          elseif ($legacyCorrect === trim(strtolower((string)$question['option3']))) { $correct = 'c'; }
          elseif ($legacyCorrect === trim(strtolower((string)$question['option4']))) { $correct = 'd'; }
        }
      } else {
        $correct = trim(strtolower((string)$question['correct_option']));
      }

      if ($student_answer !== '' && $correct !== '' && strtolower($student_answer) === $correct) {
        $score += (int)$question['marks'];
      }
    }
    
    // Save result
    $resultQuery = "INSERT INTO exam_results (exam_id, student_id, score, taken_at) VALUES ('$exam_id', '$student_id', '$score', NOW())";
    if (mysqli_query($con, $resultQuery)) {
      // Clear saved answers after submission
      unset($_SESSION['exam_answers'][$exam_id]);
      
      $_SESSION['success'] = 'Exam submitted successfully! Your score: ' . $score . '/' . $total_questions;
      header('Location: myresults.php?exam_id=' . $exam_id);
      exit();
  } else {
    $_SESSION['status'] = 'Error submitting exam: ' . mysqli_error($con);
    header('Location: availableexams.php');
    exit();
  }
  } else {
    $_SESSION['status'] = 'Exam not found. Please try again.';
    header('Location: availableexams.php');
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
    
    // Check if student already took this exam
    $takenQuery = "SELECT * FROM exam_results WHERE exam_id='$exam_id' AND student_id='$student_id'";
    $takenResult = mysqli_query($con, $takenQuery);
    if ($takenResult && mysqli_num_rows($takenResult) > 0) {
      $_SESSION['status'] = 'You have already taken this exam';
      header('Location: availableexams.php');
      exit();
    }
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
    ?>

    <?php if (!$exam): ?>
      <div class="alert alert-danger">
        <h5>Exam Not Found</h5>
        <p>The requested exam could not be found.</p>
        <a href="availableexams.php" class="btn btn-primary">Back to Available Exams</a>
      </div>
    <?php else: ?>
      <div class="row">
        <div class="col-md-12 mb-3">
          <div class="card-header d-sm-flex align-items-center justify-content-between">
            <span><i class="bi bi-pencil-square me-2"></i>Taking Exam: <?php echo $exam['title']; ?></span> 
            <div class="text-xs font-weight-bold">
              <span class="badge bg-info me-2">Duration: <?php echo $exam['timelimit']; ?> minutes</span>
              <span class="badge bg-primary">Questions: <?php echo $exam['total_questions']; ?></span>
            </div>
          </div>
          <div class="card-body">
            <?php
            // Get all questions to determine total count and current question
            $questionsResult = mysqli_query($con, "SELECT id, question, option_a AS a, option_b AS b, option_c AS c, option_d AS d, correct_option AS correct, COALESCE(marks,1) AS marks, attachment FROM exam_questions WHERE exam_id='$exam_id' ORDER BY id ASC");
            $usingLegacy = false;
            if(!$questionsResult || mysqli_num_rows($questionsResult) === 0){
              // Fallback to legacy
              $usingLegacy = true;
              $questionsResult = mysqli_query($con, "SELECT id, question, option1 AS a, option2 AS b, option3 AS c, option4 AS d, correct_answer AS correct, COALESCE(marks,1) AS marks, NULL AS attachment FROM exams_questions WHERE questionID='$exam_id' ORDER BY question_no ASC, id ASC");
            }

            if($questionsResult && mysqli_num_rows($questionsResult) > 0){
              $allQuestions = mysqli_fetch_all($questionsResult, MYSQLI_ASSOC);
              $totalQuestions = count($allQuestions);
              
              // Validate current question number
              if ($current_question < 1) $current_question = 1;
              if ($current_question > $totalQuestions) $current_question = $totalQuestions;
              
              $question = $allQuestions[$current_question - 1];
              $savedAnswer = $_SESSION['exam_answers'][$exam_id][$question['id']] ?? '';
            ?>
            
            <!-- Progress Bar -->
            <div class="mb-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted">Question <?php echo $current_question; ?> of <?php echo $totalQuestions; ?></span>
                <span class="text-muted"><?php echo round(($current_question / $totalQuestions) * 100); ?>% Complete</span>
              </div>
              <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo ($current_question / $totalQuestions) * 100; ?>%"></div>
              </div>
            </div>

            <!-- Current Question -->
            <form action="takeexam.php" method="POST" id="questionForm">
              <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
              <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
              
              <div class="card mb-4">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-1">
                      <h5 class="text-primary"><?php echo $current_question; ?>.</h5>
                    </div>
                    <div class="col-md-11">
                      <h6 class="mb-3"><?php echo $question['question']; ?></h6>
                      
                      <?php if (!empty($question['attachment'])): ?>
                        <div class="mb-3">
                          <a href="../<?php echo $question['attachment']; ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-paperclip"></i> View Attachment
                          </a>
                        </div>
                      <?php endif; ?>
                      
                      <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="answer" value="a" id="q<?php echo $question['id']; ?>_a" <?php echo $savedAnswer === 'a' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="q<?php echo $question['id']; ?>_a">
                          A. <?php echo $question['a']; ?>
                        </label>
                      </div>
                      <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="answer" value="b" id="q<?php echo $question['id']; ?>_b" <?php echo $savedAnswer === 'b' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="q<?php echo $question['id']; ?>_b">
                          B. <?php echo $question['b']; ?>
                        </label>
                      </div>
                      <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="answer" value="c" id="q<?php echo $question['id']; ?>_c" <?php echo $savedAnswer === 'c' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="q<?php echo $question['id']; ?>_c">
                          C. <?php echo $question['c']; ?>
                        </label>
                      </div>
                      <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="answer" value="d" id="q<?php echo $question['id']; ?>_d" <?php echo $savedAnswer === 'd' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="q<?php echo $question['id']; ?>_d">
                          D. <?php echo $question['d']; ?>
                        </label>
                      </div>
                      
                      <div class="text-muted small">
                        <i class="bi bi-star"></i> <?php echo $question['marks']; ?> mark(s)
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Navigation Buttons -->
              <div class="row">
                <div class="col-12">
                  <div class="d-flex justify-content-between">
                    <div>
                      <?php if ($current_question > 1): ?>
                        <a href="takeexam.php?exam_id=<?php echo $exam_id; ?>&q=<?php echo $current_question - 1; ?>" class="btn btn-outline-secondary">
                          <i class="bi bi-arrow-left"></i> Previous
                        </a>
                      <?php endif; ?>
                    </div>
                    
                    <div>
                      <a href="availableexams.php" class="btn btn-secondary me-2">Cancel Exam</a>
                      
                      <?php if ($current_question < $totalQuestions): ?>
                        <button type="submit" class="btn btn-primary" name="save_answer">
                          Next <i class="bi bi-arrow-right"></i>
                        </button>
                        <input type="hidden" name="next_question" value="<?php echo $current_question + 1; ?>">
                      <?php else: ?>
                        <button type="button" class="btn btn-success" onclick="submitExam()">
                          <i class="bi bi-check-circle"></i> Submit Exam
                        </button>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            
            <?php
            }else{
              echo "<div class='alert alert-info'>No questions found for this exam.</div>";
            }
            ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</main>

<script>
// Enhanced Timer functionality
var timeLimit = <?php echo $exam ? $exam['timelimit'] * 60 : 0; ?>; // Convert to seconds
var timeLeft = timeLimit;
var timerElement = document.getElementById('timer');
var timerContainer = timerElement.closest('.alert');
var timer = setInterval(function() {
  var minutes = Math.floor(timeLeft / 60);
  var seconds = timeLeft % 60;
  var timeString = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
  
  timerElement.innerHTML = timeString;
  
  // Change color based on remaining time
  if (timeLeft <= 300) { // Last 5 minutes
    timerContainer.className = 'alert alert-danger shadow-lg';
    timerElement.className = 'h5 mb-0 text-white fw-bold';
  } else if (timeLeft <= 600) { // Last 10 minutes
    timerContainer.className = 'alert alert-warning shadow-lg';
    timerElement.className = 'h5 mb-0 text-dark fw-bold';
  } else {
    timerContainer.className = 'alert alert-info shadow-lg';
    timerElement.className = 'h5 mb-0 text-primary fw-bold';
  }
  
  if (timeLeft <= 0) {
    clearInterval(timer);
    // Show final warning
    timerElement.innerHTML = 'TIME UP!';
    timerContainer.className = 'alert alert-danger shadow-lg';
    timerElement.className = 'h5 mb-0 text-white fw-bold';
    
    // Auto-submit after 2 seconds
    setTimeout(function() {
      alert('Time is up! Your exam will be submitted automatically.');
      submitExam();
    }, 2000);
  }
  
  timeLeft--;
}, 1000);

// Add warning when time is running low
setTimeout(function() {
  if (timeLeft <= 300) { // 5 minutes warning
    alert('Warning: You have 5 minutes remaining!');
  }
}, (timeLimit - 300) * 1000);

// Function to submit exam
function submitExam() {
  if (confirm('Are you sure you want to submit this exam? You cannot change your answers after submission.')) {
    // Create a form to submit all answers
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = 'takeexam.php';
    
    // Add exam_id
    var examIdInput = document.createElement('input');
    examIdInput.type = 'hidden';
    examIdInput.name = 'exam_id';
    examIdInput.value = '<?php echo $exam_id; ?>';
    form.appendChild(examIdInput);
    
    // Add submit flag
    var submitInput = document.createElement('input');
    submitInput.type = 'hidden';
    submitInput.name = 'submit_exam';
    submitInput.value = '1';
    form.appendChild(submitInput);
    
    // Add all saved answers from session (they'll be retrieved server-side)
    document.body.appendChild(form);
    form.submit();
  }
}

// Auto-save answer when user selects an option
document.addEventListener('DOMContentLoaded', function() {
  var radioButtons = document.querySelectorAll('input[name="answer"]');
  radioButtons.forEach(function(radio) {
    radio.addEventListener('change', function() {
      // Auto-save the answer
      var form = document.createElement('form');
      form.method = 'POST';
      form.action = 'takeexam.php';
      form.style.display = 'none';
      
      var examIdInput = document.createElement('input');
      examIdInput.type = 'hidden';
      examIdInput.name = 'exam_id';
      examIdInput.value = '<?php echo $exam_id; ?>';
      form.appendChild(examIdInput);
      
      var questionIdInput = document.createElement('input');
      questionIdInput.type = 'hidden';
      questionIdInput.name = 'question_id';
      questionIdInput.value = '<?php echo $question['id']; ?>';
      form.appendChild(questionIdInput);
      
      var answerInput = document.createElement('input');
      answerInput.type = 'hidden';
      answerInput.name = 'answer';
      answerInput.value = this.value;
      form.appendChild(answerInput);
      
      var saveInput = document.createElement('input');
      saveInput.type = 'hidden';
      saveInput.name = 'save_answer';
      saveInput.value = '1';
      form.appendChild(saveInput);
      
      var nextQuestionInput = document.createElement('input');
      nextQuestionInput.type = 'hidden';
      nextQuestionInput.name = 'next_question';
      nextQuestionInput.value = '<?php echo $current_question; ?>';
      form.appendChild(nextQuestionInput);
      
      document.body.appendChild(form);
      form.submit();
    });
  });
});
</script>

<!-- Countdown Timer positioned properly to not block content -->
<div class="position-fixed" style="top: 100px; right: 20px; z-index: 1050;">
  <div class="alert alert-warning shadow-lg" style="min-width: 220px;">
    <div class="d-flex align-items-center">
      <i class="bi bi-hourglass-split me-2"></i>
      <div>
        <div class="fw-bold text-uppercase small">Countdown Timer</div>
        <div class="h4 mb-0 text-danger fw-bold" id="timer"><?php echo $exam ? $exam['timelimit'] . ':00' : '0:00'; ?></div>
        <div class="small text-muted">Time Remaining</div>
      </div>
    </div>
  </div>
</div>

<?php
include('includes/footer.php');
// Flush output buffer so any header redirects above are sent correctly
ob_end_flush();
?>