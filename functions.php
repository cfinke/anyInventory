<?php

function connect_to_database(){
	// This function opens and returns the database connection.
	// $dsn comes from environment.php
	global $dsn;
	
	$db = DB::connect($dsn);
	if (DB::isError($db)) die($db->getMessage());
	
	$db->setOption('portability',  DB_PORTABILITY_ALL);
	$db->setOption('debug',  2);
	
	if (DB::isError($db)) die($db->getMessage());
	
	$db->setFetchMode(DB_FETCHMODE_ASSOC);
	
	return $db;
}

function nextId($table){
	global $db;
	
	$query = "SELECT MAX(" . $db->quoteIdentifier('id') . ") AS " . $db->quoteIdentifier('seq_id') . " FROM " . $db->quoteIdentifier("anyInventory_" . $table);
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	if ($result->numRows() == 0){
		return 1;
	}
	else{
		$row = $result->fetchRow();
		return intval($row["seq_id"]) + 1;
	}
}

function display($output){
	// This function displays a page with the content in $output.
	// $title should be declared before calling display()
	
	global $title;
	global $inHead;
	global $inBodyTag;
	global $breadcrumbs;
	global $sectionTitle;
	
	global $DIR_PREFIX;
	
	header("Content-Type: text/html; charset=ISO-8859-1");
	require_once($DIR_PREFIX."header.php");
	echo $output;
	require_once($DIR_PREFIX."footer.php");
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
	global $db;
	$query = "SELECT " . $db->quoteIdentifier('id') . "," . $db->quoteIdentifier('name') . " FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('parent') . "='".$id."' ORDER BY " . $db->quoteIdentifier('name') . " ASC";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	
	if ($id != 0){
		$newquery = "SELECT " . $db->quoteIdentifier('name') . " FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('id') . "='".$id."'";
		$newresult = $db->query($newquery);
		if (DB::isError($newresult)) die($newresult->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $newquery);
		
		$row = $newresult->fetchRow();
		$category_name = $row["name"];
		$pre .= $category_name . ' > ';
	}
	
	$list = '';
	
	if ($result->numRows() > 0){
		while ($row = $result->fetchRow()){
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

function get_item_options($cat_ids = 0, $selected = null, $exclude = null, $select_all = true){
	// This function creates select box options for the items in the category $cat.
	global $db;
	
	if (!is_array($selected)) $selected = array($selected);
	if (!is_array($cat_ids)) $cat_ids = array($cat_ids);
	if (!is_array($exclude)) $exclude = array($exclude);
	
	$query = "SELECT " . $db->quoteIdentifier('id') . "," . $db->quoteIdentifier('name') . " FROM " . $db->quoteIdentifier('anyInventory_items') . " WHERE " . $db->quoteIdentifier('item_category') . " IN (".implode(", ", $cat_ids).") ORDER BY " . $db->quoteIdentifier('name') . "";
	$result = $db->query($query);
    if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	
	while ($row = $result->fetchRow()){
		if (!in_array($row["id"], $exclude)){
			$options .= '<option value="'.$row["id"].'"';
			
			if (in_array($row["id"],$selected) || (($selected[0] === null) && ($select_all))){
				$options .= ' selected="selected"';
			}
			
			$options .= '>'.$row["name"].'</option>';
		}
	}
	
	return $options;
}

function get_fields_checkbox_area($checked = array()){
	// This function returns the field checkboxes.
	// Any field ids in the array $checked will be checked.
	global $db;
	
	$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_fields') . " ORDER BY " . $db->quoteIdentifier('importance') . " ASC";
	$result = $db->query($query);
    if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	
	while($row = $result->fetchRow()){
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
						$output .= '; '.$field->size;
					}
					elseif (($field->input_type != 'file') && ($field->input_type != 'item')){
						$output .= '; '.strtolower(VALUES).': ';
						
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
	// This function returns an array of categories, starting with
	// the category id'd by $top and working down.
	
	$array = array();
	
	if ($top != 0){
		$query = "SELECT " . $db->quoteIdentifier('name') . " FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('id') . "='".$top."'";
		$result = $db->query($query);
    	if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		if ($result->numCols() > 0){
			$row = $result->fetchRow();
			$array[] = array("name"=>$row["name"],"id"=>$top);
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
    global $db;
	
	$query = "SELECT " . $db->quoteIdentifier('name') . "," . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('parent') . "='".$id."' ORDER BY " . $db->quoteIdentifier('name') . " ASC";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);	
	if ($id != 0){
		$newquery = "SELECT " . $db->quoteIdentifier('name') . " FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('id') . "='".$id."'";
		$newresult = $db->query($newquery);
		
    	if (DB::isError($newresult)){
        	die($newresult->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $newquery);
    	}
		
		$newrow = $newresult->fetchRow();
		$pre .= $newrow["name"] . ' > ';
	}
	
	if ($result->numRows() > 0){
		while ($row = $result->fetchRow()){
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
	// This function creates array entries for any child of $id.
	global $db;
	
	$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('parent') . "='".$id."' ORDER BY " . $db->quoteIdentifier('name') . " ASC";
	$result = $db->query($query);
    if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	
	if ($result->numRows() > 0){
		while ($row = $result->fetchRow()){
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
	// This function deletes a subcategory $category and its children.
	
	if (is_array($category->children_ids)){
		foreach($category->children_ids as $child_id){
			$child = new category($child_id);
			delete_subcategories($child);
		}
	}
	
	$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_items') . " WHERE " . $db->quoteIdentifier('item_category') . "='".$category->id."'";
	$result = $db->query($query);
    if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	
	while ($result->fetchRows()){
		$newquery = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_alerts') . " WHERE " . $db->quoteIdentifier('item_ids') . " LIKE '%\"".$row["id"]."\"%'";
		$newresult = $db->query($newquery);
    	if (DB::isError($newresult)) die($newresult->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $newquery);
		
		while ($newrow = $newresult->fetchRow()){
			$alert = new alert($newrow["id"]);
			
			$alert->remove_item($row["id"]);
			
			if (count($alert->item_ids) == 0){
				$newerquery = "DELETE FROM " . $db->quoteIdentifier('anyInventory_alerts') . " WHERE " . $db->quoteIdentifier('id') . "='".$alert->id."'";
				$newerresult = $db->query($newerquery);
    			if (DB::isError($newerresult)) die($newerresult->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $newerquery);
			}
			
			$query = "DELETE FROM " . $db->quoteIdentifier('anyInventory_values') . " WHERE " . $db->quoteIdentifier('item_id') . "='".$newrow["id"]."'";
			$result = $db->query($query);
    		if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		}
	}
	
	// Delete all of the items in the category
	$query = "DELETE FROM " . $db->quoteIdentifier('anyInventory_items') . " WHERE " . $db->quoteIdentifier('item_category') . "='".$category->id."'";
	$result = $db->query($query);
    if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	
	// Delete this category.
	$query = "DELETE FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('id') . "='".$category->id."'";
	$result = $db->query($query);
    if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	
	remove_from_fields($category->id);
	
	return;
}

function remove_from_fields($cat_id){
	// This function removes all fields from a category.
	$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_fields') . " WHERE " . $db->quoteIdentifier('categories') . " LIKE '%\"".$cat_id."\"%'";
	$result = $db->query($query);
    if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	
	while($result->fetchRow()){
		$field = new field(intval($row["id"]));
		$field->remove_category($cat_id);
	}
	
	return;
}

function display_alert_form($c = null, $title = null, $i = null, $timed = false, $field = null, $condition = null, $value = null, $month = null, $day = null, $year = null, $expire = false, $expire_month = null, $expire_day = null, $expire_year = null){
	global $db;
	global $admin_user;
	
	if (!is_array($c)) $c = array($c);
	
	if ($c[0] == 'doc'){
		$documentation = true;
	}
	else{
		$documentation = false;
	}
	
	if (!is_array($i)) $i = array($i);
	
	if ($timed) $timed_checked = ' checked="checked"';
	if ($expire) $expire_checked = ' checked="checked"';
	
	if ($day == null) $day = date("j");
	if ($expire_day == null) $expire_day = date("j");
	
	if ($month == null) $month = date("n");
	if ($expire_month == null) $expire_month = date("n");
	
	if ($year == null) $year = date("Y");
	if ($expire_year == null) $expire_year = date("Y");
	
	$items = array();
	$fields = array();
	
	if ($documentation){
		$fields = array(array("id"=>1,"name"=>"Brand"),
						array("id"=>2,"name"=>"Quantity"),
						array("id"=>3,"name"=>"UPC"));
		
		$items = array(array("id"=>1,"name"=>"Printer Cartridges"),
					   array("id"=>2,"name"=>"Paper"),
					   array("id"=>3,"name"=>"Toner"));
	}
	else{
		if (count($c) > 0){
			$query = "SELECT " . $db->quoteIdentifier('id') . "," . $db->quoteIdentifier('name') . " FROM " . $db->quoteIdentifier('anyInventory_fields') . " WHERE 1 ";
			
			foreach($c as $cat_id){
				if (!$admin_user->can_admin($cat_id)){
					header("Location: ../error_handler.php?eid=13");
					exit;
				}
				else{
					$query .= " AND " . $db->quoteIdentifier('categories') . " LIKE '%".$cat_id."%' AND " . $db->quoteIdentifier('input_type') . " NOT IN ('divider','file','item') ";
				}
			}
			
			$result = $db->query($query);
    		if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
			
			if ($result->numRows() == 0){
				header("Location: ../error_handler.php?eid=3");
				exit;
			}
			else{
				while ($row = $result->fetchRow()){
					$fields[] = $row;
				}
				
				$query = "SELECT " . $db->quoteIdentifier('id') . "," . $db->quoteIdentifier('name') . " FROM " . $db->quoteIdentifier('anyInventory_items') . " WHERE " . $db->quoteIdentifier('item_category') . " IN (".implode(", ",$c).")";
				$result = $db->query($query);
    			if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
				
				if ($result->numRows() == 0){
					header("Location: ../error_handler.php?eid=2");
					exit;
				}
				else{
					while ($row = $result->fetchRow()){
						$items[] = $row;
					}
				}
			}
		}
		else{
			header("Location: ../error_handler.php?eid=3");
			exit;
		}
	}
	
	$output .= '
		<tr>
			<td class="form_label"><label for="title">'.ALERT_TITLE.':</label></td>
			<td class="form_input"><input type="text" name="title" id="title" value="'.$title.'" maxlength="255" style="width: 100%;" />
		</tr>
		<tr>
			<td class="form_label"><label for="i[]">'.APPLIES_TO.':</label><br /><small><a href="javascript:void(0);" onclick="selectNone(\'i[]\');">'.SELECT_NONE.'</a></small></td>
			<td class="form_input">
				<select name="i[]" id="i[]" multiple="multiple" size="10" style="width: 100%;">';
	
	foreach($items as $item){
		$output .= '<option value="'.$item["id"].'"';
		if (($i == array(null)) || (in_array($item["id"], $i))) $output .= ' selected="selected"';
		$output .= '>'.$item["name"].'</option>';
	}
	
	$output .= '
				</select>
			</td>
		</tr>
		<tr>
			<td class="form_label"><input onclick="toggle();" type="checkbox" id="timed" name="timed" value="yes"'.$timed_checked.' /></td>
			<td class="form_input"><label for="timed">'.TIMED_ONLY_LABEL.'</label>
			<br /><small>'.TIMED_ONLY_EXPLANATION.'</small></td>
		</tr>
		<tr>
			<td class="form_label"><label for="field">'.FIELD.':</label></td>
			<td class="form_input">
				<select name="field" id="field" style="width: 100%;">';
	
	foreach($fields as $field_id){
		$output .= '<option value="'.$field_id["id"].'"';
		if ($field_id["id"] == $field) $output .= ' selected="selected"';
		$output .= '> '.$field_id["name"].'</option>';
	}
	
	$output .= '
				</select>
			</td>
		</tr>
		<tr>
			<td class="form_label"><label for="condition">'.CONDITION.':</label></td>
				<td class="form_input">
					<select name="condition" id="condition" style="width: 100%;">
						<option value="=="';if ($condition == '==') $output .= ' selected="selected"'; $output .= '>=</option>
						<option value="!="';if ($condition == '!=') $output .= ' selected="selected"'; $output .= '>!=</option>
						<option value="<"';if ($condition == '<') $output .= ' selected="selected"'; $output .= '>&lt;</option>
						<option value=">"';if ($condition == '>') $output .= ' selected="selected"'; $output .= '>&gt;</option>
						<option value="<="';if ($condition == '<=') $output .= ' selected="selected"'; $output .= '>&lt;=</option>
						<option value=">="';if ($condition == '>=') $output .= ' selected="selected"'; $output .= '>&gt;=</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="form_label"><label for="value">'.VALUE.':</label></td>
				<td class="form_input"><input type="text" name="value" id="value" value="'.$value.'" style="width: 100%;" /></td>
			</tr>
			<tr>
				<td class="form_label"><label for="month">'.EFFECTIVE_DATE.':</label></td>
				<td class="form_input">
					<select name="month" id="month">
						<option value="1"';if($month == 1) $output .= ' selected="selected"'; $output .= '>'.MONTH_1.'</option>
						<option value="2"';if($month == 2) $output .= ' selected="selected"'; $output .= '>'.MONTH_2.'</option>
						<option value="3"';if($month == 3) $output .= ' selected="selected"'; $output .= '>'.MONTH_3.'</option>
						<option value="4"';if($month == 4) $output .= ' selected="selected"'; $output .= '>'.MONTH_4.'</option>
						<option value="5"';if($month == 5) $output .= ' selected="selected"'; $output .= '>'.MONTH_5.'</option>
						<option value="6"';if($month == 6) $output .= ' selected="selected"'; $output .= '>'.MONTH_6.'</option>
						<option value="7"';if($month == 7) $output .= ' selected="selected"'; $output .= '>'.MONTH_7.'</option>
						<option value="8"';if($month == 8) $output .= ' selected="selected"'; $output .= '>'.MONTH_8.'</option>
						<option value="9"';if($month == 9) $output .= ' selected="selected"'; $output .= '>'.MONTH_9.'</option>
						<option value="10"';if($month == 10) $output .= ' selected="selected"'; $output .= '>'.MONTH_10.'</option>
						<option value="11"';if($month == 11) $output .= ' selected="selected"'; $output .= '>'.MONTH_11.'</option>
						<option value="12"';if($month == 12) $output .= ' selected="selected"'; $output .= '>'.MONTH_12.'</option>
					</select>
					<select name="day" id="day">';
	
	for ($i = 1; $i <= 31; $i++){
		$output .= '<option value="'.$i.'"';if($day == $i) $output .= ' selected="selected"'; $output .= '>'.$i.'</option>';
	}
	
	$output .= '
					</select>,
					<select name="year" id="year">';
	
	for ($i = 0; $i < 20; $i++){
		$output .= '<option value="'.($i + date("Y")).'"';
		if ($year == ($i + date("Y"))) $output .= ' selected="selected"';
		$output .= '>'.($i + $year).'</option>';
	}
	
	$output .= '
					</select>
				</td>
			</tr>
			<tr>
				<td class="form_label"><label for="expire_month">'.EXPIRATION_DATE.':</label></td>
				<td class="form_input">
					<select name="expire_month" id="expire_month">
						<option value="1"';if($expire_month == 1) $output .= ' selected="selected"'; $output .= '>'.MONTH_1.'</option>
						<option value="2"';if($expire_month == 2) $output .= ' selected="selected"'; $output .= '>'.MONTH_2.'</option>
						<option value="3"';if($expire_month == 3) $output .= ' selected="selected"'; $output .= '>'.MONTH_3.'</option>
						<option value="4"';if($expire_month == 4) $output .= ' selected="selected"'; $output .= '>'.MONTH_4.'</option>
						<option value="5"';if($expire_month == 5) $output .= ' selected="selected"'; $output .= '>'.MONTH_5.'</option>
						<option value="6"';if($expire_month == 6) $output .= ' selected="selected"'; $output .= '>'.MONTH_6.'</option>
						<option value="7"';if($expire_month == 7) $output .= ' selected="selected"'; $output .= '>'.MONTH_7.'</option>
						<option value="8"';if($expire_month == 8) $output .= ' selected="selected"'; $output .= '>'.MONTH_8.'</option>
						<option value="9"';if($expire_month == 9) $output .= ' selected="selected"'; $output .= '>'.MONTH_9.'</option>
						<option value="10"';if($expire_month == 10) $output .= ' selected="selected"'; $output .= '>'.MONTH_10.'</option>
						<option value="11"';if($expire_month == 11) $output .= ' selected="selected"'; $output .= '>'.MONTH_11.'</option>
						<option value="12"';if($expire_month == 12) $output .= ' selected="selected"'; $output .= '>'.MONTH_12.'</option>
					</select>
					<select name="expire_day" id="expire_day">';
	
	for ($i = 1; $i <= 31; $i++){
		$output .= '<option value="'.$i.'"';if($expire_day == $i) $output .= ' selected="selected"'; $output .= '>'.$i.'</option>';
	}
	
	$output .= '
					</select>,
					<select name="expire_year" id="expire_year">';
	
	for ($i = 0; $i < 20; $i++){
		$output .= '<option value="'.($i + date("Y")).'"';
		if ($expire_year == ($i + date("Y"))) $output .= ' selected="selected"';
		$output .= '>'.($i + $year).'</option>';
	}
	
	$output .= '
					</select>
					<input type="checkbox" name="expire" id="expire" value="yes" onclick="toggle();"'.$expire_checked.' /> <label for="expire">'.ALLOW_EXPIRATION.'</label>
				</td>
			</tr>';
	
	return $output;
}

function display_field_form($c_options = null, $name = null, $input_type = null, $field_values = null, $default_value = null, $size = null, $highlight = false){
	if ($highlight) $checked = ' checked="checked"';
	if (!is_array($field_values)) $field_values = array($field_values);
	
	$output .= '
		<tr>
			<td class="form_label"><label for="name">'.NAME.':</label></td>
			<td class="form_input"><input type="text" name="name" id="name" value="'.$name.'" maxlength="64" /></td>
		</tr>
		<tr>
			<td class="form_label"><label for="name">'.DATA_TYPE.':</label></td>
			<td class="form_input">
				<select name="input_type" id="input_type" onchange="toggle();">
					<option value="text"';if ($input_type == 'text') $output .= ' selected="selected"'; $output .= '>'.TEXT.'</option>
					<option value="select"';if ($input_type == 'select') $output .= ' selected="selected"'; $output .= '>'.SELECT_BOX.'</option>
					<option value="multiple"';if ($input_type == 'multiple') $output .= ' selected="selected"'; $output .= '>'.MULTIPLE.'</option>
					<option value="checkbox"';if ($input_type == 'checkbox') $output .= ' selected="selected"'; $output .= '>'.CHECKBOX.'</option>
					<option value="radio"';if ($input_type == 'radio') $output .= ' selected="selected"'; $output .= '>'.RADIO.'</option>
					<option value="item"';if ($input_type == 'item') $output .= ' selected="selected"'; $output .= '>'.ITEMS.'</option>
					<option value="file"';if ($input_type == 'file') $output .= ' selected="selected"'; $output .= '>'.FILE.'</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="form_label"><label for="field_values">'.VALUES.':</label></td>
			<td class="form_input"><input type="text" name="field_values" id="field_values" value="'.implode(", ",$field_values).'" /><br /><small>'.VALUES_INFO.'</small></td>
		</tr>
		<tr>
			<td class="form_label"><label for="default_value">'.DEFAULT_VALUE.':</label></td>
			<td class="form_input"><input type="text" name="default_value" id="default_value" value="'.$default_value.'" /><br /><small>'.DEFAULT_VALUE_INFO.'</small></td>
		</tr>
		<tr>
			<td class="form_label"><label for="size">'.SIZE.':</label></td>
			<td class="form_input"><input type="text" name="size" id="size" value="'.$size.'" /><br /><small>'.SIZE_INFO.'</small></td>
		</tr>
		<tr>
			<td class="form_label"><input type="checkbox" name="highlight" id="highlight" value="yes"'.$checked.' /></td>
			<td class="form_input"><label for="highlight">'.HIGHLIGHT_FIELD.'</label></td>
		</tr>
		<tr>
			<td class="form_label"><label for="add_to[]">'.APPLIES_TO.':</label><br /><small><a href="javascript:void(0);" onclick="selectNone(\'\add_to[]\');">'.SELECT_NONE.'</a></small></td>
			<td class="form_input">
				<select name="add_to[]" id="add_to[]" multiple="multiple" size="10" style="width: 100%;">
					'.$c_options.'
				</select>
			</td>
		</tr>';
	
	return $output;
}

function create_label($item_id, $field_id, $as_file = null, $max_width = null){
	require_once("barcode/barcode.php");
	require_once("barcode/c39object.php");
	require_once("barcode/c128aobject.php");
	require_once("barcode/c128bobject.php");	
	require_once("barcode/c128cobject.php");
	require_once("barcode/i25object.php");
	
	$item = new item($item_id);
	
	if ($field_id != 0){
		$field = new field($field_id);
	}
	
	// This is the width of one character in pixels.
	$char_width = 5;
	
	if ($max_width != null){
		$chars = ($max_width / $char_width) - 5;
		
		if (strlen($item->name) > $chars){
			$item->name = substr($item->name, 0, $chars).'...';
		}
	}
	
	settype($string, "string");
	
	// Create a barcode 120 by 25
	if($field_id == 0){
		// We want the autoincrement field.  Pad out the number if needed
		if(strlen($item->id) < LABEL_PADDING){
			$i = LABEL_PADDING - strlen($item->id);
		}
		while($i > 0){
			$string .= PAD_CHAR;
			$i--;
		}
		if(!strlen($item->id) % 2 && (BARCODE == I25 || BARCODE == C128C)){
			// Pad a zero to make it even
			$string = PAD_CHAR;
		}
		(string) $value = (string) $string . $item->id;
	}
	else{
		if(strlen($item->fields[$field->name]) < LABEL_PADDING){
			$i = LABEL_PADDING - strlen($item->id);
		}
		
		while($i > 0){
			$string .= PAD_CHAR;
			$i--;
		}
		
		if(!strlen($item->fields[$field->name]) % 2  && (BARCODE == I25 || BARCODE == C128C)){
			// Pad a zero to make it even
			$string = PAD_CHAR;
		}
		
		(string) $value = (string) $string . $item->fields[$field->name];
	}
	
	switch ($_GET["bar"]){
    	case "I25":
			$barcode = new I25Object(110, 26, 452, (string) $value);
			break;
   		case "C39":
			$barcode = new C39Object(110, 26, 452, (string) $value);
			break;
    	case "C128A":
			$barcode = new C128AObject(110, 26, 452, (string) $value);
			break;
    	case "C128B":
			$barcode = new C128BObject(110, 26, 452, (string) $value);
			break;
    	case "C128C":
			$barcode = new C128CObject(110, 26, 452, (string) $value);
			break;
        default:
			$obj = false;
  	}
	
	if($barcode){
		$barcode->SetFont(1);
		$barcode->DrawObject(1);
		$bar = $barcode->GetImage();
	}
	else{
		header("Location: error_handler.php?eid=17&mess=Bar+barcode+type");
	}
	if(isset($barcode->mError)){
		header("Location: error_handler.php?eid=17&mess=".$barcode->GetError());
	}
	
	// Create the image.
	// Write the item name to the label.
	$new_image = ImageCreate(120,35);
	// Color the background white
	$white = imagecolorallocate($new_image, 255, 255, 255);
	// Set the color for the text.
	$black = imagecolorallocate($new_image, 0, 0, 0);
	ImageString($new_image, 1, 60 - (ImageFontWidth(1) * strlen($item->name)) /2,0, $item->name, $black);
	imagecopy($new_image, $bar, 0, 7, 0, 0, 120, 26);
	
	// Delete the old image.
	imagedestroy($bar);
	
	if ($as_file != null){
		imagepng($new_image,$as_file);
	}
	else{
		// Send the new image to the browser
		header("Content-type: image/png");
		imagepng($new_image);
	}
	
	// Delete the new image.
	imagedestroy($new_image);
}

function incision_sort($arr, $col){
	for($k = 0; $k < sizeof($arr)-1; $k++){
		// $arr[$k+1] is possibly in the wrong place. Take it out.
		$t = $arr[$k+1];
		$i = $k;
		
		// Push $arr[i] to the right until we find the right place for $t.
		while($i >= 0 && $arr[$i][$col] > $t[$col]){
			$arr[$i+1] = $arr[$i];
			$i--;
		}
		
		// Insert $t into the right place.
		$arr[$i+1] = $t;
	}
	
	return $arr;
}

?>
