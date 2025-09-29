
<?php

session_start();
require '../config.php';
// error_reporting(0);

// writing to check if payment done before entry of page
if (!$_GET['successfullypaid']) {
  header("Location: index.php");
  exit;
}else{
  $reference = $_GET['successfullypaid'];
}

// Insert into database
$query = "INSERT INTO donation (firstname, lastname, contact, amount, reference) VALUES ('$_SESSION[fname]', '$_SESSION[lname]', '$_SESSION[phone]', '$_SESSION[amount]', '$reference')";
$query_run = mysqli_query($con, $query);
if ($query_run){
  // session_unset();
  // session_destroy();
  // exit;
}else{
  die("Sorry! something went wrong. Data not inserted");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <title>Optimum TI - Payment Session </title>
    <link rel="icon" href="../images/Optimum.png">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <!-- Optional to allow when offline -->
    <script type="text/javascript" src="sweetalert.min.js"></script>
</head>
<style>
  a{
    text-decoration: none;
  }
</style>
<body style="background-color: #292a74;">

    <!----------------------- Main Container -------------------------->

     <div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!----------------------- Login Container -------------------------->

       <div class="row col-md-8 border rounded-4 p-2 bg-white shadow box-area m-3">
        <h5 class="text-center">Payment successful, you can click the exit button to leave the page</h5>
       <div class="col-md-12 right-box">
        <table>
          <tr>
            <td>Firstname:</td><td><?php echo $_SESSION['fname'];?></td>
          </tr>
          <tr>
            <td>Lastname:</td><td><?php echo $_SESSION['lname'];?></td>
          </tr>
          <tr>
            <td>Amount Paid:</td><td><?php echo $_SESSION['amount'];?></td>
          </tr>
          <tr>
            <td>Reference No:</td><td><?php echo $reference; ?></td>
          </tr>
        </table>
       </div> 
       <div><a href="index.php"><button class="btn btn-primary">Exit</button></a></div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

</body>
</html>
