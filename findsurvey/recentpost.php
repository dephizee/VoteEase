<?php 
	require_once("./../php_check/DBAccess.php");
	$mDBAccess = new DBAccess();
	print($mDBAccess->recentPost());