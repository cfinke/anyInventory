<?php

include("globals.php");

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
	
	$_POST["name"] = stripslashes($_POST["name"]);
	$_POST["name"] = str_replace($replace,"",$_POST["name"]);
	$_POST["name"] = str_replace("_"," ",$_POST["name"]);
	$_POST["name"] = trim(addslashes($_POST["name"]));
	
	$query = "SELECT `id` FROM `anyInventory_fields` WHERE `name`='".$_POST["name"]."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	if (mysql_num_rows($result) > 0){
		header("Location: ../error_handler.php?eid=0");
		exit;
	}
	else{
		$_POST["values"] = stripslashes($_POST["values"]);
		$_POST["values"] = str_replace("'","",$_POST["values"]);
		$_POST["values"] = trim(str_replace($replace,"",$_POST["values"]));
		
		$_POST["default_value"] = stripslashes($_POST["default_value"]);
		$_POST["default_value"] = str_replace("'","",$_POST["default_value"]);
		$_POST["default_value"] = trim(str_replace($replace,"",$_POST["default_value"]));
		
		if (($_POST["input_type"] == "select") || ($_POST["input_type"] == "radio")){
			if (($_POST["default_value"] == '') || (stristr($_POST["values"],$_POST["default_value"]) === false)){
				header("Location: ../error_handler.php?eid=1");
				exit;
			}
			elseif($_POST["values"] == ''){
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
		
		// Add the field to the items table
		$query = "ALTER TABLE `anyInventory_items` ADD `".$_POST["name"]."` ".get_mysql_column_type($_POST["input_type"],$_POST["size"],$_POST["values"],$_POST["default_value"]);
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
		
		$values = explode(",",$_POST["values"]);
		
		if (is_array($values)){
			foreach($values as $key => $value){
				$values[$key] = trim($value);
			}
			
			$values = array_unique($values);
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
		$query = "INSERT INTO `anyInventory_fields` (`name`,`input_type`,`values`,`default_value`,`size`,`categories`,`importance`,`highlight`) VALUES ('".$_POST["name"]."','".$_POST["input_type"]."','".$values."','".$_POST["default_value"]."','".$_POST["size"]."','".$categories."','".$importance."','".((int) (($_POST["highlight"] == "yes") / 1))."')";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
		
		$field = new field(mysql_insert_id());
		
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
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	$importance = mysql_result($result, 0, 'biggest') + 1;
	
	$query = "INSERT INTO `anyInventory_fields` (`name`,`input_type`,`importance`) VALUES ('divider','divider','".$importance."')";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
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
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	if ((mysql_num_rows($result) > 0) && (mysql_result($result, 0, 'id') != $_POST["id"])){
		header("Location: ../error_handler.php?eid=0");
		exit;
	}
	
	$_POST["values"] = stripslashes($_POST["values"]);
	$_POST["values"] = str_replace("'","",$_POST["values"]);
	$_POST["values"] = trim(str_replace($replace,"",$_POST["values"]));
	
	$_POST["default_value"] = stripslashes($_POST["default_value"]);
	$_POST["default_value"] = str_replace("'","",$_POST["default_value"]);
	$_POST["default_value"] = trim(str_replace($replace,"",$_POST["default_value"]));
	
	$_POST["name"] = stripslashes($_POST["name"]);
	$_POST["name"] = str_replace($replace,"",$_POST["name"]);
	$_POST["name"] = str_replace("_"," ",$_POST["name"]);	
	$_POST["name"] = trim(addslashes($_POST["name"]));
	
	if (($_POST["input_type"] == "select") || ($_POST["input_type"] == "radio")){
		if (($_POST["default_value"] == '') || (stristr($_POST["values"],$_POST["default_value"]) === false)){
			header("Location: ../error_handler.php?eid=1");
			exit;
		}
		elseif($_POST["values"] == ''){
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
	
	$values = explode(",",$_POST["values"]);
	
	if (is_array($values)){
		foreach($values as $key => $value){
			$values[$key] = trim($value);
		}
		
		$values = array_unique($values);
	}
	else{
		$values = array();
	}
	
	$values = serialize($values);
	
	// Change the field.
	$query = "UPDATE `anyInventory_fields` SET
				`name`='".$_POST["name"]."',
				`input_type`='".$_POST["input_type"]."',
				`values`='".$values."',
				`default_value`='".$_POST["default_value"]."',
				`size`='".$_POST["size"]."',
				`highlight`='".((int) (($_POST["highlight"] == "yes") / 1))."'
				WHERE `id`='".$_POST["id"]."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	// Change the items table name.
	$query = "ALTER TABLE `anyInventory_items` CHANGE `".$old_field->name."` `".$_POST["name"]."` ";
 	$query .= get_mysql_column_type($_POST["input_type"], $_POST["size"], $_POST["values"], $_POST["default_value"]);
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
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
		$query = "UPDATE `anyInventory_fields` SET `importance`=(`importance` - 1) WHERE `importance` >= '".$field->importance."'";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
		
		if ($field->input_type != 'divider'){
			// Remove the field from the items table
			$query = "ALTER TABLE `anyInventory_items` DROP `".$field->name."`";
			$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
		}
		
		// Delete the field 
		$query = "DELETE FROM `anyInventory_fields` WHERE `id`='".$field->id."'";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	}
}
elseif($_GET["action"] == "moveup"){
	if (!$admin_user->can_admin_field($_GET["id"])){
		header("Location: ../error_handler.php?eid=13");
		exit;
	}
	
	// Move a field up
	$query = "UPDATE `anyInventory_fields` SET `importance`=".$_GET["i"]." WHERE `importance`='".($_GET["i"] - 1)."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	$query = "UPDATE `anyInventory_fields` SET `importance`=".($_GET["i"] - 1)." WHERE `id`='".$_GET["id"]."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
}
elseif($_GET["action"] == "movedown"){
	if (!$admin_user->can_admin_field($_GET["id"])){
		header("Location: ../error_handler.php?eid=13");
		exit;
	}
	
	// Move a field down
	$query = "UPDATE `anyInventory_fields` SET `importance`=".$_GET["i"]." WHERE `importance`='".($_GET["i"] + 1)."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	$query = "UPDATE `anyInventory_fields` SET `importance`=".($_GET["i"] + 1)." WHERE `id`='".$_GET["id"]."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
}

header("Location: fields.php");

?>