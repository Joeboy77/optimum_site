<?php
include('includes/header.php');
include('includes/navbar.php');
?>


    <main class="mt-5 pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <h4>Change Password</h4>
          </div>
        </div>
        <?php
       if (isset($_SESSION["status"]) && $_SESSION["status"] != '') {
         
         ?>
         <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Hey!</strong> <?php echo $_SESSION["status"];?>.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
          
         <?php
         unset($_SESSION["status"]);
         }

         if (isset($_SESSION["success"]) && $_SESSION["success"] != '') {
           
           ?>
           <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Hey!</strong> <?php echo $_SESSION["success"];?>.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
           </div>
            
           <?php
           unset($_SESSION["success"]);
         }
         ?>
        <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="signup-form">
                <form action="code.php" method="POST" class="border p-4 bg-lightgrey shadow">
                    <div>
                        <center>
                        <img class="img-profile rounded-circle" src="../images/1.png" style="width: 100px; height: 100px;">
                        </center>
                    </div>
                    <center><div style="font-size: 12px; color: red;">**First enter previous password in the texbox below before proceeding**</div></center>
                    <div class="mb-3 col-md-12">
                        <label>Old Password</label>
                        <input type="text" name="oldpassword" class="form-control">
                        <input type="hidden" name="id" value="<?php echo $_SESSION['id'];?>">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label>New Password</label>
                        <input type="password" name="newpassword" class="form-control">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label>Confirm Password</label>
                        <input type="password" name="confirmpassword" class="form-control">
                    </div>

                    <div class="mb-3 col-md-12">
                        <button type="submit" name="passwordsubmit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        </div>
      </div>
    </main>

<?php
include('includes/footer.php');
?>
