<?php

include("globals.php");

if ($_REQUEST["action"] == "do_add"){
	$query = "INSERT INTO `anyInventory_categories` (`name`,`parent`) VALUES ('".$_REQUEST["name"]."','".$_REQUEST["parent"]."')";
	$result = query($query);
	
	$this_id = insert_id();
	
	if (is_array($_REQUEST["fields"])){
		foreach($_REQUEST["fields"] as $key => $value){
			$temp_field = new field($key);
			$temp_field->add_category($this_id);
		}
	}
	
	header("Location: ".$_SERVER["PHP_SELF"]);
}
elseif($_REQUEST["action"] == "delete"){
	// 
	$query = "DELETE FROM `categories`"; 

	header("Location: ".$_SERVER["PHP_SELF"]);
}

$title = 'anyInventory Categories';
$page_key = "categories";
$links = array(array("url"=>$_SERVER["PHP_SELF"]."?action=add","name"=>"Add a Category"));

if ($_REQUEST["action"] == "add"){
	$output = '
		<form method="post" action="'.$_SERVER["PHP_SELF"].'" enctype="multipart/form-data">
			<input type="hidden" name="action" value="add_category" />
			<table>
				<tr>
					<td class="form_label"><label for="name">Name:</label></td>
					<td class="form_input"><input type="text" name="name" id="name" value="" /></td>
				</tr>
				<tr>
					<td class="form_label"><label for="parent">Parent Category:</label></td>
					<td class="form_input">
						<select name="parent" id="parent">
							'.get_category_dropdown().'
						</select>
					</td>
				</tr>
				<tr>
					<td class="form_label">Fields:</td>
					<td class="form_input">
						'.get_fields_checkbox_area().'
					</td>
				</tr>
				<tr>
					<td class="form_label">&nbsp;</td>
					<td class="form_input"><input type="submit" name="submit" id="submit" value="Submit" /></td>
				</tr>
			</table>
		</form>';
}
else{
	$output .= '<p><a href="'.$_SERVER["PHP_SELF"].'?action=add">Add a Category.</a></p>';
	
	$query = "SELECT *,'' as `nosortcol_`,`name` as `sortcol_Name`,'' as `nosortcol_Fields`, '' as `nosortcol_Items` FROM `anyInventory_categories`";
	$data_obj = new dataset_library("Categories", $query, $_REQUEST, "mysql");
	$result = $data_obj->get_result_resource();
	$rows = $data_obj->get_result_set();
	
	if (mysql_num_rows($result) > 0){
		$i = 0;
		
		while($row = mysql_fetch_assoc($result)){
			$temp = new category($row["id"]);
			
			$color_code = (($i % 2) == 1) ? 'row_on' : 'row_off';
			$table_set .= '<tr class="'.$color_code.'">';
			$table_set .= '<td align="center" style="width: 10%; white-space: nowrap;"><a href="'.$_SERVER["PHP_SELF"].'?action=edit&amp;id='.$row["id"].'">[edit]</a> <a href="'.$_SERVER["PHP_SELF"].'?action=delete&amp;id='.$row["id"].'">[delete]</a></td>';
			$table_set .= '<td>'.$temp->breadcrumb_names.'</td>';
			$table_set .= '<td>';
			
			if (count($temp->fields) > 0){
				foreach($temp->fields as $field){
					$table_set .= $field["name"] . ', ';
				}
				
				$table_set = substr($table_set, 0, strlen($table_set) - 2);
			}
			
			$table_set .= '&nbsp;</td>';
			$table_set .= '<td>'.$temp->num_items().'</td>';
			$table_set .= '</tr>';
			$i++;
		}
	}
	else{
		$table_set .= '<tr class="row_off"><td>There are no categories to display.</td></tr>';
	}
	
	$table_set = $data_obj->get_sort_interface() . $table_set . $data_obj->get_paging_interface();
	
	$output .= '<table style="width: 100%; background-color: #000000;" cellspacing="1" cellpadding="2">'.$table_set.'</table>';
	
}

include("header.php");
echo $output;
include("footer.php");

exit;

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

function get_fields_checkbox_area($checked = null){
	$query = "SELECT * FROM `anyInventory_fields` WHERE 1 ORDER BY `name` ASC";
	$result = query($query);
	
	$num_fields = num_rows($result);
	
	$output .= '<div id="field_checkboxes">
		<div style="float: left;">';
	
	for ($i = 0; $i < ceil($num_fields / 2); $i++){
		$output .= '<div class="checkbox"><input type="checkbox" name="fields['.result($result, $i, "id").']" value="yes" /> '.result($result, $i, "name").'</div>';
	}
	
	$output .= '</div>
		<div>';
	
	for (; $i < $num_fields; $i++){
		$output .= '<div class="checkbox"><input type="checkbox" name="fields['.result($result, $i, "id").']" value="yes" /> '.result($result, $i, "name").'</div>';	
	}
	
	$output .= '</div>';
	
	return $output;
}

?>