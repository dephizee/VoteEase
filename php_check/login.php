<?php
session_start();
if(isset($_POST['login'])){
	require('./../conn.php');
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	$query = "select * from users where username = '{$username}'";
	if($result = mysqli_query($conn, $query)){
	    if(mysqli_num_rows($result) > 0){
	    	$arr = mysqli_fetch_assoc($result);
	    	if(password_verify($password, $arr['password'])){
	    		$_SESSION['logged_in'] = "true";
	    		$_SESSION['user_name'] = $arr['username'];
	    		$_SESSION['user_id'] = $arr['user_id'];
	    		header("location: ./../dashboard.php");
	    	}else{
	    		$_SESSION['error_message'] = "Incorrect password or username";
	    		header("location: ./errorpage.php");
	    	}
	    }else{
	    	$_SESSION['error_message'] = "Invalid Username";
	    	header("location: ./errorpage.php");
	    }
	}else{
		echo "failed". mysqli_error($conn);
	}
}else{
	$_SESSION['error_message'] = "Bad Access";
	header("location: ./errorpage.php");
}

 ?>