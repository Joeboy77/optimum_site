<?php
include('includes/header.php');
include('includes/navbar.php');

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
                <span><i class="bi bi-table me-2"></i>Visitor Information</span> 
                <div class="text-xs font-weight-bold">
                  <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i>
                    Add Visitor
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <table id="example" class="table table-striped table-hover text-center">
                      <thead class="table-success">
                        <tr>
                          <th hidden>S. No.</th>
                          <th>S. No.</th>
                          <th>Name</th>
                          <th>Contact</th>
                          <th>Address</th>
                          <th>Purpose</th>
                          <th>View</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          $query = "SELECT * FROM visitor_information WHERE entrydate = '$_SESSION[date]'";
                          $query_run = mysqli_query($con, $query);
                          if(mysqli_num_rows($query_run) > 0){
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query_run)){
                        ?>
                        <tr>
                          <td hidden><?php echo $row["id"];?></td>
                          <td><?php echo $no;?></td>
                          <td><?php echo $row["name"];?></td>
                          <td><?php echo $row["contact"];?></td>
                          <td><?php echo $row["Address"];?></td>
                          <td><?php echo $row["purpose"];?></td>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Visitor Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="visitor.php" method="POST">
      <div class="modal-body">
          <div class="mb-2">
            <label class="form-label">Visitor Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter name">
          </div>
          <div class="mb-2">
            <label class="form-label">Visitor Contact</label>
            <input type="text" name="Contact" class="form-control" placeholder="Enter Contact Number">
          </div>
          <!-- <div class="row">
            <div class="col-12">
              <div class="mb-2">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" name="email">
              </div>
            </div>
          </div> -->

          <div class="mb-2">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="address"></textarea>
          </div>
          <div class="mb-2">
            <label class="form-label">Purpose</label>
            <textarea class="form-control" name="purpose"></textarea>
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
  $name = mysqli_real_escape_string($con, $_POST["name"]);
  $Contact = mysqli_real_escape_string($con, $_POST["Contact"]);
  $address = mysqli_real_escape_string($con, $_POST["address"]);
  $purpose = mysqli_real_escape_string($con, $_POST["purpose"]);

  //Code for validation
    if (empty($name)) {
        $_SESSION['status'] = "Please Enter Visitor Name";
        echo '<script type="text/javascript">window.location="visitor.php"</script>';
        exit();
    }elseif (empty($Contact)) {
        $_SESSION['status'] = "Please Enter Contact";
        echo '<script type="text/javascript">window.location="visitor.php"</script>';
        exit();
    }elseif (empty($address)) {
        $_SESSION['status'] = "Please Enter Address";
        echo '<script type="text/javascript">window.location="visitor.php"</script>';
        exit();
    }else{
      $query = "INSERT INTO visitor_information (name, contact, Address, purpose) VALUES ('$name', '$Contact', '$address', '$purpose')";
        $query_run = mysqli_query($con, $query);
        if ($query_run) {
            $_SESSION['success'] = "Success!! Information Saved Successfully";
            echo '<script type="text/javascript">window.location="visitor.php"</script>';
            exit();
        }else{
            $_SESSION['status'] = "Error!! Information not Saved Successfully";
            echo '<script type="text/javascript">window.location="visitor.php"</script>';
            exit();
        }
    }
}
?>