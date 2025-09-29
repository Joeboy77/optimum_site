<?php
date_default_timezone_set("Africa/Accra");

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
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="icon" href="../images/Optimum.png">
    <title>Optimum Portal | Login Page</title>
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

       <div class="row col-md-4 border rounded-4 p-2 bg-white shadow box-area m-3">
        
       <div class="col-md-12 right-box">
        <form action="index.php" method="POST">
                      
          <div class="row align-items-center">
                <div class="input-group">
                  <img src="../images/Optimum.png" alt="logo" class="rounded mx-auto d-block" style="width: 80px;">
                </div>
                <div class="header-text">
                     <!-- <h2>Hello,Again</h2> -->
                     <p class="text-center fs-5" style="font-family: 'Courier New', Courier, monospace; font-weight: 600; color: #292a74;">School Portal System</p>
                </div>
                <div class="row mb-1">
                    <small>Please enter details to login</small>
                </div>
                <div class="form-group input-group mb-3">
                    <input type="text" name="username" class="form-control form-control-lg bg-light fs-6" placeholder="Enter Username">
                </div>
                <div class="form-group input-group mb-3">
                    <input type="password" name="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password" id="pass">
                    <div class="input-group-prepend">
                    	<div class="input-group-text">
                    		<a href="#" class="text-dark p-1" id="icon-click">
                          <span class="passIcon" id="signupPassIcon"><i class="fa-solid fa-eye"></i></span>
                    		</a>
                    	</div>
                    </div>
                    <!-- <img src="images/eye-close.png"> -->
                </div>
                <div class="input-group mb-3 d-flex justify-content-between">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="formCheck">
                        <label for="formCheck" class="form-check-label text-secondary"><small>Remember Me</small></label>
                    </div>
                    <div class="forgot">
                        <small><a href="forgotpassword.php">Forgot Password?</a></small>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <button type="submit" name="enter" class="btn btn-lg btn-success w-100 fs-6">Login</button>
                </div>
                <div class="row mb-2">
                  <center>
                    <small>Don't have an account? <a href="signup.php">Sign Up</a></small>
                  </center>
                </div>
                <div class="row">
                    <a href="../index.php" class="text-danger text-center"><b>Exit</b></a>
                </div>
          </div>
        </form>
       </div> 

      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- bootsrap script -->
    <script src="js/jquery-3.6.0.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script type="text/javascript">
    	$(document).ready(function(){
    		// alert('Hello');
    		$("#icon-click").click(function(){
    			$("#icon").toggleClass('fa-eye-slash');

    			var input = $("#pass");
    			if (input.attr("type")==="password") {
    				input.attr("type","text");
    			}
    			else{
    				input.attr("type","password");
    			}
    		});
    	});

        // Eye view
        $(document).ready(function () {

           $("#signinPassIcon").click(function(){
              $("#signinPassIcon i").toggleClass("fa-eye fa-eye-slash");

              $($("#signinPassIcon").siblings()[1]).attr("type", function(index, attr){
                 return attr == "password" ? "text" : "password";
              })
           });
           
           $("#signupPassIcon").click(function(){
              $("#signupPassIcon i").toggleClass("fa-eye fa-eye-slash");

              $($("#signupPassIcon").siblings()[1]).attr("type", function(index, attr){
                 return attr == "password" ? "text" : "password";
              })
           });
        });
    </script>

</body>
</html>

<?php


if (isset($_POST["enter"])) {
  # code...
  $username = mysqli_real_escape_string($con, $_POST["username"]);
  $password = mysqli_real_escape_string($con, $_POST["password"]);

  if (empty($username)) {
    ?>
    <script>

      swal({
        title: "Error",
        text: "Enter Username",
        icon: "error",
      });

    </script>

    <?php
    // header("Location: index.php?error= Email is required");
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
    // header("Location: index.php?error= password is required");
    exit();
  }else if ($username === "admin" && $password ==="admin123") {
    $_SESSION['id'] = "admin";
    $_SESSION['username'] = "$username";
    $_SESSION['date'] = date('Y-m-d');
    echo '<script type="text/javascript">window.location="admin/index.php"</script>';
    // header("Location: admin/index.php");
    exit();
  }else{
    $password = md5($password);
    //Writing the query for the select function
    $query = "SELECT * FROM registration WHERE username = '$username' AND password = '$password' LIMIT 1";
    $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run) === 1){
      $row = mysqli_fetch_assoc($query_run);
      if ($row['username'] === $username && $row['password'] === $password && $row['position'] === 'Receptionist' && $row['status'] === 'Staff'){
        //Creating the session onward usage
        $_SESSION['id'] = $row['id'];
        $_SESSION['schoolID'] = $row['indexnumber'];
        $_SESSION['firstname'] = $row['firstname'];
        $_SESSION['lastname'] = $row['lastname'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['date'] = date('Y-m-d');

        //Checking the checkbox
        if (!empty($_POST["remember"])) {
          # code...
          $remember = $_POST["remember"];
          //set the cookies
          setcookie("username",$username,time()+ (10 * 365 * 24 * 60 * 60));
          setcookie("password",$password,time()+ (10 * 365 * 24 * 60 * 60));
        }else{
          setcookie("username",$username,30);
          setcookie("password",$password,30);
        }
        //Redirecting the the admin page
        echo '<script type="text/javascript">window.location="receptionist/index.php"</script>';
        // header("Location: staff/index.php");
        exit();
      }elseif ($row['username'] === $username && $row['password'] === $password && $row['status'] === 'Student') {
        # code...
        $_SESSION['id'] = $row['id'];
        $_SESSION['schoolID'] = $row['indexnumber'];
        $_SESSION['indexnumber'] = $row['indexnumber'];
        $_SESSION['firstname'] = $row['firstname'];
        $_SESSION['lastname'] = $row['lastname'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['date'] = date('Y-m-d');
        
        // Get course information from student_registration table
        $studentQuery = "SELECT courseSelected FROM student_registration WHERE indexnumber = '{$row['indexnumber']}' LIMIT 1";
        $studentResult = mysqli_query($con, $studentQuery);
        if ($studentResult && mysqli_num_rows($studentResult) > 0) {
          $studentRow = mysqli_fetch_assoc($studentResult);
          $_SESSION['course'] = $studentRow['courseSelected'] ?? '';
        } else {
          $_SESSION['course'] = '';
        }

        //Checking the checkbox
        if (!empty($_POST["remember"])) {
          # code...
          $remember = $_POST["remember"];
          //set the cookies
          setcookie("username",$username,time()+ (10 * 365 * 24 * 60 * 60));
          setcookie("password",$password,time()+ (10 * 365 * 24 * 60 * 60));
        }else{
          setcookie("username",$username,30);
          setcookie("password",$password,30);
        }
        echo '<script type="text/javascript">window.location="student/index.php"</script>';
        // header("Location: student/index.php");
        exit();
      }elseif ($row['username'] === $username && $row['password'] === $password && $row['position'] === 'Tutor' && $row['status'] === 'Staff') {
        # code...
        $_SESSION['id'] = $row['id'];
        $_SESSION['schoolID'] = $row['indexnumber'];
        $_SESSION['firstname'] = $row['firstname'];
        $_SESSION['lastname'] = $row['lastname'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['date'] = date('Y-m-d');

        //Checking the checkbox
        if (!empty($_POST["remember"])) {
          # code...
          $remember = $_POST["remember"];
          //set the cookies
          setcookie("username",$username,time()+ (10 * 365 * 24 * 60 * 60));
          setcookie("password",$password,time()+ (10 * 365 * 24 * 60 * 60));
        }else{
          setcookie("username",$username,30);
          setcookie("password",$password,30);
        }
        echo '<script type="text/javascript">window.location="staff/index.php"</script>';
        // header("Location: student/index.php");
        exit();
      }else{
        ?>
        <script>

          swal({
            title: "Error",
            text: "Username and Password Entered Incorrect",
            icon: "error",
          });

        </script>

        <?php
          // header("Location: index.php?error= Invalid Username or Password");
          exit();
      }
    }else{
        ?>
        <script>

          swal({
            title: "Error",
            text: "Invalid Username or Password",
            icon: "error",
          });

        </script>

        <?php
      // header("Location: index.php?error= Invalid Username or Password");
      exit();
    }
  }
}

?>




