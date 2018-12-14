<?php 
include ("./../conn.php");
$query = "select * from surveys order by survey_id desc limit 5";
if($result = mysqli_query($conn, $query)){
 	while($arr = mysqli_fetch_assoc($result)){
 		$temp = "./voteplace_multiple.php?access_code=".$arr['survey_accesscode'];
		echo "<ul><a href='$temp'><li>";
 		echo  $arr['survey_title'];
 		echo "</li></a></ul>";
 	}
}else{
	$_SESSION['error_message'] = "Error fetching post";
	header("location: errorpage.php");
}
 ?>