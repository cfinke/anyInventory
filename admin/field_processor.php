<?php

include("globals.php");

if ($_REQUEST["action"] == "do_add"){
	if (($_REQUEST["size"] == '') && ($_REQUEST["input_type"] == "text")){
		$_REQUEST["size"] = 255;
	}
	
	$query = "ALTER TABLE `anyInventory_items` ADD `".$_REQUEST["name"]."`";
	
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
			
			$enums = explode(",",$_REQUEST["values"]);
			
			foreach($enums as $enum){
				$query .= "'".trim(str_replace("'","",str_replace('"','',$enum)))."',";
			}
			
			$query = substr($query, 0, strlen($query) - 1);
			
			$query .= ") DEFAULT '' ";
			break;
	}
	
	$query .= " NOT NULL";
	$result = query($query);
	
	$query = "SELECT MAX(`importance`) as `biggest` FROM `anyInventory_fields`";
	$result = query($query);
	$importance = mysql_result($result, 0, 'biggest') + 1;
	
	$query = "INSERT INTO `anyInventory_fields` (`name`,`input_type`,`values`,`default_value`,`size`,`categories`,`importance`) VALUES ('".$_REQUEST["name"]."','".$_REQUEST["input_type"]."','".$_REQUEST["values"]."','".$_REQUEST["default_value"]."','".$_REQUEST["size"]."','0','".$importance."')";
	$result = query($query);
	
	$field = new field(mysql_insert_id());
	
	if (is_array($_REQUEST["add_to"])){
		foreach($_REQUEST["add_to"] as $cat_id){
			$field->add_category($cat_id);
		}
	}
}
elseif($_REQUEST["action"] == "do_edit"){
	$old_field = new field($_REQUEST["id"]);
	
	if ($_REQUEST["input_type"] == "text"){
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
	
	$new_field = new field($_REQUEST["id"]);
	
	if (is_array($old_field->categories)){
		foreach($old_field->categories as $cat_id){
			$new_field->remove_category($cat_id);
		}
	}
	
	if (is_array($_REQUEST["add_to"])){
		foreach($_REQUEST["add_to"] as $cat_id){
			$new_field->add_category($cat_id);
		}
	}
}
elseif($_REQUEST["action"] == "do_delete"){
	$field = new field($_REQUEST["id"]);
	
	$query = "UPDATE `anyInventory_fields` SET `importance`=(`importance` + 1) WHERE `importance` < '".$field->importance."'";
	$result = query($query);
	
	$query = "ALTER TABLE `anyInventory_items` DROP `".$field->name."`";
	$result = query($query);
	
	$query = "DELETE FROM `anyInventory_fields` WHERE `id`='".$field->id."'";
	$result = query($query);
}
elseif($_REQUEST["action"] == "moveup"){
	$query = "UPDATE `anyInventory_fields` SET `importance`=".$_REQUEST["i"]." WHERE `importance`='".($_REQUEST["i"] - 1)."'";
	$result = query($query);
	
	$query = "UPDATE `anyInventory_fields` SET `importance`=".($_REQUEST["i"] - 1)." WHERE `id`='".$_REQUEST["id"]."'";
	$result = query($query);
}
elseif($_REQUEST["action"] == "movedown"){
	$query = "UPDATE `anyInventory_fields` SET `importance`=".$_REQUEST["i"]." WHERE `importance`='".($_REQUEST["i"] + 1)."'";
	$result = query($query);
	
	$query = "UPDATE `anyInventory_fields` SET `importance`=".($_REQUEST["i"] + 1)." WHERE `id`='".$_REQUEST["id"]."'";
	$result = query($query);
}

header("Location: fields.php");

?>