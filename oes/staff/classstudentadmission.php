<?php
include('includes/header.php');
include('includes/navbar.php');

$id = $_GET["id"];
$_SESSION['id'] = $_GET['id'];
$sql = "SELECT * FROM tutorclass WHERE id = '$_GET[id]'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
// session names for them
$_SESSION['classname'] = $row["classname"];
$_SESSION['course_name'] = $row["course_name"];
$_SESSION['course_code'] = $row["course_code"];

?> 

  <main class="mt-5 pt-3">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i>Student Addition</span> 
                <div class="text-xs font-weight-bold">
                  
                  <a href="addstudent.php?id=<?php echo $row["id"];?>" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> Add Student</a>
                </div>
              </div>
              <div>

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

              </div>
              
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white h-100">
              <div class="card-body py-2">Class Name</div>
              <div class="card-footer d-flex">
                <?php echo $row['classname'];?>
                <!-- <span class="ms-auto">
                  <i class="bi bi-chevron-right"></i>
                </span> -->
               </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card bg-success text-white h-100">
              <div class="card-body py-2">Program Type</div>
              <div class="card-footer d-flex">
                <?php echo $row['course_name'];?>
                <!-- <span class="ms-auto">
                  <i class="bi bi-chevron-right"></i>
                </span> -->
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card h-100" style="background-color: peachpuff;">
              <div class="card-body py-2">Course Name</div>
              <div class="card-footer d-flex">
                <?php echo $row['course_code'];?>
                <!-- <span class="ms-auto">
                  <i class="bi bi-chevron-right"></i>
                </span> -->
              </div>
            </div>
          </div>
        </div>

        <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <table id="example" class="table table-striped table-hover text-center">
                      <thead class="table-success">
                        <tr>
                          <th hidden>S. No.</th>
                          <th>S. No.</th>
                          <th>StudentID</th>
                          <th>Name</th>
                          <th>Program</th>
                          <th>Course</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          // Check if the optional 'selection' column exists
                          $hasSelection = false;
                          $col = mysqli_query($con, "SHOW COLUMNS FROM student_registration LIKE 'selection'");
                          if ($col && mysqli_num_rows($col) > 0) { $hasSelection = true; }

                          $program = mysqli_real_escape_string($con, $_SESSION['course_name']);
                          $course  = mysqli_real_escape_string($con, $_SESSION['course_code']);
                          $where   = "programType = '".$program."' AND courseSelected = '".$course."'";
                          if ($hasSelection) {
                            // Only students added to THIS class
                            $classId = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0);
                            $where .= " AND selection = '".$classId."'";
                          }

                          $query = "SELECT * FROM student_registration WHERE $where";
                          $query_run = mysqli_query($con, $query);
                          if(mysqli_num_rows($query_run) > 0){
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query_run)){
                        ?>
                        <tr>
                          <td hidden><?php echo $row["id"];?></td>
                          <td><?php echo $no;?></td>
                          <td><?php echo htmlspecialchars($row["indexnumber"]);?></td>
                          <td><?php echo htmlspecialchars($row["firstname"].' '.$row["lastname"]);?></td>
                          <td><?php echo htmlspecialchars($row["programType"]);?></td>
                          <td><?php echo htmlspecialchars($row["courseSelected"]);?></td>
                        </tr>
                        <?php
                        $no++;
                        }
                      }else{
                        echo "No Record Found";
                      }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

        
      </div>
    </main>

<?php
include('includes/footer.php');
?>



<?php
if (isset($_POST['addstudent'])) {
  $id = mysqli_real_escape_string($con, $_POST["id"]);

  $query = "SELECT * FROM tutorclass WHERE id = '$id' LIMIT 1";
  $query_run = mysqli_query($con, $query);
  if(mysqli_num_rows($query_run) === 1){
    $row = mysqli_fetch_assoc($query_run);
    $_SESSION['classname'] = $row["classname"];
    $_SESSION['course_name'] = $row["course_name"];
    $_SESSION['course_code'] = $row["course_code"];

    echo '<script type="text/javascript">window.location="addstudent.php"</script>';
    exit();
  }
}
?>

