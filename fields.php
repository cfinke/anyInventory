<?php

include("globals.php");

$title = 'anyInventory Fields';
$page_key = "fields";
$links = array(array("url"=>$_SERVER["PHP_SELF"]."?action=add","name"=>"Add a Field"));

if (($_REQUEST["action"] == "add") || ($_REQUEST["action"] == "edit")){
	if ($_REQUEST["action"] == "edit"){
		$field = new field($_REQUEST["id"]);
	}
	
	$output = '
			<form method="post" action="fields_actions.php" enctype="multipart/form-data">
				<h2>'.ucfirst($_REQUEST["action"]).' Field</h2>
				<input type="hidden" name="action" value="do_'.$_REQUEST["action"].'" />
				<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
				<table>
					<tr>
						<td class="form_label"><label for="name">Name:</label></td>
						<td class="form_input"><input type="text" name="name" id="name" value="'.$field->name.'" /></td>
					</tr>
					<tr>
						<td class="form_label"><label for="name">Data type:</label></td>
						<td class="form_input">
							<select name="input_type" id="input_type"">
								<option value="text"';if($field->input_type == 'text') $output .= ' selected="selected"';$output.='>Text</option>
								<option value="select"';if($field->input_type == 'select') $output .= ' selected="selected"';$output.='>Select Box</option>
								<option value="multiple"';if($field->input_type == 'multiple') $output .= ' selected="selected"';$output.='>Multiple (Select + Text)</option>
								<option value="checkbox"';if($field->input_type == 'checkbox') $output .= ' selected="selected"';$output.='>Checkboxes</option>
								<option value="radio"';if($field->input_type == 'radio') $output .= ' selected="selected"';$output.='>Radio Buttons</option>
							</select>
						</td>
					</tr>
					<tr>
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
					<tr>
						<td class="form_label"><label for="default_value">Default value:</label></td>
						<td class="form_input"><input type="text" name="default_value" id="default_value" value="'.$field->default_value.'" /></td>
					</tr>
					<tr>
						<td class="form_label"><label for="size">Size, in characters:</label><br /><small>Only for data types \'Multiple\' and \'Text\'.</small></td>
						<td class="form_input"><input type="text" name="size" id="size" value="'.$field->size.'" /></td>
					</tr>
					<tr>
						<td class="form_label">&nbsp;</td>
						<td class="form_input"><input type="submit" name="submit" id="submit" value="Submit" /></td>
					</tr>
				</table>
			</form>';
}
elseif($_REQUEST["action"] == "delete"){
	$field = new field($_REQUEST["id"]);
	
	$output .= '
		<form method="post" action="fields_actions.php">
			<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
			<input type="hidden" name="action" value="do_delete" />
			<p>Are you sure you want to delete this field?</p>';
	
	$output .= '
		<div class="field_info">
			<p><b>Field:</b> '.$field->name.'</p>
			<p><b>Input type:</b> '.$field->input_type.'</p>
			<p><b>Values:</b> ';
	
	if(is_array($field->values)){
		foreach($field->values as $value){
			$output .= $value.', ';
		}
		$output = substr($output, 0, strlen($output) - 2);
	}
	else{
		$output .= 'None';
	}
	
	$output .= '<p><b>Size:</b> '.$field->size.'</p>';
	$output .= '<p><b>Default value:</b> '.$field->default_value.'</p>
				<p style="text-align: center;"><input type="submit" name="delete" value="Delete" /> <input type="submit" name="cancel" value="Cancel" /></p>
		</form>';
}
else{
	$output .= '<p><a href="'.$_SERVER["PHP_SELF"].'?action=add">Add a field.</a></p>';
	
	$query = "SELECT *,'' as `nosortcol_`,`name` as `sortcol_Name`,`input_type` as `nosortcol_Type`,`values` as `nosortcol_Values`,`default_value` as `nosortcol_Default Value`,`size` as `nosortcol_Size` FROM `anyInventory_fields`";
	$data_obj = new dataset_library("Fields", $query, $_REQUEST, "mysql");
	$result = $data_obj->get_result_resource();
	$rows = $data_obj->get_result_set();
	
	if (mysql_num_rows($result) > 0){
		$i = 0;
		
		while($row = mysql_fetch_assoc($result)){
			$color_code = (($i % 2) == 1) ? 'row_on' : 'row_off';
			$table_set .= '<tr class="'.$color_code.'">';
			$table_set .= '<td align="center" style="width: 10%; white-space: nowrap;"><a href="'.$_SERVER["PHP_SELF"].'?action=edit&amp;id='.$row["id"].'">[edit]</a> <a href="'.$_SERVER["PHP_SELF"].'?action=delete&amp;id='.$row["id"].'">[delete]</a></td>';
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
}

include("header.php");
echo $output;
include("footer.php");

exit;

?>