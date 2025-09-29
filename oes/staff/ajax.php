<?php
require '../../config.php';
error_reporting(0);

$program=$_GET["program"];
$course=$_GET["course"];
// $town=$_GET["town"];
// $community=$_GET["community"];
// $area=$_GET["area"];


if($program!=""){
$res= mysqli_query($con, "SELECT * FROM courses WHERE programTypeID=$program ORDER BY course_name ASC");
echo "<select id='coursedd' onchange='change_course()' name='course' class='form-control'>";
echo "<option>";echo "Select Course"; echo "</option>";
while($row = mysqli_fetch_array($res)) {
    echo "<option value='$row[id]'>"; echo $row["course_name"]; echo "</option>";
}
echo "</select>";
}

// if($course!=""){
// $res= mysqli_query($con, "SELECT * FROM tutorclass WHERE district_ID=$district ORDER BY name ASC");
// echo "<select id='towndd' onchange='change_town()' name='town'>";
// echo "<option>";echo "Select Town"; echo "</option>";
// while($row = mysqli_fetch_array($res)) {
//     echo "<option value='$row[id]'>"; echo $row["name"]; echo "</option>";
// }
// echo "</select>";
// }

// if($town!=""){
// $res= mysqli_query($con, "SELECT * FROM town WHERE cityID=$town ORDER BY name ASC");
// echo "<select id='communitydd' onchange='change_community()' name='community'>";
// echo "<option>";echo "Select Community"; echo "</option>";
// while($row = mysqli_fetch_array($res)) {
//     echo "<option value='$row[id]'>"; echo $row["name"]; echo "</option>";
// }
// echo "</select>";
// }

// if($community!=""){
// $res= mysqli_query($con, "SELECT * FROM community WHERE townID=$community ORDER BY name ASC");
// echo "<select id='areadd' name='area'>";
// echo "<option>";echo "Select Area"; echo "</option>";
// while($row = mysqli_fetch_array($res)) {
//     echo "<option value='$row[id]'>"; echo $row["name"]; echo "</option>";
// }
// echo "</select>";
// }


?>