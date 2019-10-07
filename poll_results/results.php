<?php 
	session_start();
	require_once("./../php_check/DBAccess.php");
	$mDBAccess = new DBAccess();
	$pollData = $mDBAccess->getSearchResult($_GET['s']);
  	if(!$pollData){
    	// echo $_SESSION['error_message'];
  	}
  	header('Content-Type: application/json');
	echo json_encode($pollData);
	die();
	exit();
 ?>