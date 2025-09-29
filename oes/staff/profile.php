<?php
include('includes/header.php');
include('includes/navbar.php');
?> 

    <main class="mt-5 pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="d-sm-flex align-items-center justify-content-between mb-3">
            <h1 class="h3 mb-0 text-gray-800"><?php echo $_SESSION['firstname'].' '.$_SESSION['lastname']?>'s Profile</h1>
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
          <div class="col-9"><h6><?php echo isset($_SESSION['firstname'], $_SESSION['lastname']) ? ($_SESSION['firstname'].' '.$_SESSION['lastname']) : 'Not specified';?></h6></div>
        </div>
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Email:</h6></div>
          <div class="col-9"><h6><?php echo $_SESSION['email'] ?? 'Not specified';?></h6></div>
        </div>
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Mobile Number:</h6></div>
          <div class="col-9"><h6><?php echo $_SESSION['contact'] ?? 'Not specified';?></h6></div>
        </div>
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Position:</h6></div>
          <div class="col-9"><h6>Tutor</h6></div>
        </div>
      </div>
    </div>

    <!-- <div class="container-fluid">
      <div class="card-header bg-primary">
        <p class="text-white">Course Information</p>
      </div>
      <div class="card-body" style="border: 1px solid cornflowerblue;">
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Full Name:</h6></div>
          <div class="col-9"><h6><?php echo $_SESSION['firstname'].' '.$_SESSION['lastname']?></h6></div>
        </div>
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Email:</h6></div>
          <div class="col-9"><h6><?php echo $_SESSION['email'];?></h6></div>
        </div>
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Mobile Number:</h6></div>
          <div class="col-9"><h6><?php echo $_SESSION['contact'];?></h6></div>
        </div>
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Position:</h6></div>
          <div class="col-9"><h6>Tutor</h6></div>
        </div>
      </div>
    </div> -->

    <!-- <div class="col-md-6 offset-md-3">
        <div class="signup-form">
          <div class="card">
            <form action="code.php" class="border p-4 bg-lightgrey shadow" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <table class="table" id="dataTable">
                          <tr>
                            <td>Firstname:</td> <td><?php echo $_SESSION['fname'];?></td>
                          </tr>
                          <tr>
                            <td>Lastname:</td> <td><?php echo $_SESSION['lname'];?></td>
                          </tr>
                          <tr>
                            <td>Contact No.:</td> <td><?php echo $_SESSION['contactno'];?></td>
                          </tr>
                        </table>
                    </div>
                </form>
          </div>
        </div>
    </div> -->

  </div>
        
      </div>
    </main>

<?php
include('includes/footer.php');
?>