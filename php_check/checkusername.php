<?php 
if (isset($_GET['user'])) {
	require('./../conn.php');
	$username = mysqli_real_escape_string($conn, $_GET['user']);
	$query = "select * from users where username = '{$username}'";
	if($result = mysqli_query($conn, $query)){
	    echo mysqli_num_rows($result);
	}
}
	
 ?>