<?php

function connect_to_database(){
	global $db_host;
	global $db_name;
	global $db_user;
	global $db_pass;
	
	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($db_name, $link);
	
	return $link;
}

function query($query){
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	return $result;
}

function display($output){
	include("header.php");
	echo $output;
	include("footer.php");
	exit;
}

function get_category_options($selected = null){
	if (!is_array($selected)) $selected = array($selected);
	
	$output = '<option value="0"';
	if (in_array(0,$selected)) $output .= ' selected="selected"';
	$output .= '>Top Level</option>';
	$output .= get_options_children(0, '', $selected);
	
	return $output;
}

function get_options_children($id, $pre = "", $selected = 0){
	$query = "SELECT * FROM `anyInventory_categories` WHERE `parent`='".$id."' ORDER BY `name` ASC";
	$result = query($query);
	
	if ($id != 0){
		$newquery = "SELECT `name` FROM `anyInventory_categories` WHERE `id`='".$id."'";
		$newresult = query($newquery);
		$category_name = mysql_result($newresult, 0, 'name');
		$pre .= $category_name . ' > ';
	}
	
	$list = '';
	
	if (mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)){
			$category = $row["name"];
			
			$list .= '<option value="'.$row["id"].'"';
			if (in_array($row["id"],$selected)) $list .= ' selected="selected"';
			$list .= '>'.$pre . $category.'</option>';
			
			$list .= get_options_children($row["id"], $pre, $selected);
		}
	}
	
	return $list;
}

function get_fields_checkbox_area($checked = array()){
	$query = "SELECT * FROM `anyInventory_fields` WHERE 1 ORDER BY `name` ASC";
	$result = query($query);
	
	$num_fields = mysql_num_rows($result);
	
	$output .= '<div id="field_checkboxes">
		<div style="float: left;">';
	
	for ($i = 0; $i < ceil($num_fields / 2); $i++){
		$output .= '<div class="checkbox"><input type="checkbox" name="fields['.mysql_result($result, $i, "id").']" value="yes" ';
		if ((is_array($checked)) && (in_array(mysql_result($result, $i, "id"), $checked))) $output .= ' checked="checked"';
		$output .= ' /> '.mysql_result($result, $i, "name").'</div>';
	}
	
	$output .= '</div>
		<div>';
	
	for (; $i < $num_fields; $i++){
		$output .= '<div class="checkbox"><input type="checkbox" name="fields['.mysql_result($result, $i, "id").']" value="yes" ';
		if ((is_array($checked)) && (in_array(mysql_result($result, $i, "id"), $checked))) $output .= ' checked="checked"';
		$output .= '/> '.mysql_result($result, $i, "name").'</div>';	
	}
	
	$output .= '</div>';
	
	return $output;
}

function get_category_array($top = 0){
	$array = array();
	
	get_array_children($top, $array);
	
	return $array;
}

function get_array_children($id, &$array, $pre = ""){
	$query = "SELECT `name`,`id` FROM `anyInventory_categories` WHERE `parent`='".$id."' ORDER BY `name` ASC";
	$result = query($query);
	
	if ($id != 0){
		$newquery = "SELECT `name` FROM `anyInventory_categories` WHERE `id`='".$id."'";
		$newresult = query($newquery);
		$pre .= mysql_result($newresult, 0, 'name') . ' > ';
	}
	
	if (mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)){
			$array[] = array("name"=>$pre.$row["name"],"id"=>$row["id"]);
			
			get_array_children($row["id"], $array, $pre);
		}
	}
}

function delete_subcategories($category){
	if (is_array($category->children)){
		foreach($category->children as $child){
			delete_subcategory($child);
		}
	}
	
	return;
}

function delete_subcategory($category){
	if (is_array($category->children)){
		foreach($category->children as $child){
			delete_subcategories($child);
		}
	}
	
	$query = "DELETE FROM `anyInventory_items` WHERE `item_category`='".$category->id."'";
	$result = query($query);
	
	$query = "UPDATE `anyInventory_categories` SET `parent`='".$category->parent_id."' WHERE `parent`='".$category->id."'";
	$result = query($query);
	
	$query = "DELETE FROM `anyInventory_categories` WHERE `id`='".$category->id."'";
	$result = query($query);
	
	remove_from_fields($category->id);
	
	return;
}

function remove_from_fields($cat_id){
	$query = "SELECT `id` FROM `anyInventory_fields` WHERE `categories` LIKE '%".$cat_id.",%'";
	$result = query($query);
	
	while($row = mysql_fetch_array($result)){
		$field = new field($row["id"]);
		$field->remove_category($cat_id);
	}
	
	return;
}

function get_mysql_column_type($input_type, $size, $values, $default_value){
	switch($input_type){
		case 'text':
		case 'multiple':
		case 'checkbox':
			if ($size < 256){
				$type = " VARCHAR(".$size.") DEFAULT '".$default_value."' ";
			}
			else{
				$type = " TEXT ";
			}
			break;
		case 'radio':
		case 'select':
			$type = " ENUM(";
			
			$enums = explode(",",$values);
					
			foreach($enums as $enum){
				$type .= "'".trim(str_replace("'","",str_replace('"','',$enum)))."',";
			}
			
			$type = substr($type, 0, strlen($type) - 1);
			
			$type .= ") DEFAULT '".$default_value."' ";
			break;
	}
	
	$type .= " NOT NULL";
	
	return $type;
}

function add_photo($id, $picture){
	// This function associates an uploaded photo with a profile.
	// It has no return value.

	global $photo_dir;
	global $mime_to_ext;
	
	// Check that the file was uploaded and of an appropriate mime type.
	if (is_uploaded_file($picture["tmp_name"]) && (isset($mime_to_ext[$picture["type"]]))){
		$query = "SELECT `photo_name` FROM `umsec_people` WHERE `id`='".$id."'";
		$result = run_query($query);
		
		if (mysql_num_rows($result)){
			$photo_name = mysql_result($result, 0, 'photo_name');
		
			if (is_file($photo_dir.$photo_name)){
				@unlink($photo_dir.$photo_name);
				@unlink($photo_dir."thumb_".$photo_name);
			}
		}
		
		$name = 'profile_' . $id;
		
		if ($mime_to_ext[$picture["type"]] == "gif"){
			$image = imagecreatefromgif($picture["tmp_name"]);
			$name .= '.png';
			imagepng($image, $photo_dir.$name);
			imagedestroy($image);
		}
		else{
			$name .= '.' .$mime_to_ext[$picture["type"]];
			
			// Copy the uploaded picture.
			if (!copy($picture["tmp_name"], $photo_dir.$name)){
				echo 'Could not upload photo.';
				exit;
			}
		}
		
		// resize_image($name, 400, 600);
		
		// Make a thumbnail image of this picture.
		make_thumbnail($name);
		
		// Update the database information to have the name of the new picture.		
		$query = "UPDATE `umsec_people` SET `photo_name`='".$name."' WHERE `id`='".$id."'";
		$result = run_query($query);
	}
}

function make_thumbnail($photo_name){
	global $images_dir;
	
	if (is_file($images_dir."thumb_".$photo_name)) @unlink($images_dir."thumb_".$photo_name);
	
	$thumb_width = 120;
	$thumb_height = 120;
	
	$image_info = getimagesize($images_dir.$photo_name);
	
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
		
		$new_thumb = imagecreatetruecolor($new_image_width, $new_image_height);
		
		$x_start_point = round(($thumb_width - $new_image_width) / 2);
		$y_start_point = round(($thumb_height - $new_image_height) / 2);
		
		switch($image_info[2]){
			case 2:
				// JPG
				$image = imagecreatefromjpeg($images_dir.$photo_name);
				
				imagecopyresampled($new_thumb, $image, 0, 0, 0, 0, $new_image_width, $new_image_height, $image_width, $image_height);
				imagejpeg($new_thumb, $images_dir."thumb_".$photo_name, 75);
				
				break;
			case 3:
				// PNG
				$image = imagecreatefrompng($images_dir.$photo_name);
				imagecopyresampled($new_thumb, $image, 0, 0, 0, 0, $new_image_width, $new_image_height, $image_width, $image_height);
				imagepng($new_thumb, $images_dir."thumb_".$photo_name);
				break;
		}
		
		imagedestroy($image);
		imagedestroy($new_thumb);
	}
	else{
		copy($images_dir.$photo_name, $photo_dir."thumb_".$photo_name);
	}
	
	return;
}


?>