
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
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <title>Optimum TI - Payment Session </title>
    <link rel="icon" href="../images/Optimum.png">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <!-- Optional to allow when offline -->
    <script type="text/javascript" src="sweetalert.min.js"></script>
    <!-- Paystack cdn -->
    <!-- <script src="https://js.paystack.co/v2/inline.js"></script> -->
    <script src="https://js.paystack.co/v1/inline.js"></script>

</head>
<style>
  
</style>
</style>
<body style="background-color: cornflowerblue;">

    <!----------------------- Main Container -------------------------->

     <div class="container d-flex justify-content-center align-items-center min-vh-100">

    <!----------------------- Login Container -------------------------->

       <div class="row col-md-4 border rounded-4 p-2 bg-white shadow box-area m-3">

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
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="input-group">
            <img src="../images/Optimum.png" alt="logo" class="rounded mx-auto d-block" style="width: 80px;">
          </div>

          <div class="mb-3 col-md-12">
            <label>Firstname</label><input type="text" class="form-control" value="<?php echo $_SESSION['fname'];?>" readonly>
          </div>

          <div class="mb-3 col-md-12">
            <label>Lastname</label><input type="text" class="form-control" value="<?php echo $_SESSION['lname'];?>" readonly>
          </div>

          <div class="mb-3 col-md-12">
            <label>Email</label><input type="text" class="form-control" value="<?php echo $_SESSION['email'];?>" readonly>
          </div>

          <div class="mb-3 col-md-12">
            <label>Amount Ghc</label><input type="text" class="form-control" value="<?php echo $_SESSION['amount'];?>" readonly>
          </div>

          <div class="mb-3 col-md-12">
            <label>Phone</label><input type="text" class="form-control" value="<?php echo $_SESSION['phone'];?>" readonly>
          </div>

          <div class="row-flex text-center">
            <a class="btn btn-danger col-md-4 m-2" href="index.php">Back</a>
            <button type="button" name="enter" class="btn btn-success col-md-4 m-2" onclick="payWithPaystack()">Pay</button>
          </div>
        </form>
       </div> 

      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- bootsrap script -->
    <script src="js/jquery-3.6.0.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        function payWithPaystack(){
          const api = "pk_test_3c4e1af23aa7f3a3ea5aeefc7d0da2bea102d0b1";
          var handler = PaystackPop.setup({
            key: api,
            email: "<?php echo $_SESSION['email'];?>",
            amount: "<?php echo $_SESSION['amount']*100;?>",
            currency: "GHS",
            ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
            metadata: {
              firstname: "<?php echo $_SESSION['fname'];?>",
              lastname: "<?php echo $_SESSION['lname'];?>",
               custom_fields: [
                  {
                      display_name: "<?php echo $_SESSION['fname'];?>",
                      variable_name: "<?php echo $_SESSION['fname'];?>",
                      value: "<?php echo $_SESSION['phone'];?>",
                  }
               ]
            },
            callback: function(response){
                // alert('success. transaction ref is ' + response.reference);
              const referenced = response.reference;
              window.location.href='success.php?successfullypaid='+referenced;
            },
            onClose: function(){
                alert('window closed');
            }
          });
          handler.openIframe();
        }
      </script>

</body>
</html>




<!-- Callback transaction -->
<!-- callback: function(response){
    console.log('success. ref is ' + response.reference);

    let data = {reference: response.reference};

    fetch("ijsucceed.replit.com/paystack-integeration/verify-response.php", {
        method: "POST", 
        body: JSON.stringify(data)
    }).then(res => {
        console.log("Request complete! response:", res);
        alert("Payment complete!")
    });
}, -->

<!-- redirect to server -->
<!-- callback: function(response) {
  window.location = "https://ijsucceed.replit.com/paystack-integeration-php/verify-redirect.php?reference=" + response.reference;
}, -->


<!-- verify payment -->
<?php
  // $curl = curl_init();
  
  // curl_setopt_array($curl, array(
  //   CURLOPT_URL => "https://api.paystack.co/transaction/verify/:reference",
  //   CURLOPT_RETURNTRANSFER => true,
  //   CURLOPT_ENCODING => "",
  //   CURLOPT_MAXREDIRS => 10,
  //   CURLOPT_TIMEOUT => 30,
  //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  //   CURLOPT_CUSTOMREQUEST => "GET",
  //   CURLOPT_HTTPHEADER => array(
  //     "Authorization: Bearer SECRET_KEY",
  //     "Cache-Control: no-cache",
  //   ),
  // ));
  
  // $response = curl_exec($curl);
  // $err = curl_error($curl);

  // curl_close($curl);
  
  // if ($err) {
  //   echo "cURL Error #:" . $err;
  // } else {
  //   echo $response;
  // }
?>
