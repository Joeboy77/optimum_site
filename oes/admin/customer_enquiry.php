<?php
include('includes/header.php');
include('includes/navbar.php');



?> 

	<!-- <main class="mt-5 pt-3"  onload="multiply();"> -->
    <main class="mt-5 pt-3">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i>Customer Enquiry</span> 
                <!-- <div class="text-xs font-weight-bold">
                  <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i>
                    Add New Staff
                  </button>
                </div> -->
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
                          <th>Email</th>
                          <th>Enquiry</th>
                          <th>View</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          $query = "SELECT * FROM customer_enquiry WHERE  update_approve = ''";
                          $query_run = mysqli_query($con, $query);
                          if(mysqli_num_rows($query_run) > 0){
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query_run)){
                        ?>
                        <tr>
                          <td hidden><?php echo $row["id"];?></td>
                          <td><?php echo $no;?></td>
                          <td><?php echo $row["name"];?></td>
                          <td><?php echo $row["email"];?></td>
                          <td><?php echo $row["enquiry"];?></td>
                          <td>
                            <a href="staffdetails.php?id=<?php echo $row["id"];?>" class="btn btn-primary"><i class="bi bi-eye"></i></a>
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


