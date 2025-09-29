<?php
include('includes/header.php');
include('includes/navbar.php');

?>


<main class="mt-5 pt-3">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="d-sm-flex align-items-center justify-content-between ">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
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

         // Fetch dashboard stats
         $totalPrograms = 0; $totalCourses = 0; $totalStudents = 0; $totalStaff = 0;
         $res1 = mysqli_query($con, "SELECT COUNT(*) AS c FROM programtype");
         if ($res1) { $row = mysqli_fetch_assoc($res1); $totalPrograms = (int)$row['c']; }
         $res2 = mysqli_query($con, "SELECT COUNT(*) AS c FROM courses");
         if ($res2) { $row = mysqli_fetch_assoc($res2); $totalCourses = (int)$row['c']; }
         $res3 = mysqli_query($con, "SELECT COUNT(*) AS c FROM student_registration");
         if ($res3) { $row = mysqli_fetch_assoc($res3); $totalStudents = (int)$row['c']; }
         $res4 = mysqli_query($con, "SELECT COUNT(*) AS c FROM registration WHERE status = 'Staff'");
         if ($res4) { $row = mysqli_fetch_assoc($res4); $totalStaff = (int)$row['c']; }
        ?>

        <!-- KPI Cards -->
        <div class="row g-3 mb-3">
          <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <div class="text-muted">Programs</div>
                    <div class="h4 mb-0"><?php echo number_format($totalPrograms);?></div>
                  </div>
                  <div class="text-primary"><i class="bi bi-grid-3x3-gap" style="font-size: 28px;"></i></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <div class="text-muted">Courses</div>
                    <div class="h4 mb-0"><?php echo number_format($totalCourses);?></div>
                  </div>
                  <div class="text-primary"><i class="bi bi-journal-code" style="font-size: 28px;"></i></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <div class="text-muted">Students</div>
                    <div class="h4 mb-0"><?php echo number_format($totalStudents);?></div>
                  </div>
                  <div class="text-primary"><i class="bi bi-people" style="font-size: 28px;"></i></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <div class="text-muted">Staff</div>
                    <div class="h4 mb-0"><?php echo number_format($totalStaff);?></div>
                  </div>
                  <div class="text-primary"><i class="bi bi-person-badge" style="font-size: 28px;"></i></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-3">
          <div class="col-12">
            <div class="card border-0 shadow-sm">
              <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                  <a href="programtype.php" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i>Add Program</a>
                  <a href="courses.php" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i>Add Course</a>
                  <a href="staff.php" class="btn btn-outline-primary btn-sm"><i class="bi bi-person-plus me-1"></i>Register Staff</a>
                  <a href="student.php" class="btn btn-outline-primary btn-sm"><i class="bi bi-person-plus me-1"></i>Register Student</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Data -->
        <div class="row g-3">
          <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm">
              <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Recent Programs</span>
                <a href="programtype.php" class="btn btn-sm btn-outline-primary">View all</a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-success">
                      <tr>
                        <th style="width: 70px;">#</th>
                        <th>Name</th>
                        <th style="width: 140px;">Cost (Gh&cent;)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $rp = mysqli_query($con, "SELECT * FROM programtype ORDER BY id DESC LIMIT 5");
                        $n=1;
                        if ($rp && mysqli_num_rows($rp) > 0) {
                          while($p = mysqli_fetch_assoc($rp)){
                            echo '<tr>';
                            echo '<td>'.$n++.'</td>';
                            echo '<td class="text-start">'.htmlspecialchars($p['program']).'</td>';
                            echo '<td>Gh&cent; '.number_format((float)$p['cost'], 2).'</td>';
                            echo '</tr>';
                          }
                        } else {
                          echo '<tr><td colspan="3" class="text-center py-3">No programs yet</td></tr>';
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm">
              <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Recent Courses</span>
                <a href="courses.php" class="btn btn-sm btn-outline-primary">View all</a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-success">
                      <tr>
                        <th style="width: 70px;">#</th>
                        <th>Course</th>
                        <th style="width: 160px;">Program</th>
                        <th style="width: 110px;">Code</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $rc = mysqli_query($con, "SELECT * FROM courses ORDER BY id DESC LIMIT 5");
                        $n=1;
                        if ($rc && mysqli_num_rows($rc) > 0) {
                          while($c = mysqli_fetch_assoc($rc)){
                            echo '<tr>';
                            echo '<td>'.$n++.'</td>';
                            echo '<td class="text-start">'.htmlspecialchars($c['course_name']).'</td>';
                            echo '<td>'.htmlspecialchars($c['programType']).'</td>';
                            echo '<td><span class="text-dark">'.htmlspecialchars($c['course_code']).'</span></td>';
                            echo '</tr>';
                          }
                        } else {
                          echo '<tr><td colspan="4" class="text-center py-3">No courses yet</td></tr>';
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








