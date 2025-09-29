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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="icon" href="logo/ruumlink.png">
    <title>Optimum OES | Sign Up</title>
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
        <form action="signup.php" method="POST" class="border p-4 bg-white shadow">
          
          <div class="mb-3 col-md-12">
            <img src="logo/1.png" alt="logo" class="rounded mx-auto d-block" style="width: 80px;">
          </div>
          <h6 class="mb-3 col-md-12 text-center" style="letter-spacing: 1px;">Sign Up Form</h6>
                    
          <div class="mb-3 col-md-12">
            <input type="text" name="schoolID" class="form-control" placeholder="Enter SchoolID">            
          </div>

          <div class="row-flex text-center">
            <a type="submit" href="index.php" class="btn btn-danger col-md-4">Back</a>
            <button type="submit" name="signupsubmit" class="btn btn-success col-md-4">Submit</button>
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
if (isset($_POST["signupsubmit"])) {
  // code...
  $schoolID = mysqli_real_escape_string($con, $_POST["schoolID"]);

  if (empty($schoolID)) {
    ?>
    <script>

      swal({
        title: "Error",
        text: "Please Enter SchoolID",
        icon: "error",
      });

    </script>

    <?php
    // header("Location: index.php?error= Email is required");
    exit();
  }else{
    $query = "SELECT * FROM registration WHERE indexnumber = '$schoolID' LIMIT 1";
    $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run)===1){
      // Select Check multiple registration
      $query1 = "SELECT * FROM registration 
                 WHERE indexnumber = '$schoolID' 
                 AND (
                   username IS NULL 
                   OR TRIM(username) = '' 
                   OR UPPER(TRIM(username)) IN ('NULL','N/A','NOT REGISTERED')
                 ) 
                 AND (
                   password IS NULL 
                   OR TRIM(password) = '' 
                   OR UPPER(TRIM(password)) IN ('NULL','N/A','NOT REGISTERED')
                 )";
      $query_run = mysqli_query($con, $query1);
      if(mysqli_num_rows($query_run)===1){
        $row = mysqli_fetch_assoc($query_run);
        $_SESSION['firstname'] = $row["firstname"];
        $_SESSION['lastname'] = $row["lastname"];
        $_SESSION['indexnumber'] = $row["indexnumber"];
        header("Location: register.php");
        exit();
      }else{
        ?>
        <script>

          swal({
            title: "Error",
            text: "You cannot register with schoolID twice",
            icon: "error",
          });

        </script>

        <?php
        exit();
      }
    }else{
      ?>
        <script>

          swal({
            title: "Error",
            text: "SchoolID entered doesnot exist",
            icon: "error",
          });

        </script>

        <?php
      exit();
    }
  }
}
?>




