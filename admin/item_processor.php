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
    $key = nextId('items');
	
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
					$parsed_url = parse_url($remote_url);
					$extension = explode("/",$parsed_url["path"]);
					if (in_array($extension,array("jpeg", "jpg", "png"))) {
						// Remote URL is an image; download it and add it as a local image
						
						$remote_content_type = "image/".$extension;
						$filename = $parsed_url["path"];
						
						// Copy file
						if(!($file_data = file_get_contents($remote_url))){
							$has_file = true;
							$filename = '';
							$filesize = '';
							$filetype = '';
							$offsite_link = addslashes($remote_url);
						}
						else{
							$has_file = true;
							$filesize = strlen($file_data);
							$filetype = $remote_content_type;
							$offsite_link = '';
							
							write_file_to_db(nextId("files"), $file_data);
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
					$filename = $_FILES[str_replace(" ","_",$field->name)]["name"];
					$file_data = file_get_contents($_FILES[str_replace(" ","_",$field->name)]["tmp_name"]);
					
					write_file_to_db(nextId("files"), $file_data);
					
					$has_file = true;
					$filetype = $_FILES[str_replace(" ","_",$field->name)]["type"];
					$filesize = $_FILES[str_replace(" ","_",$field->name)]["size"];
					$offsite_link = '';
				}
				
				if ($has_file){
					$new_key = nextId("files");
					
					$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_files') . "
								(" . $db->quoteIdentifier("id") . ", " . $db->quoteIdentifier('key') . "," . $db->quoteIdentifier('file_name') . "," . $db->quoteIdentifier('file_size') . "," . $db->quoteIdentifier('file_type') . "," . $db->quoteIdentifier('offsite_link') . ")
								VALUES
								('".$new_key."',
								 '".$key."',
								 '".$filename."',
								 '".$filesize."',
								 '".$filetype."',
								 '".$offsite_link."')";
					$result = $db->query($query);
					if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
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
							// If so, delete the file data and erase the value from the item entry.
							$remquery = "UPDATE " . $db->quoteIdentifier('anyInventory_values') . " SET " . $db->quoteIdentifier('value') . "='0' WHERE " . $db->quoteIdentifier('field_id') . "='".$field->id."' AND " . $db->quoteIdentifier('item_id') . "='".$item->id."'";
							$remresult = $db->query($remquery);
							if (DB::isError($remresult)) die($remresult->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $remquery);
							
							$delquery = "DELETE FROM " . $db->quoteIdentifier('anyInventory_files') . " WHERE " . $db->quoteIdentifier('id') . "='".$file->id."'";
							$delresult = $db->query($delquery);
							if (DB::isError($delresult)) die($delresult->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $delquery);
							
							$delquery = "DELETE FROM " . $db->quoteIdentifier('anyInventory_file_data') . " WHERE " . $db->quoteIdentifier('file_id') . "='".$file->id."'";
							$delresult = $db->query($delquery);
							if (DB::isError($delresult)) die($delresult->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $delquery);
						}
						
						// Check if a file was uploaded in its place
						
						if (is_uploaded_file($_FILES[str_replace(" ","_",$field->name)]["tmp_name"])){
							$file_query = true;
							
							$delquery = "DELETE FROM " . $db->quoteIdentifier('anyInventory_files') . " WHERE " . $db->quoteIdentifier('id') . "='".$file->id."'";
							$delresult = $db->query($delquery);
							if (DB::isError($delresult)) die($delresult->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $delquery);
							
							$remquery = "UPDATE " . $db->quoteIdentifier('anyInventory_values') . " SET " . $db->quoteIdentifier('value') . "='0' WHERE " . $db->quoteIdentifier('field_id') . "='".$field->id."' AND " . $db->quoteIdentifier('item_id') . "='".$item->id."'";
							$remresult = $db->query($remquery);
							if (DB::isError($remresult)) die($remresult->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $remquery);
							
							if (!$file->is_remote){
								$delquery = "DELETE FROM " . $db->quoteIdentifier('anyInventory_file_data') . " WHERE " . $db->quoteIdentifier('file_id') . "='".$file->id."'";
								$delresult = $db->query($delquery);
								if (DB::isError($delresult)) die($delresult->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $delquery);
							}
							
							$filename = $_FILES[str_replace(" ","_",$field->name)]["name"];
							$file_data = file_get_contents($_FILES[str_replace(" ","_",$field->name)]["tmp_name"]);
							
							write_file_to_db(nextId("files"), $file_data);
							
							$filetype = $_FILES[str_replace(" ","_",$field->name)]["type"];
							$filesize = $_FILES[str_replace(" ","_",$field->name)]["size"];
							$offsite_link = '';
						}
						// If not, check for a remote file.
						elseif($_POST[str_replace(" ","_",$field->name)."remote"] != 'http://'){
							$file_query = true;
							
							$delquery = "DELETE FROM " . $db->quoteIdentifier('anyInventory_files') . " WHERE " . $db->quoteIdentifier('id') . "='".$file->id."'";
							$delresult = $db->query($delquery);
							if (DB::isError($delresult)) die($delresult->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $delquery);							
							
							$remquery = "UPDATE " . $db->quoteIdentifier('anyInventory_values') . " SET " . $db->quoteIdentifier('value') . "='0' WHERE " . $db->quoteIdentifier('field_id') . "='".$field->id."' AND " . $db->quoteIdentifier('item_id') . "='".$item->id."'";
							$remresult = $db->query($remquery);
							if (DB::isError($remresult)) die($remresult->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $remquery);
							
							if (!$file->is_remote){
								$delquery = "DELETE FROM " . $db->quoteIdentifier('anyInventory_file_data') . " WHERE " . $db->quoteIdentifier('file_id') . "='".$file->id."'";
								$delresult = $db->query($delquery);
								if (DB::isError($delresult)) die($delresult->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $delquery);
							}
							
							// START new remote file upload ///////////////////////////////////////////////
							// Determine what to do - is the remote file an image?
							// $_POST[str_replace(" ","_",$field->name)."remote"]  = remote filename
							$remote_url = $_POST[str_replace(" ","_",$field->name)."remote"];
							$parsed_url = parse_url($remote_url);
							$extension = explode("/",$parsed_url["path"]);
							if (in_array($extension,array("jpeg", "jpg", "png"))) {
								// Remote URL is an image; download it and add it as a local image
								
								$remote_content_type = "image/".$extension;
								$filename = $parsed_url["path"];
								
								// Copy file
								if(!($file_data = file_get_contents($remote_url))){
									$has_file = true;
									$filename = '';
									$filesize = '';
									$filetype = '';
									$offsite_link = addslashes($remote_url);
								}
								else{
									$has_file = true;
									$filesize = strlen($file_data);
									$filetype = $remote_content_type;
									$offsite_link = '';
									
									write_file_to_db(nextId("files"), $file_data);
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
						
						if ($file_query){
							$new_key = nextId("files");
							
							$query = "INSERT INTO " . $db->quoteIdentifier('anyInventory_files') . "
										(".$db->quoteIdentifier('id').", " . $db->quoteIdentifier('key') . "," . $db->quoteIdentifier('file_name') . "," . $db->quoteIdentifier('file_size') . "," . $db->quoteIdentifier('file_type') . "," . $db->quoteIdentifier('offsite_link') . ")
										VALUES
										('".$new_key."',
										 '".$item->id."',
										 '".$filename."',
										 '".$filesize."',
										 '".$filetype."',
										 '".$offsite_link."')";
							$result = $db->query($query);
							if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
							
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

if (isset($_REQUEST["on_submit"])){
	$_SESSION["ai_options"]["on_submit"] = $_REQUEST["on_submit"];
	
	if ($_REQUEST["on_submit"] == 'add_another'){
		header("Location: add_item.php?c=".$_POST["c"]);
		exit;
	}
}

header("Location: items.php");
exit;

function write_file_to_db($file_id, $string){
	global $db;
	
	$file_data = base64_encode($string);
	
	$bookmark = 0;
	$part_id = 0;
	
	$length = strlen($file_data);
	
	// Write the data in chunks of 100000 to the database to avoid
	// the max_packet_size error.
	
	while ($bookmark < $length){
		$bodypart = substr($file_data,$bookmark,100000);
		
		if (strlen($bodypart) > 0){
			$query = "INSERT INTO " . $db->quoteIdentifier("anyInventory_file_data") . "
						(" . $db->quoteIdentifier("file_id") . "," . $db->quoteIdentifier("part_id") . "," . $db->quoteIdentifier("data") . ")
						VALUES 
						('".$file_id."',
						 ".$part_id++.",
						 '".$db->escapeSimple($bodypart)."')";
			$result = $db->query($query);
			if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		}
		
		$bookmark += 100000;
	}
}

?>
