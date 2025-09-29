<?php
include('includes/header.php');
include('includes/navbar.php');

?> 

<!-- View Info -->
<div class="modal fade" id="viewusermodal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="viewusermodalLabel">Property Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="view_user_data">
          
        </div>
      </div>
      
    </div>
  </div>
</div>

  <main class="mt-5 pt-3">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i> Edit Staff Information</span> 
                <!-- <div class="text-xs font-weight-bold">No. of Rooms: ... </div> -->
              </div>

              <?php
                $id = $_GET["id"];
                $sql = "SELECT * FROM staff_registration WHERE id = '$_GET[id]'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($result);
              ?>
              <form action="" method="POST">
              <div class="card-body">
                <!-- <h3 class="text-danger text-center" id="para">Not Found</h3> -->
                <div class="row">
                  <div>
                    <div class="card shadow h-100 py-2">
                      <div class="card-header d-sm-flex align-items-center justify-content-between">
                        <h5 class="text-xs font-weight-bold text-primary text-uppercase">Staff Details</h5>
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-pencil-square"></i> Edit</button>
                      </div>
                      <div class="card-body d-flex">
                        <div class="col-6">
                          <div class="row mb-2">
                            <div class="col-4">Staff ID</div>
                            <div class="col-8">
                              <input type="hidden" class="form-control" name="id" value="<?php echo $row['id']?>">
                              <input type="text" class="form-control" name="indexnumber" value="<?php echo $row['indexnumber']?>" readonly>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Firstname</div>
                            <div class="col-8">
                              <input type="text" class="form-control" name="firstname" value="<?php echo $row['firstname'];?>" readonly>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Lastname</div>
                            <div class="col-8"><input type="text" class="form-control" name="lastname" value="<?php echo $row['lastname'];?>" readonly></div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Date of Birt</div>
                            <div class="col-8"><input type="date" class="form-control" name="dob" value="<?php echo $row['dob'];?>" readonly></div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Nationality</div>
                            <div class="col-8"><input type="text" class="form-control" name="nationality" value="<?php echo $row['nationality'];?>" readonly></div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Qualification</div>
                            <div class="col-8">
                              <input type="text" class="form-control" name="qualification" value="<?php echo $row['qualification'];?>" readonly>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Email</div>
                            <div class="col-8">
                              <input type="text" class="form-control" name="email" value="<?php echo $row['email'];?>" readonly>
                            </div>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="row mb-2">
                            <div class="col-4">Marital Status</div>
                            <div class="col-8">
                              <input type="text" class="form-control" name="maritalstatus" value="<?php echo $row['maritalstatus'];?>" readonly>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Contact</div>
                            <div class="col-8">
                              <input type="text" class="form-control" name="contact" value="<?php echo $row['contact'];?>" readonly>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Address</div>
                            <div class="col-8">
                              <textarea class="form-control" name="address" readonly><?php echo $row['address'];?></textarea>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Appointment Date</div>
                            <div class="col-8">
                              <input type="text" class="form-control" name="appointmentdate" value="<?php echo $row['appointmentdate'];?>" readonly>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Position</div>
                            <div class="col-8">
                              <input type="text" class="form-control" name="position" value="<?php echo $row['position'];?>" readonly>
                            </div>
                          </div>
                        </div>
                        <div>
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-body">
                        <div class="col-12">
                          <a href="staff.php" class="btn btn-danger" type="submit"><i class="bi bi-arrow-left-circle"></i> Back</a>
                          <!-- <button class="btn btn-success" type="submit" name="update">Update</button> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </form>
          </div>
        </div>

        
      </div>
    </main>

<?php
include('includes/footer.php');
?>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Trip Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="edittripentry.php" method="POST">
      <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Type of Trip</label>
            <input type="hidden" class="form-control" name="id" value="<?php echo $row['id'];?>" readonly>
            <input type="text" class="form-control" name="priceoftrip" value="<?php echo $row['triptype'];?>" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Price of Trip</label>
            <input type="text" class="form-control" name="priceoftrip" value="<?php echo $row['priceoftrip'];?>">
          </div>
          <div class="row">
            <div class="col-6">
              <div class="mb-3">
                <label class="form-label">Loading Fee</label>
                <input type="text" class="form-control" name="loadingfee" value="<?php echo $row['loadingfee'] ?>">
              </div>
            </div>
            <div class="col-6">
              <div class="mb-3">
                <label class="form-label">Agent Fee</label>
                <input type="text" class="form-control" name="agent" value="<?php echo $row['agent'] ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="mb-3">
                <label class="form-label">Load Location</label>
                <textarea name="location" placeholder="Enter Location" class="form-control"><?php echo $row['location'];?></textarea>
              </div>
            </div>
            <div class="col-6">
              <div class="mb-3">
                <label class="form-label">Destination</label>
                <textarea name="destination" placeholder="Enter Destination" class="form-control"><?php echo $row['destination'];?></textarea>
              </div>
            </div>
          </div>
          <hr>
          <h6 class="text-center text-primary">Customer Information</h6>
          <div class="row">
            <div class="col-6">
              <div class="mb-3">
                <label class="form-label">Customer Name</label>
                <input type="text" class="form-control" name="customername" value="<?php echo $row['customername'];?>">
              </div>
            </div>
            <div class="col-6">
              <div class="mb-3">
                <label class="form-label">Customer Number</label>
                <input type="text" class="form-control" name="customernumber" value="<?php echo $row['customernumber'];?>">
              </div>
            </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="update">Submit Information</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  // View info data
  // $(document).ready(function(){
  //   $('.userinfo').click(function(){
  //     var userid = $(this).data('id');
  //     // alert(userid)
  //     $.ajax({
  //       url: "ajaxfileindex.php",
  //       type: "POST",
  //       data: {userid: userid},
  //       success: function (response) {
  //         // console.log(response);

  //         $('.view_user_data').html(response);
  //         $('#viewusermodal').modal('show');
  //       }
  //     });
  //   });
  // });
</script>

<?php
if (isset($_POST["update"])) {
  // code...
  $id = mysqli_real_escape_string($con, $_POST["id"]);
  $triptype = mysqli_real_escape_string($con, $_POST["triptype"]);
  $priceoftrip = mysqli_real_escape_string($con, $_POST["priceoftrip"]);
  $loadingfee = mysqli_real_escape_string($con, $_POST["loadingfee"]);
  $agent = mysqli_real_escape_string($con, $_POST["agent"]);
  $location = mysqli_real_escape_string($con, $_POST["location"]);
  $destination = mysqli_real_escape_string($con, $_POST["destination"]);
  $customername = mysqli_real_escape_string($con, $_POST["customername"]);
  $customernumber = mysqli_real_escape_string($con, $_POST["customernumber"]);

  // if (empty($reason)) {
  //     $_SESSION['status'] = "Please Enter Reason for Update";
  //     echo '<script type="text/javascript">window.location="edittripentry.php"</script>';
  //     exit();
  // }

  $query = "UPDATE tripinformation SET priceoftrip='$priceoftrip', loadingfee='$loadingfee', agent='$agent', location='$location', destination='$destination', customername='$customername', customernumber='$customernumber', update_prove='Yes' WHERE id = '$id'";
  $query_run = mysqli_query($con, $query);
  if ($query_run) {
      $_SESSION['status'] = "Success!! Information Updated Successfully";
      $_SESSION['status_code'] = "success";
      echo '<script type="text/javascript">window.location="tripentry.php"</script>';
      exit();
  }else{
      $_SESSION['status'] = "Error!! Information not Updated Successfully";
      $_SESSION['status_code'] = "error";
      echo '<script type="text/javascript">window.location="edittripentry.php"</script>';
      exit();
  }
}
?>

