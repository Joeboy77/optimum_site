<?php
include('includes/header.php');
include('includes/navbar.php');

// Total Gross Amount
$query = "SELECT * FROM student_registration WHERE indexnumber = '$_SESSION[schoolID]' LIMIT 1";
$query_result = mysqli_query($con, $query);
if ($query_result && mysqli_num_rows($query_result) > 0) {
  $row1 = mysqli_fetch_assoc($query_result);
  $_SESSION['fees'] = isset($row1['fees']) ? (float)$row1['fees'] : 0.0;
  $_SESSION['amountpaind'] = isset($row1['amountpaind']) ? (float)$row1['amountpaind'] : 0.0;
  $_SESSION['balance'] = isset($row1['balance']) ? (float)$row1['balance'] : (float)($_SESSION['fees'] - $_SESSION['amountpaind']);
} else {
  $_SESSION['fees'] = 0.0;
  $_SESSION['amountpaind'] = 0.0;
  $_SESSION['balance'] = 0.0;
}



?>

<main class="mt-5 pt-3">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="d-sm-flex align-items-center justify-content-between ">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <!-- <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i>Weekly Report</button> -->
          </div>
        </div>
         
        </div>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-4 mb-4">
              <div class="card bg-primary text-white h-100">
                <div class="card-body py-1 text-center">Total Fee</div>
                <div class="card-footer d-flex">
                  <?php echo number_format($_SESSION['fees'], 2)?>
                  <span class="ms-auto">
                    Gh&#x20B5;
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-4">
              <div class="card bg-primary text-white h-100">
                <div class="card-body py-1 text-center">Amount Paid</div>
                <div class="card-footer d-flex">
                  <?php echo number_format($_SESSION['amountpaind'], 2)?>
                  <span class="ms-auto">
                    Gh&#x20B5;
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-4">
              <div class="card bg-primary text-white h-100">
                <div class="card-body py-1 text-center">Balance</div>
                <div class="card-footer d-flex">
                  <?php echo number_format($_SESSION['balance'], 2)?>
                  <span class="ms-auto">
                    Gh&#x20B5;
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="container-fluid">
              <div class="card-header bg-primary mb-1">
                <p class="text-white">Payment Records</p>
              </div>
                    <table class="table table-striped table-hover text-center">
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
                          $query = "SELECT * FROM paymentdetails WHERE indexnumber = '$_SESSION[schoolID]'";
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
        </div>
    </main>

<?php
include('includes/footer.php');
?>








