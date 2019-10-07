<?php 
if (isset($_GET['user'])) {
	require_once("./DBAccess.php");
	$mDBAccess = new DBAccess();
	echo $mDBAccess->checkUser($_GET['user']);
}
	
 ?>