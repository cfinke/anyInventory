<?php

include("globals.php");
include("remote_functions.php");

if ($_REQUEST["action"] == "do_add"){
	// Add an item
	
	// Create an object of the current category
	$category = new category($_REQUEST["c"]);
	
	// Put the query together
	$query = "INSERT INTO `anyInventory_items` (";
	
	if (is_array($category->field_ids)){
		foreach($category->field_ids as $field_id){
			$field = new field($field_id);
			
			if ($field->input_type != 'file'){
				$query .= "`".str_replace("_"," ",$field->name)."`, ";
			}
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
			elseif($field->input_type == "file"){
				continue;
			}
			else{
				$query .= "'".$_REQUEST[str_replace(" ","_",$field->name)]."', ";
			}
		}
	}
	
	$query .= " '".$_REQUEST["c"]."','".$_REQUEST["name"]."')";
	mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	// Get the id of the item
	$key = mysql_insert_id();
	
	if (is_array($category->field_ids)){
		foreach($category->field_ids as $field_id){
			$field = new field($field_id);
			
			if ($field->input_type == 'file'){
				if ($_REQUEST[str_replace(" ","_",$field->name)."remote"] != 'http://'){
					// Determine what to do - is the remote file an image?
					// $_REQUEST[str_replace(" ","_",$field->name)."remote"]  = remote filename
					$remote_url = $_REQUEST[str_replace(" ","_",$field->name)."remote"];
					if (url_is_type($remote_url,array("image/jpeg", "image/jpg", "image/png"))) {
						// Remote URL is an image; download it and add it as a local image

						// Make the correct extension
						$remote_headers = url_headers($remote_url);
						$remote_content_type = $remote_headers["content-type"]; // image/xyz
						$extension = explode("/",$remote_content_type);         // extension[1] = xyz
						$parsed_url = parse_url($remote_url);
						
						// Find a filename
						$i = 1;
						do {
							$filename = $key.".".$i++.".".$parsed_url["host"].str_replace(array("/"," "),"_",$parsed_url["path"]).".".$extension[1];
						} while (is_file(realpath($DIR_PREFIX."item_files/")."/".$filename));

						// Copy file
						if(!curl_copy($remote_url, realpath($DIR_PREFIX."item_files/")."/".$filename)){
							die("Could not download/store remote file.");
						}

						// Update DB
						$query = "INSERT INTO `anyInventory_files` 
							(`key`,
							 `file_name`,
							 `file_size`,
							 `file_type`)
							VALUES
							('".$key."',
							 '".$filename."',
							 '".filesize(realpath($DIR_PREFIX."item_files/")."/".$filename)."',
							 '".$remote_content_type."')";
						//query($query);
						mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
						$new_key = mysql_insert_id();
						$query = "UPDATE `anyInventory_items` SET `".str_replace("_"," ",$field->name)."`='".$new_key."' WHERE `id`='".$key."'";
						//query($query);
						mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
					} else {
					// Remote URL is not an image; add it as a remote file
					$query = "INSERT INTO `anyInventory_files` 
								(`key`,
								 `offsite_link`)
								VALUES
								('".$key."',
								 '".$_REQUEST[str_replace(" ","_",$field->name)."remote"]."')";
					mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
					
					$new_key = mysql_insert_id();
					
					$query = "UPDATE `anyInventory_items` SET `".str_replace("_"," ",$field->name)."`='".$new_key."' WHERE `id`='".$key."'";
					mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
					}
				}
				elseif(is_uploaded_file($_FILES[str_replace(" ","_",$field->name)]["tmp_name"])){
					// Copy the uploaded file
					
					$i = 1;
					
					// Find a filename
					do {
						$filename = $key.".".$i++.".".$_FILES[str_replace(" ","_",$field->name)]["name"];
					} while (is_file(realpath($DIR_PREFIX."item_files/")."/".$filename));
					
					if(!copy($_FILES[str_replace(" ","_",$field->name)]["tmp_name"], realpath($DIR_PREFIX."item_files/")."/".$filename)){
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
							 '".$_FILES[str_replace(" ","_",$field->name)]["size"]."',
							 '".$_FILES[str_replace(" ","_",$field->name)]["type"]."')";
					//query($query);
					mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
					
					$new_key = mysql_insert_id();
					
					$query = "UPDATE `anyInventory_items` SET `".str_replace("_"," ",$field->name)."`='".$new_key."' WHERE `id`='".$key."'";
					//query($query);
					mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
				}
			}
		}
	}
}
elseif($_REQUEST["action"] == "do_edit"){
	// Create an object of the old item
	$item = new item($_REQUEST["id"]);
	
	// Put the query together
	$query = "UPDATE `anyInventory_items` SET ";
	
	if (is_array($item->category->field_ids)){
		foreach($item->category->field_ids as $field_id){
			$field = new field($field_id);
			
			if ($field->input_type == 'file'){
				$file = new file_object($item->fields[$field->name]);
				
				// Check if the delete file box was checked	
				if (is_array($_REQUEST["delete_files"]) && (in_array($file->id, $_REQUEST["delete_files"]))){
					// If so, delete the file first (and erase the value from the item entry).
					if (!$file->is_remote){
						unlink($file->server_path);
					}
					
					$delquery = "DELETE FROM `anyInventory_files` WHERE `id`='".$file->id["file_id"]."'";
					mysql_query($delquery) or die(mysql_error() . '<br /><br />'. $delquery);
					
					$remquery = "UPDATE `anyInventory_items` SET `".$field->name."`='0' WHERE `id`='".$item->id."'";
					mysql_query($remquery) or die(mysql_error() . '<br /><br />'. $remquery);
				}
				
				// Check if a file was uploaded in its place
				
				if (is_uploaded_file($_FILES[str_replace(" ","_",$field->name)]["tmp_name"])){
					if (!$file->is_remote){
						if (is_file($file->server_path)){
							unlink($file->server_path);
						}
						
						$delquery = "DELETE FROM `anyInventory_files` WHERE `id`='".$file->id."'";
						mysql_query($delquery) or die(mysql_error() . '<br /><br />'. $delquery);
					}
					
					// Copy the uploaded file
					
					$i = 1;
					
					// Find a filename
					do {
						$filename = $item->id.".".$i++.".".$_FILES[str_replace(" ","_",$field->name)]["name"];
					} while (is_file(realpath($DIR_PREFIX."item_files/")."/".$filename));
					
					if(!copy($_FILES[str_replace(" ","_",$field->name)]["tmp_name"], realpath($DIR_PREFIX."item_files/")."/".$filename)){
						echo 'Could not copy uploaded file.';
						exit;
					}
					
					$newquery = "INSERT INTO `anyInventory_files` 
							(`key`,
							 `file_name`,
							 `file_size`,
							 `file_type`)
							VALUES
							('".$item->id."',
							 '".$filename."',
							 '".$_FILES[str_replace(" ","_",$field->name)]["size"]."',
							 '".$_FILES[str_replace(" ","_",$field->name)]["type"]."')";
					mysql_query($newquery) or die(mysql_error() . '<br /><br />'. $newquery);
					
					$new_key = mysql_insert_id();
					
					$query .= " `".$field->name."`='".$new_key."', ";
				}
				// If not, check for a remote file.
				elseif($_REQUEST[str_replace(" ","_",$field->name)."remote"] != 'http://'){
					if (!$file->is_remote){
						if (is_file($file->server_path)){
							unlink($file->server_path);
						}
						
						$delquery = "DELETE FROM `anyInventory_files` WHERE `id`='".$file->id."'";
						//query($delquery);
						mysql_query($delquery) or die(mysql_error() . '<br /><br />'. $delquery);
					}
					
					// START new remote file upload ///////////////////////////////////////////////
					// Determine what to do - is the remote file an image?
					// $_REQUEST[str_replace(" ","_",$field->name)."remote"]  = remote filename
					$remote_url = $_REQUEST[str_replace(" ","_",$field->name)."remote"];
					if (url_is_type($remote_url,array("image/jpeg", "image/jpg", "image/png"))) {
						// Remote URL is an image; download it and add it as a local image

						// Make the correct extension
						$remote_headers = url_headers($remote_url);
						$remote_content_type = $remote_headers["content-type"]; // image/xyz
						$extension = explode("/",$remote_content_type);         // extension[1] = xyz
						$parsed_url = parse_url($remote_url);
						
						// Find a filename
						$i = 1;
						do {
							$filename = $key.".".$i++.".".$parsed_url["host"].str_replace(array("/"," "),"_",$parsed_url["path"]).".".$extension[1];
						} while (is_file(realpath($DIR_PREFIX."item_files/")."/".$filename));

						// Copy file
						if(!curl_copy($remote_url, realpath($DIR_PREFIX."item_files/")."/".$filename)){
							die("Could not download/store remote file.");
						}

						// Update DB
						$newquery = "INSERT INTO `anyInventory_files` 
							(`key`,
							 `file_name`,
							 `file_size`,
							 `file_type`)
							VALUES
							('".$key."',
							 '".$filename."',
							 '".filesize(realpath($DIR_PREFIX."item_files/")."/".$filename)."',
							 '".$remote_content_type."')";
						//query($newquery);
						mysql_query($newquery) or die(mysql_error() . '<br /><br />'. $newquery);
						$new_key = mysql_insert_id();
						$query .= " `".$field->name."`='".$new_key."', ";
					} else {
					// Remote URL is not an image; add it as a remote file
					$newquery = "INSERT INTO `anyInventory_files` 
								(`key`,
								 `offsite_link`)
								VALUES
								('".$key."',
								 '".$_REQUEST[str_replace(" ","_",$field->name)."remote"]."')";
					//query($newquery);
					mysql_query($newquery) or die(mysql_error() . '<br /><br />'. $newquery);
					
					$new_key = mysql_insert_id();
					$query .= " `".$field->name."`='".$new_key."', ";
					}
					// END new remote file upload /////////////////////////////////////////////////
				}
			}
			else{
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
	}
	
	$query .= " `name`='".$_REQUEST["name"]."' WHERE `id`='".$_REQUEST["id"]."'";
	mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
}
elseif($_REQUEST["action"] == "do_move"){
	// Move an item.
	
	$query = "UPDATE `anyInventory_items` SET `item_category`='".$_REQUEST["c"]."' WHERE `id`='".$_REQUEST["id"]."'";
	mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
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
						mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
					}
					else{
						echo "Could not delete ".$file->file_name.'<br />';
						exit;
					}
				}
				else{
					$query = "DELETE FROM `anyInventory_files` WHERE `id`='".$file->id."'";
					mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
				}
			}
		}
		
		// Remove this item from any alerts
		
		$query = "SELECT `id` FROM `anyInventory_alerts` WHERE `item_ids` LIKE '%\"".$item->id."\"%'";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
		
		while ($row = mysql_fetch_array($result)){
			$alert = new alert($row["id"]);
			
			$alert->remove_item($item->id);
			
			if (count($alert->item_ids) == 0){
				$query = "DELETE FROM `anyInventory_alerts` WHERE `id`='".$alert->id."'";
				mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
			}
		}
		
		$query = "DELETE FROM `anyInventory_items` WHERE `id`='".$item->id."'";
		mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	}
}

header("Location: items.php");

?>