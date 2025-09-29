<?php
include('includes/header.php');
include('includes/navbar.php');

$student_id = $_SESSION['indexnumber'];
$exam_id = isset($_GET['exam_id']) ? $_GET['exam_id'] : '';

?> 

<main class="mt-5 pt-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 mb-3">
        <div class="card-header d-sm-flex align-items-center justify-content-between">
          <span><i class="bi bi-trophy me-2"></i>My Exam & Quiz Results</span> 
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
                    <th>Course</th>
                    <th>Score</th>
                    <th>Total Questions</th>
                    <th>Percentage</th>
                    <th>Grade</th>
                    <th>Taken At</th>
                    <th class="no-sort" style="width: 120px;">Actions</th>
                  </tr>
                </thead>
                <tbody id="data">
                  <?php
                  $query = "SELECT r.*, e.title as exam_title, e.course, e.total_questions, e.totalmarks, e.category 
                           FROM exam_results r 
                           LEFT JOIN exams_setting e ON r.exam_id = e.id 
                           WHERE r.student_id = '$student_id'";
                  
                  if ($exam_id) {
                    $query .= " AND r.exam_id = '$exam_id'";
                  }
                  
                  $query .= " ORDER BY r.taken_at DESC";
                  
                  $query_run = mysqli_query($con, $query);
                  if($query_run && mysqli_num_rows($query_run) > 0){
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($query_run)){
                      $denominator = (isset($row['totalmarks']) && (int)$row['totalmarks'] > 0) ? (int)$row['totalmarks'] : ((int)$row['total_questions'] > 0 ? (int)$row['total_questions'] : 0);
                      $percentage = $denominator > 0 ? round(($row['score'] / $denominator) * 100, 2) : 0;
                      
                      // Calculate grade
                      $grade = '';
                      $gradeClass = '';
                      if ($percentage >= 90) {
                        $grade = 'A+';
                        $gradeClass = 'text-success';
                      } elseif ($percentage >= 80) {
                        $grade = 'A';
                        $gradeClass = 'text-success';
                      } elseif ($percentage >= 70) {
                        $grade = 'B+';
                        $gradeClass = 'text-primary';
                      } elseif ($percentage >= 60) {
                        $grade = 'B';
                        $gradeClass = 'text-primary';
                      } elseif ($percentage >= 50) {
                        $grade = 'C';
                        $gradeClass = 'text-warning';
                      } else {
                        $grade = 'F';
                        $gradeClass = 'text-danger';
                      }
                  ?>
                  <tr>
                    <td hidden><?php echo $row["id"];?></td>
                    <td><?php echo $no;?></td>
                    <td><?php echo $row["exam_title"] . (isset($row['category']) && $row['category'] ? ' ('.htmlspecialchars($row['category']).')' : ''); ?></td>
                    <td><?php echo $row["course"];?></td>
                    <td><?php echo $row["score"];?></td>
                    <td><?php echo $row["total_questions"];?></td>
                    <td>
                      <span class="badge <?php echo $percentage >= 70 ? 'bg-success' : ($percentage >= 50 ? 'bg-warning' : 'bg-danger'); ?>">
                        <?php echo $percentage; ?>%
                      </span>
                    </td>
                    <td>
                      <span class="fw-bold <?php echo $gradeClass; ?>"><?php echo $grade; ?></span>
                    </td>
                    <td><?php echo date('M d, Y H:i', strtotime($row["taken_at"]));?></td>
                    <td>
                      <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewResultModal<?php echo $row['id']; ?>" title="View Details">
                        <i class="bi bi-eye"></i>
                      </button>
                      <button type="button" class="btn btn-primary btn-sm" onclick="printResult(<?php echo $row['id']; ?>)" title="Print Result">
                        <i class="bi bi-printer"></i>
                      </button>
                    </td>
                  </tr>

                  <!-- View Result Modal -->
                  <div class="modal fade" id="viewResultModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewResultModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="viewResultModalLabel<?php echo $row['id']; ?>">Exam Result Details</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="resultContent<?php echo $row['id']; ?>">
                          <div class="row">
                            <div class="col-md-6">
                              <h6>Student Information</h6>
                              <p><strong>Name:</strong> <?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname']; ?></p>
                              <p><strong>Index Number:</strong> <?php echo $student_id; ?></p>
                            </div>
                            <div class="col-md-6">
                              <h6>Exam Information</h6>
                              <p><strong>Exam:</strong> <?php echo $row["exam_title"]; ?></p>
                              <p><strong>Course:</strong> <?php echo $row["course"]; ?></p>
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-md-3">
                              <div class="text-center">
                                <h4 class="text-primary"><?php echo $row["score"]; ?></h4>
                                <p class="text-muted">Score</p>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="text-center">
                                <h4 class="text-info"><?php echo $row["total_questions"]; ?></h4>
                                <p class="text-muted">Total Questions</p>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="text-center">
                                <h4 class="<?php echo $percentage >= 70 ? 'text-success' : ($percentage >= 50 ? 'text-warning' : 'text-danger'); ?>">
                                  <?php echo $percentage; ?>%
                                </h4>
                                <p class="text-muted">Percentage</p>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="text-center">
                                <h4 class="<?php echo $gradeClass; ?>"><?php echo $grade; ?></h4>
                                <p class="text-muted">Grade</p>
                              </div>
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-12">
                              <p><strong>Taken At:</strong> <?php echo date('M d, Y H:i:s', strtotime($row["taken_at"])); ?></p>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary" onclick="printResult(<?php echo $row['id']; ?>)">Print Result</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <?php
                  $no++;
                  }
                }else{
                  echo "<tr><td hidden></td><td colspan='9' class='text-center'>No exam results found</td></tr>";
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

<script>
function printResult(resultId) {
  var printContent = document.getElementById('resultContent' + resultId).innerHTML;
  var originalContent = document.body.innerHTML;
  
  document.body.innerHTML = `
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header text-center">
              <h4>Optimum Training Institute</h4>
              <h5>Exam Result</h5>
            </div>
            <div class="card-body">
              ${printContent}
            </div>
            <div class="card-footer text-center">
              <small>Printed on: ${new Date().toLocaleString()}</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  `;
  
  window.print();
  document.body.innerHTML = originalContent;
  location.reload();
}
</script>

<?php
include('includes/footer.php');
?>