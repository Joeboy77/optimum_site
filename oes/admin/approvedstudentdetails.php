<?php
include('includes/header.php');
include('includes/navbar.php');

?> 

  <main class="mt-5 pt-3">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i> Student Information</span> 
                <!-- <div class="text-xs font-weight-bold">No. of Rooms: ... </div> -->
                <!-- <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i> Edit</button> -->
              </div>
              <div>
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
                 ?>
              </div>

              <?php
                $id = $_GET["id"];
                $sql = "SELECT * FROM student_registration WHERE id = '$_GET[id]'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($result);
              ?>
              <form action="" method="POST">
              <div class="card-body">
                <!-- <h3 class="text-danger text-center" id="para">Not Found</h3> -->
                <div class="row">
                  <div>
                    <div class="card shadow h-100 py-2">
                      <div class="card-header">
                        <h5 class="text-xs font-weight-bold text-primary text-uppercase">Student ID: <?php echo $row["indexnumber"];?></h5>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-6">
                            <p class="text-danger text-center">Personal Details</p>
                            <div class="row mb-2">
                              <div class="col-4">Firstname</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['firstname']?>" readonly>
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-4">Lastname</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['lastname']?>" readonly>
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-4">Birth Place</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['placeOfBirth']?>" readonly>
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-4">Hometown</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['Hometown']?>" readonly>
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-4">Region</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['region']?>" readonly>
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-4">Nationality</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['nationality']?>" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-6">
                            <p class="text-danger text-center">Program Details</p>
                            <div class="row mb-2">
                              <div class="col-4">Program Type</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['programType']?>" readonly>
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-4">Course Selected</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['courseSelected']?>" readonly>
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-4">Course Duration</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['courseDuration']?>" readonly>
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-4">Course Session</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['courseSession']?>" readonly>
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-4">Residency</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['residency']?>" readonly>
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-4">Date of Admission</div>
                              <div class="col-8">
                                <input type="text" class="form-control" value="<?php echo $row['dateOfAdmission']?>" readonly>
                              </div>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <p class="text-center text-danger">Fee Details</p>





                        <div>
                          <div class="row mb-2">
                            <div class="col-4">School Fee</div>
                            <div class="col-8">
                              <input type="text" class="form-control" value="<?php echo $row['fees']?>" readonly>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Amount Paid</div>
                            <div class="col-8">
                              <input type="number" class="form-control" value="<?php echo $row['amountpaind'];?>" readonly>
                            </div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-4">Balance</div>
                            <div class="col-8"><input type="text" class="form-control" value="<?php echo $row['balance'];?>" readonly></div>
                          </div>

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
                          <a href="approvedstudent.php" class="btn btn-danger" type="submit">Back</a>
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



