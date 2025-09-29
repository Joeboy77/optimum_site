<?php
include('includes/header.php');
include('includes/navbar.php');

$student_id = $_SESSION['indexnumber'] ?? '';
$student_course = $_SESSION['course'] ?? '';

// Debug: Check if student is logged in
if (empty($student_id)) {
    $_SESSION['status'] = 'Please log in to view available exams';
    header('Location: index.php');
    exit();
}

// Debug information (remove in production)
$debug_info = "Student ID: " . $student_id . ", Course: " . $student_course;


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
          <span><i class="bi bi-calendar-check me-2"></i>Available Exams</span>
          <small class="text-muted"><?php echo $debug_info; ?></small>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <table id="example" class="table table-striped table-hover text-center">
                <thead class="table-success">
                  <tr>
                    <th hidden>S. No.</th>
                    <th>S. No.</th>
                    <th>Exam Title</th>
                    <th>Category</th>
                    <th>Course</th>
                    <th>Duration</th>
                    <th>Questions</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                    <th class="no-sort" style="width: 120px;">Actions</th>
                  </tr>
                </thead>
                <tbody id="data">
                  <?php
                  $current_time = date('Y-m-d H:i:s');
                  $query = "SELECT e.*, c.name as category_name
                           FROM exams_setting e 
                           LEFT JOIN exam_categories c ON e.category = c.name 
                           WHERE (e.course = '$student_course' OR e.course = '' OR e.course IS NULL)
                           AND (e.category != 'Quiz' OR e.category IS NULL)
                           ORDER BY e.id DESC";
                  
                  $query_run = mysqli_query($con, $query);
                  if (!$query_run) {
                    echo "<tr><td colspan='11' class='text-center text-danger'>Database error: " . mysqli_error($con) . "</td></tr>";
                  } elseif (mysqli_num_rows($query_run) > 0) {
                    // Debug: Show query info
                    echo "<!-- Debug: Query returned " . mysqli_num_rows($query_run) . " rows -->";
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($query_run)){
                      // Normalize dates
                      $startRaw = $row['start_at'];
                      $endRaw = $row['end_at'];
                      $startAt = (!empty($startRaw) && $startRaw !== '0000-00-00 00:00:00') ? strtotime($startRaw) : null;
                      $endAt = (!empty($endRaw) && $endRaw !== '0000-00-00 00:00:00') ? strtotime($endRaw) : null;
                      $nowTs = strtotime($current_time);

                      // Compute status in PHP to avoid SQL invalid datetime comparisons
                      if ($startAt === null) {
                        $exam_status = 'Available';
                      } elseif ($startAt > $nowTs) {
                        $exam_status = 'Not Started';
                      } elseif ($endAt !== null && $endAt < $nowTs) {
                        $exam_status = 'Expired';
                      } else {
                        $exam_status = 'Available';
                      }
                      $can_take = ($exam_status === 'Available');
                      
                      // Check if student already took this exam
                      $takenQuery = "SELECT * FROM exam_results WHERE exam_id='".$row['id']."' AND student_id='$student_id'";
                      $takenResult = mysqli_query($con, $takenQuery);
                      if ($takenResult && mysqli_num_rows($takenResult) > 0) {
                        $can_take = false;
                        $exam_status = 'Completed';
                      }
                  ?>
                  <tr>
                    <td hidden><?php echo $row["id"];?></td>
                    <td><?php echo $no;?></td>
                    <td><?php echo $row["title"];?></td>
                    <td><?php echo $row["category_name"] ?: $row["category"];?></td>
                    <td><?php echo $row["course"];?></td>
                    <td><?php echo $row["timelimit"];?> min</td>
                    <td><?php echo $row["total_questions"];?></td>
                    <td><?php echo ($startAt !== null) ? date('M d, Y H:i', $startAt) : 'Not set';?></td>
                    <td><?php echo ($endAt !== null) ? date('M d, Y H:i', $endAt) : 'Not set';?></td>
                    <td>
                      <span class="badge <?php 
                        echo $exam_status == 'Available' ? 'bg-success' : 
                             ($exam_status == 'Not Started' ? 'bg-warning' : 
                             ($exam_status == 'Completed' ? 'bg-info' : 'bg-danger')); 
                      ?>">
                        <?php echo $exam_status; ?>
                      </span>
                    </td>
                    <td>
                      <?php if ($can_take): ?>
                        <a href="takeexam.php?exam_id=<?php echo $row['id'];?>" class="btn btn-primary btn-sm" title="Take Exam">
                          <i class="bi bi-play-circle"></i> Take Exam
                        </a>
                      <?php elseif ($exam_status == 'Completed'): ?>
                        <a href="myresults.php?exam_id=<?php echo $row['id'];?>" class="btn btn-info btn-sm" title="View Result">
                          <i class="bi bi-eye"></i> View Result
                        </a>
                      <?php else: ?>
                        <button class="btn btn-secondary btn-sm" disabled title="Exam not available">
                          <i class="bi bi-lock"></i> Not Available
                        </button>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <?php
                  $no++;
                  }
                  } else {
                    echo "<tr><td colspan='11' class='text-center text-info'>No exams available for your course</td></tr>";
                    // Debug: Show all exams in database
                    $debugQuery = "SELECT id, title, course, category FROM exams_setting ORDER BY id DESC LIMIT 10";
                    $debugResult = mysqli_query($con, $debugQuery);
                    if ($debugResult && mysqli_num_rows($debugResult) > 0) {
                      echo "<!-- Debug: All exams in DB: ";
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