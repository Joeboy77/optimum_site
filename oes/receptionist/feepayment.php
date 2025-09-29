<?php
include('includes/header.php');
include('includes/navbar.php');

?> 

	<main class="mt-5 pt-3">
      <div class="container-fluid">
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

        <!-- <div class="row mb-2">
          <div class="d-sm-flex align-items-center justify-content-between ">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="searchpage.php"><button class="btn btn-primary btn-sm"><i class="bi bi-border-outer me-2"></i>Search Rooms</button></a>
          </div>
        </div> -->

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i>Daily Payment Record</span> 
                <div class="text-xs font-weight-bold">
                	<button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i>
        					  Fee Payment
        					</button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <table id="example" class="table table-striped table-hover text-center">
                      <thead class="table-success">
                        <tr>
                          <th hidden>S. No.</th>
                          <th>S. No.</th>
                          <th>Student ID</th>
                          <th>Firstname</th>
                          <th>Lastname</th>
                          <th>Fees</th>
                          <th>Amount Paid</th>
                          <th>Balance</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          $query = "SELECT * FROM paymentdetails WHERE dateofpayment = '$_SESSION[date]'";
                          $query_run = mysqli_query($con, $query);
                          if(mysqli_num_rows($query_run) > 0){
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query_run)){
                        ?>
                        <tr>
                          <td hidden><?php echo $row["id"];?></td>
                          <td><?php echo $no;?></td>
                          <td><?php echo $row["indexnumber"];?></td>
                          <td><?php echo $row["firstname"];?></td>
                          <td><?php echo $row["lastname"];?></td>
                          <td><?php echo $row["feeamount"];?></td>
                          <td><?php echo $row["payment"];?></td>
                          <td><?php echo $row["balance"];?></td>
                        </tr>
                        <?php
                        $no++;
                        }
                      }else{
                        echo "No Record Found";
                      }
                      ?>
                      </tbody>
                    </table>
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

<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Make Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="feepayment.php" method="POST">
      <div class="modal-body">
          
          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <label class="form-label">Enter Student ID</label>
                <input type="text" class="form-control" name="studentID" >
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="enter">Enter</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
if (isset($_POST["enter"])) {
  // code...
  $studentID = mysqli_real_escape_string($con, $_POST["studentID"]);

  //Code for validation
    if (empty($studentID)) {
        $_SESSION['status'] = "Please Enter Studdent ID to continue";
        echo '<script type="text/javascript">window.location="feepayment.php"</script>';
        exit();
    }else{
      $query = "SELECT * FROM student_registration WHERE indexnumber = '$studentID' LIMIT 1";
      $query_run = mysqli_query($con, $query);
      if(mysqli_num_rows($query_run) === 1){
        $row = mysqli_fetch_assoc($query_run);
        $_SESSION['indexnumber'] = $row['indexnumber'];
        $_SESSION['firstname'] = $row['firstname'];
        $_SESSION['lastname'] = $row['lastname'];
        $_SESSION['fees'] = $row['fees'];
        $_SESSION['amountpaind'] = $row['amountpaind'];
        $_SESSION['balance'] = $row['balance'];
        $_SESSION['paymentstatus'] = $row['paymentstatus'];

        echo '<script type="text/javascript">window.location="paymentoffee.php"</script>';
        exit();

      }else{
        $_SESSION['status'] = "Error! You have enter a wrong StudentID";
        echo '<script type="text/javascript">window.location="feepayment.php"</script>';
        exit();
      }
    }
}
?>