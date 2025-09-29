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
                <span><i class="bi bi-table me-2"></i>Exams Intro</span> 
                <!-- <div class="text-xs font-weight-bold">
                	<button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus"></i>
        					  Add Debtor Information
        					</button>
                </div> -->
              </div>
              <?php
                $id = $_GET["id"];
                $sql = "SELECT * FROM exams_setting WHERE id = '$_GET[id]'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($result);
              ?>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <form action="exemsintro" method="POST">
                      <p class="text-center"><span class="text-danger">Important Notice:</span> <span class="text-primary">Please write all introductions, rules and regulation regarding the writing of this exams questions</span></p>
                      <div class="mb-3">
                        <label class="form-label">Exams Introduction</label>
                        <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                        <textarea class="form-control" name="exemsintro" id="editor"></textarea>
                      </div>
                      <hr>
                      <div class="row-flex text-center">
                        <a href="setexams.php" class="btn btn-primary col-md-2">Back</a>
                        <button type="submit" name="submit" class="btn btn-success col-md-2">Proceed</button>
                      </div>
                    </form>
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

<?php
if (isset($_POST["cashindebtsubmit"])) {
  // code...
  $name = mysqli_real_escape_string($con, $_POST["name"]);
  $amount = mysqli_real_escape_string($con, $_POST["amount"]);
  $contact = mysqli_real_escape_string($con, $_POST["contact"]);
  $location = mysqli_real_escape_string($con, $_POST["location"]);

  //Code for validation
    if (empty($name)) {
        $_SESSION['status'] = "Please Enter name of person";
        echo '<script type="text/javascript">window.location="cashindebt.php"</script>';
        exit();
    }
    if (empty($amount)) {
        $_SESSION['status'] = "Please Enter Amount";
        echo '<script type="text/javascript">window.location="cashindebt.php"</script>';
        exit();
    }
    if (empty($contact)) {
        $_SESSION['status'] = "Please Enter Contact Number";
        echo '<script type="text/javascript">window.location="cashindebt.php"</script>';
        exit();
    }

    $query = "INSERT INTO cashindebt (name, amount, contact, location, work_unit, track, balance) VALUES ('$name', '$amount', '$contact', '$location', '$_SESSION[work_unit]', '$_SESSION[track]', '$amount')";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['success'] = "Success!! Information Saved Successfully";
        echo '<script type="text/javascript">window.location="cashindebt.php"</script>';
        exit();
    }else{
        $_SESSION['status'] = "Error!! Information not Saved Successfully";
        echo '<script type="text/javascript">window.location="cashindebt.php"</script>';
        exit();
    }
}
?>