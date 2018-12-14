<?php 
	$v = './thumnail/000.jpg';
	echo file_exists($v);

	function genThumbnail($src){
		$data = imagecreatefromjpeg($src);
		$width = imagesx($data);
		$height = imagesy($data);
		$desired_height = 200;
		$desired_width = 200;

		$desired_height = floor($height * ($desired_width/ $width));
		$new_data = imagecreatetruecolor($desired_width, 200);
		$offsety = ($height - $width)/2;
		$offsetx = ($width - $height)/2;
		if($height > $width){
			imagecopyresampled($new_data, $data, 0, 0, 0, $offsety, $desired_width, 200, $width, $offsety+$width);
		}else{
			imagecopyresampled($new_data, $data, 0, 0, $offsetx, 0, 200, 200, $height+$offsetx, $height);
		}
		
		//imagecopyresampled(dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
		imagejpeg($new_data, './thumnail/thumbnail.jpg');
	}


	genThumbnail($v);
 ?>