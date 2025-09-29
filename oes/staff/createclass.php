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
        <!-- <div class="row mb-2">
          <div class="d-sm-flex align-items-center justify-content-between ">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="searchpage.php"><button class="btn btn-primary btn-sm"><i class="bi bi-border-outer me-2"></i>Search Rooms</button></a>
          </div>
        </div> -->

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i>Create Class</span> 
                <div class="text-xs font-weight-bold">
                  <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i>
                    Add New Class
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
                          <th>Class Name</th>
                          <th>Program</th>
                          <th>Course Name</th>
                          <th>Class Status</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          $query = "SELECT * FROM tutorclass WHERE staffID = '$_SESSION[schoolID]'";
                          $query_run = mysqli_query($con, $query);
                          if(mysqli_num_rows($query_run) > 0){
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query_run)){
                        ?>
                        <tr>
                          <td hidden><?php echo $row["id"];?></td>
                          <td><?php echo $no;?></td>
                          <td><?php echo $row["classname"];?></td>
                          <td><?php echo $row["course_name"];?></td>
                          <td><?php echo $row["course_code"];?></td>
                          <td>
                            <a href="classstudentadmission.php?id=<?php echo $row["id"];?>" class="btn btn-primary"><i class="bi bi-eye"></i></a>
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

<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Class</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="POST">
      <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <label class="form-label">Class Name:</label>
                <input type="text" class="form-control" name="class_name">
              </div>
            </div>
            <div class="form-group mb-3">
                 <label> Select Program </label>
                 <select id="programdd" onchange="change_program()" class="form-control" name="program">
                     <option value="Select Program">Select Program</option>
                     <?php
                     // $res = mysqli_query($con, "SELECT * FROM region ORDER BY name ASC");
                     $res = mysqli_query($con, "SELECT * FROM programtype");
                    while ($row= mysqli_fetch_array($res)){
                        ?>
                    <option value="<?php echo $row["id"];?>"><?php echo $row["program"];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mb-3">
                <label> Course: </label>
                <div id="course">
                    <select class="form-control" name='course' onchange="change_course()">
                        <option value="Select Course">Select Course</option>
                    </select>
                </div>
            </div>
            
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="tripsubmit">Add Class</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
    function change_program(){
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET", "ajax.php?program="+document.getElementById("programdd").value,false);
        xmlhttp.send(null);
        document.getElementById("course").innerHTML=xmlhttp.responseText;
    }
    // function change_course(){
    //     var xmlhttp=new XMLHttpRequest();
    //     xmlhttp.open("GET", "ajax.php?course="+document.getElementById("coursedd").value,false);
    //     xmlhttp.send(null);
    //     document.getElementById("town").innerHTML=xmlhttp.responseText;
    // }
    // function change_town(){
    //     var xmlhttp=new XMLHttpRequest();
    //     xmlhttp.open("GET", "ajax.php?town="+document.getElementById("towndd").value,false);
    //     xmlhttp.send(null);
    //     document.getElementById("community").innerHTML=xmlhttp.responseText;
    // }

</script>

<?php
if (isset($_POST["tripsubmit"])) {
  // code...
  $class_name = mysqli_real_escape_string($con, $_POST["class_name"]);
  $program = mysqli_real_escape_string($con, $_POST["program"]);
  $course = mysqli_real_escape_string($con, $_POST["course"]);

  //Code for validation
    if (empty($class_name)) {
        $_SESSION['status'] = "Please Enter Class Name";
        echo '<script type="text/javascript">window.location="createclass.php"</script>';
        exit();
    }
    if ($program === "Select Program") {
        $_SESSION['status'] = "Please Select Program";
        echo '<script type="text/javascript">window.location="createclass.php"</script>';
        exit();
    }
    if ($course === "Select Course") {
        $_SESSION['status'] = "Please Select Course";
        echo '<script type="text/javascript">window.location="createclass.php"</script>';
        exit();
    }

    // Code to select id representing names 1
    $query = "SELECT * FROM programtype WHERE id = '$program' LIMIT 1";
    $query_run = mysqli_query($con, $query);
     if(mysqli_num_rows($query_run) === 1){
      $row = mysqli_fetch_assoc($query_run);
      $_SESSION['program'] = $row['program'];
      if ($query_run) {
        // code to selecting name 2
        $query1 = "SELECT * FROM courses WHERE id = '$course' LIMIT 1";
        $query_run1 = mysqli_query($con, $query1);
        if(mysqli_num_rows($query_run1) === 1){
          $row1 = mysqli_fetch_assoc($query_run1);
          $_SESSION['course_name'] = $row1['course_name'];
          // code to make sure classname not registered twice
          $query = "SELECT * FROM tutorclass WHERE classname = '$class_name' AND staffID = '$_SESSION[schoolID]' LIMIT 1";
          $query_run = mysqli_query($con, $query);
          if(mysqli_num_rows($query_run) === 1){
            $_SESSION['status'] = "Error!! Class Name entered exist already";
            echo '<script type="text/javascript">window.location="createclass.php"</script>';
            exit();
          }else{
            $query = "INSERT INTO tutorclass (classname, course_name, course_code, staff_name, staffID) VALUES ('$class_name', '$_SESSION[program]', '$_SESSION[course_name]', '$_SESSION[firstname] $_SESSION[lastname]', '$_SESSION[schoolID]')";
            $query_run = mysqli_query($con, $query);
            if ($query_run) {
                $_SESSION['success'] = "Success!! Information Saved Successfully";
                echo '<script type="text/javascript">window.location="createclass.php"</script>';
                exit();
            }else{
                $_SESSION['status'] = "Error!! Information not Saved Successfully";
                echo '<script type="text/javascript">window.location="createclass.php"</script>';
                exit();
            }
          }
        }
      }
     }
    
}
?>
