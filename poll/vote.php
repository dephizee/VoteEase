<?php 
	if(isset($_POST['sub'])){
		session_start();
		require_once("./../php_check/DBAccess.php");
		$mDBAccess = new DBAccess();
		$conn = $mDBAccess->getConn();
		$survey_id = $_POST['survey_id'];
		$vote_ip_address =  $_SERVER['REMOTE_ADDR'];
		$checkquery = "select * from votes where vote_survey_number = '{$survey_id}' and vote_ip_address = '{$vote_ip_address}' ";		 
		if($result = mysqli_query($conn, $checkquery)){
			if(mysqli_num_rows($result) > 0){
				$_SESSION['error_message'] = "Voting Error, you cannnot Vote twice ";
	    		header("location: ./../php_check/errorpage.php");
	    		return;
	    		die();
	    		exit();
			}
	   		
	   	}
		$votequery = "insert into votes (vote_survey_number, vote_ip_address) values ('{$survey_id}', '{$vote_ip_address}')";
	   	if(!mysqli_query($conn, $votequery)){
	   		$_SESSION['error_message'] = "error22>> ". mysqli_error($conn);
	    	header("location: ./../php_check/errorpage.php");
	    	return;
	    	die();
	    	exit();
	   	}
		foreach ($_POST['ans'] as $key => $value) {
	 		$temp = mysqli_real_escape_string($conn, $value);
	 		if($temp=='-1'){
	  			continue;
	 		}
	 		$qry = "update options set option_select_count = option_select_count + 1 where question_number = '{$_POST['question_number'][$key]}' and ";
	 		$qry .= "option_id = '{$temp}'";
	 		if(!mysqli_query($conn, $qry)){
	    		echo "error22>> ". mysqli_error($conn);
	    		$_SESSION['error_message'] = "An Error Occurred";
	    		header("location: ./php_check/errorpage.php");
	  		}
	   	}

	   	
	   	header("location: ".$_SERVER['HTTP_REFERER']);
	   	exit();
	   	die();
	 }
 ?>