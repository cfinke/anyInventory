<?php

require_once("globals.php");
require_once("remote_functions.php");

if ($_POST["action"] == "do_add"){
	if (!$admin_user->can_admin($_POST["c"])){
		header("Location: ../error_handler.php?eid=13");
		exit;
	}
	
	// Add an item
	
	// Create an object of the current category
	$category = new category($_POST["c"]);
    $key = $db->nextId('items');
	
	// Put the query together
    $query = "INSERT INTO ".$db->quoteIdentifier('anyInventory_items')." (".$db->quoteIdentifier('id').",".$db->quoteIdentifier('item_category').",".$db->quoteIdentifier('name').") VALUES ('".$key."', '".$_POST["c"]."', '".$_POST["name"]."')";
	$result = $db->query($query);
	if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	
	if (is_array($category->field_ids)){
		foreach($category->field_ids as $field_id){
			$field = new field($field_id);
			
			if (($field->input_type != 'file') && ($field->input_type != 'divider')){
				$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_values') . " (" . $db->quoteIdentifier('item_id') . "," . $db->quoteIdentifier('field_id') . "," . $db->quoteIdentifier('value') . ") VALUES ('".$key."','".$field->id."','";
				
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
						foreach($_POST[str_replace(" ","_",$field->name)] as $checkbox_key => $val){
							$string .= $checkbox_key.", ";
						}
						
						$_POST[str_replace(" ","_",$field->name)] = substr($string,0,strlen($string) - 2);
						$query .= $_POST[str_replace(" ","_",$field->name)];
					}
					else{
						$query .= "''";
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
				$result = $db->query($query);
                if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
			}
		}
		
		foreach($category->field_ids as $field_id){
			$field = new field($field_id);
			
			if ($field->input_type == 'file'){
				if (trim(str_replace("http://","",$_POST[str_replace(" ","_",$field->name)."remote"])) != ''){
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
							$has_file = true;
							$filename = '';
							$filesize = '';
							$filetype = '';
							$offsite_link = addslashes($remote_url);
						}
						else{
							$has_file = true;
							$filesize = filesize(realpath($DIR_PREFIX."item_files/")."/".$filename);
							$filetype = $remote_content_type;
							$offsite_link = '';
						}
					}
					else {
						// Remote URL is not an image; add it as a remote file
						$has_file = true;
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
					
					$has_file = true;
					$filetype = $_FILES[str_replace(" ","_",$field->name)]["type"];
					$filesize = $_FILES[str_replace(" ","_",$field->name)]["size"];
					$offsite_link = '';
				}
				
				if ($has_file){
					$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_files') . "
								(" . $db->quoteIdentifier('key') . "," . $db->quoteIdentifier('file_name') . "," . $db->quoteIdentifier('file_size') . "," . $db->quoteIdentifier('file_type') . "," . $db->quoteIdentifier('offsite_link') . ")
								VALUES
								('".$key."',
								 '".$filename."',
								 '".$filesize."',
								 '".$filetype."',
								 '".$offsite_link."')";
					$result = $db->query($query);
					if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
					
					$new_key = $db->nextId("files") - 1;
				}
				else{
					$new_key = 0;
				}
				
				$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_values') . " (" . $db->quoteIdentifier('item_id') . "," . $db->quoteIdentifier('field_id') . "," . $db->quoteIdentifier('value') . ") VALUES ('".$key."','".$field->id."','".$new_key."')";
				$result = $db->query($query);
				if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
				
				$has_file = false;
			}
		}
	}
}
elseif($_POST["action"] == "do_edit"){
	if ($_POST["cancel"] != CANCEL){
		// Create an object of the old item
		$item = new item($_POST["id"]);
		
		if (!$admin_user->can_admin($item->category->id)){
			header("Location: ../error_handler.php?eid=13");
			exit;
		}
		
		// Put the query together
		$query = "UPDATE " . $db->quoteIdentifier('anyInventory_items') . " SET " . $db->quoteIdentifier('name') . "='".$_REQUEST["name"]."' WHERE " . $db->quoteIdentifier('id') . "='".$item->id."'";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		if (is_array($item->category->field_ids)){
			foreach($item->category->field_ids as $field_id){
				$file_query = false;
				$field = new field($field_id);
				
				if ($field->input_type != 'divider'){
					if ($field->input_type == 'file'){
						$file = new file_object($item->fields[$field->name]["file_id"]);
						
						// Check if the delete file box was checked	
						if (is_array($_POST["delete_files"]) && (in_array($file->id, $_POST["delete_files"]))){
							// If so, delete the file first (and erase the value from the item entry).
							if (!$file->is_remote){
								@unlink($file->server_path);
							}
							
							$delquery = "DELETE FROM " . $db->quoteIdentifier('anyInventory_files') . " WHERE " . $db->quoteIdentifier('id') . "='".$file->id["file_id"]."'";
							$delresult = $db->query($delquery);
							if (DB::isError($delresult)) die($delresult->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $delquery);
							
							$remquery = "UPDATE " . $db->quoteIdentifier('anyInventory_values') . " SET " . $db->quoteIdentifier('value') . "='0' WHERE " . $db->quoteIdentifier('field_id') . "='".$field->id."' AND " . $db->quoteIdentifier('item_id') . "='".$item->id."'";
							$remresult = $db->query($remquery);
							if (DB::isError($remresult)) die($remresult->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $remquery);
						}
						
						// Check if a file was uploaded in its place
						
						if (is_uploaded_file($_FILES[str_replace(" ","_",$field->name)]["tmp_name"])){
							$file_query = true;
							
							if (!$file->is_remote){
								if (is_file($file->server_path)){
									@unlink($file->server_path);
								}
								
								$delquery = "DELETE FROM " . $db->quoteIdentifier('anyInventory_files') . " WHERE " . $db->quoteIdentifier('id') . "='".$file->id."'";
								$delresult = $db->query($delquery);
								if (DB::isError($delresult)) die($delresult->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $delquery);
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
									@unlink($file->server_path);
								}
								
								$delquery = "DELETE FROM " . $db->quoteIdentifier('anyInventory_files') . " WHERE " . $db->quoteIdentifier('id') . "='".$file->id."'";
								$delresult = $db->query($delquery);
								if (DB::isError($delresult)) die($delresult->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $delquery);
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
							$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_files') . "
										(" . $db->quoteIdentifier('key') . "," . $db->quoteIdentifier('file_name') . "," . $db->quoteIdentifier('file_size') . "," . $db->quoteIdentifier('file_type') . "," . $db->quoteIdentifier('offsite_link') . ")
										VALUES
										('".$key."',
										 '".$filename."',
										 '".$filesize."',
										 '".$filetype."',
										 '".$offsite_link."')";
							$result = $db->query($query);
							if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);							$new_key = $db->nextId('seq_name');
							
							$query = "UPDATE " . $db->quoteIdentifier('anyInventory_values') . " SET " . $db->quoteIdentifier('value') . "= '".$new_key."' WHERE " . $db->quoteIdentifier('item_id') . " = '".$item->id."' AND " . $db->quoteIdentifier('field_id') . " = '".$field->id."'";
							$result = $db->query($query);
							if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
							
							if($db->affectedRows() == 0) {
								//If a file did not exist previously, make sure the new file gets referenced
								$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_values') . " (" . $db->quoteIdentifier('item_id') . ", " . $db->quoteIdentifier('field_id') . ", " . $db->quoteIdentifier('value') . ") VALUES('".$item->id."', '".$field->id."', '".$new_key."')";
								$result = $db->query($query);
								if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
							}
						}
						
						// END new remote file upload /////////////////////////////////////////////////
					}
					else{
						$query = "UPDATE " . $db->quoteIdentifier('anyInventory_values') . " SET " . $db->quoteIdentifier('value') . "=";
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
								foreach($_POST[str_replace(" ","_",$field->name)] as $checkbox_key => $val){
									$string .= $checkbox_key.", ";
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
						
						$query .= $query_data." WHERE " . $db->quoteIdentifier('item_id') . "='".$item->id."' AND " . $db->quoteIdentifier('field_id') . "='".$field->id."'";
						$result = $db->query($query);
						if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
						
						if ($db->affectedRows() == 0){
							$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_values') . " (" . $db->quoteIdentifier('item_id') . "," . $db->quoteIdentifier('field_id') . "," . $db->quoteIdentifier('value') . ") VALUES ('".$item->id."','".$field->id."',".$query_data.")";
							$db->query($query);
						}
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
	
	$query = "UPDATE " . $db->quoteIdentifier('anyInventory_items') . " SET " . $db->quoteIdentifier('item_category') . "='".$_POST["c"]."' WHERE " . $db->quoteIdentifier('id') . "='".$_POST["id"]."'";
	$result = $db->query($query);
	if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
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
