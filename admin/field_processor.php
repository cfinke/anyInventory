<?php

include("globals.php");

$replace = array("'",'"','&',"\\",':',';','`','[',']');

if ($_REQUEST["action"] == "do_add"){
	if (is_array($_REQUEST["add_to"])){
		foreach($_REQUEST["add_to"] as $cat_id){
			if (!$admin_user->can_admin($cat_id)){
				header("Location: ../error_handler.php?eid=13");
				exit;
			}
		}
	}
	
	// Check for duplicate fields
	
	$_REQUEST["name"] = stripslashes($_REQUEST["name"]);
	$_REQUEST["name"] = str_replace($replace,"",$_REQUEST["name"]);
	$_REQUEST["name"] = str_replace("_"," ",$_REQUEST["name"]);
	$_REQUEST["name"] = trim(addslashes($_REQUEST["name"]));
	
	$query = "SELECT `id` FROM `anyInventory_fields` WHERE `name`='".$_REQUEST["name"]."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	if (mysql_num_rows($result) > 0){
		header("Location: ../error_handler.php?eid=0");
		exit;
	}
	else{
		$_REQUEST["values"] = stripslashes($_REQUEST["values"]);
		$_REQUEST["values"] = str_replace("'","",$_REQUEST["values"]);
		$_REQUEST["values"] = trim(str_replace($replace,"",$_REQUEST["values"]));
		
		$_REQUEST["default_value"] = stripslashes($_REQUEST["default_value"]);
		$_REQUEST["default_value"] = str_replace("'","",$_REQUEST["default_value"]);
		$_REQUEST["default_value"] = trim(str_replace($replace,"",$_REQUEST["default_value"]));
		
		if (($_REQUEST["input_type"] == "select") || ($_REQUEST["input_type"] == "radio")){
			if (($_REQUEST["default_value"] == '') || (stristr($_REQUEST["values"],$_REQUEST["default_value"]) === false)){
				header("Location: ../error_handler.php?eid=1");
				exit;
			}
			elseif($_REQUEST["values"] == ''){
				header("Location: ../error_handler.php?eid=7");
				exit;
			}
		}
		elseif($_REQUEST["input_type"] == "checkbox"){
			$_REQUEST["default_value"] = '';
		}
		
		// Add a field
		if (($_REQUEST["size"] == '') && ($_REQUEST["input_type"] == "text")){
			// Set the default text size to 255
			$_REQUEST["size"] = 255;
		}
		elseif(($_REQUEST["size"] != '') && (!is_numeric($_REQUEST["size"]))){
			$_REQUEST["size"] = 255;
		}
		
		// Add the field to the items table
		$query = "ALTER TABLE `anyInventory_items` ADD `".$_REQUEST["name"]."` ".get_mysql_column_type($_REQUEST["input_type"],$_REQUEST["size"],$_REQUEST["values"],$_REQUEST["default_value"]);
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
		
		$values = explode(",",$_REQUEST["values"]);
		
		if (is_array($values)){
			foreach($values as $key => $value){
				$values[$key] = trim($value);
			}
		}
		else{
			$values = array();
		}
		
		$values = serialize($values);
		$categories = array(0);
		$categories = serialize($categories);
		
		// Get the field order for this field.
		$query = "SELECT MAX(`importance`) as `biggest` FROM `anyInventory_fields`";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
		$importance = mysql_result($result, 0, 'biggest') + 1;
		
		// Add this field.
		$query = "INSERT INTO `anyInventory_fields` (`name`,`input_type`,`values`,`default_value`,`size`,`categories`,`importance`,`highlight`) VALUES ('".$_REQUEST["name"]."','".$_REQUEST["input_type"]."','".$values."','".$_REQUEST["default_value"]."','".$_REQUEST["size"]."','".$categories."','".$importance."','".((int) (($_REQUEST["highlight"] == "yes") / 1))."')";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
		
		$field = new field(mysql_insert_id());
		
		// Add any categories that were selected.
		if (is_array($_REQUEST["add_to"])){
			foreach($_REQUEST["add_to"] as $cat_id){
				$field->add_category($cat_id);
			}
		}
	}
}
elseif($_REQUEST["action"] == "do_edit"){
	if (is_array($_REQUEST["add_to"])){
		foreach($_REQUEST["add_to"] as $cat_id){
	 		if (!$admin_user->can_admin($cat_id) || (!$admin_user->can_admin_field($_REQUEST["id"]))){
				header("Location: ../error_handler.php?eid=13");
				exit;
			}
		}
	}
	
	$query = "SELECT `id` FROM `anyInventory_fields` WHERE `name`='".$_REQUEST["name"]."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	if ((mysql_num_rows($result) > 0) && (mysql_result($result, 0, 'id') != $_REQUEST["id"])){
		header("Location: ../error_handler.php?eid=0");
		exit;
	}
	
	$_REQUEST["values"] = stripslashes($_REQUEST["values"]);
	$_REQUEST["values"] = str_replace("'","",$_REQUEST["values"]);
	$_REQUEST["values"] = trim(str_replace($replace,"",$_REQUEST["values"]));
	
	$_REQUEST["default_value"] = stripslashes($_REQUEST["default_value"]);
	$_REQUEST["default_value"] = str_replace("'","",$_REQUEST["default_value"]);
	$_REQUEST["default_value"] = trim(str_replace($replace,"",$_REQUEST["default_value"]));
	
	$_REQUEST["name"] = stripslashes($_REQUEST["name"]);
	$_REQUEST["name"] = str_replace($replace,"",$_REQUEST["name"]);
	$_REQUEST["name"] = str_replace("_"," ",$_REQUEST["name"]);	
	$_REQUEST["name"] = trim(addslashes($_REQUEST["name"]));
	
	if (($_REQUEST["input_type"] == "select") || ($_REQUEST["input_type"] == "radio")){
		if (($_REQUEST["default_value"] == '') || (stristr($_REQUEST["values"],$_REQUEST["default_value"]) === false)){
			header("Location: ../error_handler.php?eid=1");
			exit;
		}
		elseif($_REQUEST["values"] == ''){
			header("Location: ../error_handler.php?eid=7");
			exit;
		}
	}
	elseif($_REQUEST["input_type"] == "checkbox"){
		$_REQUEST["default_value"] = '';
	}
	
	// Make an object from the unchanged field.
	$old_field = new field($_REQUEST["id"]);
	
	if ($_REQUEST["input_type"] == "text"){
		// Set the default text size
		if(($_REQUEST["size"] == 0) || (!is_numeric($_REQUEST["size"]))){
			$_REQUEST["size"] = 255;
		}
	}
	elseif($_REQUEST["input_type"] == "multiple"){
		$_REQUEST["size"] = 64;
	}
	else{
		$_REQUEST["size"] = '';
	}
	
	$values = explode(",",$_REQUEST["values"]);
	
	if (is_array($values)){
		foreach($values as $key => $value){
			$values[$key] = trim($value);
		}
	}
	else{
		$values = array();
	}
	
	$values = serialize($values);
	
	// Change the field.
	$query = "UPDATE `anyInventory_fields` SET
				`name`='".$_REQUEST["name"]."',
				`input_type`='".$_REQUEST["input_type"]."',
				`values`='".$values."',
				`default_value`='".$_REQUEST["default_value"]."',
				`size`='".$_REQUEST["size"]."',
				`highlight`='".((int) (($_REQUEST["highlight"] == "yes") / 1))."'
				WHERE `id`='".$_REQUEST["id"]."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	// Change the items table name.
	$query = "ALTER TABLE `anyInventory_items` CHANGE `".$old_field->name."` `".$_REQUEST["name"]."` ";
 	$query .= get_mysql_column_type($_REQUEST["input_type"], $_REQUEST["size"], $_REQUEST["values"], $_REQUEST["default_value"]);
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	// Make an object from the new field.
	$new_field = new field($_REQUEST["id"]);
	
	// Remove all of the old categories.
	if (is_array($old_field->categories)){
		foreach($old_field->categories as $cat_id){
			$new_field->remove_category($cat_id);
		}
	}
	
	// Add the new categories
	if (is_array($_REQUEST["add_to"])){
		foreach($_REQUEST["add_to"] as $cat_id){
			$new_field->add_category($cat_id);
		}
	}
}
elseif($_REQUEST["action"] == "do_delete"){
	// Delete a field.
	
	if ($_REQUEST["delete"] == "Delete"){
		if (!$admin_user->can_admin_field($_REQUEST["id"])){
			header("Location: ../error_handler.php?eid=13");
			exit;
		}
		
		// Create an object of the field.
		$field = new field($_REQUEST["id"]);
		
		if ($field->input_type == 'file'){
			$query = "SELECT `".$field->name."` FROM `anyInventory_items` GROUP BY `".$field->name."`";
			$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
			
			while ($row = mysql_fetch_array($result)){
				$newquery = "SELECT * FROM `anyInventory_files` WHERE `id`='".$row[$field->name]."'";
				$newresult = mysql_query($newquery) or die(mysql_error() . '<br /><br />'. $newquery);
				$newrow = mysql_fetch_array($newresult);
				
				$file = new file_object($newrow["id"]);
				
				if (!$file->is_remote && is_file($file->server_path)){
					unlink($file->server_path);
				}
				
				$newestquery = "DELETE FROM `anyInventory_files` WHERE `id`='".$file->id."'";
				mysql_query($newestquery) or die(mysql_error() . '<br /><br />'. $newestquery);
			}
		}
		
		// Change the importance of the fields below it.
		$query = "UPDATE `anyInventory_fields` SET `importance`=(`importance` + 1) WHERE `importance` < '".$field->importance."'";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
		
		// Remove the field from the items table
		$query = "ALTER TABLE `anyInventory_items` DROP `".$field->name."`";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
		
		// Delete the field 
		$query = "DELETE FROM `anyInventory_fields` WHERE `id`='".$field->id."'";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	}
}
elseif($_REQUEST["action"] == "moveup"){
	if (!$admin_user->can_admin_field($_REQUEST["id"])){
		header("Location: ../error_handler.php?eid=13");
		exit;
	}
	
	// Move a field up
	$query = "UPDATE `anyInventory_fields` SET `importance`=".$_REQUEST["i"]." WHERE `importance`='".($_REQUEST["i"] - 1)."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	$query = "UPDATE `anyInventory_fields` SET `importance`=".($_REQUEST["i"] - 1)." WHERE `id`='".$_REQUEST["id"]."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
}
elseif($_REQUEST["action"] == "movedown"){
	if (!$admin_user->can_admin_field($_REQUEST["id"])){
		header("Location: ../error_handler.php?eid=13");
		exit;
	}
	
	// Move a field down
	$query = "UPDATE `anyInventory_fields` SET `importance`=".$_REQUEST["i"]." WHERE `importance`='".($_REQUEST["i"] + 1)."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	$query = "UPDATE `anyInventory_fields` SET `importance`=".($_REQUEST["i"] + 1)." WHERE `id`='".$_REQUEST["id"]."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
}

header("Location: fields.php");

?>