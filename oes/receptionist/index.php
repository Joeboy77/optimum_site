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
        <?php
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
         
        </div>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3 mb-3">
              <div class="card shadow text-white h-100">
                <div class="card-body bg-primary d-flex align-items-center justify-content-between">Profile <i class="bi bi-person-circle fs-1"></i></div>                  
                <a href="profile.php" class="btn card-footer d-flex">View Details
                  <span class="ms-auto">
                    <i class="bi bi-chevron-right"></i>
                  </span>
                </a>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <div class="card shadow text-white h-100">
                <div class="card-body bg-warning d-flex align-items-center justify-content-between">Admissions <i class="bi bi-diagram-3 fs-1"></i></div>
                <a href="addstudent.php" class="btn card-footer d-flex">View Details
                  <span class="ms-auto">
                    <i class="bi bi-chevron-right"></i>
                  </span>
                </a>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <div class="card shadow text-white h-100">
                <div class="card-body bg-success d-flex align-items-center justify-content-between">Daily Transactions <i class="bi bi-gem fs-1"></i></div>
                <a href="dailytransaction.php" class="btn card-footer d-flex">View Details
                  <span class="ms-auto">
                    <i class="bi bi-chevron-right"></i>
                  </span>
                </a>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <div class="card shadow text-white h-100">
                <div class="card-body bg-danger d-flex align-items-center justify-content-between">Visitors <i class="bi bi-person-lines-fill fs-1"></i></div>
                <a href="visitor.php" class="btn card-footer d-flex">View Details
                  <span class="ms-auto">
                    <i class="bi bi-chevron-right"></i>
                  </span>
                </a>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="container-fluid">
              <div class="card-header bg-primary">
                <p class="text-white">Daily Payment Records</p>
              </div>
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
    </main>

<?php
include('includes/footer.php');
?>








