<?php 
session_start();
  if(isset( $_GET['access_code'] ) ){
    $access_code = $_GET['access_code'];
    require_once("./DBAccess.php");
    $mDBAccess = new DBAccess();
    $update = $mDBAccess->getLivePolls($access_code);
    if($update){
      echo json_encode($update);
    }else{
      echo $_SESSION['error_message'];
      
    }
    exit();
    die();
   }