<?php
// Handle approval before any output to allow header redirects
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve'])) {
  require_once '../../config.php';
  if (session_status() === PHP_SESSION_NONE) { session_start(); }

  $id = isset($_GET['id']) ? $_GET['id'] : '';
  $indexnumber = mysqli_real_escape_string($con, $_POST['indexnumber'] ?? '');
  $cost = mysqli_real_escape_string($con, $_POST['cost'] ?? '');
  $email = mysqli_real_escape_string($con, $_POST['email'] ?? '');
  $firstname = mysqli_real_escape_string($con, $_POST['firstname'] ?? '');
  $lastname = mysqli_real_escape_string($con, $_POST['lastname'] ?? '');

  if ($cost === '') {
    $_SESSION['status'] = 'Please Enter Cost of Program';
    header('Location: studentdetails.php?id=' . urlencode($id));
    exit();
  }

  // Discover columns to avoid updating non-existent fields
  $cols = [];
  if ($d = mysqli_query($con, "SHOW COLUMNS FROM student_registration")) {
    while ($r = mysqli_fetch_assoc($d)) { $cols[] = $r['Field']; }
  }
  $setParts = [];
  if (in_array('fees', $cols)) { $setParts[] = "fees='".$cost."'"; }
  if (in_array('selection', $cols)) { $setParts[] = "selection='Yes'"; }
  if (in_array('active', $cols)) { $setParts[] = "active='Yes'"; }
  if (empty($setParts)) { $setParts[] = "indexnumber='".$indexnumber."'"; } // no-op safety to keep valid SQL
  $setClause = implode(', ', $setParts);

  $query = "UPDATE student_registration SET ".$setClause." WHERE indexnumber='".$indexnumber."' LIMIT 1";
  $query_run = mysqli_query($con, $query);
  if ($query_run) {
    // Try sending email; failure should not block redirect
    require_once 'includes/PHPMailer/src/Exception.php';
    require_once 'includes/PHPMailer/src/PHPMailer.php';
    require_once 'includes/PHPMailer/src/SMTP.php';
    try {
      $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
      $mail->isSMTP();
      $mail->Host       = 'smtp.gmail.com';
      $mail->SMTPAuth   = true;
      $mail->Username   = 'optimumumtraininginstitute@gmail.com';
      $mail->Password   = 'sdlh msco lcll zihm';
      $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
      $mail->Port       = 465;
      $mail->setFrom('optimumumtraininginstitute@gmail.com', 'Optimum Training Institute');
      if (!empty($email)) { $mail->addAddress($email, $firstname.' '.$lastname); }
      $mail->isHTML(true);
      $mail->Subject = 'Your SchoolID For Portal Registration';
      $mail->Body = '<b>Dear '.htmlspecialchars($firstname.' '.$lastname).'</b><br/>'
                  . 'Your SchoolID is <b>'.htmlspecialchars($indexnumber).'</b><br/>'
                  . 'Kindly click the link below to start registration<br/>'
                  . '<a href="http://localhost:8000/oes/signup.php">Click to Register Account</a>';
      $mail->send();
      $_SESSION['success'] = 'Student approved and email sent successfully';
    } catch (\PHPMailer\PHPMailer\Exception $e) {
      $_SESSION['success'] = 'Student approved. Email could not be sent: ' . $e->getMessage();
    }
    header('Location: approvedstudent.php');
    exit();
  } else {
    $_SESSION['status'] = 'Error!! Information not Sent Successfully';
    header('Location: studentdetails.php?id=' . urlencode($id));
    exit();
  }
}
?>
<?php
include('includes/header.php');
include('includes/navbar.php');

$id = $_GET["id"];
$sql = "SELECT * FROM student_registration WHERE id = '$_GET[id]'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$_SESSION['programType'] = $row['programType'];

$query = "SELECT * FROM programtype WHERE program = '$_SESSION[programType]' LIMIT 1";
$query_run = mysqli_query($con, $query);
if(mysqli_num_rows($query_run) > 0){
  $row1 = mysqli_fetch_assoc($query_run);
}

?> 

  <main class="mt-5 pt-3">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i> Student Information</span> 
                <!-- <div class="text-xs font-weight-bold">No. of Rooms: ... </div> -->
                <!-- <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i> Edit</button> -->
              </div>
              <div>
                <?php
               if (isset($_SESSION["status"]) && $_SESSION["status"] != '') {
                 
                 ?>
                 <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Hey!</strong> <?php echo $_SESSION["status"]; ?>.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                 </div>
                  
                 <?php
                 unset($_SESSION["status"]);
                 }
                 ?>
              </div>

              <form action="studentdetails.php?id=<?php echo htmlspecialchars($id); ?>" method="POST">
              <div class="card-body">
                <!-- <h3 class="text-danger text-center" id="para">Not Found</h3> -->
                <div class="row">
                  <div>
                    <div class="card shadow h-100 py-2">
                      <div class="card-header d-sm-flex align-items-center justify-content-between">
                        <h5 class="text-xs font-weight-bold text-primary text-uppercase">Student ID: <?php echo $row["indexnumber"];?></h5>
                          <button type="submit" name="approve" class="btn btn-success btn-sm"><i class="bi bi-eye"></i>  Approve</button>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-6">
                            <p class="text-danger text-center">Personal Details</p>
                            <div class="row mb-2">
                              <div class="col-4">Firstname</div>
                              <div class="col-8">
                                <input type="text" class="form-control" name="firstname" value="<?php echo $row['firstname']?>" readonly>
                                <input type="hidden" class="form-control" name="indexnumber" value="<?php echo $row['indexnumber']?>" readonly>
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-4">Lastname</div>
                              <div class="col-8">
                                <input type="text" class="form-control" name="lastname" value="<?php echo $row['lastname']?>" readonly>
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-4">Birth Place</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['placeOfBirth']?>" readonly>
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-4">Email</div>
                              <div class="col-8">
                                <input type="text" class="form-control" name="email" value="<?php echo $row['email']?>" readonly>
                              </div>
                            </div>
                            <!-- <div class="row mb-2">
                              <div class="col-4">Region</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['region']?>" readonly>
                              </div>
                            </div> -->
                            <div class="row mb-2">
                              <div class="col-4">Nationality</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['nationality']?>" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-6">
                            <p class="text-danger text-center">Program Details</p>
                            <div class="row mb-2">
                              <div class="col-4">Program Type</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['programType']?>" readonly>
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-4">Course Selected</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['courseSelected']?>" readonly>
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-4">Course Duration</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['courseDuration']?>" readonly>
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-4">Course Session</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['courseSession']?>" readonly>
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-4">Residency</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['residency']?>" readonly>
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-4">Cost of Program</div>
                              <div class="col-8">
                                <input type="text" name="cost" class="form-control" value="<?php echo number_format($row1['cost'], 2)?>" required>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-body">
                        <div class="col-12">
                          <a href="student.php" class="btn btn-danger" type="submit">Back</a>
                          <!-- <button class="btn btn-success" type="submit" name="update">Update</button> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </form>
          </div>
        </div>

        
      </div>
    </main>

<?php
include('includes/footer.php');
?>