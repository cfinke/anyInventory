<?php

include("globals.php");

$title = 'anyInventory: Alerts';

$output .= '<table style="width: 100%;"><tr><td><a href="add_alert.php">Add an alert.</a></td><td style="text-align: right;"><a href="../docs/alerts.php">Help with alerts</a></td></tr></table>';

$query = "SELECT *, UNIX_TIMESTAMP(`time`) AS `unix_time` FROM `anyInventory_alerts` ORDER BY `title` ASC";
$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);

$table_set .= '<tr class="row_head"><td>&nbsp;</td><td>Title</td><td>Item</td><td>Effective as of...</td></tr>';

if (mysql_num_rows($result) > 0){
	$i = 0;
	
	while($row = mysql_fetch_assoc($result)){
		$color_code = (($i % 2) == 1) ? 'row_on' : 'row_off';
		$item_ids = unserialize($row["item_ids"]);
		$item = new item($item_ids[0]);
		$table_set .= '<tr class="'.$color_code.'">';
		$table_set .= '
			<td align="center" style="width: 18ex; white-space: nowrap;">
				<a href="edit_alert.php?id='.$row["id"].'">[edit]</a>
				<a href="delete_alert.php?id='.$row["id"].'">[delete]</a>
			</td>';
		$table_set .= '<td>'.$row["title"].'</td>';
		$table_set .= '<td>'.$item->name;
		
		if (count($item_ids) > 1){
			$table_set .= ' et. al. </td>';
		}
		
		$table_set .= '<td>'.date("Y m d",$row["unix_time"]).'</td>';
		$table_set .= '</tr>';
		$i++;
	}
}
else{
	$table_set .= '<tr class="row_off"><td colspan="4">There are no alerts to display.</td></tr>';
}

$output .= '<table style="width: 100%; background-color: #000000;" cellspacing="1" cellpadding="2">'.$table_set.'</table>';

display($output);

?>