<?php

include("globals.php");

$title = 'anyInventory Items';
$page_key = "items";
$links = array(array("url"=>$_SERVER["PHP_SELF"]."?action=add","name"=>"Add an Item"));

/*
if ($_REQUEST["action"] == "add"){
	if ($_REQUEST["action"] == "edit"){
		$field = new field($_REQUEST["id"]);
	}
	
	$output = '
			<form method="post" action="fields_actions.php" enctype="multipart/form-data">
				<h2>'.ucfirst($_REQUEST["action"]).' Field</h2>
				<input type="hidden" name="action" value="do_'.$_REQUEST["action"].'" />
				<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
				<table>
					<tr style="display: auto;">
						<td class="form_label"><label for="name">Name:</label></td>
						<td class="form_input"><input type="text" name="name" id="name" value="'.$field->name.'" /></td>
					</tr>
					<tr>
						<td class="form_label"><label for="name">Data type:</label></td>
						<td class="form_input">
							<select name="input_type" id="input_type"">
								<option onclick="document.getElementById(\'values_row\').style.display = \'none\';document.getElementById(\'size_row\').style.display = \'\';" value="text"';if($field->input_type == 'text') $output .= ' selected="selected"';$output.='>Text</option>
								<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="select"';if($field->input_type == 'select') $output .= ' selected="selected"';$output.='>Select Box</option>
								<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'\';" value="multiple"';if($field->input_type == 'multiple') $output .= ' selected="selected"';$output.='>Multiple (Select + Text)</option>
								<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="checkbox"';if($field->input_type == 'checkbox') $output .= ' selected="selected"';$output.='>Checkboxes</option>
								<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="radio"';if($field->input_type == 'radio') $output .= ' selected="selected"';$output.='>Radio Buttons</option>
							</select>
						</td>
					</tr>
					<tr id="values_row" style="display: none;">
						<td class="form_label"><label for="values">Values:</label><br /><small>Only for data types \'Multiple\',\'Select Box\',\'Checkboxes\', and \'Radio Buttons\'.  Separate with commas.</small></td>
						<td class="form_input"><input type="text" name="values" id="values" value="';
						if (is_array($field->values)){
							foreach($field->values as $value){
								$output .= $value.', ';
							}
							$output = substr($output,0,strlen($output) - 2);
						}
					$output .= '" /></td>
					</tr>
					<tr style="display: auto;">
						<td class="form_label"><label for="default_value">Default value:</label></td>
						<td class="form_input"><input type="text" name="default_value" id="default_value" value="'.$field->default_value.'" /></td>
					</tr>
					<tr style="display: auto;" id="size_row">
						<td class="form_label"><label for="size">Size, in characters:</label><br /><small>Only for data types \'Multiple\' and \'Text\'.</small></td>
						<td class="form_input"><input type="text" name="size" id="size" value="'.$field->size.'" /></td>
					</tr>
					<tr style="display: auto;">
						<td class="form_label">&nbsp;</td>
						<td class="form_input"><input type="submit" name="submit" id="submit" value="Submit" /></td>
					</tr>
				</table>
			</form>';
}
else
*/
if($_REQUEST["action"] == "add"){
	//if ($_REQUEST["action"] == "edit"){
		//$field = new field($_REQUEST["id"]);
	//}
	
	if (!$_REQUEST["c"]) $_REQUEST["c"] = 0;
	
	$category = new category($_REQUEST["c"]);
	
	$output = '
			<form method="post" action="items_actions.php" enctype="multipart/form-data">
				<h2>Add an Item to '.$category->get_breadcrumb_links().'</h2>
				<input type="hidden" name="action" value="do_add" />
				<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
				<input type="hidden" name="c" value="'.$_REQUEST["c"].'" />
				<table>
					<tr>
						<td class="form_label"><label for="name">Name:</label></td>
						<td class="form_input"><input type="text" name="name" id="name" value="" maxlength="64" />
					</tr>';
	
	foreach($category->field_ids as $field_id){
		
		$field = new field($field_id);
		
		$output .= '
			<tr>
				<td class="form_label"><label for="'.str_replace(" ","_",$field->name).'">'.$field->name.':</label></td>
				<td class="form_input">';
		
		switch($field->input_type){
			case 'multiple':
				$output .= '<input type="text" id="'.str_replace(" ","_",$field->name).'_text" name="'.str_replace(" ","_",$field->name).'_text" maxlength="'.$field->size.'" value="" />';
				$output .= '<select name="'.str_replace(" ","_",$field->name).'_select" id="'.str_replace(" ","_",$field->name).'_select">';
				foreach($field->values as $value){
					$output .= '<option value="'.$value.'"';
					if ($value == $field->default_value) $output .= ' selected="selected"';
					$output .= '>'.$value.'</option>';
				}
				$output .= '<input type="text" name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'" maxlength="'.$field->size.'" value="'.$field->default_value.'" />';
				break;
			case 'select':
				$output .= '<select name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'">';
				foreach($field->values as $value){
					$output .= '<option value="'.$value.'"';
					if ($value == $field->default_value) $output .= ' selected="selected"';
					$output .= '>'.$value.'</option>';
				}
				break;
			case 'text':
				if ($field->size < 64) $output .= '<input type="text" name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'" maxlength="'.$field->size.'" value="'.$field->default_value.'" />';
				else $output .= '<textarea rows="8" cols="40" name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'">'.$field->default_value.'</textarea>';
				break;
			case 'radio':
				foreach($field->values as $value){
					$output .= '<input type="radio" name="'.str_replace(" ","_",$field->name).'" value="'.str_replace(" ","_",$value).'"';
					if ($value == $field->default_value) $output .= ' checked="checked"';
					$output .= ' /> '.$value.'<br />';
				}
				break;
			case 'checkbox':
				foreach($field->values as $value){
					$output .= '<input type="checkbox" name="'.str_replace(" ","_",$field->name).'['.$value.']" value="yes"';
					if ($value == $field->default_value) $output .= ' checked="checked"';
					$output .= ' /> '.$value.'<br />';
				}
				break;
		}
		
		$output .= '</td>
			</tr>';
	}
	
	
	$output .= '
					<tr>
						<td class="form_label">&nbsp;</td>
						<td class="form_input"><input type="submit" name="submit" id="submit" value="Submit" /></td>
					</tr>
				</table>
			</form>';
}
else{
	$output .= '<p><a href="'.$_SERVER["PHP_SELF"].'?action=add">Add an item.</a></p>';
	/*
	$query = "SELECT *,'' as `nosortcol_`,`name` as `sortcol_Name`,'' as `nosortcol_Fields` FROM `anyInventory_itemsfields`";
	$data_obj = new dataset_library("Fields", $query, $_REQUEST, "mysql");
	$result = $data_obj->get_result_resource();
	$rows = $data_obj->get_result_set();
	
	if (mysql_num_rows($result) > 0){
		$i = 0;
		
		while($row = mysql_fetch_assoc($result)){
			$color_code = (($i % 2) == 1) ? 'row_on' : 'row_off';
			$table_set .= '<tr class="'.$color_code.'">';
			$table_set .= '<td align="center" style="width: 10%; white-space: nowrap;"><a href="'.$_SERVER["PHP_SELF"].'?action=edit_field&amp;id='.$row["id"].'">[edit]</a> <a href="'.$_SERVER["PHP_SELF"].'?action=delete_field&amp;id='.$row["id"].'">[delete]</a></td>';
			$table_set .= '<td>'.$row["name"].'</td>';
			$table_set .= '<td>'.$row["input_type"].'</td>';
			$table_set .= '<td>'.$row["values"].'</td>';
			$table_set .= '<td>'.$row["default_value"].'</td>';
			$table_set .= '<td>'.$row["size"].'</td>';
			$table_set .= '</tr>';
			$i++;
		}
	}
	else{
		$table_set .= '<tr class="row_off"><td>There are no fields to display.</td></tr>';
	}
	
	$table_set = $data_obj->get_sort_interface() . $table_set . $data_obj->get_paging_interface();
	
	$output .= '<table style="width: 100%; background-color: #000000;" cellspacing="1" cellpadding="2">'.$table_set.'</table>';
	*/
}

include("header.php");
echo $output;
include("footer.php");

exit;

?>