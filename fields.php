<?php

include("globals.php");

$title = 'anyInventory Fields';

$query = "SELECT *,
			'' as `nosortcol_`,
			`name` as `sortcol_Name`,
			`input_type` as `nosortcol_Type`,
			`values` as `nosortcol_Values`,
			`default_value` as `nosortcol_Default Value`,
			`size` as `nosortcol_Size` 
			FROM `anyInventory_fields`";
$data_obj = new dataset_library("Fields", $query, $_REQUEST, "mysql","importance");
$result = $data_obj->get_result_resource();
$rows = $data_obj->get_result_set();

$output .= '<p><a href="add_field.php">Add a field.</a></p>';

if (mysql_num_rows($result) > 0){
	$i = 0;
	
	while($row = mysql_fetch_assoc($result)){
		$color_code = (($i % 2) == 1) ? 'row_on' : 'row_off';
		$table_set .= '<tr class="'.$color_code.'">';
		$table_set .= '<td align="center" style="width: 10%; white-space: nowrap;">
				<a href="edit_field.php?id='.$row["id"].'">[edit]</a>
				<a href="delete_field.php?id='.$row["id"].'">[delete]</a><br />
				[move <a href="field_processor.php?action=moveup&amp;id='.$row["id"].'&amp;i='.$row["importance"].'">up</a> |
				<a href="field_processor.php?action=movedown&amp;id='.$row["id"].'&amp;i='.$row["importance"].'">down</a>]
			</td>';
		$table_set .= '<td style="width: 10%; white-space: nowrap;">'.$row["name"].'</td>';
		$table_set .= '<td>'.$row["input_type"].'</td>';
		$table_set .= '<td>'.$row["values"].'</td>';
		$table_set .= '<td>'.$row["default_value"].'</td>';
		$table_set .= '<td>'.$row["size"].'</td>';
		$table_set .= '</tr>';
		$i++;
	}
}
else{
	$table_set .= '<tr class="row_off"><td colspan="6">There are no fields to display.</td></tr>';
}

$table_set = $data_obj->get_sort_interface() . $table_set . $data_obj->get_paging_interface();

$output .= '<table style="width: 100%; background-color: #000000;" cellspacing="1" cellpadding="3">'.$table_set.'</table>';

display($output);

?>