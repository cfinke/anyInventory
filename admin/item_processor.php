<?php

include("globals.php");

if ($_REQUEST["action"] == "do_add"){
	// Add an item
	
	// Create an object of the current category
	$category = new category($_REQUEST["c"]);
	
	// Put the query together
	$query = "INSERT INTO `anyInventory_items` (";
	
	if (is_array($category->field_ids)){
		foreach($category->field_ids as $field_id){
			$field = new field($field_id);
			
			$query .= "`".str_replace("_"," ",$field->name)."`, ";
		}
	}
	
	$query .= " `item_category`,`name`) VALUES (";
	
	if (is_array($category->field_ids)){
		foreach($category->field_ids as $field_id){
			$field = new field($field_id);
			
			if ($field->input_type == "multiple"){
				if ($_REQUEST[str_replace(" ","_",$field->name)."_text"] == ""){
					$query .= "'".$_REQUEST[str_replace(" ","_",$field->name)."_select"]."', ";
				}
				else{
					$query .= "'".$_REQUEST[str_replace(" ","_",$field->name)."_text"]."', ";
				}
			}
			elseif($field->input_type == "checkbox"){
				if (is_array($_REQUEST[str_replace(" ","_",$field->name)])){
					foreach($_REQUEST[str_replace(" ","_",$field->name)] as $key => $val){
						$string .= $key.", ";
					}
					
					$_REQUEST[str_replace(" ","_",$field->name)] = substr($string,0,strlen($string) - 2);
					$query .= "'".$_REQUEST[str_replace(" ","_",$field->name)]."', ";
				}
				else{
					$query .= "'', ";
				}
			}
			else{
				$query .= "'".$_REQUEST[str_replace(" ","_",$field->name)]."', ";
			}
		}
	}
	
	$query .= " '".$_REQUEST["c"]."','".$_REQUEST["name"]."')";
	$result = query($query);
	
	// Get the id of the item
	$key = mysql_insert_id();
	
	if (is_uploaded_file($_FILES["file"]["tmp_name"])){
		// Copy the uploaded file
		
		$i = 1;
		
		// Find a filename
		do {
			$filename = $key.".".$i++.".".$_FILES["file"]["name"];
		} while (is_file(realpath($DIR_PREFIX."item_files/")."/".$filename));
		
		if(!copy($_FILES["file"]["tmp_name"], realpath($DIR_PREFIX."item_files/")."/".$filename)){
			echo 'Could not copy uploaded file.';
			exit;
		}
		
		$query = "INSERT INTO `anyInventory_files` 
				(`key`,
				 `file_name`,
				 `file_size`,
				 `file_type`)
				VALUES
				('".$key."',
				 '".$filename."',
				 '".$_FILES["file"]["size"]."',
				 '".$_FILES["file"]["type"]."')";
		query($query);
	}
	
	if ($_REQUEST["remote_file"] != ''){
		$query = "INSERT INTO `anyInventory_files` 
				(`key`,
				 `offsite_link`)
				VALUES
				('".$key."',
				 '".$_REQUEST["remote_file"]."')";
		query($query);
	}
}
elseif($_REQUEST["action"] == "do_edit"){
	// Edit an item
	
	// Create an object of the current category
	$category = new category($_REQUEST["c"]);
	
	// Put the query together
	$query = "UPDATE `anyInventory_items` SET ";
	
	if (is_array($category->field_ids)){
		foreach($category->field_ids as $field_id){
			$field = new field($field_id);
			
			$query .= "`".str_replace("_"," ",$field->name)."`= ";
			
			if ($field->input_type == "multiple"){
				if ($_REQUEST[str_replace(" ","_",$field->name)."_text"] == ""){
					$query .= "'".$_REQUEST[str_replace(" ","_",$field->name)."_select"]."', ";
				}
				else{
					$query .= "'".$_REQUEST[str_replace(" ","_",$field->name)."_text"]."', ";
				}
			}
			elseif($field->input_type == "checkbox"){
				if (is_array($_REQUEST[str_replace(" ","_",$field->name)])){
					foreach($_REQUEST[str_replace(" ","_",$field->name)] as $key => $val){
						$string .= $key.", ";
					}
					
					$_REQUEST[str_replace(" ","_",$field->name)] = substr($string,0,strlen($string) - 2);
					$query .= "'".$_REQUEST[str_replace(" ","_",$field->name)]."', ";
				}
				else{
					$query .= "'', ";
				}
			}
			else{
				$query .= "'".$_REQUEST[str_replace(" ","_",$field->name)]."', ";
			}
		}
	}
	
	$query .= " `name`='".$_REQUEST["name"]."' WHERE `id`='".$_REQUEST["id"]."'";
	$result = query($query);
	
	if (is_array($_REQUEST["delete_files"])){
		// Delete any checked files
		
		foreach($_REQUEST["delete_files"] as $file_id){
			$query = "SELECT * FROM `anyInventory_files` WHERE `id`='".$file_id."'";
			$result = query($query);
			$row = mysql_fetch_array($result);
			
			if (($row["offsite_link"] == '') && (!unlink(realpath($DIR_PREFIX."item_files/")."/".$row["file_name"]))){
				echo "Could not delete ".$row["file_name"].'<br />';
				exit;
			}
			
			$query = "DELETE FROM `anyInventory_files` WHERE `id`='".$file_id."'";
			$result = query($query);
		}
	}
	
	$key = $_REQUEST["id"];
	
	if (is_uploaded_file($_FILES["file"]["tmp_name"])){
		// Copy any uploaded files
		
		$i = 1;
		
		do {
			$filename = $key.".".$i++.".".$_FILES["file"]["name"];
		} while (is_file(realpath($DIR_PREFIX."item_files/")."/".$filename));
		
		if(!copy($_FILES["file"]["tmp_name"], realpath($DIR_PREFIX."item_files/")."/".$filename)){
			echo 'Could not copy uploaded file.';
			exit;
		}
		
		$query = "INSERT INTO `anyInventory_files` 
				(`key`,
				 `file_name`,
				 `file_size`,
				 `file_type`)
				VALUES
				('".$_REQUEST["id"]."',
				 '".$filename."',
				 '".$_FILES["file"]["size"]."',
				 '".$_FILES["file"]["type"]."')";
		$result = query($query);
	}
	
	if ($_REQUEST["remote_file"] != ''){
		$query = "INSERT INTO `anyInventory_files` 
				(`key`,
				 `offsite_link`)
				VALUES
				('".$key."',
				 '".$_REQUEST["remote_file"]."')";
		query($query);
	}
}
elseif($_REQUEST["action"] == "do_move"){
	// Move an item.
	
	$query = "UPDATE `anyInventory_items` SET `item_category`='".$_REQUEST["c"]."' WHERE `id`='".$_REQUEST["id"]."'";
	$result = query($query);
}
elseif($_REQUEST["action"] == "do_delete"){
	// Delete an item
	
	if ($_REQUEST["delete"] == "Delete"){
		$item = new item($_REQUEST["id"]);
		
		if (is_array($item->files)){
			foreach($item->files as $file){
				if (!$file->is_remote){
					if (unlink(realpath($DIR_PREFIX."item_files/")."/".$file->file_name)){
						$query = "DELETE FROM `anyInventory_files` WHERE `id`='".$file->id."'";
						query($query);
					}
					else{
						echo "Could not delete ".$file->file_name.'<br />';
						exit;
					}
				}
				else{
					$query = "DELETE FROM `anyInventory_files` WHERE `id`='".$file->id."'";
					query($query);
				}
			}
		}
		
		// Remove this item from any alerts
		
		$query = "SELECT * FROM `anyInventory_alerts` WHERE `item_ids` LIKE '%\"".$item->id."\"%'";
		$result = query($query);
		
		while ($row = mysql_fetch_array($result)){
			$alert = new alert($row["id"]);
			
			$alert->remove_item($item->id);
		}
		
		$query = "DELETE FROM `anyInventory_items` WHERE `id`='".$item->id."'";
		$result = query($query);
	}
}

header("Location: items.php");

?>