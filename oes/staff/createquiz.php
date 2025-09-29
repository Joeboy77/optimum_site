<?php
ob_start();
include('includes/header.php');
include('includes/navbar.php');

// Create or update quiz in exams_setting with category='Quiz' (schema-aware)
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['save_quiz'])) {
  $title = mysqli_real_escape_string($con, $_POST['title'] ?? '');
  $course = mysqli_real_escape_string($con, $_POST['course'] ?? '');
  $duration = (int)($_POST['duration'] ?? 0);
  $total_questions = (int)($_POST['total_questions'] ?? 0);
  $totalmarks = (int)($_POST['totalmarks'] ?? 0);
  // optional schedule fields
  $start_at = mysqli_real_escape_string($con, $_POST['start_at'] ?? '');
  $end_at = mysqli_real_escape_string($con, $_POST['end_at'] ?? '');
  $created_by = mysqli_real_escape_string($con, $_SESSION['schoolID']);
  $id = isset($_POST['quiz_id']) ? (int)$_POST['quiz_id'] : 0;

  // Discover existing columns
  $colsRes = mysqli_query($con, "SHOW COLUMNS FROM exams_setting");
  $existing = [];
  if ($colsRes) { while($c = mysqli_fetch_assoc($colsRes)){ $existing[$c['Field']] = true; } }

  // Build data map and filter by existing columns
  $data = [
    'title' => $title,
    'category' => 'Quiz',
    'course' => $course,
    'duration' => $duration,
    'total_questions' => $total_questions,
    'totalmarks' => $totalmarks,
    'start_at' => $start_at,
    'end_at' => $end_at,
    'created_by' => $created_by,
  ];

  // Remove keys not present in table
  foreach ($data as $k=>$v) {
    if (!isset($existing[$k])) { unset($data[$k]); }
  }

  if ($id>0) {
    // UPDATE only existing fields
    $sets = [];
    foreach ($data as $k=>$v) {
      $val = is_int($v) ? (int)$v : "'".mysqli_real_escape_string($con, (string)$v)."'";
      if ($k === 'category' || $k === 'created_by') { continue; } // keep category/created_by unchanged on update
      $sets[] = $k."=".$val;
    }
    if (!empty($sets)) {
      $q = "UPDATE exams_setting SET ".implode(',', $sets)." WHERE id=$id ";
      if (isset($existing['created_by'])) { $q .= "AND created_by='".$created_by."' "; }
      $q .= "LIMIT 1";
      if (!mysqli_query($con, $q)) {
        $_SESSION['status'] = 'Error updating quiz: '.mysqli_error($con);
        header('Location: createquiz.php?edit='.$id);
        exit();
      }
    }
    $_SESSION['success'] = 'Quiz updated';
    header('Location: myquizquestions.php?quiz_id='.$id);
    exit();
  } else {
    // INSERT only existing fields
    $columns = array_keys($data);
    $values = [];
    foreach ($data as $k=>$v) {
      $values[] = is_int($v) ? (int)$v : "'".mysqli_real_escape_string($con, (string)$v)."'";
    }
    if (!empty($columns)) {
      $q = "INSERT INTO exams_setting (".implode(',', $columns).") VALUES (".implode(',', $values).")";
      if (mysqli_query($con, $q)) {
        $newId = mysqli_insert_id($con);
        $_SESSION['success'] = 'Quiz created';
        header('Location: myquizquestions.php?quiz_id='.$newId);
        exit();
      } else {
        $_SESSION['status'] = 'Error creating quiz: '.mysqli_error($con);
      }
    } else {
      $_SESSION['status'] = 'Quiz could not be created due to missing columns.';
    }
  }
}

// If editing, load quiz
$edit = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$quiz = null;
if ($edit>0) {
  $res = mysqli_query($con, "SELECT * FROM exams_setting WHERE id=$edit AND category='Quiz' AND created_by='".$_SESSION['schoolID']."' LIMIT 1");
  if ($res && mysqli_num_rows($res)===1) { $quiz = mysqli_fetch_assoc($res); }
}

// Load courses assigned to this tutor (from tutorclass)
$courseOptions = [];
$crs = mysqli_query($con, "SELECT DISTINCT course_code FROM tutorclass WHERE staffID='".$_SESSION['schoolID']."' ORDER BY course_code ASC");
if ($crs && mysqli_num_rows($crs)>0) {
  while($c = mysqli_fetch_assoc($crs)) { $courseOptions[] = $c['course_code']; }
}
?>

<main class="mt-5 pt-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-10 col-lg-8 mx-auto">
        <div class="card-header d-flex justify-content-between align-items-center mb-3">
          <span><?php echo $quiz ? 'Edit Quiz' : 'Create Quiz'; ?></span>
          <a href="myquizzes.php" class="btn btn-outline-secondary btn-sm">Back</a>
        </div>
        <div class="card-body" style="border:1px solid cornflowerblue;">
          <?php if(!empty($_SESSION['status'])){ echo '<div class="alert alert-warning">'.$_SESSION['status'].'</div>'; unset($_SESSION['status']); } ?>
          <form method="POST">
            <?php if($quiz){ echo '<input type="hidden" name="quiz_id" value="'.(int)$quiz['id'].'">'; } ?>
            <div class="mb-3">
              <label class="form-label">Title</label>
              <input type="text" name="title" class="form-control" required value="<?php echo htmlspecialchars($quiz['title'] ?? ''); ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Course</label>
              <select name="course" class="form-control" required>
                <option value="">Select course</option>
                <?php
                  $selectedCourse = $quiz['course'] ?? '';
                  foreach ($courseOptions as $opt) {
                    $sel = ($selectedCourse === $opt) ? 'selected' : '';
                    echo '<option value="'.htmlspecialchars($opt).'" '.$sel.'>'.htmlspecialchars($opt).'</option>';
                  }
                ?>
              </select>
            </div>
            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">Duration (mins)</label>
                <input type="number" min="1" name="duration" class="form-control" required value="<?php echo (int)($quiz['duration'] ?? 30); ?>">
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Total Questions</label>
                <input type="number" min="1" name="total_questions" class="form-control" required value="<?php echo (int)($quiz['total_questions'] ?? 10); ?>">
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Total Marks</label>
                <input type="number" min="1" name="totalmarks" class="form-control" required value="<?php echo (int)($quiz['totalmarks'] ?? 10); ?>">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Start At (optional)</label>
                <input type="datetime-local" name="start_at" class="form-control" value="<?php echo !empty($quiz['start_at']) ? date('Y-m-d\TH:i', strtotime($quiz['start_at'])) : ''; ?>">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">End At (optional)</label>
                <input type="datetime-local" name="end_at" class="form-control" value="<?php echo !empty($quiz['end_at']) ? date('Y-m-d\TH:i', strtotime($quiz['end_at'])) : ''; ?>">
              </div>
            </div>
            <button type="submit" name="save_quiz" class="btn btn-primary">Save and Manage Questions</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

<?php
include('includes/footer.php');
ob_end_flush();
?>

