s<?php
include('includes/header.php');
include('includes/navbar.php');

$query = mysqli_query($con, "select * from exams_questions where questionID = '$_SESSION[id]' order by id desc limit 1");
$question_no = mysqli_fetch_array($query);
$num = $question_no ? $question_no['id'] : 0;
$num++;

$sql = "SELECT COUNT(*) AS count FROM exams_questions WHERE questionID = '$_SESSION[id]' ORDER by id desc";
$sql_run = mysqli_query($con, $sql);
while ($row = mysqli_fetch_assoc($sql_run)) {
    $output = $row['count'];
}

?>


  <main class="mt-5">
    <?php

    ?>
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
                <span><i class="bi bi-table me-2"></i>Set New Exams</span>
                <span><?php echo $_SESSION['course'];?></span>
                <span>No of Roll: <?php echo $output;?> / <?php echo $_SESSION['no_of_questions'];?></span>
              </div>
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col-md-8">
                    <form action="" method="POST" enctype="multipart/form-data">
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Question No:</label>
                          <div class="col-sm-9">
                          <input type="hidden" name="examID" value="<?php echo $_SESSION['id'];?>">
                          <input type="hidden" name="noofquestions" value="<?php echo $_SESSION['no_of_questions'];?>">
                          <input type="hidden" name="course" value="<?php echo $_SESSION['course'];?>">
                          <input type="hidden" name="semester" value="<?php echo $_SESSION['semester'];?>">
                          <input type="text" name="questionno" class="form-control" value="<?php echo $num++;?>" readonly>
                          </div>
                      </div>
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Question:</label>
                          <div class="col-sm-9">
                            <textarea name="question" class="form-control" id="editor"></textarea>
                          </div>
                      </div>
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Upload Pic (Opt):</label>
                          <div class="col-sm-9">
                          <input type="file" name="pic" class="form-control" accept="image/*,application/pdf,video/*">
                          </div>
                      </div>
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Option a</label>
                          <div class="col-sm-9">
                          <input type="text" name="optionA" class="form-control" value="">
                          </div>
                      </div>
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Option b</label>
                          <div class="col-sm-9">
                          <input type="text" name="optionB" class="form-control" value="">
                          </div>
                      </div>
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Option c</label>
                          <div class="col-sm-9">
                          <input type="text" name="optionC" class="form-control" value="">
                          </div>
                      </div>
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Option d</label>
                          <div class="col-sm-9">
                          <input type="text" name="optionD" class="form-control" value="">
                          </div>
                      </div>
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Correct Answer</label>
                          <div class="col-sm-9">
                          <select class="form-control" name="correct">
                            <option value="Please Select">Please Select</option>
                            <option value="a">a</option>
                            <option value="b">b</option>
                            <option value="c">c</option>
                            <option value="d">d</option>
                          </select>
                          </div>
                      </div>
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Reason</label>
                          <div class="col-sm-9">
                            <textarea name="reason" class="form-control" id="editor1"></textarea>
                          </div>
                      </div>
                      <div class="row mb-2">
                          <label class="col-sm-3 col-form-label">Marks</label>
                          <div class="col-sm-9">
                          <input type="text" name="mark" class="form-control" value="">
                          </div>
                      </div>
                      <hr>
                      <div class="row-flex text-center">
                        <button type="reset" name="reset" class="btn btn-primary col-md-4">Reset</button>
                        <button type="submit" name="submit" class="btn btn-success col-md-4">Submit</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
          </div>
        </div>
<!-- <div id="editor">
    <p>Hello from CKEditor 5!</p>
</div> -->

        
      </div>
    </main>

<?php
include('includes/footer.php');
?>


<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.0/"
        }
    }
</script>

<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Bold,
        Italic,
        Font,
        Paragraph
    } from 'ckeditor5';

    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
            toolbar: {
                items: [
                    'undo', 'redo', '|', 'bold', 'italic', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                ]
            }
        } )
        .then( /* ... */ )
        .catch( /* ... */ );
</script>

<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Bold,
        Italic,
        Font,
        Paragraph
    } from 'ckeditor5';

    ClassicEditor
        .create( document.querySelector( '#editor1' ), {
            plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
            toolbar: {
                items: [
                    'undo', 'redo', '|', 'bold', 'italic', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                ]
            }
        } )
        .then( /* ... */ )
        .catch( /* ... */ );
</script>

<?php
if (isset($_POST['submit'])) {
  $questionno = mysqli_real_escape_string($con, $_POST["questionno"]);
  $question = mysqli_real_escape_string($con, $_POST["question"]);
  $optionA = mysqli_real_escape_string($con, $_POST["optionA"]);
  $optionB = mysqli_real_escape_string($con, $_POST["optionB"]);
  $optionC = mysqli_real_escape_string($con, $_POST["optionC"]);
  $optionD = mysqli_real_escape_string($con, $_POST["optionD"]);
  $correct = mysqli_real_escape_string($con, $_POST["correct"]);
  $reason = mysqli_real_escape_string($con, $_POST["reason"]);
  $mark = mysqli_real_escape_string($con, $_POST["mark"]);
  $examID = mysqli_real_escape_string($con, $_POST["examID"]);
  $noofquestions = mysqli_real_escape_string($con, $_POST["noofquestions"]);
  $course = mysqli_real_escape_string($con, $_POST["course"]);
  $semester = mysqli_real_escape_string($con, $_POST["semester"]);

  if (empty($question)) { $_SESSION['status'] = "Please Enter Question"; header('location: startexams.php'); exit(); }
  if (empty($optionA)) { $_SESSION['status'] = "Please Enter Possible Answer A"; header('location: startexams.php'); exit(); }
  if (empty($optionB)) { $_SESSION['status'] = "Please Enter Possible Answer B"; header('location: startexams.php'); exit(); }
  if (empty($optionC)) { $_SESSION['status'] = "Please Enter Possible Answer C"; header('location: startexams.php'); exit(); }
  if (empty($optionD)) { $_SESSION['status'] = "Please Enter Possible Answer D"; header('location: startexams.php'); exit(); }
  if ($correct === 'Please Select') { $_SESSION['status'] = "Please Select Correct Answer"; header('location: startexams.php'); exit(); }

  // Optional attachment upload
  $attachmentPath = '';
  if (!empty($_FILES['pic']['name'])) {
    $uploadDir = __DIR__ . '/../uploads/exams';
    if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0775, true); }
    $origName = basename($_FILES['pic']['name']);
    $ext = pathinfo($origName, PATHINFO_EXTENSION);
    $safeName = uniqid('q_').'.'.$ext;
    $targetFsPath = $uploadDir . '/' . $safeName;
    $webPath = 'uploads/exams/' . $safeName; // relative to oes/
    if (move_uploaded_file($_FILES['pic']['tmp_name'], $targetFsPath)) {
      $attachmentPath = $webPath;
    }
  }

  // Discover possible attachment column in exams_questions
  $desc = mysqli_query($con, "SHOW COLUMNS FROM exams_questions");
  $cols = [];
  if ($desc) { while ($r = mysqli_fetch_assoc($desc)) { $cols[] = $r['Field']; } }
  $attachmentColumn = '';
  foreach (['pic','attachment','image','file','file_path'] as $cand) { if (in_array($cand, $cols)) { $attachmentColumn = $cand; break; } }

  $fields = [
    'staffID','questionID','question_no','question','option1','option2','option3','option4','correct_answer','reason','marks'
  ];
  $values = [
    $_SESSION['schoolID'], $examID, $questionno, $question, $optionA, $optionB, $optionC, $optionD, $correct, $reason, $mark
  ];
  if ($attachmentColumn && $attachmentPath !== '') { $fields[] = $attachmentColumn; $values[] = $attachmentPath; }

  // Escape values for SQL insert
  $esc = array_map(function($v) use ($con){ return "'".mysqli_real_escape_string($con, (string)$v)."'"; }, $values);
  $sql = "INSERT INTO exams_questions (".implode(', ', $fields).") VALUES (".implode(', ', $esc).")";
  $query_run = mysqli_query($con, $sql);
  if ($query_run) {
    $_SESSION['success'] = "Success!! Information Saved Successfully";
    echo '<script type="text/javascript">window.location="startexams.php"</script>';
    exit();
  } else {
    $_SESSION['status'] = "Error!! Information not Saved Successfully";
    echo '<script type="text/javascript">window.location="startexams.php"</script>';
    exit();
  }
}
?>

