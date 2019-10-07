<?php 
	class DBUtils{
		var $conn;
		function DBUtils($h="127.0.0.1",$u="root",$p="",$d="voteease"){
		  	$this->conn = mysqli_connect($h,$u,$p,$d);
		  	if(! $this->conn ) { 
				die('Could not connect: ' . mysqli_error()); 
			}
		}
	}
