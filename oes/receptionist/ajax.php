<?php
require '../../config.php';
error_reporting(0);

$programtype=$_GET["programtype"];
$courseselected=$_GET["courseselected"];

if($programtype!=""){
$res= mysqli_query($con, "SELECT * FROM courses WHERE programTypeID=$programtype ORDER BY course_name ASC");
echo "<select id='coursedd' onchange='change_course()' name='courseselected' class='form-control'>";
echo "<option>";echo "Select Course"; echo "</option>";
while($row = mysqli_fetch_array($res)) {
    echo "<option value='$row[id]'>"; echo $row["course_name"]; echo "</option>";
}
echo "</select>";
}


?>