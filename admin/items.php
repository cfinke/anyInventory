<?php

include("globals.php");

$title = 'anyInventory: Items';

$output .= '<table style="width: 100%;"><tr><td><a href="add_item.php">Add an item.</a></td><td style="text-align: right;"><a href="../docs/items.php">Help with items</a></td></tr></table>';

$table_set .= '<tr class="row_head"><td>&nbsp;</td><td>Name</td></tr>';

$query = "SELECT `id`,`name`,`item_category` FROM `anyInventory_items` ORDER BY `name` ASC";
$result = query($query);

if (mysql_num_rows($result) > 0){
	$i = 0;
	
	while($row = mysql_fetch_assoc($result)){
		$color_code = (($i % 2) == 1) ? 'row_on' : 'row_off';
		$table_set .= '<tr class="'.$color_code.'">';
		$table_set .= '
			<td align="center" style="width: 18ex; white-space: nowrap;">
				<a href="edit_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">[edit]</a>
				<a href="move_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">[move]</a>
				<a href="delete_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">[delete]</a>
			</td>';
		$table_set .= '<td>'.$row["name"].'</td>';
		$table_set .= '</tr>';
		$i++;
	}
}
else{
	$table_set .= '<tr class="row_off"><td colspan="2">There are no items to display.</td></tr>';
}

$output .= '<table style="width: 100%; background-color: #000000;" cellspacing="1" cellpadding="2">'.$table_set.'</table>';

display($output);

?>