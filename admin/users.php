<?php

require_once("globals.php");

$title = USERS;
$breadcrumbs = ADMINISTRATION.' > '.USERS;

$query = "SELECT * FROM " . $db->quoteIdentifier('anyInventory_users') . " ORDER BY " . $db->quoteIdentifier('username') . " ASC";
$result = $db->query($query);
if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);

if ($result->numRows() > 0){
	$i = 0;
	
	while($row = $result->fetchRow()){
		$table_rows .= '
			<tr>
				<td align="center" style="width: 15ex; white-space: nowrap;">
					<nobr>';
		
		if (($admin_user->usertype == 'Administrator') || ($_SESSION["user"]["id"] == $row["id"])){
			$table_rows .= ' [<a href="edit_user.php?id='.$row["id"].'">'.EDIT_LINK.'</a>] ';
			
			if ($row["id"] != ADMIN_USER_ID){
				$table_rows .= ' [<a href="delete_user.php?id='.$row["id"].'">'.DELETE_LINK.'</a>] ';
			}
		}
		
		$table_rows .= '
					</nobr>
				</td>
				<td style="white-space: nowrap;">'.$row["username"].'</td>
				<td>'.$row["usertype"].'</td>
			</tr>';
	}
	
	$table_rows = '<table>'.$table_rows.'</table>';
}

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>
				'.USERS.'
			</td>
			<td style="text-align: right;">
				[<a href="../docs/users.php">'.HELP.'</a>]
			</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				<p style="padding: 5px;"><a href="add_user.php">'.ADD_USER.'</a></p>
				'.$table_rows.'
			</td>
		</tr>
	</table>';

display($output);

?>
