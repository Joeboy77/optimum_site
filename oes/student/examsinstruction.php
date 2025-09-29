<?php
include('includes/header.php');
include('includes/navbar.php');

?> 

	<!-- <main class="mt-5 pt-3"  onload="multiply();"> -->
    <main class="mt-5 pt-3">
      <div class="container-fluid">

        <div class="row">

          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i> Exams Instruction</span>
                <a href="availablepapers.php" class="btn btn-danger"><i class="bi bi-chevron-bar-left me-2"></i>Back</a>
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
                
              </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h2 class="text-center">Exams Instruction</h2>
              <h5 class="text-danger">Read the following instruction before the Exams</h5>
              <div>
                <ul>
                  <li>The examination is time bound</li>
                  <li>Upon the clicking the the start button below, you cant close until you finish the exams</li>
                  <li>Call on the the administrator incase you encounter any misgivens</li>
                  <li>Use you common sense and dont think of copying because you questions are different from others</li>
                  <li>If you know you cant answer the questions gracefully end the exams and see you score</li>
                </ul>
              </div>
              <div>
                <form action="" method="POST">
                  <input type="hidden" name="id" value="<?php echo $_SESSION['id'];?>">
                  <button type="submit" name="proceedtoexams" class="btn btn-success">Proceed to Start Exams</button>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
    </main>

<?php
include('includes/footer.php');
?>

<?php
if (isset($_POST['proceedtoexams'])) {
  $id = mysqli_real_escape_string($con, $_POST["id"]);

  $query = "SELECT * FROM exams_setting WHERE id = '$id' LIMIT 1";
  $query_run = mysqli_query($con, $query);
  if(mysqli_num_rows($query_run) === 1) {
    while ($row = mysqli_fetch_assoc($query_run)){
      $_SESSION['id'] = $row['id'];
      $_SESSION['title'] = $row['title'];
      $_SESSION['course'] = $row['course'];
      $_SESSION['semester'] = $row['semester'];
      $_SESSION['no_of_questions'] = $row['no_of_questions'];
      $_SESSION['timelimit'] = $row['timelimit'];
      $_SESSION['totalmarks'] = $row['totalmarks'];

      echo '<script type="text/javascript">window.location="../examination/index.php"</script>';
      exit();
    }
    $date = date("Y-m-d H:i:s");
    $_SESSION['end_time'] = date("Y-m-d H:i:s",strtotime($date."+$_SESSION[timelimit] minutes"));
    $_SESSION['exam_start'] = "yes";

    // Testing to see if it works
    // echo '<script type="text/javascript">window.location="../examination/index.php"</script>';
    // exit();
  }
}
?>



