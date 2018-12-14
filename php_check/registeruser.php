<?php 
if (isset($_GET['user'])) {
	require('./../conn.php');
	$username = mysqli_real_escape_string($conn, $_GET['user']);
	$password = mysqli_real_escape_string($conn, $_GET['password']);
	$password = password_hash($password, PASSWORD_BCRYPT);
	$query = "insert into users (username, password) values ('{$username}', '{$password}')";
	if($result = mysqli_query($conn, $query)){
	    echo "successful";
	}else{
		echo "failed";
	}
}
	
 ?>