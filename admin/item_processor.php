<?php

include("globals.php");
include("remote_functions.php");

foreach($_REQUEST as $key => $value) $_REQUEST[$key] = stripslashes($value);

if ($_POST["action"] == "do_add"){
	if (!$admin_user->can_admin($_POST["c"])){
		header("Location: ../error_handler.php?eid=13");
		exit;
	}
	
	// Add an item
	
	// Create an object of the current category
	$category = new category($_POST["c"]);
	
	// Put the query together
	$query_data = array("id"=>get_unique_id('anyInventory_items'),
						"item_category"=>$_POST["c"],
						"name"=>$_POST["name"]);
	$result = $db->autoExecute('anyInventory_items',$query_data, DB_AUTOQUERY_INSERT);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	$key = get_unique_id('anyInventory_items') - 1;
	
	if (is_array($category->field_ids)){
		foreach($category->field_ids as $field_id){
			$field = new field($field_id);
			
			if (($field->input_type != 'file') && ($field->input_type != 'divider')){
				$query_data = array("item_id"=>$key,"field_id"=>$field->id);
				
				if ($field->input_type == "multiple"){
					if ($_POST[str_replace(" ","_",$field->name)."_text"] == ""){
						$query_data["value"] = $_POST[str_replace(" ","_",$field->name)."_select"];
					}
					else{
						$query_data["value"] = $_POST[str_replace(" ","_",$field->name)."_text"];
					}
				}
				elseif($field->input_type == "checkbox"){
					if (is_array($_POST[str_replace(" ","_",$field->name)])){
						foreach($_POST[str_replace(" ","_",$field->name)] as $key => $val){
							$string .= $key.", ";
						}
						
						$_POST[str_replace(" ","_",$field->name)] = substr($string,0,strlen($string) - 2);
						$query_data["value"] = $_POST[str_replace(" ","_",$field->name)];
					}
					else{
						$query_data["value"] = '';
					}
				}
				elseif($field->input_type == 'item'){
					if (is_array($_POST[str_replace(" ","_",$field->name)])){
						$query_data["value"] = serialize($_POST[str_replace(" ","_",$field->name)]);
					}
					else{
						$query_data["value"] = serialize(array());
					}
				}
				else{
					$query_data["value"] = $_POST[str_replace(" ","_",$field->name)];
				}
				
				$result = $db->autoExecute('anyInventory_values',$query_data, DB_AUTOQUERY_INSERT);
				if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
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
							die("Could not download/store remote file.");
						}
						
						// Update DB
						$new_key = get_unique_id('anyInventory_files');
						
						$query_data = array("id"=>$new_key,
											"key_value"=>$key,
											"file_name"=>$filename,
											"file_size"=>filesize(realpath($DIR_PREFIX."item_files/")."/".$filename),
											"file_type"=>$remote_content_type);
						$result = $db->autoExecute('anyInventory_files',$query_data,DB_AUTOQUERY_INSERT);
						if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
						
						$query_data = array("item_id"=>$key,
											"field_id"=>$field->id,
											"value"=>$new_key);
						$result = $db->autoExecute('anyInventory_values',$query_data,DB_AUTOQUERY_INSERT);
						if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
					} else {
						// Remote URL is not an image; add it as a remote file
						$new_key = get_unique_id('anyInventory_files');
						
						$query_data = array("id"=>$new_key,
											"key_value"=>$key,
											"offsite_link"=>$_POST[str_replace(" ","_",$field->name)."remote"]);
						$result = $db->autoExecute('anyInventory_files',$query_data,DB_AUTOQUERY_INSERT);
						if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
						
						$query_data = array("item_id"=>$key,
											"field_id"=>$field->id,
											"field_values"=>$new_key);
						$result = $db->autoExecute('anyInventory_values',$query_data,DB_AUTOQUERY_INSERT);
						if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
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
					
					$new_key = get_unique_id('anyInventory_files');
					
					$query_data = array("id"=>$new_key,
										"key_value"=>$key,
										"file_name"=>$filename,
										"file_size"=>$_FILES[str_replace(" ","_",$field->name)]["size"],
										"file_type"=>$filetype);
					$result = $db->autoExecute('anyInventory_files',$query_data,DB_AUTOQUERY_INSERT);
					if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
					
					$query_data = array("item_id"=>$key,
										"field_id"=>$field->id,
										"value"=>$new_key);
					$result = $db->autoExecute('anyInventory_values',$query_data,DB_AUTOQUERY_INSERT);
					if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
				}
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
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
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
						$delresult = $db->query($delquery);
						if (DB::isError($delresult)) die($delresult->getMessage().': line '.__LINE__.'<br /><br />'.$delresult->userinfo);
						
						$remquery = "UPDATE `anyInventory_values` SET `value`='0' WHERE `field_id`='".$field->id."' AND `item_id`='".$item->id."'";
						$remresult = $db->query($remquery);
						if (DB::isError($remresult)) die($remresult->getMessage().': line '.__LINE__.'<br /><br />'.$remresult->userinfo);
					}
					
					// Check if a file was uploaded in its place
					
					if (is_uploaded_file($_FILES[str_replace(" ","_",$field->name)]["tmp_name"])){
						if (!$file->is_remote){
							if (is_file($file->server_path)){
								unlink($file->server_path);
							}
							
							$delquery = "DELETE FROM `anyInventory_files` WHERE `id`='".$file->id."'";
							$delresult = $db->query($delquery);
							if (DB::isError($delresult)) die($delresult->getMessage().': line '.__LINE__.'<br /><br />'.$delresult->userinfo);
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
						
						$filetype = $_FILES[str_replace(" ","_",$field->name)]["type"];
						$filesize = $_FILES[str_replace(" ","_",$field->name)]["size"];
						
						$new_key = get_unique_id('anyInventory_files');
						
						$query_data = array("id"=>$new_key,
											"key_value"=>$item->id,
											"file_name"=>$filename,
											"file_size"=>$filesize,
											"file_type"=>$filetype);
						$result = $db->autoExecute('anyInventory_files',$query_data,DB_AUTOQUERY_INSERT);
						if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
						
						$query = "UPDATE `anyInventory_values` SET `value` = ? WHERE `item_id` = ? AND `field_id` = ?";
						$query_data = array($new_key, $item_id, $field->id);
						$pquery = $db->prepare($query);
						$result = $db->execute($pquery, $query_data);
						if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
					}
					// If not, check for a remote file.
					elseif($_POST[str_replace(" ","_",$field->name)."remote"] != 'http://'){
						if (!$file->is_remote){
							if (is_file($file->server_path)){
								unlink($file->server_path);
							}
							
							$delquery = "DELETE FROM `anyInventory_files` WHERE `id`='".$file->id."'";
							$delresult = $db->query($delquery);
							if (DB::isError($delresult)) die($delresult->getMessage().': line '.__LINE__.'<br /><br />'.$delresult->userinfo);
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
							}
							
							
							$new_key = get_unique_id('anyInventory_files');
							
							$query_data = array("id"=>$new_key,
												"key_value"=>$key,
												"file_name"=>$filename,
												"file_size"=>filesize(realpath($DIR_PREFIX."item_files/")."/".$filename),
												"file_type"=>$remote_content_type);
							$result = $db->autoExecute('anyInventory_files',$query_data,DB_AUTOQUERY_INSERT);
							if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
							
							$query = "UPDATE `anyInventory_values` SET `value` = ? WHERE `item_id` = ? AND `field_id` = ?";
							$query_data = array($new_key, $item_id, $field->id);
							$pquery = $db->prepare($query);
							$result = $db->execute($pquery, $query_data);
							if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
						} else {
							$offsitelink = $_POST[str_replace(" ","_",$field->name)."remote"];
							
							$new_key = get_unique_id('anyInventory_files');
							
							$query_data = array("id"=>$new_key,
												"key_value"=>$key,
												"offsite_link"=>$offsitelink);
							$result = $db->autoExecute('anyInventory_files',$query_data,DB_AUTOQUERY_INSERT);
							if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
							
							$query = "UPDATE `anyInventory_values` SET `value`= ? WHERE `item_id` = ? AND `field_id` = ?";
							$query_data = array($new_key, $item_id, $field->id);
							$pquery = $db->prepare($query);
							$result = $db->execute($pquery, $query_data);
							if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
						}
						// END new remote file upload /////////////////////////////////////////////////
					}
				}
				else{
					$query = "UPDATE `anyInventory_values` SET `value`=";
					
					if ($field->input_type == "multiple"){
						if ($_POST[str_replace(" ","_",$field->name)."_text"] == ""){
							$query .= "'".$_POST[str_replace(" ","_",$field->name)."_select"]."'";
						}
						else{
							$query .= "'".$_POST[str_replace(" ","_",$field->name)."_text"]."'";
						}
					}
					elseif($field->input_type == "checkbox"){
						if (is_array($_POST[str_replace(" ","_",$field->name)])){
							foreach($_POST[str_replace(" ","_",$field->name)] as $key => $val){
								$string .= $key.", ";
							}
							
							$_POST[str_replace(" ","_",$field->name)] = substr($string,0,strlen($string) - 2);
							$query .= "'".$_POST[str_replace(" ","_",$field->name)]."'";
						}
						else{
							$query .= "''";
						}
					}
					elseif($field->input_type == 'item'){
						if (is_array($_POST[str_replace(" ","_",$field->name)])){
							$query .= "'".addslashes(serialize($_POST[str_replace(" ","_",$field->name)]))."'";
						}
						else{
							$query .= "'".addslashes(serialize(array()))."'";
						}
					}
					else{
						$query .= "'".$_POST[str_replace(" ","_",$field->name)]."'";
					}
					
					$query .= " WHERE `item_id`='".$item_id."' AND `field_id`='".$field->id."'";
					$result = $db->query($query);
					if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
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
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
}
elseif($_POST["action"] == "do_delete"){
	// Delete an item
	
	if ($_POST["delete"] == "Delete"){
		$item = new item($_POST["id"]);
		
		if (!$admin_user->can_admin($item->category->id)){
			header("Location: ../error_handler.php?eid=13");
			exit;
		}
		
		if (is_array($item->files)){
			foreach($item->files as $file){
				if (!$file->is_remote){
					if (unlink(realpath($DIR_PREFIX."item_files/")."/".$file->file_name)){
						$query = "DELETE FROM `anyInventory_files` WHERE `id`='".$file->id."'";
						$result = $db->query($query);
						if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
					}
					else{
						echo "Could not delete ".$file->file_name.'<br />';
						exit;
					}
				}
				else{
					$query = "DELETE FROM `anyInventory_files` WHERE `id`='".$file->id."'";
					$result = $db->query($query);
					if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
				}
			}
		}
		
		// Remove this item from any alerts
		
		$query = "SELECT `id` FROM `anyInventory_alerts` WHERE `item_ids` LIKE '%\"".$item->id."\"%'";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
		
		while ($row = $result->fetchRow()){
			$alert = new alert($row["id"]);
			
			$alert->remove_item($item->id);
			
			if (count($alert->item_ids) == 0){
				$newquery = "DELETE FROM `anyInventory_alerts` WHERE `id`='".$alert->id."'";
				$newresult = $db->query($newquery);
				if (DB::isError($newresult)) die($newresult->getMessage().': line '.__LINE__.'<br /><br />'.$newresult->userinfo);
			}
		}
		
		$query = "DELETE FROM `anyInventory_items` WHERE `id`='".$item->id."'";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
		
		$query = "DELETE FROM `anyInventory_values` WHERE `item_id`='".$item->id."'";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	}
}

header("Location: items.php");

?>
