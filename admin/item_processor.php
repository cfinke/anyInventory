<?php

include("globals.php");
include("remote_functions.php");

if ($_POST["action"] == "do_add"){
	if (!$admin_user->can_admin($_POST["c"])){
		header("Location: ../error_handler.php?eid=13");
		exit;
	}
	
	// Add an item
	
	// Create an object of the current category
	$category = new category($_POST["c"]);
	
	// Put the query together
	$query = "INSERT INTO `anyInventory_items` (`name`,`item_category`) VALUES ('".$_POST["name"]."','".$_POST["c"]."')";
	$result = mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />' . $query);
	
	$key = mysql_insert_id();
	
	if (is_array($category->field_ids)){
		foreach($category->field_ids as $field_id){
			$field = new field($field_id);
			
			if (($field->input_type != 'file') && ($field->input_type != 'divider')){
				$query = "INSERT INTO `anyInventory_values` (`item_id`,`field_id`,`value`) VALUES ('".$key."','".$field->id."','";
				
				if ($field->input_type == "multiple"){
					if ($_POST[str_replace(" ","_",$field->name)."_text"] == ""){
						$query .= $_POST[str_replace(" ","_",$field->name)."_select"];
					}
					else{
						$query .= $_POST[str_replace(" ","_",$field->name)."_text"];
					}
				}
				elseif($field->input_type == "checkbox"){
					if (is_array($_POST[str_replace(" ","_",$field->name)])){
						foreach($_POST[str_replace(" ","_",$field->name)] as $key => $val){
							$string .= $key.", ";
						}
						
						$_POST[str_replace(" ","_",$field->name)] = substr($string,0,strlen($string) - 2);
						$query .= $_POST[str_replace(" ","_",$field->name)];
					}
				}
				elseif($field->input_type == 'item'){
					if (is_array($_POST[str_replace(" ","_",$field->name)])){
						$query .= addslashes(serialize($_POST[str_replace(" ","_",$field->name)]));
					}
					else{
						$query .= addslashes(serialize(array()));
					}
				}
				else{
					$query .= $_POST[str_replace(" ","_",$field->name)];
				}
				
				$query .= "')";
				$result = mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />' . $query);
			}
		}
	}
	
	if (is_array($category->field_ids)){
		foreach($category->field_ids as $field_id){
			$field = new field($field_id);
			
			if ($field->input_type == 'file'){
				if ($_POST[str_replace(" ","_",$field->name)."remote"] != 'http://'){
					// Determine what to do - is the remote file an image?
					// $_POST[str_replace(" ","_",$field->name)."remote"]  = remote filename
					$remote_url = $_POST[str_replace(" ","_",$field->name)."remote"];
					if (extension_loaded('curl') && url_is_type($remote_url,array("image/jpeg", "image/jpg", "image/png"))) {
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
							$filename = '';
							$filesize = '';
							$filetype = '';
							$offsite_link = addslashes($remote_url);
						}
						else{
							$filesize = filesize(realpath($DIR_PREFIX."item_files/")."/".$filename);
							$filetype = $remote_content_type;
							$offsite_link = '';
						}
					}
					else {
						// Remote URL is not an image; add it as a remote file
						
						$filename = '';
						$filesize = '';
						$filetype = '';
						$offsite_link = $_POST[str_replace(" ","_",$field->name)."remote"];
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
					
					$filetype = $_FILES[str_replace(" ","_",$field->name)]["type"];
					$filesize = $_FILES[str_replace(" ","_",$field->name)]["size"];
					$offsite_link = '';
				}
				
				$query = "INSERT INTO `anyInventory_files`
							(`key`,`file_name`,`file_size`,`file_type`,`offsite_link`)
							VALUES
							('".$key."',
							 '".$filename."',
							 '".$filesize."',
							 '".$filetype."',
							 '".$offsite_link."')";
				$result = mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />' . $query);					
				
				$new_key = mysql_insert_id();
				
				$query = "INSERT INTO `anyInventory_values` (`item_id`,`field_id`,`value`) VALUES ('".$key."','".$field->id."','".$new_key."')";
				$result = mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />' . $query);
			}
		}
	}
}
elseif($_POST["action"] == "do_edit"){
	// Create an object of the old item
	$item = new item($_POST["id"]);
	
	if (!$admin_user->can_admin($item->category->id)){
		header("Location: ../error_handler.php?eid=13");
		exit;
	}
	
	// Put the query together
	$query = "UPDATE `anyInventory_items` SET `name`='".$_REQUEST["name"]."' WHERE `id`='".$item->id."'";
	$result = mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />' . $query);
	
	if (is_array($item->category->field_ids)){
		foreach($item->category->field_ids as $field_id){
			$field = new field($field_id);
			
			if ($field->input_type != 'divider'){
				if ($field->input_type == 'file'){
					$file = new file_object($item->fields[$field->name]["file_id"]);
					
					// Check if the delete file box was checked	
					if (is_array($_POST["delete_files"]) && (in_array($file->id, $_POST["delete_files"]))){
						// If so, delete the file first (and erase the value from the item entry).
						if (!$file->is_remote){
							unlink($file->server_path);
						}
						
						$delquery = "DELETE FROM `anyInventory_files` WHERE `id`='".$file->id["file_id"]."'";
						$delresult = mysql_query($delquery) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />' . $delquery);
						
						$remquery = "UPDATE `anyInventory_values` SET `value`='0' WHERE `field_id`='".$field->id."' AND `item_id`='".$item->id."'";
						$remresult = mysql_query($remquery) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />' . $remquery);
					}
					
					// Check if a file was uploaded in its place
					
					if (is_uploaded_file($_FILES[str_replace(" ","_",$field->name)]["tmp_name"])){
						$file_query = true;
						
						if (!$file->is_remote){
							if (is_file($file->server_path)){
								unlink($file->server_path);
							}
							
							$delquery = "DELETE FROM `anyInventory_files` WHERE `id`='".$file->id."'";
							$delresult = mysql_query($delquery) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />' . $delquery);
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
						else{
							$filetype = $_FILES[str_replace(" ","_",$field->name)]["type"];
							$filesize = $_FILES[str_replace(" ","_",$field->name)]["size"];
							$offsite_link = '';
						}
					}
					// If not, check for a remote file.
					elseif($_POST[str_replace(" ","_",$field->name)."remote"] != 'http://'){
						$file_query = true;
						
						if (!$file->is_remote){
							if (is_file($file->server_path)){
								unlink($file->server_path);
							}
							
							$delquery = "DELETE FROM `anyInventory_files` WHERE `id`='".$file->id."'";
							$delresult = mysql_query($delquery) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />' . $delquery);
						}
						
						// START new remote file upload ///////////////////////////////////////////////
						// Determine what to do - is the remote file an image?
						// $_POST[str_replace(" ","_",$field->name)."remote"]  = remote filename
						$remote_url = $_POST[str_replace(" ","_",$field->name)."remote"];
						if (extension_loaded('curl') && url_is_type($remote_url,array("image/jpeg", "image/jpg", "image/png"))) {
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
								
								$filesize = filesize(realpath($DIR_PREFIX."item_files/")."/".$filename);
								$filetype = $remote_content_type;
								$offsite_link = '';
							}
							else{
								$filename = '';
								$filesize = '';
								$filetype = '';
								$offsite_link = addslashes($remote_url);
							}
						}
						else {
							$filename = '';
							$filesize = '';
							$filetype = '';
							$offsite_link = $_POST[str_replace(" ","_",$field->name)."remote"];
						}
					}
					
					if ($file_query){
						$query = "INSERT INTO `anyInventory_files`
									(`key`,`file_name`,`file_size`,`file_type`,`offsite_link`)
									VALUES
									('".$key."',
									 '".$filename."',
									 '".$filesize."',
									 '".$filetype."',
									 '".$offsite_link."')";
						$result = mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />' . $query);					

						$new_key = mysql_insert_id();
				
						$query = "UPDATE `anyInventory_values` SET `value`= '".$new_key."' WHERE `item_id` = '".$item->id."' AND `field_id` = '".$field->id."'";
						$result = mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />' . $query);
					}
					
					// END new remote file upload /////////////////////////////////////////////////
				}
				else{
					$query = "UPDATE `anyInventory_values` SET `value`=";
					$query_data = '';
					
					if ($field->input_type == "multiple"){
						if ($_POST[str_replace(" ","_",$field->name)."_text"] == ""){
							$query_data .= "'".$_POST[str_replace(" ","_",$field->name)."_select"]."'";
						}
						else{
							$query_data .= "'".$_POST[str_replace(" ","_",$field->name)."_text"]."'";
						}
					}
					elseif($field->input_type == "checkbox"){
						if (is_array($_POST[str_replace(" ","_",$field->name)])){
							foreach($_POST[str_replace(" ","_",$field->name)] as $key => $val){
								$string .= $key.", ";
							}
							
							$_POST[str_replace(" ","_",$field->name)] = substr($string,0,strlen($string) - 2);
							$query_data .= "'".$_POST[str_replace(" ","_",$field->name)]."'";
						}
						else{
							$query_data .= "''";
						}
					}
					elseif($field->input_type == 'item'){
						if (is_array($_POST[str_replace(" ","_",$field->name)])){
							$query_data .= "'".addslashes(serialize($_POST[str_replace(" ","_",$field->name)]))."'";
						}
						else{
							$query_data .= "'".addslashes(serialize(array()))."'";
						}
					}
					else{
						$query_data .= "'".$_POST[str_replace(" ","_",$field->name)]."'";
					}
					
					$query .= $query_data." WHERE `item_id`='".$item->id."' AND `field_id`='".$field->id."'";
					$result = mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />' . $query);
					
					if (mysql_affected_rows() == 0){
						$query = "INSERT INTO `anyInventory_values` (`item_id`,`field_id`,`value`) VALUES ('".$item->id."','".$field->id."',".$query_data.")";
						@mysql_query($query);
					}
				}
			}
		}
	}
}
elseif($_POST["action"] == "do_move"){
	// Create an object of the old item
	$item = new item($_POST["id"]);
	
	if (!$admin_user->can_admin($item->category->id) || !$admin_user->can_admin($_POST["c"])){
		header("Location: ../error_handler.php?eid=13");
		exit;
	}
	
	// Move an item.
	
	$query = "UPDATE `anyInventory_items` SET `item_category`='".$_POST["c"]."' WHERE `id`='".$_POST["id"]."'";
	mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
}
elseif($_POST["action"] == "do_delete"){
	// Delete an item
	
	if ($_POST["delete"] == _DELETE){
		$item = new item($_POST["id"]);
		
		$item->delete_self();
	}
}

header("Location: items.php");

?>