<?php
session_start();
require '../config.php';

$exam_category = $_GET["exam_category"];
$_SESSION['exam_category'] = $exam_category;
$res=mysqli_query($con, "SELECT * FROM exams_setting WHERE id = '$exam_category'");
while ($row=mysqli_fetch_array($res) {
	$_SESSION['timelimit'] = $row["timelimit"];
}
$date=date("Y-m-d H:i:s");
$_SESSION['end_time'] = date("Y-m-d H:i:s",strtotime($date."+$_SESSION[timelimit] minutes"));
$_SESSION['exam_start'] = "yes";

?>