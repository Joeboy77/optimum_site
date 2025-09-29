
<?php

session_start();
require '../config.php';
error_reporting(0);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/Optimum.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <title>Optimum TI - Donation Page </title>
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
<body style="background-color: cornflowerblue;">

    <!----------------------- Main Container -------------------------->

     <div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!----------------------- Login Container -------------------------->

       <div class="row col-md-12 border rounded-4 p-2 bg-white shadow box-area m-3">

    <!--------------------------- Left Box ----------------------------->

       <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box">
           <div class="featured-image mb-3">
            <img src="../images/father.jpg" class="img-fluid">
           </div>
           <!-- <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Be Verified</p>
           <small class="text-white text-wrap text-center" style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Join experienced Designers on this platform.</small> -->
       </div> 

    <!-------------------- ------ Right Box ---------------------------->
        
       <div class="col-md-6 right-box">
        <form action="" method="POST">
            
          <div class="row align-items-center">
                <div class="header-text">
                     <!-- <h2>Hello,Again</h2> -->
                     <p class="text-center fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600; color: #292a74;">Payment Details </p>
                </div>
                <div class="row mb-1">
                    <small>A little token is much appreciated</small>
                </div>
                <div class="form-group input-group mb-3">
                    <input type="text" name="fname" class="form-control form-control-lg bg-light fs-6" placeholder="Enter first name">
                </div>
                <div class="form-group input-group mb-3">
                    <input type="text" name="lname" class="form-control form-control-lg bg-light fs-6" placeholder="Enter last name">
                </div>
                <div class="form-group input-group mb-3">
                    <input type="email" name="amount" class="form-control form-control-lg bg-light fs-6" placeholder="Enter Email" required>
                </div>
                <div class="form-group input-group mb-3">
                    <input type="number" name="amount" class="form-control form-control-lg bg-light fs-6" placeholder="Enter Amount" required>
                </div>
                <div class="form-group input-group mb-3">
                    <input type="text" name="phone" class="form-control form-control-lg bg-light fs-6" placeholder="Enter phone number" required>
                </div>
                <div class="input-group mb-3">
                    <button type="submit" name="enter" class="btn btn-lg btn-success w-100 fs-6">Enter</button>
                </div>
          </div>
        </form>
       </div> 

      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- bootsrap script -->
    <!-- <script src="js/jquery-3.6.0.js"></script>
    <script src="js/bootstrap.min.js"></script> -->

</body>
</html>

<?php
if (isset($_POST["enter"])) {

  # code...
  $fname = mysqli_real_escape_string($con, $_POST["fname"]);
  $lname = mysqli_real_escape_string($con, $_POST["lname"]);
  $email = mysqli_real_escape_string($con, $_POST["email"]);
  $amount = mysqli_real_escape_string($con, $_POST["amount"]);
  $phone = mysqli_real_escape_string($con, $_POST["phone"]);
  
  if (empty($fname)) {
    ?>
    <script>

      swal({
        title: "Error",
        text: "Firstname is required",
        icon: "error",
      });

    </script>

    <?php
    exit();
  }else if (empty($lname)) {
    ?>
    <script>

      swal({
        title: "Error",
        text: "Lastname is required",
        icon: "error",
      });

    </script>

    <?php
    exit();
  }else{
    // writing session for input to be used at next page
    $_SESSION['fname'] = $fname;
    $_SESSION['lname'] = $lname;
    $_SESSION['email'] = $email;
    $_SESSION['amount'] = $amount;
    $_SESSION['phone'] = $phone;

    // header("Location: pay.php");
    echo '<script type="text/javascript">window.location="pay.php"</script>';
    // header("Location: index.php");
    exit();
  }
}

?>