<?php 
session_start();
require "../../config.php";
$total_que=0;
$resl= mysqli_query($con, "SELECT * FROM exams_questions WHERE questionID = '$_SESSION[id]'");
$total_que = mysqli_num_rows($resl);
echo $total_que;

?>