<?php

function connect_to_database(){
	// This function opens and returns the database connection.
	global $dsn;
	
	$db = DB::connect($dsn);
	
	if (DB::isError($db)) {
		die($db->getMessage());
	}
	
	$db->setFetchMode(DB_FETCHMODE_ASSOC);
	
	return $db;
}

function get_unique_id($table){
	global $db;
	
	$query = "SELECT MAX(" . $db->quoteIdentifier('id') . ") AS " . $db->quoteIdentifier('seq_id') . " FROM " . $db->quoteIdentifier('".$table."') . "";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	if ($result->numRows() == 0){
		$row["seq_id"] = 0;
	}
	else{
		$row = $result->fetchRow();
	}
	
	return intval($row["seq_id"]) + 1;
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
	
	if ($id != 0){
		$query = "SELECT " . $db->quoteIdentifier('name') . " FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('id') . " = ?";
		$query_data = array($id);
		$pquery = $db->prepare($query);
		$result = $db->execute($pquery, $query_data);
		if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
		
		$row = $result->fetchRow();
		$pre .= $row["name"] . ' > ';
	}
	
	$query = "SELECT " . $db->quoteIdentifier('id') . "," . $db->quoteIdentifier('name') . " FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('parent') . "= ? ORDER BY " . $db->quoteIdentifier('name') . " ASC";
	$query_data = array($id);
	$pquery = $db->prepare($query);
	$result = $db->execute($pquery, $query_data);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
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

function get_item_options($cat_ids = 0, $selected = null, $multiple = false){
	global $db;
	
	// This function creates select box options for the items in the category $cat.
	if (!is_array($selected)) $selected = array($selected);
	if (!is_array($cat_ids)) $cat_ids = array($cat_ids);
	
	$query = "SELECT " . $db->quoteIdentifier('id') . "," . $db->quoteIdentifier('name') . " FROM " . $db->quoteIdentifier('anyInventory_items') . " WHERE " . $db->quoteIdentifier('item_category') . " IN (?)";
	$query_data = array(implode(", ",$cat_ids));
	$pquery = $db->prepare($query);
	$result = $db->execute($pquery, $query_data);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	while ($row = $result->fetchRow()){
		$options .= '<option value="'.$row["id"].'"';
		if ((($selected[0] === null) && (!$multiple)) || (in_array($row["id"],$selected))) $options .= ' selected="selected"';
		$options .= '>'.$row["name"].'</option>';
	}
	
	return $options;
}

function get_fields_checkbox_area($checked = array()){
	global $db;
	
	// This function returns the field checkboxes.
	// Any field ids in the array $checked will be checked.
	
	$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_fields') . " ORDER BY " . $db->quoteIdentifier('importance') . " ASC";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
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
						$output .= '; '.$field->size.' characters';
					}
					elseif (($field->input_type != 'file') && ($field->input_type != 'item')){
						$output .= '; '.strtolower(VALUES).': ';
						
						if (is_array($field->field_values)){
							foreach($field->field_values as $val){
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
		$query = "SELECT " . $db->quoteIdentifier('name') . " FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('id') . " = ?";
		$query_data = array($top);
		$pquery = $db->prepare($query);
		$result = $db->execute($pquery, $query_data);
		if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
		
		if ($result->numRows() > 0){
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
	global $db;
	
	// This function creates array entries for any child of $id.
	
	if ($id != 0){
		$query = "SELECT " . $db->quoteIdentifier('name') . " FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('id') . " = ?";
		$query_data = array($id);
		$pquery = $db->prepare($query);
		$result = $db->execute($pquery, $query_data);
		if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
		
		$row = $result->fetchRow();
		$pre .= $row["name"] . ' > ';
	}
	
	$query = "SELECT " . $db->quoteIdentifier('name') . "," . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('parent') . " = ? ORDER BY " . $db->quoteIdentifier('name') . " ASC";
	$query_data = array($id);
	$pquery = $db->prepare($query);
	$result = $db->execute($pquery, $query_data);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
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
	global $db;
	
	// This function creates array entries for any child of $id.
	
	$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('parent') . " = ? ORDER BY " . $db->quoteIdentifier('name') . " ASC";
	$query_data = array($id);
	$pquery = $db->prepare($query);
	$result = $db->execute($pquery, $query_data);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
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
	global $db;
	
	// This function deletes a subcategory $category and its children.
	
	if (is_array($category->children_ids)){
		foreach($category->children_ids as $child_id){
			$child = new category($child_id);
			delete_subcategories($child);
		}
	}
	
	$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_items') . " WHERE " . $db->quoteIdentifier('item_category') . " = ?";
	$query_data = array($category->id);
	$pquery = $db->prepare($query);
	$result = $db->execute($pquery, $query_data);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	while ($row = $result->fetchRow()){
		$query2 = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_alerts') . " WHERE " . $db->quoteIdentifier('item_ids') . " LIKE ?";
		$query2_data = array('%"'.$row["id"].'"%');
		$pquery2 = $db->prepare($query2);
		$result2 = $db->execute($pquery2, $query2_data);
		if (DB::isError($result2)) die($result2->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result2->userinfo.'<br /><br />'.SUBMIT_REPORT);
		
		while ($row2 = $result2->fetchRow()){
			$alert = new alert($row2["id"]);
			
			$alert->remove_item($row["id"]);
			
			if (count($alert->item_ids) == 0){
				$query3 = "DELETE FROM " . $db->quoteIdentifier('anyInventory_alerts') . " WHERE " . $db->quoteIdentifier('id') . " = ?";
				$query3_data = array($alert->id);
				$pquery3 = $db->prepare($query3);
				$db->execute($pquery3, $query3_data);
				if (DB::isError($result3)) die($result3->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result3->userinfo.'<br /><br />'.SUBMIT_REPORT);
			}
		}
		
		$query4 = "DELETE FROM " . $db->quoteIdentifier('anyInventory_values') . " WHERE " . $db->quoteIdentifier('item_id') . " = ?";
		$query4_data = array($row["id"]);
		$pquery4 = $db->prepare($query4);
		$result4 = $db->execute($pquery4, $query4_data);
		if (DB::isError($result4)) die($result4->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result4->userinfo.'<br /><br />'.SUBMIT_REPORT);
	}
	
	// Delete all of the items in the category
	$query = "DELETE FROM " . $db->quoteIdentifier('anyInventory_items') . " WHERE " . $db->quoteIdentifier('item_category') . " = ?";
	$query_data = array($category->id);
	$pquery = $db->prepare($query);
	$result = $db->execute($pquery, $query_data);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	// Delete this category.
	$query = "DELETE FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('id') . " = ?";
	$query_data = array($category->id);
	$pquery = $db->prepare($query);
	$result = $db->execute($pquery, $query_data);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	remove_from_fields($category->id);
	
	return;
}

function remove_from_fields($cat_id){
	global $db;
	
	// This function removes all fields from a category.
	$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_fields') . " WHERE " . $db->quoteIdentifier('categories') . " LIKE ?";
	$query_data = array('%"'.$cat_id.'"%');
	$pquery = $db->prepare($query);
	$result = $db->execute($pquery, $query_data);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	while($row = $result->fetchRow()){
		$field = new field($row["id"]);
		$field->remove_category($cat_id);
	}
	
	return;
}

function unix_timestamp($timestamp){
	$hour = substr($timestamp, 8, 2);
	$minute = substr($timestamp, 10, 2);
	$second = substr($timestamp, 12, 2);
	$month = substr($timestamp, 4, 2);
	$day = substr($timestamp, 6, 2);
	$year = substr($timestamp, 0, 4);
	
	return mktime($hour, $minute, $second, $month, $day, $year);
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
					$query .= " AND " . $db->quoteIdentifier('categories') . " LIKE '%\"".$cat_id."\"%' AND " . $db->quoteIdentifier('input_type') . " NOT IN ('divider','file','item') ";
				}
			}
			
			$result = $db->query($query);
			if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
			
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
				if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
				
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
			<td class="form_input"><label for="timed">'.TIMED_ONLY_LABEL.'</label>.
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

?>
