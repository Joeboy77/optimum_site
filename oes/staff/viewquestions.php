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
                <span><i class="bi bi-table me-2"></i> View Questionaire</span> 
              </div>
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
                 <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col-md-12">
                    <table id="example" class="table table-striped table-hover text-center">
                      <thead class="table-success">
                        <tr>
                          <th>No.</th>
                          <th hidden>ID.</th>
                          <th>Subject</th>
                          <th>Title</th>
                          <th>Semester</th>
                          <th>Status</th>
                          <th>Date Started</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          $query = "SELECT * FROM exams_setting";
                          $query_run = mysqli_query($con, $query);
                          if(mysqli_num_rows($query_run) > 0){
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query_run)){
                        ?>
                        <tr>
                          <td><?php echo $no;?></td>
                          <td hidden><?php echo $row["id"];?></td>
                          <td><?php echo $row["course"];?></td>
                          <td><?php echo $row["title"];?></td>
                          <td><?php echo $row["semester"];?></td>
                          <td><?php echo $row["status"];?></td>
                          <td><?php echo $row["entrydate"];?></td>
                          <td>
                            <form action="" method="POST">
                              <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                              <button type="submit" name="view" class="btn btn-primary">View</button>
                              <!-- <button type="submit" name="edit" class="btn btn-success">Edit</button> -->
                              <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                            </form>
                            <!-- <a href="creatquestions.php?id=<?php echo $row["id"];?>" class="btn btn-primary"><i class="bi bi-eye"></i> </a> -->
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

      </div>
    </main>

<?php
include('includes/footer.php');
?>

<?php
if (isset($_POST['view'])) {
  $id = mysqli_real_escape_string($con, $_POST["id"]);

  $_SESSION['id'] = $id;

  echo '<script type="text/javascript">window.location="view.php"</script>';
  exit();
}
?>


