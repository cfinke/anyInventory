<?php

class file_object{
	var $id;
	var $item_id;
	
	var $file_name;
	var $file_type;
	var $file_size;
	
	var $web_path;
	var $server_path;
	
	function file_object($id){
		global $files_dir;
		
		$this->id = $id;
		
		$query = "SELECT * FROM `anyInventory_files` WHERE `id`='".$this->id."'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		
		$this->item_id = $row["key"];
		
		$this->file_name = $row["file_name"];
		$this->file_size = $row["file_size"];
		$this->file_type = $row["file_type"];
		
		$this->web_path = "item_files/".$this->file_name;
		$this->server_path = $files_dir.$this->file_name;
	}
	
	function get_download_link(){
		$link = '<a href="'.$this->web_path.'">'.$this->file_name.' ('.$this->file_type.', '.round($this->file_size / 1000).' KB)</a>';
		
		return $link;
	}
	
	function output_thumbnail(){
		global $files_dir;
		
		$thumb_width = 120;
		$thumb_height = 120;
		
		$image_info = getimagesize($this->server_path);
		
		$image_width = $image_info[0];
		$image_height = $image_info[1];
		
		if (($image_width > $thumb_width) || ($image_height > $thumb_height)){
			if (($image_width / $thumb_width) > ($image_height > $thumb_width)){
				$ratio = $thumb_height / $image_height;
			}
			else{
				$ratio = $thumb_width / $image_width;
			}
			
			$new_image_width = round($ratio * $image_width);
			$new_image_height = round($ratio * $image_height);
			
			switch($image_info[2]){
				case 2:
					// JPG
					$thumb = imagecreatetruecolor($new_image_width, $new_image_height);
					$image = imagecreatefromjpeg($this->server_path);
					imagecopyresampled($thumb, $image, 0, 0, 0, 0, $new_image_width, $new_image_height, $image_width, $image_height);
					imagedestroy($image);
					break;
				case 3:
					// PNG
					$thumb = imagecreatetruecolor($new_image_width, $new_image_height);
					$image = imagecreatefrompng($this->server_path);
					imagecopyresampled($thumb, $image, 0, 0, 0, 0, $new_image_width, $new_image_height, $image_width, $image_height);
					imagedestroy($image);
					break;
				default:
					// Unsupported
					$thumb = imagecreatefromgif($files_dir."no_thumb.gif");
					break;
			}
		}
		else{
			switch($image_info[2]){
				case 2:
					// JPG
					$thumb = imagecreatefromjpeg($this->server_path);
					break;
				case 3:
					// PNG
					$thumb = imagecreatefrompng($this->server_path);
					break;
				default:
					// Unsupported
					$thumb = imagecreatefromgif($files_dir."no_thumb.gif");
					break;
			}
		}
		
		// Output the new image.
		header("Content-type: image/jpeg");
		imagejpeg($thumb, '', 100);
		
		// Destroy the new image.
		imagedestroy($thumb);
		exit;
	}
	
	function has_thumbnail(){
		$supported_types = array("image/jpg","image/jpeg","image/png","image/pjpg","image/pjpeg","image/gif","image/bmp");
		
		if (in_array($this->file_type, $supported_types)) return true;
		else return false;
	}
}

?>