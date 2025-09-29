<style>
  li .nav-link span{
    font-size: 14px;
    color: white;
  }
  #list:hover{
    background-color: cornflowerblue;
  }
</style>
<!-- top navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top static-top shadow">
      
      <div class="container-fluid">
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="offcanvas"
          data-bs-target="#sidebar"
          aria-controls="offcanvasExample"
        >
          <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
        </button>
        <a
          class="navbar-brand me-auto ms-lg-0 ms-3 "
          href="index.php"
          >
          <span>Optimum</span> <span class="text-primary">Portal</span>
          <!-- <span class="text-primary">ruum</span>Link -->
          <!-- <span style="margin: 5px; font-size: 16px;">ruumLink</span> -->
          </a
        >
        
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#topNavBar"
          aria-controls="topNavBar"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
        <i class="bi bi-three-dots-vertical"></i>
          <!-- <span class="navbar-toggler-icon"></span> -->
        </button>
        <div class="collapse navbar-collapse" id="topNavBar">
          <form class="d-flex ms-auto my-1 my-lg-0">
            <!-- <div>
              <a href="profile.php" style="cursor: pointer; text-decoration: none; color: black;"><?php echo $_SESSION['firstname'] ." ".$_SESSION['lastname']?></a>
            </div> -->
            <!-- <div class="input-group">
              <input
                class="form-control"
                type="search"
                placeholder="Search"
                aria-label="Search"
              />
              <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i>
              </button>
            </div> -->
          </form>
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle ms-2 d-block"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="bi bi-person-fill"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="changepassword.php">Change Password</a></li>
                <li><a href="#" class="nav-link px-3 dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- top navigation bar -->
    <!-- offcanvas -->
    <div 
      class="offcanvas offcanvas-start text-white sidebar-nav bg-primary"
      tabindex="-1"
      id="sidebar"
    >
      <div class="offcanvas-body p-0">
        <nav class="navbar-dark">
          <!-- Sidebar - Brand -->
<!-- <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
  
  <img src="../images/favicon.png" alt="logo" style="width: 80px; height: 80px; padding: 5px;">
</a>
<center>
  <span style="color: white; font-weight: bold;"><h6><?php echo $_SESSION['firstname'] ." ".$_SESSION['lastname']?></h6></span>
</center> -->
          <ul class="navbar-nav">
            
            <!-- <li>
              <div class="text-muted small fw-bold text-uppercase px-3">
                CORE
              </div>
            </li> -->
            <li class="my-1"><hr class="dropdown-divider bg-light" /></li>
            <li id="list">
              <a href="index.php" class="nav-link px-3 active">
                <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                <span>Dashboard</span>
              </a>
            </li>
            <li class="my-1"><hr class="dropdown-divider bg-white" /></li>
            <li>
              <div class="text-muted small fw-bold text-uppercase px-3 mb-1">
                <span style="font-size: 9px; color: white;">Operational Section</span>
              </div>
            </li>
            <li>
              <a
                class="nav-link px-3 sidebar-link"
                data-bs-toggle="collapse"
                href="#layouts21"
                id="list"
              >
                <span class="me-2"><i class="bi bi-border-outer"></i></span>
                <span>Admin Stuff</span>
                <span class="ms-auto">
                  <span class="right-icon">
                    <i class="bi bi-chevron-down"></i>
                  </span>
                </span>
              </a>
              <div class="collapse" id="layouts21">
                <ul class="navbar-nav ps-3">
                  <li id="list">
                    <a href="schoolfiles.php" class="nav-link px-3">
                      <span>School Files</span>
                    </a>
                  </li>
                  <li id="list">
                    <a href="programtype.php" class="nav-link px-3">
                      <span>Add Program</span>
                    </a>
                  </li>
                  <li id="list">
                    <a href="courses.php" class="nav-link px-3">
                      <span>Add Courses</span>
                    </a>
                  </li>
                  <li id="list">
                    <a href="customer_enquiry.php" class="nav-link px-3">
                      <span>Customer Enquiry</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li>
              <a
                class="nav-link px-3 sidebar-link"
                data-bs-toggle="collapse"
                href="#layouts2"
                id="list"
              >
                <span class="me-2"><i class="bi bi-border-outer"></i></span>
                <span>Registration</span>
                <span class="ms-auto">
                  <span class="right-icon">
                    <i class="bi bi-chevron-down"></i>
                  </span>
                </span>
              </a>
              <div class="collapse" id="layouts2">
                <ul class="navbar-nav ps-3">
                  <li id="list">
                    <a href="staff.php" class="nav-link px-3">
                      <span>Staff</span>
                    </a>
                  </li>
                  <li id="list">
                    <a href="student.php" class="nav-link px-3">
                      <span>Student</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <!-- <li id="list">
              <a href="regularexpenses.php" class="nav-link px-3">
                <span class="me-2"><i class="bi bi-border-outer"></i></span>
                <span>Daily Expenses</span>
              </a>
            </li>
            <li id="list">
              <a href="irregularexpenses.php" class="nav-link px-3">
                <span class="me-2"><i class="bi bi-border-outer"></i></span>
                <span>End of Week Expenses</span>
              </a>
            </li> -->
            <li>
              <a
                class="nav-link px-3 sidebar-link"
                data-bs-toggle="collapse"
                href="#layouts"
                id="list"
              >
                <span class="me-2"><i class="bi bi-border-outer"></i></span>
                <span>Exams Centre</span>
                <span class="ms-auto">
                  <span class="right-icon">
                    <i class="bi bi-chevron-down"></i>
                  </span>
                </span>
              </a>
              <div class="collapse" id="layouts">
                <ul class="navbar-nav ps-3">
                  <li id="list">
                    <a href="examcategories.php" class="nav-link px-3">
                      <span>Exam Categories</span>
                    </a>
                  </li>
                  <li id="list">
                    <a href="exams.php" class="nav-link px-3">
                      <span>Manage Exams</span>
                    </a>
                  </li>
                  <li id="list">
                    <a href="viewquestions.php" class="nav-link px-3">
                      <span>All Questions</span>
                    </a>
                  </li>
                  <li id="list">
                    <a href="examresults.php" class="nav-link px-3">
                      <span>Exam Results</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <hr>
            <li>
              <a
                class="nav-link px-3 sidebar-link"
                data-bs-toggle="collapse"
                href="#layouts1"
                id="list"
              >
                <span class="me-2"><i class="bi bi-table"></i></span>
                <span>Settings</span>
                <span class="ms-auto">
                  <span class="right-icon">
                    <i class="bi bi-chevron-down"></i>
                  </span>
                </span>
              </a>
              <div class="collapse" id="layouts1">
                <ul class="navbar-nav ps-3">
                  <li id="list">
                    <a href="profile.php" class="nav-link px-3">
                      
                      <span>Profile</span>
                    </a>
                  </li>
                  <li id="list">
                    <a href="changepassword.php" class="nav-link px-3">
                      
                      <span>Change Password</span>
                    </a>
                  </li>
                  <li id="list">
                    <a href="#" class="nav-link px-3" data-bs-toggle="modal" data-bs-target="#logoutModal">
                      <span>Logout</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="my-1"><hr class="dropdown-divider bg-light" /></li>
          </ul>
        </nav>
      </div>
    </div>
    <!-- offcanvas -->

  <!-- Logout Modal -->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="logout.php" method="POST">
          <div class="text-center">Select "<span style="color: red;">Logout</span>" below to end your current session.</div>
        <div class="modal-footer">
          <button type="submit" name="logout_btn" class="btn btn-primary">Logout</button>
          <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
        </div>
        </form>
      </div>
    </div>
  </div>


<!-- Modal -->
<div class="modal fade" id="exampleModalLabelDateRange" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Date Range</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="code.php" method="POST">
      <h6 class="text-center mt-3">Select Date Range To View Weekly Report</h6>
      <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" class="form-control" name="startdate">
          </div>
          <div class="mb-3">
            <label class="form-label">End Date</label>
            <input type="date" class="form-control" name="enddate">
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="daterangesubmit">Submit Information</button>
        </div>
      </form>
    </div>
  </div>
</div>
