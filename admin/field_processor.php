<?php

include("globals.php");

foreach($_REQUEST as $key => $value) $_REQUEST[$key] = stripslashes($value);

$replace = array("'",'"','&',"\\",':',';','`','[',']');

if ($_POST["action"] == "do_add"){
	if (is_array($_POST["add_to"])){
		foreach($_POST["add_to"] as $cat_id){
			if (!$admin_user->can_admin($cat_id)){
				header("Location: ../error_handler.php?eid=13");
				exit;
			}
		}
	}
	
	// Check for duplicate fields
	
	$_POST["name"] = str_replace($replace,"",$_POST["name"]);
	$_POST["name"] = str_replace("_"," ",$_POST["name"]);
	$_POST["name"] = trim($_POST["name"]);
	
	$query = "SELECT `id` FROM `anyInventory_fields` WHERE `name`='".$_POST["name"]."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	if ($result->numRows() > 0){
		header("Location: ../error_handler.php?eid=0");
		exit;
	}
	else{
		$_POST["field_values"] = str_replace("'","",$_POST["field_values"]);
		$_POST["field_values"] = trim(str_replace($replace,"",$_POST["field_values"]));
		
		$_POST["default_value"] = str_replace("'","",$_POST["default_value"]);
		$_POST["default_value"] = trim(str_replace($replace,"",$_POST["default_value"]));
		
		if (($_POST["input_type"] == "select") || ($_POST["input_type"] == "radio")){
			if (($_POST["default_value"] == '') || (stristr($_POST["field_values"],$_POST["default_value"]) === false)){
				header("Location: ../error_handler.php?eid=1");
				exit;
			}
			elseif($_POST["field_values"] == ''){
				header("Location: ../error_handler.php?eid=8");
				exit;
			}
		}
		elseif($_POST["input_type"] == "checkbox"){
			$_POST["default_value"] = '';
		}
		
		// Add a field
		if (($_POST["size"] == '') && ($_POST["input_type"] == "text")){
			// Set the default text size to 255
			$_POST["size"] = 255;
		}
		elseif(($_POST["size"] != '') && (!is_numeric($_POST["size"]))){
			$_POST["size"] = 255;
		}
		
		$field_values = explode(",",$_POST["field_values"]);
		
		if (is_array($field_values)){
			foreach($field_values as $key => $value){
				$field_values[$key] = trim($value);
			}
			
			$field_values = array_unique($field_values);
		}
		else{
			$field_values = array();
		}
		
		$field_values = serialize($field_values);
		$categories = array(0);
		$categories = serialize($categories);
		
		// Get the field order for this field.
		$query = "SELECT MAX(`importance`) as `biggest` FROM `anyInventory_fields`";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
		
		$row = $result->fetchRow();
		$importance = $row['biggest'] + 1;
		
		// Add this field.
		$query_data = array("id"=>get_unique_id('anyInventory_fields'),
							"name"=>$_POST["name"],
							"input_type"=>$_POST["input_type"],
							"field_values"=>$field_values,
							"default_value"=>$_POST["default_value"],
							"size"=>intval($_POST["size"]),
							"categories"=>$categories,
							"importance"=>intval($importance),
							"highlight"=>intval(($_POST["highlight"] == "yes")));
		$result = $db->autoExecute('anyInventory_fields',$query_data,DB_AUTOQUERY_INSERT);
		if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
		
		$field = new field(get_unique_id('anyInventory_fields') - 1);
		
		// Add any categories that were selected.
		if (is_array($_POST["add_to"])){
			foreach($_POST["add_to"] as $cat_id){
				$field->add_category($cat_id);
			}
		}
	}
}
elseif($_GET["action"] == "do_add_divider"){
	$query = "SELECT MAX(`importance`) as `biggest` FROM `anyInventory_fields`";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	$row = $result->fetchRow();
	$importance = $row['biggest'] + 1;
	
	$query_data = array("id"=>get_unique_id('anyInventory_fields'),
						"name"=>'divider',
						"input_type"=>'divider',
						"importance"=>$importance);
	$result = $db->autoExecute('anyInventory_fields',$query_data,DB_AUTOQUERY_INSERT);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
}
elseif($_POST["action"] == "do_edit"){
	if (is_array($_POST["add_to"])){
		foreach($_POST["add_to"] as $cat_id){
	 		if (!$admin_user->can_admin($cat_id) || (!$admin_user->can_admin_field($_POST["id"]))){
				header("Location: ../error_handler.php?eid=13");
				exit;
			}
		}
	}
	
	$query = "SELECT `id` FROM `anyInventory_fields` WHERE `name`='".$_POST["name"]."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	$numrows = $result->numRows();
	$row = $result->fetchRow();
	
	if (($numrows > 0) && ($row['id'] != $_POST["id"])){
		header("Location: ../error_handler.php?eid=0");
		exit;
	}
	
	$_POST["field_values"] = str_replace("'","",$_POST["field_values"]);
	$_POST["field_values"] = trim(str_replace($replace,"",$_POST["field_values"]));
	
	$_POST["default_value"] = str_replace("'","",$_POST["default_value"]);
	$_POST["default_value"] = trim(str_replace($replace,"",$_POST["default_value"]));
	
	$_POST["name"] = str_replace($replace,"",$_POST["name"]);
	$_POST["name"] = str_replace("_"," ",$_POST["name"]);	
	$_POST["name"] = trim($_POST["name"]);
	
	if (($_POST["input_type"] == "select") || ($_POST["input_type"] == "radio")){
		if (($_POST["default_value"] == '') || (stristr($_POST["field_values"],$_POST["default_value"]) === false)){
			header("Location: ../error_handler.php?eid=1");
			exit;
		}
		elseif($_POST["field_values"] == ''){
			header("Location: ../error_handler.php?eid=8");
			exit;
		}
	}
	elseif($_POST["input_type"] == "checkbox"){
		$_POST["default_value"] = '';
	}
	
	// Make an object from the unchanged field.
	$old_field = new field($_POST["id"]);
	
	if ($_POST["input_type"] == "text"){
		// Set the default text size
		if(($_POST["size"] == 0) || (!is_numeric($_POST["size"]))){
			$_POST["size"] = 255;
		}
	}
	elseif($_POST["input_type"] == "multiple"){
		$_POST["size"] = 64;
	}
	else{
		$_POST["size"] = '';
	}
	
	$field_values = explode(",",$_POST["field_values"]);
	
	if (is_array($field_values)){
		foreach($field_values as $key => $value){
			$field_values[$key] = trim($value);
		}
		
		$field_values = array_unique($field_values);
	}
	else{
		$field_values = array();
	}
	
	$field_values = serialize($field_values);
	
	// Change the field.
	$query = "UPDATE `anyInventory_fields` SET
				`name`='".$_POST["name"]."',
				`input_type`='".$_POST["input_type"]."',
				`field_values`='".$field_values."',
				`default_value`='".$_POST["default_value"]."',
				`size`='".intval($_POST["size"])."',
				`highlight`='".((int) (($_POST["highlight"] == "yes") / 1))."'
				WHERE `id`='".$_POST["id"]."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	// Make an object from the new field.
	$new_field = new field($_POST["id"]);
	
	// Remove all of the old categories.
	if (is_array($old_field->categories)){
		foreach($old_field->categories as $cat_id){
			$new_field->remove_category($cat_id);
		}
	}
	
	// Add the new categories
	if (is_array($_POST["add_to"])){
		foreach($_POST["add_to"] as $cat_id){
			$new_field->add_category($cat_id);
		}
	}
}
elseif($_REQUEST["action"] == "do_delete"){
	// Delete a field.
	
	// Create an object of the field.
	$field = new field($_REQUEST["id"]);
	
	if (($_REQUEST["delete"] == "Delete") || ($field->input_type == 'divider')){
		if (!$admin_user->can_admin_field($_REQUEST["id"])){
			header("Location: ../error_handler.php?eid=13");
			exit;
		}
		
		if ($field->input_type == 'file'){
			$query = "SELECT `value` FROM `anyInventory_fields` WHERE `field_id`='".$field->id."' GROUP BY `value`";
			$result = $db->query($query);
		 	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
			
			while ($row = $result->fetchRow()){
				$newquery = "SELECT * FROM `anyInventory_files` WHERE `id`='".$row["value"]."'";
				$newresult = $db->query($newquery);
				if (DB::isError($newresult)) die($newresult->getMessage().': line '.__LINE__.'<br /><br />'.$newresult->userinfo);
				
				$newrow = $newresult->fetchRow();
				
				$file = new file_object($newrow["id"]);
				
				if (!$file->is_remote && is_file($file->server_path)){
					unlink($file->server_path);
				}
				
				$newestquery = "DELETE FROM `anyInventory_files` WHERE `id`='".$file->id."'";
				$newestresult = $db->query($newestquery);
				if (DB::isError($newestresult)) die($newestresult->getMessage().': line '.__LINE__);
			}
		}
		
		// Change the importance of the fields below it.
		$query = "UPDATE `anyInventory_fields` SET `importance`=(`importance` - 1) WHERE `importance` >= '".$field->importance."'";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
		
		if ($field->input_type != 'divider'){
			// Remove the field from the items table
			$query = "DELETE FROM `anyInventory_values` WHERE `field_id`='".$field->id."'";
			$result = $db->query($query);
			if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
		}
		
		// Delete the field 
		$query = "DELETE FROM `anyInventory_fields` WHERE `id`='".$field->id."'";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	}
}
elseif($_GET["action"] == "moveup"){
	if (!$admin_user->can_admin_field($_GET["id"])){
		header("Location: ../error_handler.php?eid=13");
		exit;
	}
	
	// Move a field up
	$query = "UPDATE `anyInventory_fields` SET `importance`=".$_GET["i"]." WHERE `importance`='".($_GET["i"] - 1)."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	$query = "UPDATE `anyInventory_fields` SET `importance`=".($_GET["i"] - 1)." WHERE `id`='".$_GET["id"]."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
}
elseif($_GET["action"] == "movedown"){
	if (!$admin_user->can_admin_field($_GET["id"])){
		header("Location: ../error_handler.php?eid=13");
		exit;
	}
	
	// Move a field down
	$query = "UPDATE `anyInventory_fields` SET `importance`=".$_GET["i"]." WHERE `importance`='".($_GET["i"] + 1)."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	$query = "UPDATE `anyInventory_fields` SET `importance`=".($_GET["i"] + 1)." WHERE `id`='".$_GET["id"]."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
}

header("Location: fields.php");

?>
