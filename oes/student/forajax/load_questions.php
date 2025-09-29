<?php  
session_start();
require "../../config.php";

$question_no = "";
$question = "";
$opt1 = "";
$opt2 = "";
$opt3 = "";
$opt4 = "";
$answer = "";
$count = 0;
$ans = "";

$queno = $_GET["questionno"];
if (isset($_SESSION["answer"][$queno])){
	$ans=$_SESSION["answer"][$queno];
}

$res=mysqli_query($con, "SELECT * FROM exams_questions WHERE questionID='$_SESSION[id]' && question_no=$_GET[questionno]");
$count = mysqli_num_rows($res);

if ($count==0) {
	echo "over";
}else{
	while ($row=mysqli_fetch_array($res)) {
		$question_no=$row["question_no"];
		$question=$row["question"];
		$opt1=$row["option1"];
		$opt2=$row["option2"];
		$opt3=$row["option3"];
		$opt4=$row["option4"];
	}
	?>
	<br>

	<table>
		<tr style="font-weight: bold; font-size: 18px; padding-left: 5px;" colspan="2">
			<?php echo "{ ".$question_no."} ". $question;?>
		</tr>
	</table>
	<table>
		<tr>
			<td>
				<input type="radio" name="r1" id="r1" value="<?php echo $opt1;?>">
				<?php
				if ($ans==$opt1) {
					echo "checked";
				}
				?>
			</td>
			<td style="padding-left: 10px;">
				<?php
				if (strpos($opt1,'/image')!=false) {
					?>
					<img src="admin/<?php echo $opt1;?>" height="30" width="30">
					<?php
				}else{
					echo $opt1;
				}
				?>
			</td>
		</tr>
	</table>

	<?php
}
?>