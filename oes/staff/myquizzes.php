<?php
include('includes/header.php');
include('includes/navbar.php');
?>

<main class="mt-5 pt-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 mb-3">
        <div class="card-header d-sm-flex align-items-center justify-content-between">
          <span><i class="bi bi-list-task me-2"></i>My Quizzes</span>
          <a href="createquiz.php" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> Create Quiz</a>
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
                    <th style="width:120px;">Duration (mins)</th>
                    <th style="width:140px;">Questions</th>
                    <th style="width:160px;">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $n=1;
                  $staffId = mysqli_real_escape_string($con, $_SESSION['schoolID']);
                  // Be tolerant of schemas missing some fields
                  $cols = [];
                  $cr = mysqli_query($con, "SHOW COLUMNS FROM exams_setting");
                  if ($cr) { while($c = mysqli_fetch_assoc($cr)){ $cols[$c['Field']] = true; } }
                  $select = ['id','title','course'];
                  if (isset($cols['duration'])) { $select[]='duration'; }
                  if (isset($cols['total_questions'])) { $select[]='total_questions'; }
                  $res = mysqli_query($con, "SELECT ".implode(',', $select)." FROM exams_setting WHERE category='Quiz' AND ".(isset($cols['created_by'])?"created_by='".$staffId."'":"1=1")." ORDER BY id DESC");
                  if ($res && mysqli_num_rows($res)>0) {
                    while($r = mysqli_fetch_assoc($res)){
                      echo '<tr>';
                      echo '<td>'.$n++.'</td>';
                      echo '<td class="text-start">'.htmlspecialchars($r['title']).'</td>';
                      echo '<td>'.htmlspecialchars($r['course']).'</td>';
                      echo '<td>'.(isset($r['duration'])?(int)$r['duration']:'-').'</td>';
                      echo '<td>'.(isset($r['total_questions'])?(int)$r['total_questions']:'-').'</td>';
                      echo '<td>';
                      echo '<a href="myquizquestions.php?quiz_id='.$r['id'].'" class="btn btn-sm btn-outline-primary me-1">Questions</a>';
                      echo '<a href="createquiz.php?edit='.$r['id'].'" class="btn btn-sm btn-outline-secondary">Edit</a>';
                      echo '</td>';
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
    </div>
  </div>
</main>

<?php
include('includes/footer.php');
?>

