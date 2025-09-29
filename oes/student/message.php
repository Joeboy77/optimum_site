<?php
include('includes/header.php');
include('includes/navbar.php');

?> 

  <main class="mt-5 pt-3">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i> Send Message</span> 
                <!-- <div class="text-xs font-weight-bold">No. of Rooms: ... </div> -->
                <!-- <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i> Take a Test</button> -->
              </div>
              <div>
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
                 ?>
              </div>

              <div class="card-body">
                <!-- <h3 class="text-danger text-center" id="para">Not Found</h3> -->
                <div class="row">
                  <div>
                    <div class="card shadow h-100 py-2">
                      <!-- <div class="card-header">
                        <h5 class="text-xs font-weight-bold text-primary text-uppercase">Load Details</h5>
                      </div> -->
                      <div class="card-body">
                        <div>
                         <form action="" method="POST">
                          <div class="modal-body">
                              <div class="row">
                                <div class="col-12">
                                  <div class="mb-2">
                                    <label class="form-label">Title:</label>
                                    <input type="text" class="form-control" name="title">
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="mb-2">
                                    <label class="form-label">Message:</label>
                                    <textarea class="form-control" name="message"></textarea>
                                  </div>
                                </div>
                                
                              </div>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary" name="tripsubmit">Send Message</button>
                            </div>
                          </form>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>

        
      </div>
    </main>

<?php
include('includes/footer.php');
?>

<?php
if (isset($_POST["tripsubmit"])) {
  // code...
  $title = mysqli_real_escape_string($con, $_POST["title"]);
  $message = mysqli_real_escape_string($con, $_POST["message"]);

  //Code for validation
    if (empty($title)) {
        $_SESSION['status'] = "Please Add A Title";
        echo '<script type="text/javascript">window.location="message.php"</script>';
        exit();
    }elseif (empty($message)) {
        $_SESSION['status'] = "Please Add A Messgae";
        echo '<script type="text/javascript">window.location="message.php"</script>';
        exit();
    }else{
    
          $query = "INSERT INTO message (title, message, messengerID) VALUES ('$title', '$message', '$_SESSION[schoolID]')";
          $query_run = mysqli_query($con, $query);
          if ($query_run) {
             $_SESSION['success'] = "Message Sent Successfully";
            echo '<script type="text/javascript">window.location="message.php"</script>';
            exit();
          }else{
            $_SESSION['status'] = "Error!! Message Not Sent Unsuccessful";
            echo '<script type="text/javascript">window.location="message.php"</script>';
            exit();
            }
          }
        }
?>

