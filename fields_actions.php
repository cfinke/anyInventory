<?php

include("globals.php");

if ($_REQUEST["action"] == "add_field"){
	$sized_input_types = array("text","multiple");
	
	if (($_REQUEST["size"] == '') && (in_array($_REQUEST["input_type"], $sized_input_types))){
		$_REQUEST["size"] = 255;
	}
	
	$query = "INSERT INTO `anyInventory_fields` (`name`,`input_type`,`values`,`default_value`,`size`,`categories`) VALUES ('".$_REQUEST["name"]."','".$_REQUEST["input_type"]."','".$_REQUEST["values"]."','".$_REQUEST["default_value"]."','".$_REQUEST["size"]."','0')";
	$result = query($query);
	
	$query = "ALTER TABLE `anyInventory_items` ADD `".$_REQUEST["name"]."`";
	
	switch($_REQUEST["input_type"]){
		case 'text':
		case 'multiple':
			if ($_REQUEST["size"] < 256){
				$query .= " VARCHAR(".$_REQUEST["size"].") DEFAULT '".$_REQUEST["default_value"]."' ";
			}
			else{
				$query .= " TEXT ";
			}
			break;
		case 'radio':
		case 'checkbox':
		case 'select':
			$query .= " ENUM(";
			
			$enums = explode(",",$_REQUEST["values"]);
			
			foreach($enums as $enum){
				$query .= $enum.",";
			}
			
			$query = substr($query, 0, strlen($query) - 1);
			
			$query .= ") DEFAULT '".$_REQUEST["default_value"]."' ";
			break;
	}
	
	$query .= " NOT NULL";
	$result = query($query);
}
elseif($_REQUEST["action"] == "delete_field"){
	$field = new field($_REQUEST["id"]);
	
	$query = "ALTER TABLE `anyInventory_items` DROP `".$field->name."`";
	$result = query($query);
	
	$query = "DELETE FROM `anyInventory_fields` WHERE `id`='".$field->id."'";
	$result = query($query);
}

header("Location: fields.php");

?>