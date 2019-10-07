<?php
	require("./../php_check/CreatePoll.php");
	$mCreatePoll = new CreatePoll();
	if(isset($_POST["survey_name"])){
		$pollData = $mCreatePoll->createNewPoll($_POST["survey_name"]);
		header('Content-Type: application/json');
		echo json_encode($pollData);
	}
	if(isset($_FILES['file_key'])){
		$pollData = $mCreatePoll->uploadImage();
		header('Content-Type: application/json');
		echo json_encode($pollData);
	}
	if(isset($_GET['poll'])){
		$pollData = $mCreatePoll->createNewPollOptions($_GET['poll'], $_GET['survey_no']);
		header('Content-Type: application/json');
		echo json_encode($pollData);
	}
?>
