<?php

include("globals.php");

$sized_input_types = array("text","multiple");

if ($_REQUEST["action"] == "do_add"){
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
				$query .= "'".trim(str_replace("'","",str_replace('"','',$enum)))."',";
			}
			
			$query = substr($query, 0, strlen($query) - 1);
			
			$query .= ") DEFAULT '".$_REQUEST["default_value"]."' ";
			break;
	}
	
	$query .= " NOT NULL";
	$result = query($query);
}
elseif($_REQUEST["action"] == "do_edit"){
	$old_field = new field($_REQUEST["id"]);
	
	if (in_array($_REQUEST["input_type"], $sized_input_types)){
		if($_REQUEST["size"] == 0){
			$_REQUEST["size"] = 255;
		}
	}
	else{
		$_REQUEST["size"] = '';
	}
	
	$query = "UPDATE `anyInventory_fields` SET
				`name`='".$_REQUEST["name"]."',
				`input_type`='".$_REQUEST["input_type"]."',
				`values`='".$_REQUEST["values"]."',
				`default_value`='".$_REQUEST["default_value"]."',
				`size`='".$_REQUEST["size"]."'
				WHERE `id`='".$_REQUEST["id"]."'";
	$result = query($query);
	
	$query = "ALTER TABLE `anyInventory_items` CHANGE `".$old_field->name."` `".$_REQUEST["name"]."` ";
 	$query .= get_mysql_column_type($_REQUEST["input_type"], $_REQUEST["size"], $_REQUEST["values"], $_REQUEST["default_value"]);

	$result = query($query);
}
elseif($_REQUEST["action"] == "do_delete"){
	$field = new field($_REQUEST["id"]);
	
	$query = "ALTER TABLE `anyInventory_items` DROP `".$field->name."`";
	$result = query($query);
	
	$query = "DELETE FROM `anyInventory_fields` WHERE `id`='".$field->id."'";
	$result = query($query);
}

header("Location: fields.php");

?>