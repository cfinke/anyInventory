<?php

include("globals.php");

$title = 'anyInventory: Alerts';
$breadcrumbs = 'Administration > Alerts';

$query = "SELECT *, UNIX_TIMESTAMP(`time`) AS `unix_time` FROM `anyInventory_alerts` ORDER BY `title` ASC";
$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);

if (mysql_num_rows($result) > 0){
	while($row = mysql_fetch_assoc($result)){
		$alert = new alert($row["id"]);
		$item = new item($alert->item_ids[0]);
		
		if (is_array($alert->category_ids)){
			foreach($alert->category_ids as $cat_id){
				if (!$admin_user->can_admin($cat_id)){
					break;
				}
				
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
				
				if (count($alert->item_ids) > 1){
					$table_rows .= ' et. al.';
				}
				
				$table_rows .= '
						</td>
					</tr>';
				
				break;
			}
		}
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