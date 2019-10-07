<?php 
session_start();
require_once("./../php_check/DBAccess.php");
$mDBAccess = new DBAccess();

if($polls = $mDBAccess->getActivePolls($_SESSION['user_id'])){
 	header('Content-Type: application/json');
	echo json_encode($polls);
	die();
	exit();
}else{
	// header("location: errorpage.php");
	echo $_SESSION['error_message'];
}
 ?>