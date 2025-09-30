<?php
// Early endpoint for AJAX: return course dropdown for a selected program
if (isset($_GET['list_courses_for_program'])) {
  require_once '../../config.php';
  $pid = mysqli_real_escape_string($con, $_GET['list_courses_for_program']);
  $options = "<select class=\"form-control\" name='courseselected' required>";
  $options .= "<option value='Select Course'>Select Course</option>";
  $cres = mysqli_query($con, "SELECT id, course_name FROM courses WHERE programTypeID='".$pid."' ORDER BY course_name ASC");
  if ($cres && mysqli_num_rows($cres) > 0) {
    while ($c = mysqli_fetch_assoc($cres)) {
      $options .= "<option value='".htmlspecialchars($c['id'])."'>".htmlspecialchars($c['course_name'])."</option>";
    }
  }
  $options .= "</select>";
  echo $options;
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['proceed'])) {
  require_once '../../config.php';
  if (session_status() === PHP_SESSION_NONE) { session_start(); }

  $placeofbirth = mysqli_real_escape_string($con, $_POST["placeofbirth"] ?? '');
  $hometown = mysqli_real_escape_string($con, $_POST["hometown"] ?? '');
  $region = mysqli_real_escape_string($con, $_POST["region"] ?? '');
  $nationality = mysqli_real_escape_string($con, $_POST["nationality"] ?? '');
  $dateofadmission = mysqli_real_escape_string($con, $_POST["dateofadmission"] ?? '');
  $programtype = mysqli_real_escape_string($con, $_POST["programtype"] ?? '');
  $courseselected = mysqli_real_escape_string($con, $_POST["courseselected"] ?? '');
  $courseduration = mysqli_real_escape_string($con, $_POST["courseduration"] ?? '');
  $choiceofsession = mysqli_real_escape_string($con, $_POST["choiceofsession"] ?? '');
  $recidency = mysqli_real_escape_string($con, $_POST["recidency"] ?? '');

  if ($programtype === "Select Program" || $programtype === "Please Select" || $programtype === '') {
    $_SESSION['status'] = 'Please Select Type of Program'; header('Location: proceedregistration.php'); exit();
  }
  if ($courseselected === "Select Course" || $courseselected === '') {
    $_SESSION['status'] = 'Please Select Course'; header('Location: proceedregistration.php'); exit();
  }
  if ($courseduration === "Please Select" || $courseduration === '') {
    $_SESSION['status'] = 'Please Select Course Duration'; header('Location: proceedregistration.php'); exit();
  }
  if ($choiceofsession === "Please Select" || $choiceofsession === '') {
    $_SESSION['status'] = 'Please Select Choice of Session'; header('Location: proceedregistration.php'); exit();
  }
  if ($recidency === "Please Select" || $recidency === '') {
    $_SESSION['status'] = 'Please Select Residency'; header('Location: proceedregistration.php'); exit();
  }

  $pRes = mysqli_query($con, "SELECT program FROM programtype WHERE id='".$programtype."' LIMIT 1");
  $programName = ($pRes && mysqli_num_rows($pRes)) ? mysqli_fetch_assoc($pRes)['program'] : '';
  $cRes = mysqli_query($con, "SELECT course_name FROM courses WHERE id='".$courseselected."' LIMIT 1");
  $courseName = ($cRes && mysqli_num_rows($cRes)) ? mysqli_fetch_assoc($cRes)['course_name'] : '';
  $_SESSION['program'] = $programName;
  $_SESSION['course_name'] = $courseName;

  $currentIndex = $_SESSION['indexnumber'] ?? '';
  if ($currentIndex === '') {
    $maxRes = mysqli_query($con, "SELECT MAX(id) AS maxid FROM registration");
    $maxRow = mysqli_fetch_assoc($maxRes);
    $next = (int)$maxRow['maxid'] + 1;
    $currentIndex = date('y').'COTVI'.str_pad($next, 4, '0', STR_PAD_LEFT);
  }
  $existsRes = mysqli_query($con, "SELECT id FROM registration WHERE indexnumber='".mysqli_real_escape_string($con, $currentIndex)."' LIMIT 1");
  if ($existsRes && mysqli_num_rows($existsRes) === 1) {
    $maxRes = mysqli_query($con, "SELECT MAX(id) AS maxid FROM registration");
    $maxRow = mysqli_fetch_assoc($maxRes);
    $next = (int)$maxRow['maxid'] + 1;
    $currentIndex = date('y').'COTVI'.str_pad($next, 4, '0', STR_PAD_LEFT);
  }
  $_SESSION['indexnumber'] = $currentIndex;

  $insReg = mysqli_query($con, "INSERT INTO registration (indexnumber, firstname, lastname, dob, gender, nationality, email, maritalstatus, contact, address, doappoinment, status) VALUES ('".$currentIndex."', '".$_SESSION['fname']."', '".$_SESSION['lname']."', '".$_SESSION['dob']."', '".$_SESSION['gender']."', '".$nationality."', '".$_SESSION['email']."', '".$_SESSION['maritalstatus']."', " . (int)$_SESSION['contact'] . ", '".$_SESSION['address']."', '".$dateofadmission."', 'Student')");

  if ($insReg) {
    $cols = [];
    if ($desc = mysqli_query($con, "DESCRIBE student_registration")) {
      while ($r = mysqli_fetch_assoc($desc)) { $cols[] = $r['Field']; }
    }
    $hasCourseSession = in_array('courseSession', $cols);
    $hasResidency = in_array('residency', $cols);
    $hasFees = in_array('fees', $cols);

    $fields = [
      'indexnumber','firstname','lastname','email','contact',
      'placeOfBirth','Hometown','region','nationality','dateOfAdmission',
      'active','programType','courseSelected','courseDuration'
    ];
    $values = [
      $currentIndex, $_SESSION['fname'], $_SESSION['lname'], $_SESSION['email'], $_SESSION['contact'],
      $placeofbirth, $hometown, $region, $nationality, $dateofadmission,
      'Yes', $programName, $courseName, $courseduration
    ];
    if ($hasCourseSession) { $fields[] = 'courseSession'; $values[] = $choiceofsession; }
    if ($hasResidency) { $fields[] = 'residency'; $values[] = $recidency; }
    if ($hasFees) { $fields[] = 'fees'; $values[] = ''; }

    $fieldList = implode(', ', $fields);
    $escaped = array_map(function($v) use ($con){ return "'".mysqli_real_escape_string($con, (string)$v)."'"; }, $values);
    $valueList = implode(', ', $escaped);
    mysqli_query($con, "INSERT INTO student_registration ($fieldList) VALUES ($valueList)");

    $_SESSION['success'] = 'Success!! Student registered successfully';
    if (function_exists('error_log')) { error_log("[admin/proceedregistration] inserted student: " . $currentIndex . "\n", 3, __DIR__ . '/../../error.log'); }
    header('Location: /oes/admin/student.php');
    exit();
  } else {
    $_SESSION['status'] = 'Error!! Information not Saved Successfully';
    if (function_exists('error_log')) { error_log("[admin/proceedregistration] insert registration failed: " . mysqli_error($con) . "\n", 3, __DIR__ . '/../../error.log'); }
    header('Location: /oes/admin/proceedregistration.php');
    exit();
  }
}

include('includes/header.php');
include('includes/navbar.php');

?> 

  <main class="mt-5">
    <!-- <main class="mt-5 pt-3"> -->
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
                <span><i class="bi bi-table me-2"></i>Student Registration</span> 
                <!-- <div class="text-xs font-weight-bold">
                  <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i>
                    Add New Student
                  </button>
                </div> -->
              </div>
              <div class="card-body">
                <form id="student-reg-form" action="proceedregistration.php" method="POST">
                <div class="row d-flex">
                  
                  <div class="col-6">
                    <p class="text-center text-danger">Personal Detail</p>
                    <div class="row mb-2">
                      <div class="col-4">Place of Birth</div>
                      <div class="col-8"><input type="text" class="form-control" name="placeofbirth" value="" required></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-4">Hometown</div>
                      <div class="col-8"><input type="text" class="form-control" name="hometown" value="" required></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-4">Region</div>
                      <div class="col-8"><input type="text" class="form-control" name="region" value="" required></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-4">Nationality</div>
                      <div class="col-8"><input type="text" class="form-control" name="nationality" value="" required></div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-4">Date of Admission</div>
                      <div class="col-8"><input type="date" class="form-control" name="dateofadmission" value="" required></div>
                    </div>
                  </div>
                  <div class="col-6">
                    <p class="text-center text-danger">Course Detail</p>
                    <div class="row mb-2">
                      <div class="col-4">Program Type</div>
                      <div class="col-8">
                        <select id="programdd" onchange="change_program()" class="form-control" name="programtype" required>
                           <option value="Select Program">Select Program</option>
                           <?php                           $res = mysqli_query($con, "SELECT * FROM programtype");
                          while ($row= mysqli_fetch_array($res)){
                              ?>
                          <option value="<?php echo $row["id"];?>"><?php echo $row["program"];?></option>
                          <?php
                          }
                          ?>
                      </select>
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-4">Course Selected</div>
                      <div class="col-8" id="course">
                          <select class="form-control" name='courseselected' required>
                              <option value="Select Course">Select Course</option>
                          </select>
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-4">Course Duration</div>
                      <div class="col-8">
                        <select class="form-control" name="courseduration" required>
                          <option value="Please Select">Please Select</option>
                          <option value="Six months">Six months</option>
                          <option value="One year">One year</option>
                        </select>
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-4">Choice of Session</div>
                      <div class="col-8">
                        <select class="form-control" name="choiceofsession" required>
                          <option value="Please Select">Please Select</option>
                          <option value="Regular">Regular</option>
                          <option value="Weekend">Weekend</option>
                          <option value="Online">Online</option>
                        </select>
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-4">Residency Type</div>
                      <div class="col-8">
                        <select class="form-control" name="recidency" required>
                          <option value="Please Select">Please Select</option>
                          <option value="Residence">Residence</option>
                          <option value="Non Residence">Non Residence</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  
      <div class="modal-footer">
          <a href="addstudent.php" class="btn btn-danger" >Back</a>
          <button type="submit" class="btn btn-primary" name="proceed">Proceed</button>
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
?>

<script type="text/javascript">
  // Use Fetch instead of a missing ajax.php; build course options from a lightweight endpoint in-page
  async function change_program(){
    const programId = document.getElementById('programdd').value;
    if (!programId || programId === 'Select Program') {
      document.getElementById('course').innerHTML = "<select class=\"form-control\" name='courseselected'><option value='Select Course'>Select Course</option></select>";
      return;
    }
    try {
      const res = await fetch('proceedregistration.php?list_courses_for_program=' + encodeURIComponent(programId), { credentials: 'same-origin' });
      const html = await res.text();
      document.getElementById('course').innerHTML = html;
      // Do not submit or navigate; user must complete remaining fields then click Proceed
    } catch(e) {
      document.getElementById('course').innerHTML = "<select class=\"form-control\" name='courseselected'><option value=''>Error loading courses</option></select>";
    }
  }
</script>


