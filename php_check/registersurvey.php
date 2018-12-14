<?php 
session_start();
if(!isset($_SESSION['user_id'])){
	header("location: ./../index.php");
}
require('./../conn.php');
	if(isset($_POST['login'])){
		$title = mysqli_real_escape_string($conn, $_POST['survey_name']);
		$id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
		$access_code = mysqli_real_escape_string($conn, $_POST['accesscode']);
		$access_code = eregi_replace(' ','_', $access_code);
		$access_code = genVal($access_code) ;
		$query = "insert into surveys (survey_title, survey_accesscode, user_number) values ('{$title}', '{$access_code}', '{$id}')";
		if($result = mysqli_query($conn, $query)){
		    header("location: ./../question_multiple.php?access_code=".$access_code);
		}else{
			echo "failed";
		}
	}
	
	function genVal($v){
		echo "trying";
		require('./../conn.php');
		$question_number_rand = rand(1, 100000);
		$temp = $v.'_'.$question_number_rand;
		$query = "select * from questions where access_code = '{$question_number_rand}' ";
		if($result = mysqli_query($conn, $query)){
		$arr = mysqli_num_rows($result);
		if(! $arr>0){
		  return $temp;
		}else{
		  genVal();
		}
		}else {
		echo "error22>> ". mysqli_error($conn);
		}
	 }
	 echo ">>>";
 ?>