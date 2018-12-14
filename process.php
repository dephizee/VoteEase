<?php
	if(isset($_GET["form"])){
		require('./conn.php');
		$form = $_GET['form'];
		$data = json_decode($form);
		$text = "";
		$text .= "insert into questions (question_message, access_code) values ";
		$es_code = $_GET['access_code'];
		$options_id;
		foreach ($data as $Key => $value) {
			$es_msg = $value->question;
			$es_msg = mysqli_real_escape_string($conn, $es_msg);
			$text.="('{$es_msg}', '{$es_code}'),";
		}
		$query = ereg_replace(".{1}$",";",$text);
		if($result = mysqli_query($conn, $query)){
	    //echo "Upload 1 complete<br>";
	    $query = "select question_id from questions where access_code = '{$es_code}' ";
	    if($result = mysqli_query($conn, $query)){
	    	if(mysqli_num_rows($result) == 0){
	    		header("location: errorpage.php");
	    	}
			while ($arr = mysqli_fetch_assoc($result)) {
				$question_id[] = $arr['question_id'];
			}
	    }else {
	      echo "error22>> ". mysqli_error($conn);
	    }
	  }else {
	    echo "question>>> ". mysqli_error($conn);
	  }

		//var_dump($question_id);
		$text = "";
		$text .= "insert into options(question_number,  option_value) values ";
		$c = 0;
		foreach ($data as $value) {
			foreach ($value->options as $v) {
				$es_opt = mysqli_real_escape_string($conn, $v->option_text);
				$q_id = ($question_id[$c]);
				$text .= "('{$q_id}', '{$es_opt}'),";
				//echo $v.", ";
			}
			//echo "<br>";
			$c++;
		}
		$query = ereg_replace(".{1}$",";",$text);
		if($result = mysqli_query($conn, $query)){
	    //echo "Upload 2 complete<br>";
		////echo "window.location.href='voteplace_multiple.php?access_code=$es_code'"; 
						$query = "select option_id from options where";
						foreach ($question_id as $key => $value) {
							$query .= " question_number = '{$value}' ";
							if($key < count($question_id)-1){
								$query .= " or ";
							}
						}
						$query .= ";";
					    if($result = mysqli_query($conn, $query)){
					    	if(mysqli_num_rows($result) == 0){
					    		die($query);
					    		header("location: ./php_check/errorpage.php");
					    	}
							while ($arr = mysqli_fetch_assoc($result)) {
								$options_id[] = $arr['option_id'];
							}
							$text = "";
							$text .= "insert into image_option (image_option_url, image_option_number) values ";
							$c = 0;
							$cc = 0;
							foreach ($data as $value) {
								foreach ($value->options as $v) {
									if(isset($v->option_image)){
										$es_opt = mysqli_real_escape_string($conn, $v->option_image);
										$q_id = ($options_id[$c]);
										$text .= "('{$es_opt}', '{$q_id}'),";
										//echo $v.", ";
										$c++;
										$cc++;
									}else{
										$c++;
									}
									
									
								}
								//echo "<br>";
								
							}
							$query = ereg_replace(".{1}$",";",$text);
							if($cc==0){
								echo "window.location.href='voteplace_multiple.php?access_code=$es_code'"; 
							}else{
								if($result = mysqli_query($conn, $query)){
								    echo "window.location.href='voteplace_multiple.php?access_code=$es_code'"; 
								  }else {
								  	echo $query;
								    echo "options photo >>> ". mysqli_error($conn);
								  }
							}
					    }else {
					      echo "error id options >>>> ". mysqli_error($conn);
					    }
					  
	  }else {
	    echo "question>>> ". mysqli_error($conn);
	  }
	}
	function genVal(){
	  require('./conn.php');
	  $question_number_rand = rand(1, 10000000);
	  $query = "select * from questions where access_code = '{$question_number_rand}' ";
	  if($result = mysqli_query($conn, $query)){
	    $arr = mysqli_fetch_array($result);
	    if(! count($arr)>0){
	      return $question_number_rand;
	    }else{
	      header("location: errorpage.php");
	    }
	  }else {
	    echo "error22>> ". mysqli_error($conn);
	  }
	}
?>
