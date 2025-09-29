<?php
// Start output buffering so header redirects work even if templates output HTML
ob_start();
include('includes/header.php');
include('includes/navbar.php');

$teacher_name = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];

// Handle POST requests at the top
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['create_exam'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $course = mysqli_real_escape_string($con, $_POST['course']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $timelimit = mysqli_real_escape_string($con, $_POST['timelimit']);
    $totalmarks = mysqli_real_escape_string($con, $_POST['totalmarks']);
    $total_questions = mysqli_real_escape_string($con, $_POST['total_questions']);
    $start_at = mysqli_real_escape_string($con, $_POST['start_at']);
    $end_at = mysqli_real_escape_string($con, $_POST['end_at']);
    
    if (empty($title) || empty($category) || empty($course)) {
      $_SESSION['status'] = 'Title, Category, and Course are required';
    } else {
      $query = "INSERT INTO exams_setting (title, category, course, semester, timelimit, totalmarks, total_questions, start_at, end_at, created_by) VALUES ('$title', '$category', '$course', '$semester', '$timelimit', '$totalmarks', '$total_questions', '$start_at', '$end_at', '$teacher_name')";
      if (mysqli_query($con, $query)) {
        $exam_id = mysqli_insert_id($con);
        $_SESSION['success'] = 'Exam created successfully! You can now add questions to your exam.';
        header('Location: myquestions.php?exam_id=' . $exam_id);
        exit();
      } else {
        $_SESSION['status'] = 'Error creating exam: ' . mysqli_error($con);
      }
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
          <span><i class="bi bi-plus-circle me-2"></i>Create New Exam</span> 
          <div class="text-xs font-weight-bold">
            <a href="myexams.php" class="btn btn-secondary btn-sm">
              <i class="bi bi-arrow-left"></i> Back to My Exams
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <form action="createexam.php" method="POST">
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Exam Title</label>
                      <input type="text" name="title" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Category</label>
                      <select name="category" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php
                        $catQuery = "SELECT * FROM exam_categories ORDER BY name ASC";
                        $catResult = mysqli_query($con, $catQuery);
                        while ($cat = mysqli_fetch_assoc($catResult)) {
                          echo "<option value='".$cat['name']."'>".$cat['name']."</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Course</label>
                      <select name="course" class="form-control" required>
                        <option value="">Select Course</option>
                        <?php
                        $courseQuery = "SELECT * FROM courses ORDER BY course_name ASC";
                        $courseResult = mysqli_query($con, $courseQuery);
                        while ($course = mysqli_fetch_assoc($courseResult)) {
                          echo "<option value='".$course['course_name']."'>".$course['course_name']."</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Semester</label>
                      <select name="semester" class="form-control">
                        <option value="Semester 1">Semester 1</option>
                        <option value="Semester 2">Semester 2</option>
                        <option value="Semester 3">Semester 3</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label class="form-label">Duration (minutes)</label>
                      <input type="number" name="timelimit" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label class="form-label">Total Marks</label>
                      <input type="number" name="totalmarks" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label class="form-label">Total Questions</label>
                      <input type="number" name="total_questions" class="form-control" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Start Date & Time</label>
                      <input type="datetime-local" name="start_at" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">End Date & Time</label>
                      <input type="datetime-local" name="end_at" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <div class="alert alert-info">
                      <i class="bi bi-info-circle me-2"></i>
                      <strong>Next Step:</strong> After creating the exam, you'll be redirected to add questions to your exam.
                    </div>
                    <div class="d-grid">
                      <button type="submit" class="btn btn-success btn-lg" name="create_exam">
                        <i class="bi bi-plus-circle me-2"></i>Create Exam & Add Questions
                      </button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<?php
include('includes/footer.php');
// Flush the output buffer
ob_end_flush();
?>