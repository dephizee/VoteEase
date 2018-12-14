<?php 
session_start();
include ("./../conn.php");
$t = $_SESSION['user_id'];
$query = "select * from surveys where survey_id in (select vote_survey_number from votes where vote_user_number = '{$t}') order by survey_id desc limit 5";
if($result = mysqli_query($conn, $query)){
 	while($arr = mysqli_fetch_assoc($result)){
 		$temp = "./voteplace_multiple.php?access_code=".$arr['survey_accesscode'];
		echo "<ul><a href='$temp'><li>";
 		echo  $arr['survey_title'];
 		echo "</li></a></ul>";
 	}
}else{
	$_SESSION['error_message'] = "Error fetching post".mysqli_error($conn);
	header("location: errorpage.php");
}
 ?>