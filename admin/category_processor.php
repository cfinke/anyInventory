<?php

require_once("globals.php");

if ($_POST["action"] == "do_add"){
	if (!$admin_user->can_admin($_POST["parent"])){
		header("Location: ../error_handler.php?eid=13");
		exit;
	}
	else{
		// Add a category.
		$this_id = nextId("categories");
		$query = "INSERT INTO ".$db->quoteIdentifier('anyInventory_categories')." (".$db->quoteIdentifier('id').",".$db->quoteIdentifier('name').",".$db->quoteIdentifier('parent').",".$db->quoteIdentifier('auto_inc_field').") VALUES ('".$this_id."', '".stripslashes($_POST['name'])."', '".$_POST['parent']."', '".intval(($_POST['auto_inc'] == 'yes'))."')";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		if ($_POST["inherit_fields"] == "yes"){
			// Add the fields from the parent category
			$parent = new category($_POST["parent"]);
			
			if(is_array($parent->field_ids)){
				foreach($parent->field_ids as $field_id){
					$field = new field($field_id);
					$field->add_category($this_id);
				}
			}
		}
		
		// Add the checked fields
		if (is_array($_POST["fields"])){
			foreach($_POST["fields"] as $key => $value){
				$field = new field($key);
				$field->add_category($this_id);
			}
		}
		
		if (is_array($_POST["view_users"])){
			foreach($_POST["view_users"] as $user_id){
				$temp_user = new user($user_id);
				$temp_user->add_category_view($this_id);
			}
		}
		
		if (is_array($_POST["admin_users"])){
			foreach($_POST["admin_users"] as $user_id){
				$temp_user = new user($user_id);
				$temp_user->add_category_admin($this_id);
			}
		}
	}
}
elseif($_POST["action"] == "do_edit"){
	if ($_POST["cancel"] != CANCEL){
		if (!$admin_user->can_admin($_POST["parent"]) || (!$admin_user->can_admin($_POST["id"]))){
			header("Location: ../error_handler.php?eid=13");
			exit;
		}
		
		// Make an object from the unchanged category
		$old_category = new category($_POST["id"]);
		
		// Change the category information
		$query = "UPDATE " . $db->quoteIdentifier('anyInventory_categories') . " SET 
					" . $db->quoteIdentifier('name') . "='".$_POST["name"]."',
					" . $db->quoteIdentifier('parent') . "='".$_POST["parent"]."',
					" . $db->quoteIdentifier('auto_inc_field') . "='".((int) (($_POST["auto_inc"] == "yes") / 1))."'
					WHERE " . $db->quoteIdentifier('id') . "='".$_POST["id"]."'";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		// Remove the category from all of the fields
		if (is_array($old_category->field_ids)){
			foreach($old_category->field_ids as $field_id){
				$temp_field = new field($field_id);
				$temp_field->remove_category($old_category->id);
			}
		}
		
		if ($_POST["inherit_fields"] == "yes"){
			// Add the fields from the parent category
			$parent = new category($_POST["parent"]);
			
			if(is_array($parent->field_ids)){
				foreach($parent->field_ids as $field_id){
					$field = new field($field_id);
					$field->add_category($_POST["id"]);
				}
			}
		}
		
		// Add the checked fields
		if (is_array($_POST["fields"])){
			foreach($_POST["fields"] as $key => $value){
				$temp_field2 = new field($key);
				$temp_field2->add_category($_POST["id"]);
			}
		}
		
		if ($_POST["apply_fields"] == "yes"){
			// Apply the fields of this category to all of the children
			$category = new category($_POST["id"]);
			
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
		
		$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_users') . " WHERE " . $db->quoteIdentifier('usertype') . " != 'Administrator'";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		if (PP_ADMIN || PP_VIEW){
				while ($row =$result->fetchRow()){
				$temp_user = new user($row["id"]);
				if (PP_ADMIN) $temp_user->remove_category_admin($_POST["id"]);
				if (PP_VIEW) $temp_user->remove_category_view($_POST["id"]);
			}
			
			if (PP_VIEW){
				if (is_array($_POST["view_users"])){
					foreach($_POST["view_users"] as $user_id){
						$temp_user = new user($user_id);
						$temp_user->add_category_view($_POST["id"]);
					}
				}
			}
			
			if (PP_ADMIN){
				if (is_array($_POST["admin_users"])){
					foreach($_POST["admin_users"] as $user_id){
						$temp_user = new user($user_id);
						$temp_user->add_category_admin($_POST["id"]);
					}
				}
			}
		}
	}
}
elseif($_POST["action"] == "do_delete"){
	// Make sure the user clicked "Delete" and not "Cancel"
	if ($_POST["delete"] == _DELETE){
		$category = new category($_POST["id"]);
		
		if ($_POST["item_action"] == 'delete'){
			$category->move_items();
		}
		elseif($_POST["item_action"] == "move"){
			$category->move_items($_POST["move_items_to"]);
		}
			
		if ($_POST["subcat_action"] == "delete"){
			$category->delete_subcats();
		}
		elseif($_POST["subcat_action"] == "move"){
			$category->move_subcats($_POST["move_subcats_to"]);
		}
		
		$category->delete_self();
	}
}

header("Location: categories.php");

?>
