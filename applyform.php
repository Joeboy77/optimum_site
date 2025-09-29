<?php
include('includes/header.php');
?>
<div>
  <!-- Showcase area in the front page -->
  <section class="p-5 text-center text-sm-start" style="background-size: cover;background-repeat: no-repeat; background-image: linear-gradient(45deg, rgba(255, 0, 0, 0.5), rgba(255, 166, 0, 0.5)), url(images/ALX-Hero-nov.jpg);">
     <div class="container mt-5">
      <div class="d-sm-flex align-items-center justify-content-center">
        <h1 class="text-white" style="text-shadow: 2px 2px #ff0000;">How To Apply For Form</h1>
      </div>
     </div>
  </section>
</div>

    <!-- After Slide End -->
    <div>
      <section id="impact" class="services section-padding">
        <div class="container">
          <h5 class="text-danger text-center">
            Please read the instructions before clicking the button to buy form
          </h5>
        </div>
      </section>
    </div>

    <div class="container mb-5">
      <div class="row col-md-12 border rounded-4 bg-white shadow box-area m-3">

    <!--------------------------- Left Box ----------------------------->

       <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box">
           <div class="featured-image mb-3">
            <!-- <img src="images/father.jpg" class="img-fluid"> -->
            <h3>RULES</h3>
            <ul>
              <li>Fill in your personal details to buy the form</li>
              <li>Click the "BUY FORM" button below to purchase the form</li>
              <li>Complete the payment details buy entering pin on your mobile number</li>
              <li>After payment, the Application Form page will open for you to download</li>
              <li>Fill the forms and submit either to the office or via the institution email</li>
            </ul>
           </div>
       </div> 

    <!-------------------- ------ Right Box ---------------------------->
        
      <div class="col-md-6 right-box">
        <form action="applyform.php" method="POST">
          <div class="row align-items-center">
                <div class="header-text">
                     <!-- <h2>Hello,Again</h2> -->
                     <p class="text-center fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600; color: #292a74;">Payment Details </p>
                </div>
                <div class="row mb-1">
                    <small>Cost of Form: Gh 50.00</small>
                </div>
                <div class="form-group input-group mb-3">
                    <input type="text" name="fname" class="form-control form-control-lg bg-light fs-6" placeholder="Enter first name">
                </div>
                <div class="form-group input-group mb-3">
                    <input type="text" name="lname" class="form-control form-control-lg bg-light fs-6" placeholder="Enter last name">
                </div>
                <div class="form-group input-group mb-3">
                    <input type="email" name="email" class="form-control form-control-lg bg-light fs-6" placeholder="Email address">
                </div>
                <div class="form-group input-group mb-3">
                    <input type="text" name="phone" class="form-control form-control-lg bg-light fs-6" placeholder="Enter phone number" required>
                </div>
                <div class="input-group mb-3">
                    <button type="submit" name="enter" class="btn btn-lg btn-success fs-6" style="width: 100%;">BUY FORM</button>
                </div>
          </div>
        </form>
       </div> 

      </div>
    </div>
    
<?php
include('includes/footer.php');
?> 

<?php
if (isset($_POST["enter"])) {

  # code...
  $fname = mysqli_real_escape_string($con, $_POST["fname"]);
  $lname = mysqli_real_escape_string($con, $_POST["lname"]);
  $amount = mysqli_real_escape_string($con, $_POST["amount"]);
  $email = mysqli_real_escape_string($con, $_POST["email"]);
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
    $_SESSION['amount'] = "50.00";
    $_SESSION['phone'] = $phone;

    // header("Location: pay.php");
    echo '<script type="text/javascript">window.open("formpayment/pay.php")</script>';
    // header("Location: index.php");
    exit();
  }
}

?>