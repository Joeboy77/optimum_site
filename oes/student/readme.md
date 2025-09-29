# Bootstrap 5 Admin Dashbaord Template

# 👉 Subscribe to My Channel [💙❤️Youtube❤️💙](https://www.youtube.com/channel/UCpOHt5d6GG-mvo-_pU06rhQ?sub_confirmation=1)

---

## List of Components used in this Tutorial

| Component Name  |                                          Docs                                          |
| --------------- | :------------------------------------------------------------------------------------: |
| Navbar          | [Navbar Docs](https://getbootstrap.com/docs/5.0/components/navbar/#supported-content)  |
| Collapse        |    [Collapse Docs](https://getbootstrap.com/docs/5.0/components/collapse/#example)     |
| Offcanvas       |   [Offcanvas Docs](https://getbootstrap.com/docs/5.0/components/offcanvas/#examples)   |
| Card            |      [Card Docs](https://getbootstrap.com/docs/5.0/components/card/#card-styles)       |
| Input Group     | [Input Group Docs](https://getbootstrap.com/docs/5.0/forms/input-group/#button-addons) |
| Bootstrap Icons |             [Bootstrap Icons Docs](https://icons.getbootstrap.com/#icons)              |
| Chart.js        |          [Chart.js Docs](https://www.chartjs.org/docs/latest/charts/bar.html)          |
| DataTables      |                       [DataTables Docs](https://datatables.net/)                       |

---

# [🚀 Live Here](https://frontendfunn.github.io/bootstrap-5-admin-dashboard-template/)

---

![preview](images/preview.PNG)

### Made with ❤️ - by [FrontEndFunn](https://www.youtube.com/channel/UCpOHt5d6GG-mvo-_pU06rhQ?sub_confirmation=1)




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
          <h6 class="text-center text-danger">Please note: this field should only be entered at the end of the week</h6>
          <div class="col-md-12 mb-3">
              <div class="card-header d-sm-flex align-items-center justify-content-between">
                <span><i class="bi bi-table me-2"></i>Weekly Irregular Expenses</span> 
                <!-- <div class="text-xs font-weight-bold">No. of Rooms: ... </div> -->
              </div>
              <form action="irregularexpenses.php" method="POST" enctype="multipart/form-data">
              <div class="card-body">
                <!-- <h3 class="text-danger text-center" id="para">Not Found</h3> -->
                <div class="row">
                	<div class="col-xl-12 col-md-6 mb-2">
      				      <div class="card shadow h-100 ">
      				        <div class="card-body">
                        <div class="row">
                          <div class="col-md-4 mb-2">
                              Item Name
                            </div>
                            <div class="col-md-3 mb-2">
                              Amount
                            </div>
                            <div class="col-md-3 mb-2">
                              Supporting Document
                            </div>
                            <div class="col-md-2 mb-2 d-grid">
                              Action
                            </div>
                        </div>
                        <div id="show_item">
                          <div class="row">
                            <div class="col-md-4 mb-2">
                              <input type="text" name="itemname[]" class="form-control" placeholder="Item Name" required>
                            </div>
                            <div class="col-md-3 mb-2">
                              <input type="number" name="itemprice[]" class="form-control" placeholder="Item Amount" required>
                            </div>
                            <div class="col-md-3 mb-2">
                              <input type="file" name="itempic[]" class="form-control">
                            </div>
                            <div class="col-md-2 mb-2 d-grid">
                              <button class="btn btn-primary add_item_btn"><i class="bi bi-plus"></i></button>
                            </div>
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
                          <button class="btn btn-primary" type="submit" name="irregularexpensessubmit">Submit form</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

<script>
  $(document).ready(function() {
    // alert(Hello)
    $(".add_item_btn").click(function(e){
      e.preventDefault();
      $("#show_item").prepend(`<div class="row">
                            <div class="col-md-4 mb-2">
                              <input type="text" name="itemname[]" class="form-control" placeholder="Item Name">
                            </div>
                            <div class="col-md-3 mb-2">
                              <input type="number" name="itemprice[]" class="form-control" placeholder="Item Amount">
                            </div>
                            <div class="col-md-3 mb-2">
                              <input type="file" name="itempic[]" class="form-control">
                            </div>
                            <div class="col-md-2 mb-2 d-grid">
                              <button class="btn btn-danger remove_item_btn"><i class="bi bi-dash"></i></button>
                            </div>
                          </div>`);
    });

    // Code to remove test filled
    $(document).on('click', '.remove_item_btn', function(e) {
      e.preventDefault();
      let row_item = $(this).parent().parent();
      $(row_item).remove();
    });
  });
</script>
        
      </div>
    </main>

<?php
include('includes/footer.php');
?>

<?php
if (isset($_POST["irregularexpensessubmit"])) {
  // echo '<script type="text/javascript">alert("Good to Go")</script>';

  // Code for selecting the multiple data
  $itemname = $_POST["itemname"];
  $itemprice = $_POST["itemprice"];

  foreach ($itemname as $index => $names) {
    // echo $names."-".$itemprice[$index];
    $s_itemname = $names;
    $s_itemprice = $itemprice[$index];
    $query = "INSERT INTO  tripendofweekexpenses (itemname, itemamount, work_unit, track) VALUES ('$s_itemname', '$s_itemprice', '$_SESSION[work_unit]', '$_SESSION[track]')";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
      $_SESSION['success'] = "Success!! Information Saved Successfully";
      echo '<script type="text/javascript">window.location="irregularexpenses.php"</script>';
      exit();
    }else{
      $_SESSION['status'] = "Error!! Information Saved Successfully";
      echo '<script type="text/javascript">window.location="irregularexpenses.php"</script>';
      exit();
    }
  }
}

?>
