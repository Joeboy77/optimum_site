<?php
include('includes/header.php');
include('includes/navbar.php');

?> 

  <main class="mt-5 pt-3">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i> Payment Detail</span>
                <a href="feepayment.php" class="btn btn-danger" type="submit">Back</a>
              </div>
            
              <form action="paymentoffee.php" method="POST">
              <div class="card-body">
                <!-- <h3 class="text-danger text-center" id="para">Not Found</h3> -->
                <div class="row">
                  <div>
                    <div class="card shadow h-100 py-2">
                      <div class="card-header d-sm-flex align-items-center justify-content-between">
                        <h5 class="text-xs font-weight-bold text-primary text-uppercase">Index Number: <?php echo $_SESSION['indexnumber'];?></h5>
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal1"><i class="bi bi-plus"></i>
                            Make Payment
                          </button>
                      </div>
                      <div class="row card-body d-flex">
                        <div class="col-md-6">
                          <div class="row mb-2">
                            <div class="col-4">Firstname</div>
                            <div class="col-8">
                              <input type="hidden" class="form-control" name="indexnumber" value="<?php echo $_SESSION['indexnumber'];?>">
                              <input type="text" class="form-control" name="lastname" value="<?php echo $_SESSION['firstname'];?>" readonly>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Lastname</div>
                            <div class="col-8">
                              <input type="text" class="form-control" name="lastname" value="<?php echo $_SESSION['lastname'];?>" readonly>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Fee Status</div>
                            <div class="col-8">
                              <input type="text" class="form-control" name="paymentstatus" value="<?php echo $_SESSION['paymentstatus'];?>" readonly>
                            </div>
                          </div>
                          

                        </div>
                        <div class="col-md-6">
                          <div class="row mb-2">
                            <div class="col-4">School Fees</div>
                            <div class="col-8"><input type="text" class="form-control" name="fees" value="<?php echo $_SESSION['fees'];?>" readonly></div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Amount Paid</div>
                            <div class="col-8"><input type="text" class="form-control" name="amountpaind" value="<?php echo $_SESSION['amountpaind'];?>" readonly></div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Balance To Pay</div>
                            <div class="col-8"><input type="text" class="form-control" name="balance" value="<?php echo $_SESSION['balance'];?>" readonly></div>
                          </div>
                        </div>
                        <!-- <hr> -->
                        <!-- <div class="">
                          <label class="form-label">Enter Amount to Pay:</label>
                          <input type="text" class="form-control" name="amount" placeholder="Enter Amount Here">
                        </div> -->
                      </div>
                      
                      <!-- <div class="card-footer">
                        <center>
                          <a href="feepayment.php" class="btn btn-danger" type="submit">Back</a>
                          <button type="submit" class="btn btn-primary" name="makepayment">Make Payment</button></center>
                      </div> -->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <table class="table table-striped table-hover text-center">
                    <h3 class="text-center mt-2">Payment Records</h3>
                      <thead class="table-success">
                        <tr>
                          <th hidden>S. No.</th>
                          <th>S. No.</th>
                          <th>Amount Owned</th>
                          <th>Payment</th>
                          <th>Balance</th>
                          <th>Date of Payment</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          $query = "SELECT * FROM paymentdetails WHERE indexnumber = '$_SESSION[indexnumber]'";
                          $query_run = mysqli_query($con, $query);
                          if(mysqli_num_rows($query_run) > 0){
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query_run)){
                        ?>
                        <tr>
                          <td hidden><?php echo $row["id"];?></td>
                          <td><?php echo $no;?></td>
                          <td><?php echo $row["feeamount"];?></td>
                          <td><?php echo $row["payment"];?></td>
                          <td><?php echo $row["balance"];?></td>
                          <td><?php echo $row["dateofpayment"];?></td>
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
              </form>
          </div>

        
    </main>

<?php
include('includes/footer.php');
?>

<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Fee Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="paymentoffee.php" method="POST">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Amount to Pay:</label>
            <input type="hidden" class="form-control" name="indexnumber" value="<?php echo $_SESSION['indexnumber'];?>">
            <input type="text" class="form-control" name="amount" placeholder="Enter Amount to Pay">
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="makepayment">Make Payment</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
if (isset($_POST["makepayment"])) {
    // code...
    $indexnumber = mysqli_real_escape_string($con, $_POST["indexnumber"]);
    $amount = mysqli_real_escape_string($con, $_POST["amount"]);

    if (empty($amount)) {
       $_SESSION['status'] = "Please Enter Amount to Pay";
       $_SESSION['status_code'] = "error";
       echo '<script type="text/javascript">window.location="paymentoffee.php"</script>';
       exit();
  }else{
    $query = "SELECT * FROM student_registration WHERE indexnumber = '$indexnumber' LIMIT 1";
    $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run) === 1){
        $row = mysqli_fetch_assoc($query_run);
        $_SESSION["firstname"] = $row["firstname"];
        $_SESSION["lastname"] = $row["lastname"];
        $_SESSION["fees"] = $row["fees"];
        $_SESSION["amountpaind"] = $row["amountpaind"];
        $_SESSION["balance"] = $row["balance"];

        $currentamountpaid = intval($amount) + intval($_SESSION['amountpaind']);
        $currentbalaceremaining = $_SESSION['fees'] - $currentamountpaid;

        // Code to to update status
        if ($currentbalaceremaining <= 0) {
            $query = "UPDATE student_registration SET amountpaind='$currentamountpaid', balance='$currentbalaceremaining', paymentstatus = 'Full Payment' WHERE indexnumber = '$indexnumber'";
            $query_run = mysqli_query($con, $query);
            if ($query_run){
            $query = "INSERT INTO paymentdetails (firstname, lastname, indexnumber, feeamount,   payment, balance) VALUES ('$_SESSION[firstname]', '$_SESSION[lastname]', '$indexnumber', '$_SESSION[fees]', '$amount', $currentbalaceremaining')";
            $query_run = mysqli_query($con, $query);
            if ($query_run){
                $_SESSION['status'] = "Payment Successful";
                $_SESSION['status_code'] = "success";
                echo '<script type="text/javascript">window.location="paymentoffee.php"</script>';
                exit();
            }
        }
        } else{
            $query = "UPDATE student_registration SET amountpaind='$currentamountpaid', balance='$currentbalaceremaining', paymentstatus = 'Part Payment' WHERE indexnumber = '$indexnumber'";
            $query_run = mysqli_query($con, $query);
            if ($query_run){
            $query = "INSERT INTO paymentdetails (firstname, lastname, indexnumber, feeamount,   payment, balance) VALUES ('$_SESSION[firstname]', '$_SESSION[lastname]', '$indexnumber', '$_SESSION[fees]', '$amount', '$currentbalaceremaining')";
            $query_run = mysqli_query($con, $query);
            if ($query_run){
                $_SESSION['status'] = "Payment Successful";
                $_SESSION['status_code'] = "success";
                echo '<script type="text/javascript">window.location="paymentoffee.php"</script>';
                exit();
            }
        }
        }

    //     // Query to update current record
    //     $query = "UPDATE cashindebt SET amount_paid='$currentamountpaid', balance='$currentbalaceremaining' WHERE id = '$id'";
    //     $query_run = mysqli_query($con, $query);
    //     if ($query_run){
    //         $query = "INSERT INTO paymentdetails (name, paymentid, amountowed, payment, balance, work_unit, track) VALUES ('$_SESSION[name]', '$id', '$_SESSION[balance]', '$amount', '$currentbalaceremaining', '$_SESSION[work_unit]', '$_SESSION[track]')";
    //         $query_run = mysqli_query($con, $query);
    //         if ($query_run){
    //             $_SESSION['success'] = "Payment Successful";
    //             echo '<script type="text/javascript">window.location="cashretrieve.php"</script>';
    //             exit();
    //         }
    //     }
    // }else{
    //     $_SESSION['status'] = "Please Reselect Person";
    //     echo '<script type="text/javascript">window.location="cashpayment.php"</script>';
    //     exit();
    // }
    }
  }
}
?>

