<?php

include("globals.php");

// Remove the whitespace from each $_REQUEST value
foreach($_REQUEST as $key => $value) $_REQUEST[$key] = trim($value);

if ($_REQUEST["action"] == "do_add"){
	// Add a field
	if (($_REQUEST["size"] == '') && ($_REQUEST["input_type"] == "text")){
		// Set the default text size to 255
		$_REQUEST["size"] = 255;
	}
	
	// Add the field to the items table
	$query = "ALTER TABLE `anyInventory_items` ADD `".$_REQUEST["name"]."`";
	
	// Get the MySQL field type
	switch($_REQUEST["input_type"]){
		case 'text':
			if ($_REQUEST["size"] < 256){
				$query .= " VARCHAR(".$_REQUEST["size"].") DEFAULT '' ";
			}
			else{
				$query .= " TEXT ";
			}
			break;
		case 'multiple':
			$query .= " VARCHAR(64) DEFAULT '' ";
			break;
		case 'radio':
		case 'checkbox':
			$extra = "'',";
		case 'select':
			$query .= " ENUM(".$extra;
			
			$enums = explode(",",trim($_REQUEST["values"]));
			
			foreach($enums as $enum){
				$query .= "'".trim(str_replace("'","",str_replace('"','',$enum)))."',";
			}
			
			$query = substr($query, 0, strlen($query) - 1);
			
			$query .= ") DEFAULT '' ";
			break;
	}
	
	$query .= " NOT NULL";
	$result = query($query);
	
	// Get the field order for this field.
	$query = "SELECT MAX(`importance`) as `biggest` FROM `anyInventory_fields`";
	$result = query($query);
	$importance = mysql_result($result, 0, 'biggest') + 1;
	
	// Add this field.
	$query = "INSERT INTO `anyInventory_fields` (`name`,`input_type`,`values`,`default_value`,`size`,`categories`,`importance`) VALUES ('".$_REQUEST["name"]."','".$_REQUEST["input_type"]."','".$_REQUEST["values"]."','".$_REQUEST["default_value"]."','".$_REQUEST["size"]."','0','".$importance."')";
	$result = query($query);
	
	$field = new field(mysql_insert_id());
	
	// Add any categories that were selected.
	if (is_array($_REQUEST["add_to"])){
		foreach($_REQUEST["add_to"] as $cat_id){
			$field->add_category($cat_id);
		}
	}
}
elseif($_REQUEST["action"] == "do_edit"){
	// Make an object from the unchanged field.
	$old_field = new field($_REQUEST["id"]);
	
	if ($_REQUEST["input_type"] == "text"){
		// Set the default text size
		if($_REQUEST["size"] == 0){
			$_REQUEST["size"] = 255;
		}
	}
	elseif(($_REQUEST["input_type"] == "multiple") || ($_REQUEST["input_type"] == "checkbox")){
		$_REQUEST["size"] = 64;
	}
	else{
		$_REQUEST["size"] = '';
	}
	
	// Change the field.
	$query = "UPDATE `anyInventory_fields` SET
				`name`='".$_REQUEST["name"]."',
				`input_type`='".$_REQUEST["input_type"]."',
				`values`='".$_REQUEST["values"]."',
				`default_value`='".$_REQUEST["default_value"]."',
				`size`='".$_REQUEST["size"]."'
				WHERE `id`='".$_REQUEST["id"]."'";
	$result = query($query);
	
	// Change the items table name.
	$query = "ALTER TABLE `anyInventory_items` CHANGE `".$old_field->name."` `".$_REQUEST["name"]."` ";
 	$query .= get_mysql_column_type($_REQUEST["input_type"], $_REQUEST["size"], $_REQUEST["values"], $_REQUEST["default_value"]);
	$result = query($query);
	
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
	
	// Create an object of the field.
	$field = new field($_REQUEST["id"]);
	
	// Change the importance of the fields below it.
	$query = "UPDATE `anyInventory_fields` SET `importance`=(`importance` + 1) WHERE `importance` < '".$field->importance."'";
	$result = query($query);
	
	// Remove the field from the items table
	$query = "ALTER TABLE `anyInventory_items` DROP `".$field->name."`";
	$result = query($query);
	
	// Delete the field 
	$query = "DELETE FROM `anyInventory_fields` WHERE `id`='".$field->id."'";
	$result = query($query);
}
elseif($_REQUEST["action"] == "moveup"){
	// Move a field up
	$query = "UPDATE `anyInventory_fields` SET `importance`=".$_REQUEST["i"]." WHERE `importance`='".($_REQUEST["i"] - 1)."'";
	$result = query($query);
	
	$query = "UPDATE `anyInventory_fields` SET `importance`=".($_REQUEST["i"] - 1)." WHERE `id`='".$_REQUEST["id"]."'";
	$result = query($query);
}
elseif($_REQUEST["action"] == "movedown"){
	// Move a field down
	$query = "UPDATE `anyInventory_fields` SET `importance`=".$_REQUEST["i"]." WHERE `importance`='".($_REQUEST["i"] + 1)."'";
	$result = query($query);
	
	$query = "UPDATE `anyInventory_fields` SET `importance`=".($_REQUEST["i"] + 1)." WHERE `id`='".$_REQUEST["id"]."'";
	$result = query($query);
}

header("Location: fields.php");

?>