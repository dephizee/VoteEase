<?php 
	class Utils{
		var $conn;
		function Utils(){
		  	
		}

		public static function votingBlock($pollData=[]){
			$msg = ' "TODO: validate..." ';
			$output = "";
			$output .= '<div class="col-12 v_panel">';
    		$output .= '<div class="col-9 col-offset-3">';
			$output .= '<form method="post" action="./vote.php" onsubmit="'.'return check_vote()'.'">';
			foreach ($pollData['question'] as $key => $value) {
			$t = $key+1;
			$output .= "<div class='col-3 col-offset-1 question' style='padding:0; border-width: 0;'>";
			$output .= "<div class='col-12'>";
			$output .= $t." : ". $value;
			$output .= '<input type="hidden" name="question_number[]" value="'.$pollData['question_number'][$key].'">';
			$output .= "</div>";
			$output .= "<div class='col-12'>";
			$output .= "<select name='ans[]' class='selection col-12'>";
			$output .= '<option value="-1"> - - - </option>';
			for ($i=0; $i < count($pollData['option_arr_id'][$key]) ; $i++) { 
				$output .= '<option value="'. $pollData['option_arr_id'][$key][$i]. '">'. $pollData['option_arr_value'][$key][$i].'</option>';
			}
			$output .= "</select>";
			$output .= "</div>";
			$output .= "</div>";

			}
			$output .= '<input type="hidden" name="survey_id" value="'.$pollData['survey_data']['survey_id'].'">';
			$output .= '<button type="submit" name="sub" value="submit" class="mbutton col-9 col-offset-2" >Vote</button>';
			$output .= '</form>';
			$output .= '</div>';
			$output .= '</div>';
			return $output;
		}
		static function renderVotes($pollData =[]){
			$t = 0;
			$output = "";
			$total = $pollData['option_arr_count_total'];
	        foreach ($pollData['question'] as $key => $value) {

				$output .= "<div class='col-12 unit_container'>";
				$output .= '<div class="col-12 question_container" style="border-width:0px; font-size: 1.8em; text-align:center;">';
				$output .= $pollData['question'][$key];
				$output .= "</div>";
				  
				  /*$output .= '<img src="" >';
				  $output .= '<img src="" >';*/

				$c = count($pollData['option_arr_value'][$key]);
				//$temp = 12 /count($option_arr_re[$key]);

				//$temp = 'col-'.$temp;
				for ($i=0; $i < $c; $i++) {
				$output .= '<div class=" col-12 unit_item">';
				$tmp_img_url = $pollData['option_arr_img_url'][$key][$i];
				$no_image = ($tmp_img_url == '') ? 1 : 0;
				if($total[$key] != 0){
				  $t = round(($pollData['option_arr_count'][$key][$i]/$total[$key]) * 100, 1) ."%";
				  
				  
				  if($no_image){
				    $output .= '<div class="col-3" style="border-color:white;">'.$pollData['option_arr_value'][$key][$i].'</div>';
				    $output .= '<div class="col-2 votevalue" style="border-color:white;">'. $t .' ('.$pollData['option_arr_count'][$key][$i].') '.'</div>';
				    $output .= '<div class="col-7 votebar_containter" style="padding:0; border-width:0;border-color:white;">';
				    $output .= '<div class="col-12 votebar" style=" width:'.$t.';">'.'.'.'</div>';
				    $output .= '</div>';
				  }else{
				    $output .= '<div class="row" style="padding:0;">';
				    $output .= '<div class="col-3" style="padding:0;border-color:white;">';
				    $output .= '<div class="col-3" style="padding:0; border-width:0;">';
        			$output .= '<img src="'.'../thumbnail/'.$tmp_img_url.'" alt="image" class="col-12 imageclass" style="padding:0; border-width:1;" onclick="show_big(this)">';
				    $output .= '</div>';
				    $output .= '<div class="col-9" style="padding:0; border-width:0; font-size:1.2em;border-color:white;">';
				    $output .= $pollData['option_arr_value'][$key][$i];
				    $output .= '</div>';
				    $output .= '</div>';
				    $output .= '<div class="col-2 votevalue" style="border-color:white;">'. $t .' ('.$pollData['option_arr_count'][$key][$i].') '.'</div>';
				    $output .= '<div class="col-7 votebar_containter" style="padding:0; border-width:0;">';
				    $output .= '<div class="col- votebar" style="width:'.$t.';">'.'.'.'</div>';
				    $output .= '</div>';
				    $output .= '</div>';
				  }

				}else{
				  if($no_image){
				    $output .= '<div class="col-3" style="border-color:white;">'.$pollData['option_arr_value'][$key][$i].'</div>';
				    $output .= '<div class="col-2">No Vote Yet</div>';
				    $output .= '<div class="col-7 votebar_containter" style="padding:0; border-width:0;border-color:white;">';
				    $output .= '<div class="col-12 votebar" style=" width:'.$t.';">'.'.'.'</div>';
				    $output .= '</div>';
				  }else{
				    $output .= '<div class="row" style="padding:0;">';
				    $output .= '<div class="col-3" style="padding:0;border-color:white;">';
				    $output .= '<div class="col-3" style="padding:0; border-width:0;">';
    				$output .= '<img src="'.'../thumbnail/'.$tmp_img_url.'" alt="image" class="col-12 imageclass" style="padding:0; border-width:1;" onclick="show_big(this)">';
					$output .= '</div>';
					$output .= '<div class="col-9" style="padding:0; border-width:0; font-size:1.2em;border-color:white;">';
					$output .= $pollData['option_arr_value'][$key][$i];
					$output .= '</div>';
					$output .= '</div>';
					$output .= '<div class="col-2">No Vote Yet</div>';
					$output .= '<div class="col-7 votebar_containter" style="padding:0; border-width:0;">';
					$output .= '<div class="col- votebar" style=" width:'.$t.';">'.'.'.'</div>';
					$output .= '</div>';
				    $output .= '</div>';
			      }

			    }

			    $output .= "</div>";
			  }
			  $output .= "</div>";
			}
	        return $output;
		}
	}
