<?php
session_start();
require '../config.php';
error_reporting(0);

// Update the records
if (isset($_POST["update"])) {
    // code...
    $id = mysqli_real_escape_string($con, $_POST["id"]);
    $typeoftrip = mysqli_real_escape_string($con, $_POST["typeoftrip"]);
    $priceoftrip = mysqli_real_escape_string($con, $_POST["priceoftrip"]);
    $dailyexpenditure = mysqli_real_escape_string($con, $_POST["dailyexpenditure"]);
    $sales = mysqli_real_escape_string($con, $_POST["sales"]);
    $loadingfee = mysqli_real_escape_string($con, $_POST["loadingfee"]);
    $noofload = mysqli_real_escape_string($con, $_POST["noofload"]);
    $totalloadingfee = mysqli_real_escape_string($con, $_POST["totalloadingfee"]);
    $feedingfee = mysqli_real_escape_string($con, $_POST["feedingfee"]);
    $fuel = mysqli_real_escape_string($con, $_POST["fuel"]);
    $numberoflitres = mysqli_real_escape_string($con, $_POST["numberoflitres"]);
    $totalcost = mysqli_real_escape_string($con, $_POST["totalcost"]);
    $totalexpenses = mysqli_real_escape_string($con, $_POST["totalexpenses"]);
    $totalsales = mysqli_real_escape_string($con, $_POST["totalsales"]);
    $remarks = mysqli_real_escape_string($con, $_POST["remarks"]);

    $query = "UPDATE truckinformation SET typeoftrip='$typeoftrip', priceoftrip='$priceoftrip', dailyexpenditure='$dailyexpenditure', sales='$sales', loadingfee='$loadingfee', noofload='$noofload', totalloadingfee='$totalloadingfee', feedingfee='$feedingfee', fuel='$fuel', numberoflitres='$numberoflitres', totalcost='$totalcost', totalexpenses='$totalexpenses', totalsales='$totalsales', remarks='$remarks' WHERE id = '$id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['success'] = "Success!! Information Updated Successfully";
        echo '<script type="text/javascript">window.location="index.php"</script>';
        exit();
    }else{
        $_SESSION['status'] = "Error!! Information not Updated Successfully";
        echo '<script type="text/javascript">window.location="addtrip.php"</script>';
        exit();
    }
}

// Change password
if (isset($_POST["passwordsubmit"])) {
    # code...
    $id = mysqli_real_escape_string($con, $_POST["id"]);
    $oldpassword = mysqli_real_escape_string($con, $_POST["oldpassword"]);
    $newpassword = mysqli_real_escape_string($con, $_POST["newpassword"]);
    $confirmpassword = mysqli_real_escape_string($con, $_POST["confirmpassword"]);
    $oldpassword1 = md5($oldpassword);
    $newpassword1 = md5($newpassword);

    if (empty($oldpassword)) {
        //echo '<script type="text/javascript">alert("You cannot proceed")</script>';
        $_SESSION['status'] = "Please Enter Oldpassword";
        header('location: changepassword.php');
        exit();
    }elseif (empty($newpassword)) {
        # code...
        $_SESSION['status'] = "Please Enter Newpassword";
        header('location: changepassword.php');
        exit();
    }elseif (empty($confirmpassword)) {
        # code...
        $_SESSION['status'] = "Please Enter Confirmpassword";
        header('location: changepassword.php');
        exit();
    }elseif ($newpassword !== $confirmpassword) {
        # code...
        $_SESSION['status'] = "Newpassword and Confirmpassword donot Match";
        header('location: changepassword.php');
        exit();
    }else{
        //Writing the code to check the old password
        $query = "SELECT * FROM registration WHERE password = '$oldpassword1' AND id = '$id' AND contactno = '$_SESSION[contactno]' LIMIT 1";
        $query_run = mysqli_query($con, $query);
        if(mysqli_num_rows($query_run) === 1){
            //Writiing the query for the update
            $query = "UPDATE registration SET password='$newpassword1' WHERE id = '$id' LIMIT 1";
            $query_run = mysqli_query($con, $query);
            if ($query_run) {
                $_SESSION['success'] = "Data Update Successful";
                header('location: changepassword.php');
                exit();
            }else{
                $_SESSION['status'] = "Error!! Update not Successful";
                header('location: changepassword.php');
                exit();
            }
        } else {
            $_SESSION['status'] = "Error!! The oldpassword entered is not correct";
            header('location: changepassword.php');
            exit();
        }
    }
}

// Trip Incidential Expenses
if (isset($_POST["tripsubmit"])) {
  // code...
  $itemname = mysqli_real_escape_string($con, $_POST["itemname"]);
  $itemamount = mysqli_real_escape_string($con, $_POST["itemamount"]);
  // $pic = mysqli_real_escape_string($con, $_POST["pic"]);

  //Code for validation
  if (empty($itemname)) {
       $_SESSION['status'] = "Please Enter Item Name";
       echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
       exit();
  }
   if (empty($itemamount)) {
      $_SESSION['status'] = "Please Enter Item Price";
      echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
      exit();
  }

  if (isset($_FILES['pic']['name'])) {
      // code...
    //Script for selecting image
    $filename = $_FILES["pic"]["name"];
      $tempname = $_FILES["pic"]["tmp_name"];
      $filesize = $_FILES["pic"]["size"];
      $filetype = $_FILES["pic"]["type"];
      $filError = $_FILES["pic"]["error"];
      //Code to restrict the type of file to upload
      $fileExt = explode('.', $filename);
      $fileActualExt = strtolower(end($fileExt));

      $allowed = array('jpg', 'jpeg', 'png', 'gif');
      if(in_array($fileActualExt, $allowed)){
          if($filError === 0){
          //Checking the filesize
            if($filesize < 18000000){
              $folder = "images/".$filename;
                move_uploaded_file($tempname, $folder);
          } else {
            $_SESSION['status'] = "Error!! Your file is too big.";
            echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
            exit();
                  }
      } else {
        $_SESSION['status'] = "Error!! There was an error uploading this file.";
        echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
        exit();
        }
      } else {
        $query = "INSERT INTO tripirregularexpenses (itemname, itemamount, work_unit, track) VALUES ('$itemname', '$itemamount', '$_SESSION[work_unit]', '$_SESSION[track]')";
        $query_run = mysqli_query($con, $query);
        if ($query_run) {
            $_SESSION['success'] = "Success!! Information Saved Successfully";
            echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
            exit();
        }else{
            $_SESSION['status'] = "Error!! Information not Saved Successfully";
            echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
            exit();
        }
      }

    $query = "INSERT INTO tripirregularexpenses (itemname, itemamount, itemimage, work_unit, track) VALUES ('$itemname', '$itemamount', '$folder', '$_SESSION[work_unit]', '$_SESSION[track]')";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['success'] = "Success!! Information Saved Successfully";
        echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
        exit();
    }else{
        $_SESSION['status'] = "Error!! Information not Saved Successfully";
        echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
        exit();
    }

  }
}

if (isset($_POST["regularexpensessubmit"])) {
  // code...
  // echo '<script type="text/javascript">alert(Good to)</script>';
    $feedingfee = mysqli_real_escape_string($con, $_POST["feedingfee"]);
    $tax = mysqli_real_escape_string($con, $_POST["tax"]);
    $fuelprice = mysqli_real_escape_string($con, $_POST["fuelprice"]);
    $nooflitres = mysqli_real_escape_string($con, $_POST["nooflitres"]);
    $dailyremark = mysqli_real_escape_string($con, $_POST["dailyremark"]);

    $totalfuelcost = $fuelprice * $nooflitres;
    $totalregularexpenses= $feedingfee + $tax + $totalfuelcost;

    //Code for validation
  if (empty($feedingfee)) {
       $_SESSION['status'] = "Please Enter Feeding Fee";
       echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
       exit();
  }

    if (isset($_FILES['pic']['name'])) {
      // code...
    //Script for selecting image
    $filename = $_FILES["pic"]["name"];
      $tempname = $_FILES["pic"]["tmp_name"];
      $filesize = $_FILES["pic"]["size"];
      $filetype = $_FILES["pic"]["type"];
      $filError = $_FILES["pic"]["error"];
      //Code to restrict the type of file to upload
      $fileExt = explode('.', $filename);
      $fileActualExt = strtolower(end($fileExt));

      $allowed = array('jpg', 'jpeg', 'png', 'gif');
      if(in_array($fileActualExt, $allowed)){
          if($filError === 0){
          //Checking the filesize
            if($filesize < 18000000){
              $folder = "images/".$filename;
                move_uploaded_file($tempname, $folder);
          } else {
            $_SESSION['status'] = "Error!! Your file is too big.";
            echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
            exit();
                  }
      } else {
        $_SESSION['status'] = "Error!! There was an error uploading this file.";
        echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
        exit();
        }
      } else {
      // Select query
      $query = "SELECT * FROM tripregularexpenses WHERE track = '$_SESSION[track]' AND entrydate = '$_SESSION[date]'";
      $query_run = mysqli_query($con, $query);
      if(mysqli_num_rows($query_run) > 0){
        $_SESSION['status'] = "Error! Daily regular expenses for the day recorded already.";
        echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
        exit();
      }else{
        $query = "INSERT INTO tripregularexpenses (feedingfee, tax, fuel, numberoflitres, totalfuelcost, remarks, totalregularexpenses, work_unit, track) VALUES ('$feedingfee', '$tax', '$fuelprice', '$nooflitres', '$totalfuelcost', '$dailyremark', $totalregularexpenses, '$_SESSION[work_unit]', '$_SESSION[track]')";
        $query_run = mysqli_query($con, $query);
        if ($query_run) {
            // code...
            $_SESSION['success'] = "Information entered Successfully.";
            echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
            exit();
        }else{
            $_SESSION['status'] = "Error! Information not entered Successfully.";
            echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
            exit();
        }
      }
      }

    // Select query
  $query = "SELECT * FROM tripregularexpenses WHERE track = '$_SESSION[track]' AND entrydate = '$_SESSION[date]'";
  $query_run = mysqli_query($con, $query);
  if(mysqli_num_rows($query_run) > 0){
    $_SESSION['status'] = "Error! Daily regular expenses for the day recorded already.";
    echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
    exit();
  }else{
    $query = "INSERT INTO tripregularexpenses (feedingfee, tax, fuel, numberoflitres, totalfuelcost, picture, remarks, totalregularexpenses, work_unit, track) VALUES ('$feedingfee', '$tax', '$fuelprice', '$nooflitres', '$totalfuelcost', '$folder', '$dailyremark', $totalregularexpenses, '$_SESSION[work_unit]', '$_SESSION[track]')";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        // code...
        $_SESSION['success'] = "Information entered Successfully.";
        echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
        exit();
    }else{
        $_SESSION['status'] = "Error! Information not entered Successfully.";
        echo '<script type="text/javascript">window.location="regularexpenses.php"</script>';
        exit();
    }
  }

  }

}

if (isset($_POST["makepayment"])) {
    // code...
    $id = mysqli_real_escape_string($con, $_POST["id"]);
    $amount = mysqli_real_escape_string($con, $_POST["amount"]);

    if (empty($amount)) {
       $_SESSION['status'] = "Please Enter Amount to Pay";
       echo '<script type="text/javascript">window.location="cashpayment.php"</script>';
       exit();
  }else{
    $query = "SELECT * FROM cashindebt WHERE id = '$id' LIMIT 1";
    $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run) === 1){
        $row = mysqli_fetch_assoc($query_run);
        $_SESSION["amount_paid"] = $row["amount_paid"];
        $_SESSION["balance"] = $row["balance"];
        $currentamountpaid = $amount + $_SESSION['amount_paid'];
        $currentbalaceremaining = $_SESSION['balance'] - $currentamountpaid;
        // Query to update current record
        $query = "UPDATE cashindebt SET amount_paid='$currentamountpaid', balance='$currentbalaceremaining' WHERE id = '$id'";
        $query_run = mysqli_query($con, $query);
        if ($query_run){
            $query = "INSERT INTO paymentdetails (paymentid, amountowed, payment, balance, work_unit, track) VALUES ('$id','$_SESSION[balance]', '$amount', '$currentbalaceremaining', '$_SESSION[work_unit]', '$_SESSION[track]')";
            $query_run = mysqli_query($con, $query);
            if ($query_run){
                $_SESSION['success'] = "Payment Successful";
                echo '<script type="text/javascript">window.location="cashretrieve.php"</script>';
                exit();
            }
        }
    }else{
        $_SESSION['status'] = "Please Reselect Person";
        echo '<script type="text/javascript">window.location="cashpayment.php"</script>';
        exit();
    }
  }
}

// Code for date range
if (isset($_POST["daterangesubmit"])) {
    // code...
    $startdate = mysqli_real_escape_string($con, $_POST["startdate"]);
    $enddate = mysqli_real_escape_string($con, $_POST["enddate"]);

    //Code for validation
      if (empty($startdate)) {
           $_SESSION['status'] = "Please Enter Start Date";
           echo '<script type="text/javascript">window.location="index.php"</script>';
           exit();
      }
       if (empty($enddate)) {
          $_SESSION['status'] = "Please Enter End Date";
          echo '<script type="text/javascript">window.location="index.php"</script>';
          exit();
      }

    $_SESSION["startdate"] = $startdate;
    $_SESSION["enddate"] = $enddate;

    echo '<script type="text/javascript">window.location="weeklyreport.php"</script>';
    exit();
}

?>