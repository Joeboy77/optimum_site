<?php
include('includes/header.php');
include('includes/navbar.php');

// $query = mysqli_query($con, "select * from courses order by id desc limit 1");
// $line = mysqli_fetch_array($query);
// $num = $line['id'];
// $num++;

// $course_code = 'C'.str_pad($num++, 3, '0', STR_PAD_LEFT);
// $_SESSION['course_code'] = $course_code;
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
        <!-- <div class="row mb-2">
          <div class="d-sm-flex align-items-center justify-content-between ">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="searchpage.php"><button class="btn btn-primary btn-sm"><i class="bi bi-border-outer me-2"></i>Search Rooms</button></a>
          </div>
        </div> -->

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i>Course Registration</span> 
                <div class="text-xs font-weight-bold">
                  <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i>
                    Add New Course
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <table id="example" class="table table-striped table-hover text-center">
                      <thead class="table-success">
                        <thead class="table-success">
                        <tr>
                          <th hidden>S. No.</th>
                          <th>S. No.</th>
                          <th>Course Name</th>
                          <th>Course Code</th>
                          <th>Semester</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          $query = "SELECT * FROM course_registration WHERE studentID = '$_SESSION[schoolID]'";
                          $query_run = mysqli_query($con, $query);
                          if(mysqli_num_rows($query_run) > 0){
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query_run)){
                        ?>
                        <tr>
                          <td hidden><?php echo $row["id"];?></td>
                          <td><?php echo $no;?></td>
                          <td><?php echo $row["course_name"];?></td>
                          <td><?php echo $row["course_code"];?></td>
                          <td><?php echo $row["semester"];?></td>
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
        </div>

        
      </div>
    </main>

<?php
include('includes/footer.php');
?>

<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Course Registration</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="courseregistration.php" method="POST">
      <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <label class="form-label">Select Course</label>
                <select class="form-control" name="course">
                   <option value="Select Course">Select Course</option>
                    <?php
                    $res = mysqli_query($con, "SELECT * FROM courses ORDER BY id ASC");
                    while ($row= mysqli_fetch_array($res)){
                          ?>
                     <option value="<?php echo $row["course_name"];?>"><?php echo $row["course_name"];?></option>
                     <?php
                      }
                      ?>
                </select>
              </div>
              <div class="mb-2">
                <label class="form-label">Select Semester</label>
                <select name="semester" class="form-control">
                  <option value="Select Semeter">Select Semeter</option>
                  <option value="Semeter 1">Semeter 1</option>
                  <option value="Semeter 2">Semeter 2</option>
                  <option value="Semeter 3">Semeter 3</option>
                </select>
              </div>
              </div>
            </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="tripsubmit">Add Course</button>
        </div>
        </form>
      </div>
      
      
    </div>
  </div>
</div>

<?php
if (isset($_POST["tripsubmit"])) {
  // code...
  $course = mysqli_real_escape_string($con, $_POST["course"]);
  $semester = mysqli_real_escape_string($con, $_POST["semester"]);

  //Code for validation
    if ($course === "Select Course") {
        $_SESSION['status'] = "Please Select Course";
        echo '<script type="text/javascript">window.location="courseregistration.php"</script>';
        exit();
    }elseif ($semester === "Select Semeter") {
        $_SESSION['status'] = "Please Select Semester";
        echo '<script type="text/javascript">window.location="courseregistration.php"</script>';
        exit();
    }else{
      $query = "SELECT * FROM courses WHERE course_name = '$course' LIMIT 1";
      $query_run = mysqli_query($con, $query);
      if(mysqli_num_rows($query_run) === 1) {
        $row = mysqli_fetch_assoc($query_run);
        $_SESSION['course_code'] = $row['course_code'];
        if ($query_run) {
          $query = "SELECT * FROM course_registration WHERE course_name = '$course' AND semester = '$semester' LIMIT 1";
          $query_run = mysqli_query($con, $query);
          if(mysqli_num_rows($query_run) === 1) {
            $_SESSION['status'] = "Error!! You cannot register a course in the same semester twice";
            echo '<script type="text/javascript">window.location="courseregistration.php"</script>';
            exit();
          }else{
            $query = "INSERT INTO course_registration (studentID, firstname, lastname, course_name, course_code, semester) VALUES ('$_SESSION[schoolID]', '$_SESSION[firstname]', '$_SESSION[lastname]', '$course', '$_SESSION[course_code]', '$semester')";
            $query_run = mysqli_query($con, $query);
            if ($query_run) {
              $_SESSION['success'] = "Registration Successfully";
              echo '<script type="text/javascript">window.location="courseregistration.php"</script>';
              exit();
            }else{
              $_SESSION['status'] = "Error!! Registration Unsuccessful";
              echo '<script type="text/javascript">window.location="courseregistration.php"</script>';
              exit();
            }
          }
        }
      }
    }

    // $query = "SELECT * FROM courses WHERE course_registrationn = '$course_name' LIMIT 1";
    // $query_run = mysqli_query($con, $query);
    // if(mysqli_num_rows($query_run) === 1){
    //   $_SESSION['status'] = "Error!! Course Name entered exist already";
    //   echo '<script type="text/javascript">window.location="courses.php"</script>';
    //   exit();
    // }else{
    //   $query = "INSERT INTO courses (course_name, course_code) VALUES ('$course_name', '$course_code')";
    //   $query_run = mysqli_query($con, $query);
    //   if ($query_run) {
    //       $_SESSION['success'] = "Success!! Information Saved Successfully";
    //       echo '<script type="text/javascript">window.location="courses.php"</script>';
    //       exit();
    //   }else{
    //       $_SESSION['status'] = "Error!! Information not Saved Successfully";
    //       echo '<script type="text/javascript">window.location="courses.php"</script>';
    //       exit();
    //   }
    // }
}
?>