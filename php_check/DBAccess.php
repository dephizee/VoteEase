<?php 
	require_once("/DBUtils.php");
	class DBAccess extends DBUtils{
		function recentPost($page = 1){
			$query = "select * from surveys order by survey_id desc";
			$output = "";
			if($result = mysqli_query($this->conn, $query)){
			 	while($arr = mysqli_fetch_assoc($result)){
			 		$temp = "./voteplace_multiple.php?access_code=".$arr['survey_id'];
					$output .= "<ul><a href='$temp'><li>";
			 		$output .=  $arr['survey_title'];
			 		$output .= "</li></a></ul>";
			 	}
			 	return $output;
			}else{
				$_SESSION['error_message'] = "Error fetching post";
				header("location: errorpage.php");
			}
		}
		function checkUser($user){
			$username = mysqli_real_escape_string($this->conn, $user);
			$query = "select * from users where username = '{$username}'";
			if($result = mysqli_query($this->conn, $query)){
			    return mysqli_num_rows($result);
			}
			
			return null;

		}
		function getPollData($access_code = -1){
			$access_code = mysqli_real_escape_string($this->conn, $access_code);
			if($access_code==-1){
				$_SESSION['error_message'] = "Error fetching Poll Data";
				return null;
			}
			$data = array();	
			$question = array();
			$question_number = array();
			$option_arr_id = array();
			$option_arr_value = array();
			$option_arr_img_url = array();
			$option_arr_count = array();
			$query = "select * from questions where survey_no = '{$access_code}' ";
			if($result = mysqli_query($this->conn, $query)){
				if(mysqli_num_rows($result) == 0){
					$_SESSION['error_message'] = "No Poll was found with this Access Code";
		      		return null;
			    }
			  	while ($arr = mysqli_fetch_assoc($result)) {
					$question[] = $arr['question_message'];
				    $question_number[] = $arr['question_id'];
				}

			  //

			  	if( count($question_number) > 0){
			    	foreach ($question_number as $key => $value) {
			      		$q = $value;
			      		$ops_id = array();
			      		$ops_value = array();
			      		$ops_img_url = array();
			      		$count = array();
			      		$option_img = array();
				      	$query = "select * from options where question_number = '{$q}' ";
			      		if($result = mysqli_query($this->conn, $query)){
			        		while ($arr = mysqli_fetch_assoc($result)) {
			        			$temp_ops_id = $arr['option_id'];
			        			$ops_id[] = $arr['option_id'];
				          		$ops_value[] = $arr['option_value'];
			        	  		$count[]= $arr['option_select_count'];
			        	  		$qry = "select image_option_url from image_option where image_option_number = '{$arr['option_id']}' ";
					            if($re = mysqli_query($this->conn, $qry)){
					              if(mysqli_num_rows($re) == 1){
					              	while ($ar = mysqli_fetch_assoc($re)) {
					                  $option_img[] = $ar['image_option_url'];
					              		// $option_img[] = mysqli_num_rows($re);
					                }
					                $ar = mysqli_fetch_assoc($re);
					                // $option_img[] = mysqli_num_rows($re);
					              }else if(mysqli_num_rows($re) == 0){
					                $option_img[] ='';
					              }else{
					              	$option_img[] = null;
					                // die("error>> more than a record ". mysqli_num_rows($re));
					              }
					            }else {
					            	$_SESSION['error_message'] = "error22>> ". mysqli_error($this->conn);
					            	return null;
					            }


			        		}
			      		}else {
					   		$_SESSION['error_message'] = "failed ". mysqli_error($this->conn);
					   		return null;
			      		}
			      		$option_arr_id[] = $ops_id;
			      		$option_arr_value[] = $ops_value;
			      		$option_arr_count[] = $count;
			      		$option_arr_count_total[] = $this->totalCount($count);
			      		$option_arr_img_url[] = $option_img;
			    	}
			  	}else{
			    	$_SESSION['error_message'] = "Invalid Access Code";
			    	header("location: ./php_check/errorpage.php");
				}
			}else {
			  die("error22>> ". mysqli_error($this->conn));
			}
			$data['question'] = $question;
			$data['question_number'] = $question_number;
			$data['option_arr_id'] = $option_arr_id;
			$data['option_arr_value'] = $option_arr_value;
			$data['option_arr_count'] = $option_arr_count;
			$data['option_arr_count_total'] = $option_arr_count_total;
			$data['option_arr_img_url'] = $option_arr_img_url;
			$data['survey_data'] = $this->getSurveyData($access_code);
			$data['has_voted'] = $this->hasVoted($data['survey_data']['survey_id']);
			$data['colors'] = $this->getColor($access_code);


			return $data;
		}
		function hasVoted($survey_id){
			$ip_address = $_SERVER['REMOTE_ADDR'];
			$query = "select * from votes where vote_ip_address = '{$ip_address}' and vote_survey_number = '{$survey_id}' ";
		  	if($result = mysqli_query($this->conn, $query)){
		    	if(mysqli_num_rows($result) > 0){
		      		return true;
			    }
			    return false;
		  	}else {
		  		return null;
		    	die("error22>> ". mysqli_error($conn));
			}
		}
		function saveColors($colors){
			$survey_no = $colors['access_code'];
			$p_color = mysqli_real_escape_string($this->conn, $colors['p_color']); 
			$s_color = mysqli_real_escape_string($this->conn, $colors['s_color']);
			$b_color = mysqli_real_escape_string($this->conn, $colors['b_color']);
			$p_color = str_replace('$', '#', $p_color);
			$s_color = str_replace('$', '#', $s_color);
			$b_color = str_replace('$', '#', $b_color);
			$query = "insert into survey_color(survey_no, p_color, s_color, b_color) values 
											('{$survey_no}', '{$p_color}', '{$s_color}', '{$b_color}')
											on duplicate key update 
											p_color = '{$p_color}', s_color = '{$s_color}', b_color = '{$b_color}' ";
			// TODO: CONTINUE HERE
		  	if($result = mysqli_query($this->conn, $query)){
			    return true;
		  	}else {
		  		
		    	print("error22>> ". mysqli_error($this->conn));
		    	die("\n >> ". $query);
		    	return false;
			}
		}
		function getColor($access_code){
			$query = "select * from survey_color where survey_no = '{$access_code}' ";
		    $survey_color = array();
		    $votequery = "";
		    if($result = mysqli_query($this->conn, $query)){
		      $colors= mysqli_fetch_assoc($result);
		      $survey_color['p_color'] = mysqli_real_escape_string($this->conn, $colors['p_color']);
		      $survey_color['s_color'] = mysqli_real_escape_string($this->conn, $colors['s_color']);
		      $survey_color['b_color'] = mysqli_real_escape_string($this->conn, $colors['b_color']);

		      return $survey_color;
		    }else {
		      die("error22>> ". mysqli_error($conn));
		    }
		}
		function getSurveyData($access_code){
			$query = "select * from surveys where survey_id = '{$access_code}' ";
		    $survey_data = array();
		    $votequery = "";
		    if($result = mysqli_query($this->conn, $query)){
		      $arrtitle = mysqli_fetch_assoc($result);
		      $survey_data['survey_id'] = mysqli_real_escape_string($this->conn, $arrtitle['survey_id']);
		      $survey_data['survey_title'] = $arrtitle['survey_title'];
		      $survey_data['start_date'] = $arrtitle['start_date'];
		      $survey_data['start_time'] = $arrtitle['start_time'];
		      $survey_data['end_date'] = $arrtitle['end_date'];
		      $survey_data['end_time'] = $arrtitle['end_time'];
		      $survey_data['uploader'] = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $arrtitle['user_number'] ? true: false;
		      return $survey_data;
		    }else {
		      die("error22>> ". mysqli_error($conn));
		    }
		}
		function totalCount($option_arr_count_re){
			$total = 0;
			  	foreach ($option_arr_count_re as $k => $v) {
			    	$total += $v;
			   	}
			return $total;
		}
		function getConn(){
			return $this->conn;
		}
		function isLoggedIn($username, $password){
			$username = mysqli_real_escape_string($this->conn, $username);
			$password = mysqli_real_escape_string($this->conn, $password);
			$query = "select * from users where username = '{$username}'";
			if($result = mysqli_query($this->conn, $query)){
			    if(mysqli_num_rows($result) > 0){
			    	$arr = mysqli_fetch_assoc($result);
			    	if(password_verify($password, $arr['password'])){
			    		$_SESSION['logged_in'] = "true";
			    		$_SESSION['user_name'] = $arr['username'];
			    		$_SESSION['user_id'] = $arr['user_id'];
			    		return true;
			    		
			    	}else{

			    		$_SESSION['error_message'] = "Incorrect password or username";
			    		return false;
			    		
			    	}
			    }else{
			    	$_SESSION['error_message'] = "Invalid Username";
			    	return false;
			    }
			}else{
				echo "failed". mysqli_error($this->conn);
			}
		}
		function getRecentPolls($page){
			$voteList = array();
			$query = "select * from surveys where user_number = ".$_SESSION['user_id'] . " order by survey_id desc limit ".(10*$page).", 10";
			if($result = mysqli_query($this->conn, $query)){
			 	while($arr = mysqli_fetch_assoc($result)){
			 		$vote = array();
			 		$vote['survey_accesscode'] = $arr['survey_id'];
			 		$vote['survey_title'] = $arr['survey_title'];

			 		$voteList[] = $vote;
			 	}
			 	return $voteList;
			}else{
				$_SESSION['error_message'] = "Error fetching post ".mysqli_error($this->conn);
				return null;
			}
		}
		function getActivePolls($user_id){
			date_default_timezone_set("Africa/Lagos");
		  	$current_date = getdate();
		  	$formatted_date = $current_date['year'] . "-";
			$formatted_date .= $current_date['mon'] . "-";
			$formatted_date .= $current_date['mday'] . "";
			// $formatted_date .= $current_date['hours'] . ":";
			// $formatted_date .= $current_date['minutes'] . ":";
			// $formatted_date .= $current_date['seconds'];
			$voteList = array();
			$query = "select * from surveys where now() > concat(start_date , ' ' , start_time)  and now() < concat(end_date , ' ', end_time) order by concat(end_date , ' ', end_time) asc limit 10";
			if($result = mysqli_query($this->conn, $query)){
			 	while($arr = mysqli_fetch_assoc($result)){
			 		$vote = array();
			 		$vote['survey_accesscode'] = $arr['survey_id'];
			 		$vote['survey_title'] = $arr['survey_title'];

			 		$voteList[] = $vote;
			 	}
			 	return $voteList;
			}else{
				$_SESSION['error_message'] = "Error fetching post ".mysqli_error($this->conn);
				return null;
			}
		}
		function getSearchResult($s){
			$voteList = array();
			$query = "select * from surveys where survey_title like '%{$s}%' or survey_accesscode like '%{$s}%' order by survey_id desc";
			if($result = mysqli_query($this->conn, $query)){
			 	while($arr = mysqli_fetch_assoc($result)){
			 		$vote = array();
			 		$vote['survey_accesscode'] = $arr['survey_id'];
			 		$vote['survey_title'] = $arr['survey_title'];

			 		$voteList[] = $vote;
			 	}
			 	return $voteList;
			}else{
				$_SESSION['error_message'] = "Error fetching post ".mysqli_error($this->conn);
				return null;
			}
		}
		function getLivePolls($access_code){
			$query = "select * from questions where survey_no = '{$access_code}' ";
			if($result = mysqli_query($this->conn, $query)){				
			  while ($arr = mysqli_fetch_assoc($result)) {
			    $question_re[] = $arr['question_message'];
			    $question_number_re[] = $arr['question_id'];
			  }
			  if( count($question_number_re) > 0){
			    foreach ($question_number_re as $key => $value) {
			      $q = $value;
			      $ops = array();
			      $option_img = array();
			      $count = array();
			      $query = "select * from options where question_number = '{$q}' ";
			      if($result = mysqli_query($this->conn, $query)){
			        while ($arr = mysqli_fetch_assoc($result)) {
			          $ops[] = $arr['option_value'];
			          $ops_id = $arr['option_id'];
			          $count[]= $arr['option_select_count'];

			            $qry = "select image_option_url from image_option where image_option_number = '{$ops_id}' ";
			            if($re = mysqli_query($this->conn, $qry)){
			              if(mysqli_num_rows($re) == 1){
			                while ($ar = mysqli_fetch_assoc($re)) {
			                  $option_img[] = $ar['image_option_url'];
			                }
			              }elseif(mysqli_num_rows($re) == 0){
			                $option_img[] ='';
			              }else{
			                echo $_SESSION['error_message'] = "error>> more than a record ". mysqli_num_rows($re);
							return null;
			              }
			            }else {
			              $_SESSION['error_message'] = "error>>  ". mysqli_error($this->conn);
						  return null;
			            }
			        }
			      }else {
			        echo $_SESSION['error_message'] = "error>>  ". mysqli_error($this->conn);
					return null;
			      }
			      $option_arr_re[] = $ops;
			      $option_arr_img_re[] = $option_img;
			      $option_arr_count_re[] = $count;
			    }
			  }else{
			    echo $_SESSION['error_message'] = "error>>  ". mysqli_error($this->conn);
				return null;
			  }
			}else {
				echo $_SESSION['error_message'] = "error>> ". mysqli_error($this->conn);
				return null;
			}
			return $option_arr_count_re;
		}
	}
 ?>