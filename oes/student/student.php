<?php
include('includes/header.php');
include('includes/navbar.php');

$query = mysqli_query($con, "select * from registration order by id desc limit 1");
$line = mysqli_fetch_array($query);
$num = $line['id'];
$num++;

$indexnumber = date("y").'COTVI'.str_pad($num++, 4, '0', STR_PAD_LEFT);
$_SESSION['indexnumber'] = $indexnumber;
?> 

  <main class="mt-5 pt-3">
      <div class="container-fluid">
        <?php
       if (isset($_SESSION["status"]) && $_SESSION["status"] != '') {
         
         ?>
         <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Hey!</strong> <?php echo $_SESSION["status"];?>.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
          
         <?php
         unset($_SESSION["status"]);
         }

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
        <!-- <div class="row mb-2">
          <div class="d-sm-flex align-items-center justify-content-between ">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="searchpage.php"><button class="btn btn-primary btn-sm"><i class="bi bi-border-outer me-2"></i>Search Rooms</button></a>
          </div>
        </div> -->

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i>Student Information</span> 
                <div class="text-xs font-weight-bold">
                  <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i>
                    Add New Student
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <table class="table table-striped table-hover text-center">
                      <thead class="table-success">
                        <thead class="table-success">
                        <tr>
                          <th hidden>S. No.</th>
                          <th>S. No.</th>
                          <th>Index No.</th>
                          <th>Firstname</th>
                          <th>Lastname</th>
                          <th>Nationality</th>
                          <th>View</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          $query = "SELECT * FROM registration WHERE status = 'Student'";
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
                          <td><?php echo $row["nationality"];?></td>
                          <td>
                            <a href="cashpayment.php?id=<?php echo $row["id"];?>" class="btn btn-primary"><i class="bi bi-eye"></i></a>
                          </td>
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
          </div>
        </div>

        
      </div>
    </main>

<?php
include('includes/footer.php');
?>

<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Student Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="student.php" method="POST">
      <div class="modal-body">
          <div class="row">
            <h5 class="text-center text-primary">Student ID: <?php echo $indexnumber;?></h5>
          </div>
          <hr>
          <div class="row">
               <div class="mb-2 col-md-6">
                   <label>First Name</label>
                   <input type="text" name="fname" class="form-control" placeholder="First name" aria-label="First name">
              </div>

              <div class="mb-2 col-md-6">
                  <label>Last Name</label>
                  <input type="text" name="lname" class="form-control" placeholder="Last name" aria-label="Last name">
              </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="mb-2">
                <label class="form-label">Date of Birth</label>
                <input type="date" class="form-control" name="dob">
              </div>
            </div>
            <div class="col-6">
              <div class="mb-2">
                <label class="form-label">Nationality</label>
                <input type="text" class="form-control" name="nationality">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" name="email">
              </div>
            </div>
          </div>

          <div class="mb-2">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="address"></textarea>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="studentsubmit">Submit Information</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
if (isset($_POST["studentsubmit"])) {
  // code...
  $fname = mysqli_real_escape_string($con, $_POST["fname"]);
  $lname = mysqli_real_escape_string($con, $_POST["lname"]);
  $dob = mysqli_real_escape_string($con, $_POST["dob"]);
  $nationality = mysqli_real_escape_string($con, $_POST["nationality"]);
  $email = mysqli_real_escape_string($con, $_POST["email"]);
  $address = mysqli_real_escape_string($con, $_POST["address"]);

  //Code for validation
    if (empty($fname)) {
        $_SESSION['status'] = "Please Enter firstname";
        echo '<script type="text/javascript">window.location="student.php"</script>';
        exit();
    }elseif (empty($lname)) {
        $_SESSION['status'] = "Please Enter lastname";
        echo '<script type="text/javascript">window.location="student.php"</script>';
        exit();
    }elseif (empty($email)) {
        $_SESSION['status'] = "Please Enter Email";
        echo '<script type="text/javascript">window.location="student.php"</script>';
        exit();
    }else{
      $query = "SELECT * FROM registration WHERE indexnumber = '$_SESSION[indexnumber]' LIMIT 1";
      $query_run = mysqli_query($con, $query);
      if(mysqli_num_rows($query_run) === 1){
        $_SESSION['status'] = "Unsuccessful!! Index Number exist already. Please try again";
        echo '<script type="text/javascript">window.location="student.php"</script>';
        exit();
      }else{
        $query = "INSERT INTO registration (indexnumber, firstname, lastname, dob, nationality, email, address, status) VALUES ('$_SESSION[indexnumber]', '$fname', '$lname', '$dob', '$nationality', '$email', '$address', 'Student')";
        $query_run = mysqli_query($con, $query);
        if ($query_run) {
            $_SESSION['success'] = "Success!! Information Saved Successfully";
            echo '<script type="text/javascript">window.location="student.php"</script>';
            exit();
        }else{
            $_SESSION['status'] = "Error!! Information not Saved Successfully";
            echo '<script type="text/javascript">window.location="student.php"</script>';
            exit();
        }
      }
    }
}
?>