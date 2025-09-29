<?php
include('includes/header.php');
include('includes/navbar.php');

// Ensure session course
$studentId = $_SESSION['indexnumber'] ?? '';
$studentCourse = $_SESSION['course'] ?? '';

// Debug information (remove in production)
$debug_info = "Student ID: " . $studentId . ", Course: " . $studentCourse;

?>

<main class="mt-5 pt-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 mb-3">
        <div class="card-header d-sm-flex align-items-center justify-content-between">
          <span><i class="bi bi-list-check me-2"></i>Available Quizzes</span>
          <small class="text-muted"><?php echo $debug_info; ?></small>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <table id="example" class="table table-striped table-hover align-middle">
                <thead class="table-success">
                  <tr>
                    <th style="width:70px;">#</th>
                    <th class="text-start">Title</th>
                    <th>Course</th>
                    <th style="width:160px;">Start</th>
                    <th style="width:160px;">End</th>
                    <th style="width:120px;">My Score</th>
                    <th style="width:120px;">Status</th>
                    <th style="width:140px;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $n=1;
                  $cols = [];
                  $cr = mysqli_query($con, "SHOW COLUMNS FROM exams_setting");
                  if ($cr) { while($c = mysqli_fetch_assoc($cr)){ $cols[$c['Field']] = true; } }
                  $staffCourse = mysqli_real_escape_string($con, $studentCourse);
                  $res = mysqli_query($con, "SELECT id, title, course".
                    (isset($cols['start_at'])?', start_at':'').
                    (isset($cols['end_at'])?', end_at':'').
                    (isset($cols['duration'])?', duration':'').
                    (isset($cols['totalmarks'])?', totalmarks':'').
                    (isset($cols['total_questions'])?', total_questions':'').
                    " FROM exams_setting WHERE category='Quiz' AND (course='".$staffCourse."' OR course='' OR course IS NULL) ORDER BY id DESC");
                  $now = time();
                  if ($res && mysqli_num_rows($res)>0) {
                    // Debug: Show query info
                    echo "<!-- Debug: Quiz query returned " . mysqli_num_rows($res) . " rows -->";
                    while($r = mysqli_fetch_assoc($res)){
                      // Fetch my latest score for this quiz
                      $myScore = '-';
                      $rr = mysqli_query($con, "SELECT score FROM exam_results WHERE exam_id=".$r['id']." AND student_id='".$studentId."' ORDER BY taken_at DESC LIMIT 1");
                      if ($rr && mysqli_num_rows($rr)>0) { $rowS = mysqli_fetch_assoc($rr); $myScore = (int)$rowS['score']; }
                      $den = 0;
                      if (isset($r['totalmarks']) && (int)$r['totalmarks']>0) { $den = (int)$r['totalmarks']; }
                      elseif (isset($r['total_questions']) && (int)$r['total_questions']>0) { $den = (int)$r['total_questions']; }
                      $start = isset($r['start_at']) && !empty($r['start_at']) ? strtotime($r['start_at']) : null;
                      $end = isset($r['end_at']) && !empty($r['end_at']) ? strtotime($r['end_at']) : null;
                      $status = 'Available';
                      if ($start && $now < $start) $status = 'Not Started';
                      if ($end && $now > $end) $status = 'Expired';
                      echo '<tr>';
                      echo '<td>'.$n++.'</td>';
                      echo '<td class="text-start">'.htmlspecialchars($r['title']).'</td>';
                      echo '<td>'.htmlspecialchars($r['course']).'</td>';
                      echo '<td>'.(!empty($r['start_at'])?htmlspecialchars($r['start_at']):'-').'</td>';
                      echo '<td>'.(!empty($r['end_at'])?htmlspecialchars($r['end_at']):'-').'</td>';
                      $scoreDisplay = ($myScore==='-') ? '-' : ($myScore.'/'.($den>0?$den:'-'));
                      echo '<td>'.htmlspecialchars($scoreDisplay).'</td>';
                      echo '<td>'.$status.'</td>';
                      $disabled = ($status!=='Available' || $myScore!=='-')? ' disabled' : '';
                      echo '<td><a href="takequiz.php?quiz_id='.$r['id'].'" class="btn btn-sm btn-primary'.$disabled.'">Take</a></td>';
                      echo '</tr>';
                    }
                  } else {
                    echo '<tr><td colspan="8" class="text-center text-info">No quizzes available for your course</td></tr>';
                    // Debug: Show all quizzes in database
                    $debugQuery = "SELECT id, title, course, category FROM exams_setting WHERE category='Quiz' ORDER BY id DESC LIMIT 10";
                    $debugResult = mysqli_query($con, $debugQuery);
                    if ($debugResult && mysqli_num_rows($debugResult) > 0) {
                      echo "<!-- Debug: All quizzes in DB: ";
                      while($debugRow = mysqli_fetch_assoc($debugResult)) {
                        echo "ID:" . $debugRow['id'] . " Title:" . $debugRow['title'] . " Course:" . $debugRow['course'] . " Category:" . $debugRow['category'] . " | ";
                      }
                      echo " -->";
                    }
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

