<?php

function connect_to_database(){
	// This function opens and returns the database connection.
	global $dsn;
	
	$options = array('portability' => DB_PORTABILITY_ALL);
	
	$db = DB::connect($dsn, $options);
	
	if (DB::isError($db)) {
		die($db->getMessage());
	}
	
	$db->setFetchMode(DB_FETCHMODE_ASSOC);
	
	$db->createSequence('items');
	$db->createSequence('fields');
	$db->createSequence('categories');
	$db->createSequence('users');
	$db->createSequence('alerts');
	$db->createSequence('files');
	
	return $db;
}

function display($output){
	// This function displays a page with the content in $output.
	// $title should be declared before calling display()
	
	global $title;
	global $inHead;
	global $inBodyTag;
	global $breadcrumbs;
	global $sectionTitle;
	global $db;
	
	global $DIR_PREFIX;
	
	header("Content-Type: text/html; charset=ISO-8859-1");
	include($DIR_PREFIX."header.php");
	echo $output;
	include($DIR_PREFIX."footer.php");
	exit;
}

function get_category_options($selected = null, $multiple = true, $exclude = null){
	// This function returns the options for a category dropdown.
	// Any category id's in the array $selected will be selected in the 
	// resulting list.
	
	if (!is_array($selected)) $selected = array($selected);
	if (!is_array($exclude)) $exclude = array($exclude);
	
	$output .= get_options_children(0, '', $selected, $multiple, $exclude);
	
	return $output;
}

function get_options_children($id, $pre = null, $selected = null, $multiple = true, $exclude){
	global $db;
	
	// This function creates select box options for the children of a category
	// with the id $id.
	
	$query = "SELECT `id`,`name` FROM `anyInventory_categories` WHERE `parent`='".$id."' ORDER BY `name` ASC";
	$result = $db->query($query) or die($db->error() . '<br /><br />'. $query);
	
	if ($id != 0){
		$newquery = "SELECT `name` FROM `anyInventory_categories` WHERE `id`='".$id."'";
		$newresult = $db->query($newquery) or die($db->error() . '<br /><br />'. $newquery);
		$names = $newresult->fetchRow();
		$category_name = $names[0];
		$pre .= $category_name . ' > ';
	}
	
	$list = '';
	
	if ($result->numRows() > 0){
		while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
			$category = $row["name"];
			
			if (!in_array($row["id"],$exclude)){
				$list .= '<option value="'.$row["id"].'"';
				if ((($selected[0] === null) && ($multiple == true)) || (in_array($row["id"],$selected))) $list .= ' selected="selected"';
				$list .= '>'.$pre . $category.'</option>';
			}
			
			$list .= get_options_children($row["id"], $pre, $selected, $multiple, $exclude);
		}
	}
	
	return $list;
}

function category_array_to_options($array, $selected = null, $exclude = null){
	if (!is_array($selected)) $selected = array($selected);
	if (!is_array($exclude)) $exclude = array($exclude);
	
	if (is_array($array)){
		foreach($array as $cat_id){
			if (!in_array($cat_id,$exclude)){
				$category = new category($cat_id);
				
				$output .= '<option value="'.$cat_id.'"';
				if (in_array($cat_id, $selected)) $output .= ' selected="selected"';
				$output .= '>'.$category->breadcrumb_names.'</option>';
			}
		}
	}
	
	return $output;
}

function get_item_options($cat_ids = 0, $selected = null){
	global $db;
	
	// This function creates select box options for the items in the category $cat.
	if (!is_array($selected)) $selected = array($selected);
	if (!is_array($cat_ids)) $cat_ids = array($cat_ids);
	
	$query = "SELECT `id`,`name` FROM `anyInventory_items` WHERE `item_category` IN (";
	
	foreach($cat_ids as $cat_id){
		$query .= $cat_id.", ";
	}
	
	$query = substr($query, 0, strlen($query) - 2);
	
	$query .= ")";
	$result = $db->query($query) or die($db->error() . '<br /><br />'. $query);
	
	while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
		$options .= '<option value="'.$row["id"].'"';
		if (($selected[0] === null) || (in_array($row["id"],$selected))) $options .= ' selected="selected"';
		$options .= '>'.$row["name"].'</option>';
	}
	
	return $options;
}

function get_fields_checkbox_area($checked = array()){
	global $db;
	
	// This function returns the field checkboxes.
	// Any field ids in the array $checked will be checked.
	
	$query = "SELECT `id` FROM `anyInventory_fields` ORDER BY `importance` ASC";
	$result = $db->query($query) or die($db->error() . '<br /><br />'. $query);
	
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
		$field = new field($row["id"]);
		
		if ($field->input_type == 'divider'){
			$output .= '<hr />';
		}
		else{
			$output .= '
				<input type="checkbox" name="fields['.$field->id.']" value="yes" ';
					if ((is_array($checked)) && (in_array($field->id, $checked))) $output .= ' checked="checked"';
					$output .= ' />
					'.$field->name.' ('.$field->input_type;
					
					if ($field->input_type == "text"){
						$output .= '; '.$field->size.' characters';
					}
					elseif (($field->input_type != 'file') && ($field->input_type != 'item')){
						$output .= '; values: ';
						
						if (is_array($field->values)){
							foreach($field->values as $val){
								$output .= $val .', ';
							}
							$output = substr($output, 0, strlen($output) - 2);
						}
					}
					
			$output .= ')<br />';
		}
	}
	
	return $output;
}

function get_category_array($top = 0){
	global $db;
	
	// This function returns an array of categories, starting with
	// the category id'd by $top and working down.
	
	$array = array();
	
	if ($top != 0){
		$query = "SELECT `name` FROM `anyInventory_categories` WHERE `id`='".$top."'";
		$result = $db->query($query) or die($db->error() . '<br /><br />'. $query);
		
		if ($result->numRows() > 0){
			$row = $result->fetchRow();
			$array[] = array("name"=>$row(0),"id"=>$top);
		}
		else{
			return $array;
		}
	}
	
	get_array_children($top, $array);
	
	return $array;
}

function get_array_children($id, &$array, $pre = ""){
	global $db;
	
	// This function creates array entries for any child of $id.
	
	$query = "SELECT `name`,`id` FROM `anyInventory_categories` WHERE `parent`='".$id."' ORDER BY `name` ASC";
	$result = $db->query($query) or die($db->error() . '<br /><br />'. $query);
	
	if ($id != 0){
		$newquery = "SELECT `name` FROM `anyInventory_categories` WHERE `id`='".$id."'";
		$newresult = $db->query($newquery) or die($db->error() . '<br /><br />'. $newquery);
		$names = $newresult->fetchRow();
		$pre .= $names[0] . ' > ';
	}
	
	if ($result->numRows() > 0){
		while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
			$array[] = array("name"=>$pre.$row["name"],"id"=>$row["id"]);
			
			get_array_children($row["id"], $array, $pre);
		}
	}
}

function get_category_id_array($top = 0){
	// This function returns an array of categories, starting with
	// the category id'd by $top and working down.
	
	$array = array();
	
	if ($top != 0){
		if ($result->numRows() > 0){
			$array[] = $top;
		}
		else{
			return $array;
		}
	}
	
	get_array_id_children($top, $array);
	
	return $array;
}

function get_array_id_children($id, &$array){
	global $db;
	
	// This function creates array entries for any child of $id.
	
	$query = "SELECT `id` FROM `anyInventory_categories` WHERE `parent`='".$id."' ORDER BY `name` ASC";
	$result = $db->query($query) or die($db->error() . '<br /><br />'. $query);
	
	if ($result->numRows() > 0){
		while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
			$array[] = $row["id"];
			
			get_array_id_children($row["id"], $array);
		}
	}
}

function delete_subcategories($category){
	// This function deletes any subcategories of $category.
	
	if (is_array($category->children_ids)){
		foreach($category->children_ids as $child_id){
			$child = new category($child_id);
			delete_subcategory($child);
		}
	}
	
	return;
}

function delete_subcategory($category){
	global $db;
	
	// This function deletes a subcategory $category and its children.
	
	if (is_array($category->children_ids)){
		foreach($category->children_ids as $child_id){
			$child = new category($child_id);
			delete_subcategories($child);
		}
	}
	
	$query = "SELECT `id` FROM `anyInventory_items` WHERE `item_category`='".$category->id."'";
	$result = $db->query($query) or die($db->error() . '<br /><br />'. $query);
	
	while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
		$newquery = "SELECT `id` FROM `anyInventory_alerts` WHERE `item_ids` LIKE '%\"".$row["id"]."\"%'";
		$newresult = $db->query($newquery) or die($db->error() . '<br /><br />'. $newquery);
		
		while ($newrow = $newresult->fetchRow(DB_FETCHMODE_ASSOC)){
			$alert = new alert($newrow["id"]);
			
			$alert->remove_item($row["id"]);
			
			if (count($alert->item_ids) == 0){
				$newerquery = "DELETE FROM `anyInventory_alerts` WHERE `id`='".$alert->id."'";
				$db->query($newerquery) or die($db->error() . '<br /><br />'. $newerquery);
			}
		}
		
		$query = "DELETE FROM `anyInventory_values` WHERE `item_id`='".$row["id"]."'";
		$db->query($query) or die($db->error() . '<br /><br />'. $query);
	}
	
	// Delete all of the items in the category
	$query = "DELETE FROM `anyInventory_items` WHERE `item_category`='".$category->id."'";
	$db->query($query) or die($db->error() . '<br /><br />'. $query);
	
	// Delete this category.
	$query = "DELETE FROM `anyInventory_categories` WHERE `id`='".$category->id."'";
	$db->query($query) or die($db->error() . '<br /><br />'. $query);
	
	remove_from_fields($category->id);
	
	return;
}

function remove_from_fields($cat_id){
	global $db;
	
	// This function removes all fields from a category.
	$query = "SELECT `id` FROM `anyInventory_fields` WHERE `categories` LIKE '%\"".$cat_id."\"%'";
	$result = $db->query($query) or die($db->error() . '<br /><br />'. $query);
	
	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
		$field = new field($row["id"]);
		$field->remove_category($cat_id);
	}
	
	return;
}

?>
