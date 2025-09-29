<?php
include('includes/header.php');
include('includes/navbar.php');
?> 

    <main class="mt-5 pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="d-sm-flex align-items-center justify-content-between mb-3">
            <h1 class="h3 mb-0 text-gray-800">Admin Profile</h1>
            <!-- <a href="searchpage.php"><button class="btn btn-primary btn-sm"><i class="bi bi-border-outer me-2"></i>Search Rooms</button></a> -->
          </div>
        </div>
        <!-- Content Row -->
  <div class="row">

    <div class="container-fluid mb-3">
      <div class="card-header bg-primary">
        <p class="text-white">Personal Information</p>
      </div>
      <div class="card-body" style="border: 1px solid cornflowerblue;">
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Full Name:</h6></div>
          <div class="col-9"><h6><?php echo isset($_SESSION['fname'], $_SESSION['lname']) ? ($_SESSION['fname'].' '.$_SESSION['lname']) : 'Not specified';?></h6></div>
        </div>
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Email:</h6></div>
          <div class="col-9"><h6><?php echo $_SESSION['email'] ?? 'Not specified';?></h6></div>
        </div>
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Mobile Number:</h6></div>
          <div class="col-9"><h6><?php echo $_SESSION['contactno'] ?? 'Not specified';?></h6></div>
        </div>
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Position:</h6></div>
          <div class="col-9"><h6>Admin</h6></div>
        </div>
      </div>
    </div>

  </div>
        
      </div>
    </main>

<?php
include('includes/footer.php');
?>