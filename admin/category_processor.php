<?php

include("globals.php");

if ($_REQUEST["action"] == "do_add"){
	if (!$admin_user->can_admin($_REQUEST["parent"])){
		header("Location: ../error_handler.php?eid=13");
		exit;
	}
	else{
		// Add a category.
		$query = "INSERT INTO `anyInventory_categories` (`name`,`parent`,`auto_inc_field`) VALUES ('".$_REQUEST["name"]."','".$_REQUEST["parent"]."','".((int) (($_REQUEST["auto_inc"] == "yes") / 1))."')";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
		
		// Get the id of the category
		$this_id = mysql_insert_id();
		
		if ($_REQUEST["inherit_fields"] == "yes"){
			// Add the fields from the parent category
			$parent = new category($_REQUEST["parent"]);
			
			if(is_array($parent->field_ids)){
				foreach($parent->field_ids as $field_id){
					$field = new field($field_id);
					$field->add_category($this_id);
				}
			}
		}
		
		// Add the checked fields
		if (is_array($_REQUEST["fields"])){
			foreach($_REQUEST["fields"] as $key => $value){
				$field = new field($key);
				$field->add_category($this_id);
			}
		}
		
		$admin_user->add_category_admin($this_id);
		$admin_user->add_category_view($this_id);
		
		$view_user->add_category_view($this_id);
		$view_user->add_category_admin($this_id);
	}
}
elseif($_REQUEST["action"] == "do_edit"){
	if (!$admin_user->can_admin($_REQUEST["parent"]) || (!$admin_user->can_admin($_REQUEST["id"]))){
		header("Location: ../error_handler.php?eid=13");
		exit;
	}
	
	// Make an object from the unchanged category
	$old_category = new category($_REQUEST["id"]);
	
	// Change the category information
	$query = "UPDATE `anyInventory_categories` SET 
				`name`='".$_REQUEST["name"]."',
				`parent`='".$_REQUEST["parent"]."',
				`auto_inc_field`='".((int) (($_REQUEST["auto_inc"] == "yes") / 1))."'
				WHERE `id`='".$_REQUEST["id"]."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	// Remove the category from all of the fields
	if (is_array($old_category->field_ids)){
		foreach($old_category->field_ids as $field_id){
			$temp_field = new field($field_id);
			$temp_field->remove_category($old_category->id);
		}
	}
	
	if ($_REQUEST["inherit_fields"] == "yes"){
		// Add the fields from the parent category
		$parent = new category($_REQUEST["parent"]);
		
		if(is_array($parent->field_ids)){
			foreach($parent->field_ids as $field_id){
				$field = new field($field_id);
				$field->add_category($_REQUEST["id"]);
			}
		}
	}
	
	// Add the checked fields
	if (is_array($_REQUEST["fields"])){
		foreach($_REQUEST["fields"] as $key => $value){
			$temp_field2 = new field($key);
			$temp_field2->add_category($_REQUEST["id"]);
		}
	}
	
	if ($_REQUEST["apply_fields"] == "yes"){
		// Apply the fields of this category to all of the children
		$category = new category($_REQUEST["id"]);
		
		$children = get_category_array($category->id);
		
		if (is_array($children)){
			foreach($children as $child){
				remove_from_fields($child["id"]);
				
				if (is_array($category->field_ids)){
					foreach($category->field_ids as $field_id){
						$field = new field($field_id);
						$field->add_category($child["id"]);
					}
				}
			}
		}
	}
}
elseif($_REQUEST["action"] == "do_delete"){
	// Make sure the user clicked "Delete" and not "Cancel"
	if ($_REQUEST["delete"] == "Delete"){
		if (!$admin_user->can_admin($_REQUEST["id"])){
			header("Location: ../error_handler.php?eid=13");
			exit;
		}
		else{
			// Create an object from the category
			$category = new category($_REQUEST["id"]);
			
			// Delete the category
			$query = "DELETE FROM `anyInventory_categories` WHERE `id`='".$_REQUEST["id"]."'"; 
			$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
			
			if ($_REQUEST["item_action"] == "delete"){
				// Delete all of the items in the category
				$query = "DELETE FROM `anyInventory_items` WHERE `item_category`='".$category->id."'";
				$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
			}
			elseif($_REQUEST["item_action"] == "move"){
				// Move the items to a different category
				$query = "UPDATE `anyInventory_items` SET `item_category`='".$_REQUEST["move_items_to"]."' WHERE `item_category`='".$category->id."'";
				$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
			}
			
			if ($_REQUEST["subcat_action"] == "delete"){
				// Delete the subcategories
				delete_subcategories($category);
			}
			elseif($_REQUEST["subcat_action"] == "move"){
				// Move the subcategories
				$query = "UPDATE `anyInventory_categories` SET `parent`='".$_REQUEST["move_subcats_to"]."' WHERE `parent`='".$category->id."'";
				$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
			}
			
			// Remove all of the fields from this category.
			remove_from_fields($category->id);
		}
	}
}

header("Location: categories.php");

?>