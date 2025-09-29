<?php
include('includes/header.php');
include('includes/navbar.php');

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
            <div class="col-md-3 mb-3">
              <div class="card bg-primary text-white h-100">
                <div class="text-center"><i class="bi bi-person-bounding-box" style="font-size: 60px;"></i></div>
                <div class="card-body py-1 text-center">Profile</div>
                <a href="profile.php" class="btn card-footer d-flex text-white">View Details
                  <span class="ms-auto">
                    <i class="bi bi-chevron-right"></i>
                  </span>
                </a>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <div class="card bg-warning text-white h-100">
                <div class="text-center"><i class="bi bi-book" style="font-size: 60px;"></i></div>
                <div class="card-body py-1 text-center">Courses</div>
                <a href="courseupload.php" class="btn card-footer d-flex text-white">View Details
                  <span class="ms-auto">
                    <i class="bi bi-chevron-right"></i>
                  </span>
                </a>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <div class="card bg-success text-white h-100">
                <div class="text-center"><i class="bi bi-cash-stack" style="font-size: 60px;"></i></div>
                <div class="card-body py-1 text-center">Fees</div>
                <a href="fee.php" class="btn card-footer d-flex text-white">View Details
                  <span class="ms-auto">
                    <i class="bi bi-chevron-right"></i>
                  </span>
                </a>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <div class="card bg-danger text-white h-100">
                <div class="text-center"><i class="bi bi-envelope" style="font-size: 60px;"></i></div>
                <div class="card-body py-1 text-center">Messages</div>
                <a href="message.php" class="btn card-footer d-flex text-white">View Details
                  <span class="ms-auto">
                    <i class="bi bi-chevron-right"></i>
                  </span>
                </a>
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








