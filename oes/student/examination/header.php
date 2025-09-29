<?php
session_start();
require '../config.php';
// error_reporting(0);

// Writing code to retrict login users
if(isset($_SESSION["schoolID"])){
       
} else {
    header("location: ../index.php");
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Optimum OES | Exams Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="../logo/wipeup.png">
  </head>
  <body>
    <!-- <h1>Hello, world!</h1> -->
    <!-- Navbar begining -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
          <img src="../logo/wipeup.png" class="d-inline-block align-top" width="30px" height="30px">
          <span>Optimum</span> <span class="text-primary">OES</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <!-- <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li> -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $_SESSION['firstname'] ." ".$_SESSION['lastname']?></a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a href="#" class="nav-link px-3 dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal01">Logout</a></li>
                <!-- <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li> -->
              </ul>
            </li>
          </ul>
          <!-- <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form> -->
        </div>
      </div>
    </nav>
    <!-- Navbar ending -->
  <section class="container">
    <div class="card-header bg-white d-sm-flex align-items-center justify-content-between">
      <span><i class="bi bi-table me-2"></i>Course: </span> 
      <!-- <span><i class="bi bi-table me-2"></i>Course: <?php echo $_SESSION['course'] ?></span>  -->
      <div class="text-xs font-weight-bold">
        <span class="d-flex">Time Remaining: &nbsp; <div id="countdowntimer" style="display: block;"></div></span>
      </div>
    </div>
  </section>
  

  <script type="text/javascript">
    // setInterval(function()
    //   {
    //     var xmlhttp =new XMLHttpRequest;
    //     xmlhttp.open("GET","response.php",false);
    //     xmlhttp.send(null);
    //     document.getElementById("response").innerHTML=xmlhttp.responseText;
    //   },1000);

    // Code to call out countdown timer
    setInterval(function(){
      timer();
    },1000)
    function timer()
    {
      var xmlhttp =new XMLHttpRequest();
      xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readystate == 4 && xmlhttp.status == 200) {
          if (xmlhttp.responseText=="00:00:01") {
            window.location = "result.php";
          }
          document.getElementById("countdowntimer").innerHTML=xmlhttp.responseText;
        }
      };
      xmlhttp.open("GET","forajax/load_timer.php",true);
      xmlhttp.send(null);
    }

  </script>