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

        <div class="row">
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i>Set New Exams</span> 
                <!-- <div class="text-xs font-weight-bold">
                	<button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i>
        					  Add Load Information
        					</button>
                </div> -->
              </div>
              <div class="card-body">
                <div class="row align-items-center justify-content-center">
                  <div class="col-md-12">
                    <table class="table table-striped table-hover text-center">
                      <thead class="table-success">
                        <tr>
                          <th hidden>S. No.</th>
                          <th>S. No.</th>
                          <th>Title</th>
                          <th>Course</th>
                          <th>Semester</th>
                          <th>Time</th>
                          <th>Total Marks</th>
                          <th>Start</th>
                        </tr>
                      </thead>
                      <tbody id="data">
                        <?php
                          $query = "SELECT * FROM exams_setting WHERE start_indicator = ''";
                          $query_run = mysqli_query($con, $query);
                          if(mysqli_num_rows($query_run) > 0){
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query_run)){
                        ?>
                        <tr>
                          <td hidden><?php echo $row["id"];?></td>
                          <td><?php echo $no;?></td>
                          <td><?php echo $row["title"];?></td>
                          <td><?php echo $row["course"];?></td>
                          <td><?php echo $row["semester"];?></td>
                          <td><?php echo $row["timelimit"];?></td>
                          <td><?php echo $row["totalmarks"];?></td>
                          <td>
                            <form action="" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                                <button type="submit" name="start" class="btn btn-primary">Stat Question</button>
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
<!-- <div id="editor">
    <p>Hello from CKEditor 5!</p>
</div> -->

        
      </div>
    </main>

<?php
include('includes/footer.php');
?>


<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.0/"
        }
    }
</script>

<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Bold,
        Italic,
        Font,
        Paragraph
    } from 'ckeditor5';

    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
            toolbar: {
                items: [
                    'undo', 'redo', '|', 'bold', 'italic', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                ]
            }
        } )
        .then( /* ... */ )
        .catch( /* ... */ );
</script>

<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Bold,
        Italic,
        Font,
        Paragraph
    } from 'ckeditor5';

    ClassicEditor
        .create( document.querySelector( '#editor1' ), {
            plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
            toolbar: {
                items: [
                    'undo', 'redo', '|', 'bold', 'italic', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                ]
            }
        } )
        .then( /* ... */ )
        .catch( /* ... */ );
</script>

<?php
if (isset($_POST['start'])) {
    // code...
    $id = mysqli_real_escape_string($con, $_POST["id"]);

    $query = "UPDATE exams_setting SET start_indicator='Start' WHERE id = '$id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        
        $query = "SELECT * FROM exams_setting WHERE id = '$id' LIMIT 1";
        $query_run = mysqli_query($con, $query);
        if(mysqli_num_rows($query_run) === 1){
            $row = mysqli_fetch_assoc($query_run);
            $_SESSION['id'] = $row['id'];
            $_SESSION['no_of_questions'] = $row['no_of_questions'];
            $_SESSION['course'] = $row['course'];
            $_SESSION['semester'] = $row['semester'];

            echo '<script type="text/javascript">window.location="startexams.php"</script>';
            exit();
        }

        

        // $_SESSION['success'] = "Success!! Information Updated Successfully";
        // echo '<script type="text/javascript">window.location="index.php"</script>';
        // exit();
        // $query = "SELECT * FROM exams_setting WHERE id = '$id'";
        // $query_run = mysqli_query($con, $query);
        // if(mysqli_num_rows($query_run) === 1){

        // }
    }else{
        $_SESSION['status'] = "Error!! Something Went Wrong";
        echo '<script type="text/javascript">window.location="setexams.php"</script>';
        exit();
    }
}
?>
