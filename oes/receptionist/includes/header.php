<?php

date_default_timezone_set("Africa/Accra");
session_start();
require '../../config.php';
// error_reporting(0);

// Writing code to retrict login users
if(isset($_SESSION["id"])){
       
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
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Optimum Sch. Portal | Admin Dashboard</title>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables using bootstrap 5 with fundaebit -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />

    <!-- Adding datatable css -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css"> -->
  </head>
  <body>