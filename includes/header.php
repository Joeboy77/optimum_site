<?php

session_start();
require 'config.php';
// error_reporting(0);

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Optimum Training Inst.</title>
    <link rel="icon" href="images/Optimum.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- bootstrap icon cdn -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">
    <!-- Fonts Icons link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- main style -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="cardhoverstyle.css">
    <link rel="stylesheet" type="text/css" href="servicestyle.css">
  </head>
  <body>
    <div>
      <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> -->
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
          <a class="navbar-brand fs-2 fw-bold" href="index.php">
          <img src="/images/Optimum.png" class="img-fluid" style="width: 60px;"/>
            <span class="text-primary">Optimum</span>TI
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-lg-0 fs-5 ms-auto p-2 text-center">
              <!-- <ul class="navbar-nav me-auto mb-lg-0 fs-5 ms-auto p-2 text-center"> -->
              <li class="nav-item me-3">
                <a class="nav-link active fs-6" aria-current="page" href="index.php">Home</a>
              </li>
              <li class="nav-item me-3">
                <a class="nav-link fs-6" href="about.php">About US</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle fs-6" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Courses
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="itprograms.php">Computer Courses</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="vocprograms.php">Vocational Courses</a></li>
                  <!-- <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                </ul>
              </li>
              <!-- <li class="nav-item me-3">
                <a class="nav-link" href="#">Service</a>
              </li> -->
              <!-- <li class="nav-item me-3">
                <a class="nav-link fs-6" href="contact.php">Contact US</a>
              </li> -->
              <li class="nav-item">
                <a href="donationpage.php" class="btn btn-primary fs-6">Donate to Support</a>
              </li>
            </ul>
            <!-- <div>
              <a href="" class="btn btn-primary">Donate to Support</a>
            </div> -->
            <!-- <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form> -->
          </div>
        </div>
      </nav>
      <nav class="navbar-expand-lg navbar-primary bg-primary" id="submenu">
        <!-- <nav class="navbar-expand-lg navbar-primary bg-primary" id="submenu"> -->
          <div class="container d-flex text-white" style="font-size: 18px;">
            <div class="col-9 d-flex" style="padding-top: 3px;"><i class="bi bi-phone-fill"></i>: +233 53 531 8127 &nbsp; &#124; &nbsp;<i class="bi bi-envelope-fill"></i>: optimumtraininginstitute@gmail.com</div>
            <!-- <div class="col-7" style="padding-top: 3px;"><i class="bi bi-envelope-fill"></i>: optimumtraininginstitute@gmail.com</div> -->
            <div class="col-3 d-flex text-white">
              <!-- <a href="oes/index.php" target="_blank" rel="noopener noreferrer" class="btn btn-primary" id="min_nav_btn">Login</a> -->
              <a href="oes/index.php" class="btn btn-primary" id="min_nav_btn">Login</a>
              <div style="height: 30px; border: 1px solid white; margin: 5px;"></div>
              <a href="applyform.php" class="btn btn-primary" id="min_nav_btn">Apply</a>
            </div>
          </div>
      </nav>
    </div>