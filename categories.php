<?php

include("globals.php");

$title = 'anyInventory Categories';

$output .= '<p><a href="add_category.php">Add a Category.</a></p>';

$rows = get_category_array();

if (count($rows) > 0){
	$i = 0;
	
	foreach($rows as $row){
		$temp = new category($row["id"]);
		
		$color_code = (($i % 2) == 1) ? 'row_on' : 'row_off';
		$table_set .= '<tr class="'.$color_code.'">';
		$table_set .= '
			<td align="center" style="white-space: nowrap;">
				<a href="edit_category.php?id='.$row["id"].'">[edit]</a>
				<a href="delete_category.php?id='.$row["id"].'">[delete]</a>
			</td>';
		$table_set .= '<td style="white-space: nowrap;">'.$row["name"].'</td>';
		$table_set .= '<td>'.$temp->num_items().'</td>';
		$table_set .= '</tr>';
		$i++;
	}
}
else{
	$table_set .= '<tr class="row_off"><td>There are no categories to display.</td></tr>';
}

$output .= '
	<table style="width: 100%; background-color: #000000;" cellspacing="1" cellpadding="2">
		<tr class="row_head">
			<td style="width: 12ex;">&nbsp;</td>
			<td>Category Name</td>
			<td># of Items</td>
		</tr>
		'.$table_set.'</table>';

display($output);

?>