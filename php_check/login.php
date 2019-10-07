<?php
session_start();
require_once("./DBAccess.php");
$mDBAccess = new DBAccess();
$logged_in = false;
if(isset($_POST['login'])){	
	$logged_in = $mDBAccess->isLoggedIn($_POST['username'], $_POST['password']);
}else if(isset($_GET['username'])){
	$logged_in = $mDBAccess->isLoggedIn($_GET['username'], $_GET['password']);
}else{
	$_SESSION['error_message'] = "Invalid Credentials";
	header("location: ./errorpage.php");
}
if($logged_in){
	header("location: ./../dashboard");
}else{
	header("location: ./errorpage.php");
}

 ?>