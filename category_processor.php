<?php

include("globals.php");

if ($_REQUEST["action"] == "do_add"){
	$query = "INSERT INTO `anyInventory_categories` (`name`,`parent`) VALUES ('".$_REQUEST["name"]."','".$_REQUEST["parent"]."')";
	$result = query($query);
	
	$this_id = mysql_insert_id();
	
	if ($_REQUEST["inherit_fields"] == "yes"){
		$parent = new category($_REQUEST["parent"]);
		
		if(is_array($parent->field_ids)){
			foreach($parent->field_ids as $field_id){
				$field = new field($field_id);
				$field->add_category($this_id);
			}
		}
	}
	
	if (is_array($_REQUEST["fields"])){
		foreach($_REQUEST["fields"] as $key => $value){
			$field = new field($key);
			$field->add_category($this_id);
		}
	}
}
elseif($_REQUEST["action"] == "do_edit"){
	$old_category = new category($_REQUEST["id"]);
	
	$query = "UPDATE `anyInventory_categories` SET `name`='".$_REQUEST["name"]."',`parent`='".$_REQUEST["parent"]."' WHERE `id`='".$_REQUEST["id"]."'";
	$result = query($query);
	
	if (is_array($old_category->field_ids)){
		foreach($old_category->field_ids as $field_id){
			$temp_field = new field($field_id);
			$temp_field->remove_category($old_category->id);
		}
	}
	
	if (is_array($_REQUEST["fields"])){
		foreach($_REQUEST["fields"] as $key => $value){
			$temp_field2 = new field($key);
			$temp_field2->add_category($_REQUEST["id"]);
		}
	}
	
	if ($_REQUEST["apply_fields"] == "yes"){
		$category = new category($_REQUEST["id"]);
		
		$children = get_category_array($category->id);
		
		foreach($children as $child){
			remove_from_fields($child["id"]);
			
			foreach($category->field_ids as $field_id){
				$field = new field($field_id);
				$field->add_category($child["id"]);
			}
		}
	}
}
elseif($_REQUEST["action"] == "do_delete"){
	if ($_REQUEST["delete"] == "Delete"){
		$category = new category($_REQUEST["id"]);
		
		$query = "DELETE FROM `anyInventory_categories` WHERE `id`='".$_REQUEST["id"]."'"; 
		$result = query($query);
		
		if ($_REQUEST["item_action"] == "delete"){
			$query = "DELETE FROM `anyInventory_items` WEHRE `item_category`='".$category->id."'";
			$result = query($query);
		}
		elseif($_REQUEST["item_action"] == "move"){
			$query = "UPDATE `anyInventory_items` SET `item_category`='".$_REQUEST["move_items_to"]."'";
			$result = query($query);
		}
		
		if ($_REQUEST["subcat_action"] == "delete"){
			delete_subcategories($category);
		}
		elseif($_REQUEST["subcat_action"] == "move"){
			$query = "UPDATE `anyInventory_categories` SET `parent`='".$_REQUEST["move_subcats_to"]."' WHERE `parent`='".$category->id."'";
			$result = query($query);
		}
		
		remove_from_fields($category->id);
	}
}

header("Location: categories.php");

?>