<?php
include('includes/header.php');
include('includes/navbar.php');

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
                <span><i class="bi bi-table me-2"></i>Exams Settings</span> 
                <div class="text-xs font-weight-bold">
                  <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i>
                    Set New Exams
                  </button>
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
                          <th>Title</th>
                          <th>Course</th>
                          <th>Semester</th>
                          <th>Time</th>
                          <th>Total Marks</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          $query = "SELECT * FROM exams_setting ";
                          $query_run = mysqli_query($con, $query);
                          if(mysqli_num_rows($query_run) > 0){
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query_run)){
                        ?>
                        <tr>
                          <td hidden><?php echo $row["id"];?></td>
                          <td><?php echo $no;?></td>
                          <td><?php echo $row["title"];?></td>
                          <td><?php echo $row["course"];?></td>
                          <td><?php echo $row["semester"];?></td>
                          <td><?php echo $row["timelimit"];?></td>
                          <td><?php echo $row["totalmarks"];?></td>
                          <td>
                            <a href="editexamssettings.php?id=<?php echo $row["id"];?>" class="btn btn-primary"><i class="bi bi-eye"></i></a>
                          </td>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Set New Exams</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="examsetting.php" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="row mb-2">
           <label class="col-sm-4 col-form-label">Exams Title:</label>
          <div class="col-sm-8">
          <input type="text" name="examtitle" class="form-control" value="">
           </div>
        </div>
          <div class="row mb-2">
              <label class="col-sm-4 col-form-label">Course:</label>
              <div class="col-sm-8">
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
          </div>
          <div class="row mb-2">
              <label class="col-sm-4 col-form-label">Semester:</label>
              <div class="col-sm-8">
              <select name="semester" class="form-control">
                <option value="Select Semeter">Select Semeter</option>
                <option value="Semeter 1">Semeter 1</option>
                <option value="Semeter 2">Semeter 2</option>
                <option value="Semeter 3">Semeter 3</option>
              </select>
              </div>
           </div>
           <div class="row mb-2">
               <label class="col-sm-4 col-form-label">Time:</label>
              <div class="col-sm-8">
              <input type="number" name="timelimit" class="form-control" value="">
              </div>
           </div>
           <div class="row mb-2">
               <label class="col-sm-4 col-form-label">Total Marks</label>
               <div class="col-sm-8">
               <input type="number" name="totalmarks" class="form-control" value="">
               </div>
           </div>
           <!-- <div class="row mb-2">
              <label class="col-sm-4 col-form-label">Date</label>
               <div class="col-sm-8">
              <input type="date" name="doexams" class="form-control" value="">
               </div>
           </div> -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
if (isset($_POST["submit"])) {
  // code...
  $examtitle = mysqli_real_escape_string($con, $_POST["examtitle"]);
  $course = mysqli_real_escape_string($con, $_POST["course"]);
  $semester = mysqli_real_escape_string($con, $_POST["semester"]);
  $timelimit = mysqli_real_escape_string($con, $_POST["timelimit"]);
  $totalmarks = mysqli_real_escape_string($con, $_POST["totalmarks"]);

  // Query to insert into database
  $query = "INSERT INTO exams_setting (title, course, semester, timelimit, totalmarks, lecturer) VALUES ('$examtitle', '$course', '$semester', '$timelimit', '$totalmarks', 'Teacher 1')";
  $query_run = mysqli_query($con, $query);
  if ($query_run) {
       // $_SESSION['success'] = "Success!! Information Inserted Successfully";
       echo '<script type="text/javascript">window.location="startexams.php"</script>';
       exit();
   }else{
       $_SESSION['status'] = "Error!! Information not Inserted Successfully";
       echo '<script type="text/javascript">window.location="examsetting.php"</script>';
       exit();
  }

}
?>
