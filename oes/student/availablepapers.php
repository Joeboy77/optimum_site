<?php
include('includes/header.php');
include('includes/navbar.php');

?> 

	<!-- <main class="mt-5 pt-3"  onload="multiply();"> -->
    <main class="mt-5 pt-3">
      <div class="container-fluid">

        <div class="row">

          <div class="col-md-12">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i> Available Exams</span> 
              </div>
              
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
                          <td>
                            <input type="button" class="btn btn-primary form-control" value="<?php echo $row["id"];?>" onclick= "set_exams_type_session(this.value);">
                            <!-- <form action="" method="POST">
                              <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                              <button type="submit" name="view" class="btn btn-primary">Start Paper</button>
                            </form> -->
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

<script type="text/javascript">
  function set_exams_type_session(exam_category){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
      if (xmlhttp.readyState == 4 && xmlhttp.status==200) {
        window.location="dashboard.php";
        // window.location="../examination/dashboard.php";
      }
    };
    xmlhttp.open("GET","forajax/set_exams_type_session.php?exam_category="+ exam_category, true);
    // xmlhttp.open("GET","../examination/forajax/set_exams_type_session.php?exam_category="+ exam_category, true);
    xmlhttp.send(null);
  }
</script>

<?php
// if (isset($_POST['view'])) {
//   $id = mysqli_real_escape_string($con, $_POST["id"]);

//   // $_SESSION['id'] = $id;

//   $query = "SELECT * FROM exams_setting WHERE id = '$id' LIMIT 1";
//   $query_run = mysqli_query($con, $query);
//   if(mysqli_num_rows($query_run) === 1) {
//     while ($row = mysqli_fetch_assoc($query_run)){
//       $_SESSION['id'] = $row['id'];
//       $_SESSION['title'] = $row['title'];
//       $_SESSION['course'] = $row['course'];
//       $_SESSION['semester'] = $row['semester'];
//       $_SESSION['no_of_questions'] = $row['no_of_questions'];
//       $_SESSION['timelimit'] = $row['timelimit'];
//       $_SESSION['totalmarks'] = $row['totalmarks'];

//       echo '<script type="text/javascript">window.location="examsinstruction.php"</script>';
//       exit();
//     }
    
//   }
// }
?>
