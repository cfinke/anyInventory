<?php

include("globals.php");

$title = 'anyInventory: Fields';

$query = "SELECT * FROM `anyInventory_fields` ORDER BY `importance`";
$result = query($query);

$output .= '<table style="width: 100%;"><tr><td><a href="add_field.php">Add a field.</a></td><td style="text-align: right;"><a href="../docs/fields.php">Help with fields</a></td></tr></table>';

$table_set .= '<tr class="row_head"><td>&nbsp;</td><td>Name</td><td>Type</td><td>Default Value</td><td>Size</td></tr>';

if (mysql_num_rows($result) > 0){
	$i = 0;
	
	while($row = mysql_fetch_assoc($result)){
		$color_code = (($i % 2) == 1) ? 'row_on' : 'row_off';
		$table_set .= '<tr class="'.$color_code.'">';
		$table_set .= '<td align="center" style="width: 15ex; white-space: nowrap;"><nobr>
				<a href="edit_field.php?id='.$row["id"].'">[edit]</a>
				<a href="delete_field.php?id='.$row["id"].'">[delete]</a>
				[<a href="field_processor.php?action=moveup&amp;id='.$row["id"].'&amp;i='.$row["importance"].'"><img src="'.$DIR_PREFIX.'images/arrow_up.gif" /></a>]
				[<a href="field_processor.php?action=movedown&amp;id='.$row["id"].'&amp;i='.$row["importance"].'"><img src="'.$DIR_PREFIX.'images/arrow_down.gif" /></a>]
				</nobr>
			</td>';
		$table_set .= '<td style="width: 10%; white-space: nowrap;">'.$row["name"].'</td>';
		$table_set .= '<td>'.$row["input_type"].'</td>';
		$table_set .= '<td>'.$row["default_value"].'</td>';
		$table_set .= '<td>'.$row["size"].'</td>';
		$table_set .= '</tr>';
		$i++;
	}
}
else{
	$table_set .= '<tr class="row_off"><td colspan="5">There are no fields to display.</td></tr>';
}

$output .= '<table style="width: 100%; background-color: #000000;" cellspacing="1" cellpadding="3">'.$table_set.'</table>';

display($output);

?>