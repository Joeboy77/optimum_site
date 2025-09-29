<?php
session_start();
require '../config.php';
// error_reporting(0);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="icon" href="../images/Optimum.png">
    <title>Optimum Portal | Register Page</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- Optional to allow when offline -->
    <script type="text/javascript" src="sweetalert.min.js"></script>
</head>
<body style="background-color: cornflowerblue;">

    <!----------------------- Main Container -------------------------->

     <div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!----------------------- Login Container -------------------------->

       <div class="row col-md-4 m-3">

    <!--------------------------- Left Box ----------------------------->

       <!-- <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;">
           <div class="featured-image mb-3">
            <img src="images/1.png" class="img-fluid" style="width: 250px;">
           </div>
           <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Be Verified</p>
           <small class="text-white text-wrap text-center" style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Join experienced Designers on this platform.</small>
       </div>  -->

    <!-------------------- ------ Right Box ---------------------------->
        
       <div class="col-md-12 right-box">
        <form action="register.php" method="POST" class="border p-4 bg-white shadow">
          
          <div class="mb-3 col-md-12">
            <img src="logo/1.png" alt="logo" class="rounded mx-auto d-block" style="width: 80px;">
          </div>
          <div class="text-center text-primary"><?php echo $_SESSION['firstname'] ." ". $_SESSION['lastname']?></div>
          <h6 class="mb-3 col-md-12 text-center" style="letter-spacing: 1px;">Create User Credentials</h6>
          
          <div class="mb-3 col-md-12">
            <input type="text" name="username" class="form-control" placeholder="Enter Username">
          </div>

          <div class="mb-3 col-md-12">
            <input type="password" name="password" class="form-control" placeholder="Enter Password">
          </div>

          <div class="mb-3 col-md-12">
            <input type="password" name="cpassword" class="form-control" placeholder="Confirm Password">
          </div>

          <div class="row-flex text-center">
            <button type="submit" name="registersubmit" class="btn btn-success col-md-4">Submit</button>
            <a type="submit" href="signup.php" class="btn btn-danger col-md-4">Back</a>
          </div>
        </form>
       </div> 

      </div>
    </div>
    <!-- bootsrap script -->
    <script src="js/jquery-3.6.0.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>

<?php
if (isset($_POST["registersubmit"])) {

  # code...
  $username = mysqli_real_escape_string($con, $_POST["username"]);
  $password = mysqli_real_escape_string($con, $_POST["password"]);
  $cpassword = mysqli_real_escape_string($con, $_POST["cpassword"]);
  
  if (empty($username)) {
    ?>
    <script>

      swal({
        title: "Error",
        text: "Username is required",
        icon: "error",
      });

    </script>

    <?php
    exit();
  }else if (empty($password)) {
    ?>
    <script>

      swal({
        title: "Error",
        text: "Password is required",
        icon: "error",
      });

    </script>

    <?php
    exit();
  }else if (empty($cpassword)) {
    ?>
    <script>

      swal({
        title: "Error",
        text: "Confirm Password is required",
        icon: "error",
      });

    </script>

    <?php
    exit();
  }elseif ($password !== $cpassword) {
    ?>
    <script>

      swal({
        title: "Error",
        text: "Password and Confirm Password are not the same",
        icon: "error",
      });

    </script>

    <?php
    exit();
  }else{

  $password = md5($password);
  // Checking to see if username and password already been registered
  $query = "SELECT * FROM registration WHERE username = '$username' AND password = '$password' LIMIT 1";
  $query_run = mysqli_query($con, $query);
  if(mysqli_num_rows($query_run)===1){
    ?>
    <script>

      swal({
        title: "Error",
        text: "Unsuccessful. Username and Password Exist already",
        icon: "error",
      });

    </script>

    <?php

  }else{
    $query = "UPDATE registration SET username='$username', password='$password' WHERE indexnumber = '$_SESSION[indexnumber]'";
    $query_run = mysqli_query($con, $query);
      ?>
    <script>

      swal({
        title: "Success",
        text: "Registration Successful",
        icon: "success",
      });

    </script>

    <?php
      header("Location: index.php");
      exit();
  }
}
}
?>




