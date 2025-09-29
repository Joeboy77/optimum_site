<?php
session_start();
require '../config.php';

// echo $_SESSION['timelimit'];
$duration = $_SESSION['timelimit'];
$_SESSION["timelimit"] = $duration;
$_SESSION["start_time"] = date("Y-m-d H:i:s");

$end_time = date('Y-m-d H:i:s', strtotime('+'.$_SESSION["timelimit"].'minutes', strtotime($_SESSION["start_time"])));
$_SESSION["end_time"] = $end_time;

?>

<script type="text/javascript">
	window.location = "index.php";
</script>