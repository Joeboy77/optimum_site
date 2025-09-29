<?php
// Calculation for item price
$query = "SELECT SUM(itemamount) AS sum FROM tripirregularexpenses WHERE track = '$_SESSION[track]' AND entrydate BETWEEN '$_SESSION[startdate]' AND '$_SESSION[enddate]'";
$query_result = mysqli_query($con, $query);
while ($row = mysqli_fetch_assoc($query_result)) {
    $itemamount = $row['sum'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<div class="container-fluid">
    <div class="card-header d-sm-flex align-items-center justify-content-between">
         <span><i class="bi bi-table me-2"></i>Incidental Enpenses</span> 
        <!-- <button type="button" class="btn btn-success btn-sm" ><i class="bi bi-plus"></i>Export Data</button> -->
      </div>
		<div>
			<table class="table table-striped table-hover text-center">
            <thead class="table-success">
              <tr>
                <th>S. No.</th>
                <th>Item Name</th>
                <th>Item Price</th>
                <th>Supporting Receipt</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody id="data">
              <?php
                $query = "SELECT * FROM tripirregularexpenses WHERE track = '$_SESSION[track]' AND entrydate BETWEEN '$_SESSION[startdate]' AND '$_SESSION[enddate]'";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) > 0){
                  $no = 1;
                  while ($row = mysqli_fetch_assoc($query_run)){
              ?>
              <tr>
                <td><?php echo $no;?></td>
                <td><?php echo $row['itemname'];?></td>
                <td><?php echo $row['itemamount']?></td>
                <td><img src="<?php echo $row['itemimage']?>" style="width: 60px; height: 40px;"></td>
                <td><?php echo $row['entrydate']?></td>
              </tr>
              <?php
              $no++;
              }
            }else{
              echo "No Record Found";
            }
            ?>
            </tbody>
            <tr>
              <td><b>Total</b></td>
              <td></td>
              <td><b><?php echo number_format($itemamount, 2);?></b></td>
              <td><b></b></td>
              <td></td>
            </tr>
          </table>
        </div>
	</div>
</body>
</html>