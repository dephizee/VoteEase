<?php 
	require_once("./../php_check/DBAccess.php");
	session_start();
	$mDBAccess = new DBAccess();
	if($vote = $mDBAccess->getRecentPolls($_GET['r_page'])){
	 	header('Content-Type: application/json');
		echo json_encode($vote);
		die();
		exit();
	}else{
		// header("location: errorpage.php");
		echo $_SESSION['error_message'];
	}
 ?>