<?php

// Remove the whitespace from the ends of each $_REQUEST value
if (is_array($_REQUEST)){
	foreach($_REQUEST as $key => $value){
		if (!is_array($_REQUEST[$key])) $_REQUEST[$key] = trim($value);
	}
}

function connect_to_database(){
	// This function opens and returns the database connection.
	global $db_host;
	global $db_name;
	global $db_user;
	global $db_pass;
	
	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($db_name, $link);
	
	return $link;
}

function display($output){
	// This function displays a page with the content in $output.
	// $title should be declared before calling display()
	
	global $title;
	global $inHead;
	global $inBodyTag;
	global $breadcrumbs;
	global $sectionTitle;
	global $admin_pass;
	
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
	// This function creates select box options for the children of a category
	// with the id $id.
	
	$query = "SELECT `id`,`name` FROM `anyInventory_categories` WHERE `parent`='".$id."' ORDER BY `name` ASC";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	if ($id != 0){
		$newquery = "SELECT `name` FROM `anyInventory_categories` WHERE `id`='".$id."'";
		$newresult = mysql_query($newquery) or die(mysql_error() . '<br /><br />'. $newquery);
		$category_name = mysql_result($newresult, 0, 'name');
		$pre .= $category_name . ' > ';
	}
	
	$list = '';
	
	if (mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)){
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

function category_array_to_options($array, $selected = null){
	if (!is_array($selected)) $selected = array($selected);
	
	if (is_array($array)){
		foreach($array as $cat_id){
			$category = new category($cat_id);
			
			$output .= '<option value="'.$cat_id.'"';
			if (in_array($cat_id, $selected)) $output .= ' selected="selected"';
			$output .= '>'.$category->breadcrumb_names.'</option>';
		}
	}
	
	return $output;
}

function get_item_options($cat_ids = 0, $selected = null){
	// This function creates select box options for the items in the category $cat.
	if (!is_array($selected)) $selected = array($selected);
	if (!is_array($cat_ids)) $cat_ids = array($cat_ids);
	
	$query = "SELECT `id`,`name` FROM `anyInventory_items` WHERE `item_category` IN (";
	
	foreach($cat_ids as $cat_id){
		$query .= $cat_id.", ";
	}
	
	$query = substr($query, 0, strlen($query) - 2);
	
	$query .= ")";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	while ($row = mysql_fetch_array($result)){
		$options .= '<option value="'.$row["id"].'"';
		if (($selected[0] === null) || (in_array($row["id"],$selected))) $options .= ' selected="selected"';
		$options .= '>'.$row["name"].'</option>';
	}
	
	return $options;
}

function get_fields_checkbox_area($checked = array()){
	// This function returns the field checkboxes.
	// Any field ids in the array $checked will be checked.
	
	$query = "SELECT `id` FROM `anyInventory_fields` ORDER BY `importance` ASC";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	while($row = mysql_fetch_array($result)){
		$field = new field($row["id"]);
		
		$output .= '
			<input type="checkbox" name="fields['.$field->id.']" value="yes" ';
				if ((is_array($checked)) && (in_array($field->id, $checked))) $output .= ' checked="checked"';
				$output .= ' />
				'.$field->name.' ('.$field->input_type.'; ';
				if ($field->input_type == "text"){
					$output .= ' '.$field->size.' characters';
				}
				else{
					$output .= ' values: ';
					
					if (is_array($field->values)){
						foreach($field->values as $val){
							$output .= $val .', ';
						}
						$output = substr($output, 0, strlen($output) - 2);
					}
				}
				
				$output .= ')<br />';
	}
	
	return $output;
}

function get_category_array($top = 0){
	// This function returns an array of categories, starting with
	// the category id'd by $top and working down.
	
	$array = array();
	
	if ($top != 0){
		$query = "SELECT `name` FROM `anyInventory_categories` WHERE `id`='".$top."'";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
		
		if (mysql_num_rows($result) > 0){
			$array[] = array("name"=>mysql_result($result, 0, 'name'),"id"=>$top);
		}
		else{
			return $array;
		}
	}
	
	get_array_children($top, $array);
	
	return $array;
}

function get_array_children($id, &$array, $pre = ""){
	// This function creates array entries for any child of $id.
	
	$query = "SELECT `name`,`id` FROM `anyInventory_categories` WHERE `parent`='".$id."' ORDER BY `name` ASC";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	if ($id != 0){
		$newquery = "SELECT `name` FROM `anyInventory_categories` WHERE `id`='".$id."'";
		$newresult = mysql_query($newquery) or die(mysql_error() . '<br /><br />'. $newquery);
		$pre .= mysql_result($newresult, 0, 'name') . ' > ';
	}
	
	if (mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)){
			$array[] = array("name"=>$pre.$row["name"],"id"=>$row["id"]);
			
			get_array_children($row["id"], $array, $pre);
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
	// This function deletes a subcategory $category and its children.
	
	if (is_array($category->children_ids)){
		foreach($category->children_ids as $child_id){
			$child = new category($child_id);
			delete_subcategories($child);
		}
	}
	
	// Delete all items in the current category.
	$query = "DELETE FROM `anyInventory_items` WHERE `item_category`='".$category->id."'";
	mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	// Reset the parent of this categories subcategories
	$query = "UPDATE `anyInventory_categories` SET `parent`='".$category->parent_id."' WHERE `parent`='".$category->id."'";
	mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	// Delete this caegory.
	$query = "DELETE FROM `anyInventory_categories` WHERE `id`='".$category->id."'";
	mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	remove_from_fields($category->id);
	
	return;
}

function remove_from_fields($cat_id){
	// This function removes all fields from a category.
	$query = "SELECT `id` FROM `anyInventory_fields` WHERE `categories` LIKE '%\"".$cat_id."\"%'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	while($row = mysql_fetch_array($result)){
		$field = new field($row["id"]);
		$field->remove_category($cat_id);
	}
	
	return;
}

function get_mysql_column_type($input_type, $size, $values, $default_value){
	// This function returns the MySQL column type for a new field.
	
	switch($input_type){
		case 'file':
			$type = " INT ";
			break;
		case 'checkbox':
			$type = " TEXT ";
			break;
		case 'multiple':
			$size = 64;
		case 'text':
			if ($size < 256){
				$type = " VARCHAR(".$size.") DEFAULT '".$default_value."' ";
			}
			else{
				// Text fields cannot have a default value.
				$type = " TEXT ";
			}
			break;
		case 'radio':
		case 'select':
			$type = " ENUM(";
			
			$enums = explode(",",$values);
			
			if (is_array($enums)){
				foreach($enums as $enum){
					$type .= "'".trim($enum)."',";
				}
				
				$type = substr($type, 0, strlen($type) - 1);
			}
			else{
				$type .= "''";
			}
			
			$type .= ") DEFAULT '".$default_value."' ";
			break;
	}
	
	$type .= " NOT NULL";
	
	return $type;
}

function get_config_value($key){
	$query = "SELECT * FROM `anyInventory_config` WHERE `key`='".$key."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	if (mysql_num_rows($result) > 0){
		return mysql_result($result, 0, 'value');
	}
	else{
		return '';
	}
}

?>