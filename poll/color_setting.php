<?php 
	var_dump($_GET);
	if(isset($_GET['access_code'])){
		session_start();
		require_once("./../php_check/DBAccess.php");
		$mDBAccess = new DBAccess();
		$result = $mDBAccess->saveColors($_GET) ;
		if($result){
			header("location: ".$_SERVER['HTTP_REFERER']);
		}

		
	}