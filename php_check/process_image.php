<?php 
	session_start(); 
	$r = rand(0, 1000);
	$t = "./../photo_folder/".$_SESSION['user_name'];
	if(!file_exists($t)){
		mkdir($t);
	}else{
		//echo "already apc_exists";
	}
	
	$temp_loc = $t;
	$_FILES['file_key']['tmp_name'];
	$temp_loc .= '/'.$r.$_FILES['file_key']['name'];
	move_uploaded_file($_FILES['file_key']['tmp_name'], $temp_loc);
	$t = "./photo_folder/".$_SESSION['user_name'].'/'.$r.$_FILES['file_key']['name'];
	$s_add = '/'.$r.$_FILES['file_key']['name'];
	//echo $t;
	$s = './../thumbnail/photo_folder/'.$_SESSION['user_name'];
	$src_use = './thumbnail/photo_folder/'.$_SESSION['user_name'];
	if(!file_exists($s)){
		mkdir($s);
	}else{
		//echo "already apc_exists";
	}
	$s = $s.$s_add;
	$src_use = $src_use.$s_add;
	$type = $_FILES['file_key']['type'];
	genThumbnail($temp_loc, $s, $type);

	function genThumbnail($src, $loc, $type){
		if($type =='image/jpeg'){
			$data = imagecreatefromjpeg($src);
		}elseif($type =='image/png'){
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
	$image_data = array();
	$image_data['original'] = $t;
	$image_data['thumbnail'] = $src_use;
	echo json_encode($image_data);

 ?>