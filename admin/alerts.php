<?php

include("globals.php");

$title = 'anyInventory: Alerts';
$breadcrumbs = 'Administration > Alerts';

$query = "SELECT *, UNIX_TIMESTAMP(`time`) AS `unix_time` FROM `anyInventory_alerts` ORDER BY `title` ASC";
$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);

if (mysql_num_rows($result) > 0){
	while($row = mysql_fetch_assoc($result)){
		$item_ids = unserialize($row["item_ids"]);
		$item = new item($item_ids[0]);
		
		$table_rows .= '
			<tr>
				<td align="center" style="width: 18ex; white-space: nowrap;">
					<nobr>
						[<a href="edit_alert.php?id='.$row["id"].'">edit</a>]
						[<a href="delete_alert.php?id='.$row["id"].'">delete</a>]
					</nobr>
				</td>
				<td>'.$row["title"].'</td>
				<td>'.$item->name;
		
		if (count($item_ids) > 1){
			$table_rows .= ' et. al.';
		}
				
		$table_rows .= '
				</td>
			</tr>';
	}
	
	$table_rows = '<table>'.$table_rows.'</table>';
}

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>
				Alerts
			</td>
			<td style="text-align: right;">
				[ <a href="../docs/alerts.php">Help</a> ]
			</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				<p style="padding-left: 5px;"><a href="add_alert.php">Add an Alert</a></p>
				'.$table_rows.'
			</td>
		</tr>
	</table>';

display($output);

?>