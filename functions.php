<?php

function connect_to_database(){
	global $db_host;
	global $db_name;
	global $db_user;
	global $db_pass;
	
	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($db_name, $link);
	
	return $link;
}

function query($query){
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	return $result;
}

function fetch_array($result){
	$row = mysql_fetch_array($result);
	
	return $row;
}

function num_rows($result){
	return mysql_num_rows($result);
}

function result($result, $row, $field){
	return mysql_result($result, $row, $field);
}

function insert_id(){
	return mysql_insert_id();
}


function get_category_dropdown($selected = 0){
	$output = '<option value="0">Top Level</option>';
	$output .= get_dropdown_children(0, '', $selected);
	
	return $output;
}

function get_dropdown_children($id, $pre = "", $selected = 0){
	$query = "SELECT * FROM `anyInventory_categories` WHERE `parent`='".$id."' ORDER BY `name` ASC";
	$result = query($query);
	
	if ($id != 0){
		$newquery = "SELECT `name` FROM `anyInventory_categories` WHERE `id`='".$id."'";
		$newresult = query($newquery);
		$category_name = result($newresult, 0, 'name');
		$pre .= $category_name . ' > ';
	}
	
	$list = '';
	
	if (num_rows($result) > 0){
		while ($row = fetch_array($result)){
			$category = $row["name"];
			
			$list .= '<option value="'.$row["id"].'"';
			if ($row["id"] == $selected) $list .= ' selected="selected"';
			$list .= '>'.$pre . $category.'</option>';
			
			$list .= get_dropdown_children($row["id"], $pre, $selected);
		}
	}
	
	return $list;
}

function get_fields_checkbox_area($checked = array()){
	$query = "SELECT * FROM `anyInventory_fields` WHERE 1 ORDER BY `name` ASC";
	$result = query($query);
	
	$num_fields = num_rows($result);
	
	$output .= '<div id="field_checkboxes">
		<div style="float: left;">';
	
	for ($i = 0; $i < ceil($num_fields / 2); $i++){
		$output .= '<div class="checkbox"><input type="checkbox" name="fields['.result($result, $i, "id").']" value="yes" ';
		if ((is_array($checked)) && (in_array(result($result, $i, "id"), $checked))) $output .= ' checked="checked"';
		$output .= ' /> '.result($result, $i, "name").'</div>';
	}
	
	$output .= '</div>
		<div>';
	
	for (; $i < $num_fields; $i++){
		$output .= '<div class="checkbox"><input type="checkbox" name="fields['.result($result, $i, "id").']" value="yes" ';
		if ((is_array($checked)) && (in_array(result($result, $i, "id"), $checked))) $output .= ' checked="checked"';
		$output .= '/> '.result($result, $i, "name").'</div>';	
	}
	
	$output .= '</div>';
	
	return $output;
}

function get_category_array(){
	$array = array();
	
	get_array_children(0, $array);
	
	return $array;
}

function get_array_children($id, &$array, $pre = ""){
	$query = "SELECT `name`,`id` FROM `anyInventory_categories` WHERE `parent`='".$id."' ORDER BY `name` ASC";
	$result = query($query);
	
	if ($id != 0){
		$newquery = "SELECT `name` FROM `anyInventory_categories` WHERE `id`='".$id."'";
		$newresult = query($newquery);
		$pre .= result($newresult, 0, 'name') . ' > ';
	}
	
	if (num_rows($result) > 0){
		while ($row = fetch_array($result)){
			$array[] = array("name"=>$pre.$row["name"],"id"=>$row["id"]);
						
			get_array_children($row["id"], $array, $pre);
		}
	}
}

function delete_subcategories($category){
	if (is_array($category->children)){
		foreach($category->children as $child){
			delete_subcategory($child);
		}
	}
	
	return;
}

function delete_subcategory($category){
	if (is_array($category->children)){
		foreach($category->children as $child){
			delete_subcategories($child);
		}
	}
	
	$query = "DELETE FROM `anyInventory_items` WHERE `item_category`='".$category->id."'";
	$result = query($query);
	
	$query = "UPDATE `anyInventory_categories` SET `parent`='".$category->parent_id."' WHERE `parent`='".$category->id."'";
	$result = query($query);
	
	$query = "DELETE FROM `anyInventory_categories` WHERE `id`='".$category->id."'";
	$result = query($query);
	
	remove_from_fields($category->id);
	
	return;
}

function remove_from_fields($cat_id){
	$query = "SELECT `id` FROM `anyInventory_fields` WHERE `categories` LIKE '%".$cat_id.",%'";
	$result = query($query);
	
	while($row = fetch_array($result)){
		$field = new field($row["id"]);
		$field->remove_category($cat_id);
	}
	
	return;
}

function get_mysql_column_type($input_type, $size, $values, $default_value){
	switch($input_type){
		case 'text':
		case 'multiple':
		case 'checkbox':
			if ($size < 256){
				$type = " VARCHAR(".$size.") DEFAULT '".$default_value."' ";
			}
			else{
				$type = " TEXT ";
			}
			break;
		case 'radio':
		case 'select':
			$type = " ENUM(";
			
			$enums = explode(",",$values);
					
			foreach($enums as $enum){
				$type .= "'".trim(str_replace("'","",str_replace('"','',$enum)))."',";
			}
			
			$type = substr($type, 0, strlen($type) - 1);
			
			$type .= ") DEFAULT '".$default_value."' ";
			break;
	}
	
	$type .= " NOT NULL";
	
	return $type;
}

?>