<?php 
	session_start();
	require_once("/DBUtils.php");
	class CreatePoll extends DBUtils{


		function createNewPoll($survey_name){
			$title = mysqli_real_escape_string($this->conn, $_POST['survey_name']);
			$id = mysqli_real_escape_string($this->conn, $_SESSION['user_id']);
			$start_date = mysqli_real_escape_string($this->conn, $_POST['start_date']);
			$start_time = mysqli_real_escape_string($this->conn, $_POST['start_time']);
			$end_date = mysqli_real_escape_string($this->conn, $_POST['end_date']);
			$end_time = mysqli_real_escape_string($this->conn, $_POST['end_time']);
			$query = "insert into surveys
								(survey_title, user_number, start_date, start_time, end_date, end_time) values 
								('{$title}', '{$id}', '{$start_date}', '{$start_time}', '{$end_date}', '{$end_time}')";
			if($result = mysqli_query($this->conn, $query)){
				$data = array();
				$data['result_code'] = 200;
				$data['survey_no'] = mysqli_insert_id($this->conn);
				return $data;
			}else{
				echo "error22>> ". mysqli_error($this->conn);
				return 404;
			}
		}

		function createNewPollOptions($poll, $survey_no){
			$data = json_decode($poll);

			$text = "";
			$text .= "insert into questions (question_message, survey_no) values ";
			$es_code = $survey_no;
			$options_id = array();
			foreach ($data as $Key => $value) {

				$es_msg = $value->question;
				$es_msg = mysqli_real_escape_string($this->conn, $es_msg);
				$text.="('{$es_msg}', '{$es_code}'),";
			}
			$query = ereg_replace(".{1}$",";",$text);
			if($result = mysqli_query($this->conn, $query)){
			    $query = "select question_id from questions where survey_no = '{$es_code}' ";
			    if($result = mysqli_query($this->conn, $query)){
			    	if(mysqli_num_rows($result) == 0){
			    		header("location: errorpage.php");
			    	}
					while ($arr = mysqli_fetch_assoc($result)) {
						$question_id[] = $arr['question_id'];
					}
			    }else {
			      echo "error22>> ". mysqli_error($this->conn);
			    }
			}else {
			    echo "question>>> ". mysqli_error($this->conn);
			}
			//----------------//
			$text = "";
			$text .= "insert into options(question_number,  option_value) values ";
			$c = 0;
			foreach ($data as $value) {
				foreach ($value->options as $v) {
					$es_opt = mysqli_real_escape_string($this->conn, $v->option_text);
					$q_id = ($question_id[$c]);
					$text .= "('{$q_id}', '{$es_opt}'),";
				}
				$c++;
			}
			$query = ereg_replace(".{1}$",";",$text);
			if($result = mysqli_query($this->conn, $query)){
				$query = "select option_id from options where";
				foreach ($question_id as $key => $value) {
					$query .= " question_number = '{$value}' ";
					if($key < count($question_id)-1){
						$query .= " or ";
					}
				}
				$query .= ";";
				if($result = mysqli_query($this->conn, $query)){
			    	if(mysqli_num_rows($result) == 0){
			    		die($query);
			    		header("location: ./errorpage.php");
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
							if(isset($v->option_image) && $v->option_image != false ){
								$es_opt = mysqli_real_escape_string($this->conn, $v->option_image);
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
						// echo "window.location.href='voteplace_multiple.php?access_code=$es_code'"; 
						return 200;
					}else{
						if($result = mysqli_query($this->conn, $query)){
						    // echo "window.location.href='voteplace_multiple.php?access_code=$es_code'"; 
						    return 200;
						  }else {
						  	echo $query;
						    echo "options photo >>> ". mysqli_error($this->conn);
						  }
					}
			    }else {
			      echo "error id options >>>> ". mysqli_error($this->conn);
			    }
			}else{
				echo "question>>> ". mysqli_error($this->conn);
			}
		}

		function uploadImage(){
			$r = rand(0, 1000);
			$t = "./../photo_folder/".$_SESSION['user_name'];
			if(!file_exists($t)){
				mkdir($t);
			}else{
				// return 404 1;
			}
			
			$temp_loc = $t;
			$temp_loc .= '/'.$r.$_FILES['file_key']['name'];
			move_uploaded_file($_FILES['file_key']['tmp_name'], $temp_loc);
			$t = "./photo_folder/".$_SESSION['user_name'].'/'.$r.$_FILES['file_key']['name'];
			$s_add = '/'.$r.$_FILES['file_key']['name'];
			//echo $t;
			$thumbnail_loc = './../thumbnail/photo_folder/'.$_SESSION['user_name'];
			if(!file_exists($thumbnail_loc)){
				mkdir($thumbnail_loc);
			}else{
				// return 404;
			}
			$thumbnail_loc = $thumbnail_loc.$s_add;
			$type = $_FILES['file_key']['type'];
			$this->genThumbnail($temp_loc, $thumbnail_loc, $type);
			$data = array();
			$data['result_code'] = 200;
			$data['location']=$temp_loc;
			return $data;
		}

		function genThumbnail($src, $loc, $type){
			if($type =='image/jpeg'){
				$data = imagecreatefromjpeg($src);
			}elseif($type =='image/png'){
				$data = imagecreatefrompng($src);
			}elseif($type =='image/gif'){
				$data = imagecreatefrompng($src);
			}
			
			//
			$width = imagesx($data);
			$height = imagesy($data);
			$desired_height = 200;
			$desired_width = 200;

			$desired_height = floor($height * ($desired_width/ $width));
			$new_data = imagecreatetruecolor($desired_width, 200);
			$offsety = ($height - $width)/2;
			$offsetx = ($width - $height)/2;
			if($height>$width){
				imagecopyresampled($new_data, $data, 0, 0, 0, $offsety, $desired_width, 200, $width, $offsety+$width);
			}else{
				imagecopyresampled($new_data, $data, 0, 0, $offsetx, 0, 200, 200, $height+$offsetx, $height);
			}
			
			//imagecopyresampled(dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
			imagejpeg($new_data, $loc);
		}
	}
 ?>