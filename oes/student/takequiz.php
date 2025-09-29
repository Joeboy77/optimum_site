<?php
ob_start();
include('includes/header.php');
include('includes/navbar.php');

$quizId = isset($_GET['quiz_id']) ? (int)$_GET['quiz_id'] : 0;
$current_question = isset($_GET['q']) ? (int)$_GET['q'] : 1;
if ($quizId<=0) { header('Location: availablequizzes.php'); exit(); }

// Load quiz
$quiz = null;
$res = mysqli_query($con, "SELECT * FROM exams_setting WHERE id=$quizId AND category='Quiz' LIMIT 1");
if ($res && mysqli_num_rows($res)===1) { $quiz = mysqli_fetch_assoc($res); }
if (!$quiz) { header('Location: availablequizzes.php'); exit(); }

// Enforce one attempt per student (use indexnumber for consistency)
$studentIndex = mysqli_real_escape_string($con, $_SESSION['indexnumber'] ?? '');
$takenCheck = mysqli_query($con, "SELECT 1 FROM exam_results WHERE exam_id=$quizId AND student_id='".$studentIndex."' LIMIT 1");
if ($takenCheck && mysqli_num_rows($takenCheck)>0) {
  $_SESSION['status'] = 'You have already completed this quiz.';
  header('Location: availablequizzes.php');
  exit();
}

// Handle answer saving (for navigation between questions)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_answer'])) {
  $question_id = mysqli_real_escape_string($con, $_POST['question_id']);
  $answer = mysqli_real_escape_string($con, $_POST['answer']);
  $next_question = (int)$_POST['next_question'];
  
  // Save answer to session
  if (!isset($_SESSION['quiz_answers'])) {
    $_SESSION['quiz_answers'] = [];
  }
  $_SESSION['quiz_answers'][$quizId][$question_id] = $answer;
  
  // Redirect to next question
  header("Location: takequiz.php?quiz_id=$quizId&q=$next_question");
  exit();
}

// Handle submission
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['submit_quiz'])) {
  $studentId = mysqli_real_escape_string($con, $_SESSION['indexnumber'] ?? '');
  $score = 0; $total = 0;
  $qs = mysqli_query($con, "SELECT id, correct_option, marks FROM exam_questions WHERE exam_id=$quizId");
  if ($qs) {
    while($q = mysqli_fetch_assoc($qs)){
      $total += (int)$q['marks'];
      $ans = $_POST['q_'.$q['id']] ?? '';
      
      // Get saved answer from session if available
      if (empty($ans) && isset($_SESSION['quiz_answers'][$quizId][$q['id']])) {
        $ans = $_SESSION['quiz_answers'][$quizId][$q['id']];
      }
      
      if (!empty($ans) && strtoupper($ans) === strtoupper($q['correct_option'])) { $score += (int)$q['marks']; }
    }
  }
  // Save result
  mysqli_query($con, "INSERT INTO exam_results (exam_id, student_id, score, taken_at) VALUES ($quizId, '".$studentId."', $score, NOW())");
  
  // Clear saved answers after submission
  unset($_SESSION['quiz_answers'][$quizId]);
  
  $_SESSION['success'] = 'Quiz submitted. Score: '.(int)$score.' / '.(int)$total;
  header('Location: availablequizzes.php');
  exit();
}

?>

<main class="mt-5 pt-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span>Quiz: <?php echo htmlspecialchars($quiz['title']); ?> (<?php echo htmlspecialchars($quiz['course']); ?>)</span>
          <div>
            <span class="badge bg-warning text-dark me-2">Time Left: <span id="time-left"></span></span>
            <a href="availablequizzes.php" class="btn btn-outline-secondary btn-sm">Back</a>
          </div>
        </div>
        <div class="card-body">
          <?php
          // Get all questions to determine total count and current question
          $qs = mysqli_query($con, "SELECT * FROM exam_questions WHERE exam_id=$quizId ORDER BY id ASC");
          if ($qs && mysqli_num_rows($qs) > 0) {
            $allQuestions = mysqli_fetch_all($qs, MYSQLI_ASSOC);
            $totalQuestions = count($allQuestions);
            
            // Validate current question number
            if ($current_question < 1) $current_question = 1;
            if ($current_question > $totalQuestions) $current_question = $totalQuestions;
            
            $question = $allQuestions[$current_question - 1];
            $savedAnswer = $_SESSION['quiz_answers'][$quizId][$question['id']] ?? '';
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
          <form action="takequiz.php" method="POST" id="questionForm">
            <input type="hidden" name="quiz_id" value="<?php echo $quizId; ?>">
            <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
            
            <div class="card mb-4">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-1">
                    <h5 class="text-primary"><?php echo $current_question; ?>.</h5>
                  </div>
                  <div class="col-md-11">
                    <h6 class="mb-3"><?php echo htmlspecialchars($question['question']); ?></h6>
                    
                    <div class="form-check mb-2">
                      <input class="form-check-input" type="radio" name="answer" value="A" id="q<?php echo $question['id']; ?>_A" <?php echo $savedAnswer === 'A' ? 'checked' : ''; ?>>
                      <label class="form-check-label" for="q<?php echo $question['id']; ?>_A">
                        A. <?php echo htmlspecialchars($question['option_a']); ?>
                      </label>
                    </div>
                    <div class="form-check mb-2">
                      <input class="form-check-input" type="radio" name="answer" value="B" id="q<?php echo $question['id']; ?>_B" <?php echo $savedAnswer === 'B' ? 'checked' : ''; ?>>
                      <label class="form-check-label" for="q<?php echo $question['id']; ?>_B">
                        B. <?php echo htmlspecialchars($question['option_b']); ?>
                      </label>
                    </div>
                    <div class="form-check mb-2">
                      <input class="form-check-input" type="radio" name="answer" value="C" id="q<?php echo $question['id']; ?>_C" <?php echo $savedAnswer === 'C' ? 'checked' : ''; ?>>
                      <label class="form-check-label" for="q<?php echo $question['id']; ?>_C">
                        C. <?php echo htmlspecialchars($question['option_c']); ?>
                      </label>
                    </div>
                    <div class="form-check mb-2">
                      <input class="form-check-input" type="radio" name="answer" value="D" id="q<?php echo $question['id']; ?>_D" <?php echo $savedAnswer === 'D' ? 'checked' : ''; ?>>
                      <label class="form-check-label" for="q<?php echo $question['id']; ?>_D">
                        D. <?php echo htmlspecialchars($question['option_d']); ?>
                      </label>
                    </div>
                    
                    <div class="text-muted small">
                      <i class="bi bi-star"></i> <?php echo $question['marks'] ?? 1; ?> mark(s)
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
                      <a href="takequiz.php?quiz_id=<?php echo $quizId; ?>&q=<?php echo $current_question - 1; ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Previous
                      </a>
                    <?php endif; ?>
                  </div>
                  
                  <div>
                    <a href="availablequizzes.php" class="btn btn-secondary me-2">Cancel Quiz</a>
                    
                    <?php if ($current_question < $totalQuestions): ?>
                      <button type="submit" class="btn btn-primary" name="save_answer">
                        Next <i class="bi bi-arrow-right"></i>
                      </button>
                      <input type="hidden" name="next_question" value="<?php echo $current_question + 1; ?>">
                    <?php else: ?>
                      <button type="button" class="btn btn-success" onclick="submitQuiz()">
                        <i class="bi bi-check-circle"></i> Submit Quiz
                      </button>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </form>
          
          <?php
          } else {
            echo "<div class='alert alert-info'>No questions found for this quiz.</div>";
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
// Quiz Timer functionality
var timeLimit = <?php echo isset($quiz['duration']) ? $quiz['duration'] * 60 : 30 * 60; ?>; // Convert to seconds
var timeLeft = timeLimit;
var timerElement = document.getElementById('time-left');
var timer = setInterval(function() {
  var minutes = Math.floor(timeLeft / 60);
  var seconds = timeLeft % 60;
  var timeString = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
  
  timerElement.innerHTML = timeString;
  
  if (timeLeft <= 0) {
    clearInterval(timer);
    timerElement.innerHTML = 'TIME UP!';
    
    // Auto-submit after 2 seconds
    setTimeout(function() {
      alert('Time is up! Your quiz will be submitted automatically.');
      submitQuiz();
    }, 2000);
  }
  
  timeLeft--;
}, 1000);

// Function to submit quiz
function submitQuiz() {
  if (confirm('Are you sure you want to submit this quiz? You cannot change your answers after submission.')) {
    // Create a form to submit all answers
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = 'takequiz.php';
    
    // Add quiz_id
    var quizIdInput = document.createElement('input');
    quizIdInput.type = 'hidden';
    quizIdInput.name = 'quiz_id';
    quizIdInput.value = '<?php echo $quizId; ?>';
    form.appendChild(quizIdInput);
    
    // Add submit flag
    var submitInput = document.createElement('input');
    submitInput.type = 'hidden';
    submitInput.name = 'submit_quiz';
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
      form.action = 'takequiz.php';
      form.style.display = 'none';
      
      var quizIdInput = document.createElement('input');
      quizIdInput.type = 'hidden';
      quizIdInput.name = 'quiz_id';
      quizIdInput.value = '<?php echo $quizId; ?>';
      form.appendChild(quizIdInput);
      
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

<?php
include('includes/footer.php');
ob_end_flush();
?>

