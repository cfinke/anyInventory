<?php

require_once("globals.php");

$title = ALERTS;
$breadcrumbs = ADMINISTRATION.' > '.ALERTS;

$query = "SELECT * FROM `anyInventory_alerts` ORDER BY `title` ASC";
$result = $db->query($query);
if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);

if ($result->numRows() > 0){
	while($row = $result->fetchRow()){
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
								[<a href="edit_alert.php?id='.$row["id"].'">'.EDIT_LINK.'</a>]
								[<a href="delete_alert.php?id='.$row["id"].'">'.DELETE_LINK.'</a>]
							</nobr>
						</td>
						<td>'.$row["title"].'</td>
						<td>'.$item->name;
				
				if (count($alert->item_ids) > 1){
					$table_rows .= MORE_ITEMS;
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
				'.ALERTS.'
			</td>
			<td style="text-align: right;">
				[ <a href="../docs/'.LANG.'/alerts.php">'.HELP.'</a> ]
			</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				<p style="padding-left: 5px;"><a href="add_alert.php">'.ADD_ALERT.'</a></p>
				'.$table_rows.'
			</td>
		</tr>
	</table>';

display($output);

?>
