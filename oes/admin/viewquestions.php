<?php
include('includes/header.php');
include('includes/navbar.php');

?> 

<main class="mt-5 pt-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 mb-3">
        <div class="card-header d-sm-flex align-items-center justify-content-between">
          <span><i class="bi bi-table me-2"></i>All Questions</span> 
        </div>
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
        <div class="card-body">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-12">
              <table id="example" class="table table-striped table-hover text-center">
                <thead class="table-success">
                  <tr>
                    <th hidden>ID.</th>
                    <th>S. No.</th>
                    <th>Exam</th>
                    <th>Course</th>
                    <th>Question</th>
                    <th>Correct Answer</th>
                    <th>Marks</th>
                    <th>Created By</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="data">
                  <?php
                  $query = "SELECT q.*, e.title as exam_title, e.course, e.created_by FROM exam_questions q LEFT JOIN exams_setting e ON q.exam_id = e.id ORDER BY q.created_at DESC";
                  $query_run = mysqli_query($con, $query);
                  if($query_run && mysqli_num_rows($query_run) > 0){
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($query_run)){
                  ?>
                  <tr>
                    <td hidden><?php echo $row["id"];?></td>
                    <td><?php echo $no;?></td>
                    <td><?php echo $row["exam_title"];?></td>
                    <td><?php echo $row["course"];?></td>
                    <td class="text-start"><?php echo substr(strip_tags($row["question"]), 0, 80); ?>...</td>
                    <td><?php echo strtoupper($row["correct_option"]);?></td>
                    <td><?php echo $row["marks"];?></td>
                    <td><?php echo $row["created_by"];?></td>
                    <td>
                      <a href="examquestions.php?exam_id=<?php echo $row['exam_id'];?>" class="btn btn-info btn-sm" title="View Exam Questions">
                        <i class="bi bi-eye"></i>
                      </a>
                    </td>
                  </tr>
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
        </div>
      </div>
    </div>
  </div>
</main>

<?php
include('includes/footer.php');
?>


