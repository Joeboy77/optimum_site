<?php

date_default_timezone_set("Africa/Accra");
session_start();
require '../../config.php';
error_reporting(0);

// Writing code to retrict login users
if(isset($_SESSION["schoolID"])){
       
} else {
    header("location: index.php");
}


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
    <link rel="icon" href="../../images/Optimum.png">
    <!-- ckeditor -->
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.css" />

    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Optimum OES | Staff Dashboard</title>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  </head>
  <body>