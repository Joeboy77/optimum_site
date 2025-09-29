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
              <div class="card bg-primary text-white h-100">
                <div class="card-body py-4">Profile</div>                  
                <a href="profile.php" class="btn card-footer d-flex text-white">View Details
                  <span class="ms-auto">
                    <i class="bi bi-chevron-right"></i>
                  </span>
                </a>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <div class="card bg-warning text-white h-100">
                <div class="card-body py-4">Courses / Departments</div>
                <a href="createclass.php" class="btn card-footer d-flex text-white">View Details
                  <span class="ms-auto">
                    <i class="bi bi-chevron-right"></i>
                  </span>
                </a>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <div class="card bg-success text-white h-100">
                <div class="card-body py-4">Exams</div>
                <a href="#" class="btn card-footer d-flex text-white">View Details
                  <span class="ms-auto">
                    <i class="bi bi-chevron-right"></i>
                  </span>
                </a>
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <div class="card bg-danger text-white h-100">
                <div class="card-body py-4">Messages</div>
                <a href="complain.php" class="btn card-footer d-flex text-white">View Details
                  <span class="ms-auto">
                    <i class="bi bi-chevron-right"></i>
                  </span>
                </a>
              </div>
            </div>
          </div>
          <div class="row">
          <div class="col-md-6 mb-3">
            <div class="card h-100">
              <div class="card-header">
                <span class="me-2"><i class="bi bi-bar-chart-fill"></i></span>
                Area Chart Example
              </div>
              <div class="card-body">
                <canvas class="chart" width="400" height="200"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="card h-100">
              <div class="card-header">
                <span class="me-2"><i class="bi bi-bar-chart-fill"></i></span>
                Area Chart Example
              </div>
              <div class="card-body">
                <canvas class="chart" width="400" height="200"></canvas>
              </div>
            </div>
          </div>
        </div>
        </div>
    </main>

<?php
include('includes/footer.php');
?>








