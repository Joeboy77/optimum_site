<?php
include('includes/header.php');
include('includes/navbar.php');

// Fetch student data with proper error handling
$student_data = [];
$query = "SELECT * FROM student_registration WHERE indexnumber = '{$_SESSION['schoolID']}' LIMIT 1";
$query_result = mysqli_query($con, $query);
if ($query_result && mysqli_num_rows($query_result) > 0) {
  $student_data = mysqli_fetch_assoc($query_result);
}

// Set session variables with fallbacks
$_SESSION['programType'] = $student_data['programType'] ?? 'Not specified';
$_SESSION['courseSelected'] = $student_data['courseSelected'] ?? 'Not specified';
$_SESSION['courseDuration'] = $student_data['courseDuration'] ?? 'Not specified';
$_SESSION['courseSession'] = $student_data['courseSession'] ?? 'Not specified';
$_SESSION['residency'] = $student_data['residency'] ?? 'Not specified';
$_SESSION['entrydate'] = $student_data['entrydate'] ?? 'Not specified';

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
          <div class="col-9"><h6><?php echo $_SESSION['firstname'].' '.$_SESSION['lastname']?></h6></div>
        </div>
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>School ID:</h6></div>
          <div class="col-9"><h6><?php echo $_SESSION['schoolID'];?></h6></div>
        </div>
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Email:</h6></div>
          <div class="col-9"><h6><?php echo $_SESSION['email'];?></h6></div>
        </div>
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Mobile Number:</h6></div>
          <div class="col-9"><h6><?php echo $_SESSION['contact'] ?? 'Not specified';?></h6></div>
        </div>
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Position:</h6></div>
          <div class="col-9"><h6>Student</h6></div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="card-header bg-primary">
        <p class="text-white">Course Information</p>
      </div>
      <div class="card-body" style="border: 1px solid cornflowerblue;">
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Program:</h6></div>
          <div class="col-9"><h6><?php echo $_SESSION['programType'];?></h6></div>
        </div>
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Course:</h6></div>
          <div class="col-9"><h6><?php echo $_SESSION['courseSelected'];?></h6></div>
        </div>
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Course Duration</h6></div>
          <div class="col-9"><h6><?php echo $_SESSION['courseDuration'];?></h6></div>
        </div>
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Course Session</h6></div>
          <div class="col-9"><h6><?php echo $_SESSION['courseSession'];?></h6></div>
        </div>
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Residency</h6></div>
          <div class="col-9"><h6><?php echo $_SESSION['residency'];?></h6></div>
        </div>
        <div class="row d-flex mb-3">
          <div class="col-3"><h6>Date of Admission</h6></div>
          <div class="col-9"><h6><?php echo $_SESSION['entrydate'];?></h6></div>
        </div>
      </div>
    </div>


  </div>
        
      </div>
    </main>

<?php
include('includes/footer.php');
?>