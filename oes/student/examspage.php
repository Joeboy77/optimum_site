<?php

date_default_timezone_set("Africa/Accra");
session_start();
require '../config.php';
// error_reporting(0);

// require '../master/Examination.php';

// $exam = new Examination;

// // naming three variables
// $exam_id = $_SESSION['id'];
// $exam_status = '';
// $remaining_minutes = '';

// // Writing code to retrict login users
// if(isset($_SESSION["id"])){
//     // Code to select question on the page
//   $query = "SELECT * FROM exams_questions WHERE questionID = '$_SESSION[id]'";

//   // Picking start time
//   $startime = "";
//   // duration
//   $duration = $_SESSION["timelimit"];
//   // exams endtime
//   $exam_end_time = strtotime($startime. '+' .$duration);
//   $exam_end_time = date('Y-m-d', $exam_end_time);
//   $remaining_minutes = strtotime($exam_end_time) - time();
// } else {
//     header("location: availablepapers.php");
// }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
    <!----favicon---->
    <link rel="icon" href="../logo/wipeup.png">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Optimum OES | Exam Page</title>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  </head>
  <body>
  <style>
  li .nav-link span{
    font-size: 14px;
    color: white;
  }
  #list:hover{
    background-color: cornflowerblue;
  }
</style>
<!-- top navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top static-top shadow">
      
      <div class="container-fluid">
        
        <a
          class="navbar-brand me-auto ms-lg-0 ms-3 "
          href="#"
          >
          <span>Optimum</span> <span class="text-primary">OES</span>
          <!-- <span class="text-primary">ruum</span>Link -->
          <!-- <span style="margin: 5px; font-size: 16px;">ruumLink</span> -->
          </a
        >
        
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#topNavBar"
          aria-controls="topNavBar"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <i class="bi bi-three-dots-vertical"></i>
          <!-- <span class="navbar-toggler-icon"></span> -->
        </button>
        <div class="collapse navbar-collapse" id="topNavBar">
          <form class="d-flex ms-auto my-1 my-lg-0">
            <div>
              <a href="profile.php" style="cursor: pointer; text-decoration: none; color: black;"><?php echo $_SESSION['firstname'] ." ".$_SESSION['lastname']?></a>
            </div>
            <!-- <div class="input-group">
              <input
                class="form-control"
                type="search"
                placeholder="Search"
                aria-label="Search"
              />
              <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i>
              </button>
            </div> -->
          </form>
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle ms-2 d-block"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="bi bi-person-fill"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="changepassword.php">Change Password</a></li>
                <li><a href="#" class="nav-link px-3 dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal1">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- top navigation bar -->
    <section class="pt-3">
      <div class="container-fluid ">
        <!-- <div class="card-header d-sm-flex align-items-center justify-content-between">
          <span><i class="bi bi-table me-2"></i> Edit Daily Debtors Information</span>
        </div> -->
        <div class="row ">
          <div>
            <div class="card shadow h-100 py-2">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                 <h5 class="text-xs font-weight-bold text-primary text-uppercase">Exams Details</h5>
                 
              </div>
              <div class="card-header">
                <div class="d-sm-flex align-items-center justify-content-center mb-2">
                  <span style="font-size: 20px;"><b>Course: <?php echo $_SESSION['course']?></b></span>
                </div>
                <div class="d-sm-flex align-items-center justify-content-center mb-1">
                  <span style="font-size: 18px;"><b>Exam Title: <?php echo $_SESSION['title']?></b></span>
                </div>
                <div class="d-sm-flex align-items-center justify-content-between">
                  <span><b>Semester: <?php echo $_SESSION['semester']?></b></span>
                  <span><b>Total Marks: <?php echo $_SESSION['totalmarks']?></b></span>
                  <!-- <span><b>No. of Rolls: <?php echo $_SESSION['marks']?></b></span> -->
                </div>
              </div>
              <?php

              ?>
              <div class="row card-body d-flex">
                  <div id="single_question_area">

                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script>
      $(document).ready(function(){
        var exam_id = "<?php echo $exam_id;?>";

        function load_question(question_id = ''){
          $.ajax({
            url:"user_ajax_action.php",
            method:"POST",
            data:{exam_id:exam_id, question_id:question_id, page:'examspage', action:'load_question'},
            success:function(data){
              $('#single_question_area').html(data);
            }
          })
        }
      });
    </script>

              <?php

              ?>
    

    
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- include jquery cdn -->
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->
    
    
  </body>
</html>

 <!-- Logout Modal -->
  <div class="modal fade" id="logoutModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST">
          <div class="text-center">Select "<span style="color: red;">Logout</span>" below to end your current session.</div>
        <div class="modal-footer">
          <button type="submit" name="logout_btn" class="btn btn-primary">Logout</button>
          <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <?php
  if (isset($_POST["logout_btn"])) {
  # code...
  session_destroy();
  unset($_SESSION['id']);
  header('location: index.php');
}
  ?>
