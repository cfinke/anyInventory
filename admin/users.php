<?php

include("globals.php");

$title = 'anyInventory: Users';
$breadcrumbs = 'Administration > Users';

$query = "SELECT * FROM `anyInventory_users` ORDER BY `username` ASC";
$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);

if (mysql_num_rows($result) > 0){
	$i = 0;
	
	$admin_id = get_config_value('ADMIN_USER_ID');
	
	while($row = mysql_fetch_assoc($result)){
		$table_rows .= '
			<tr>
				<td align="center" style="width: 15ex; white-space: nowrap;">
					<nobr>
						[<a href="edit_user.php?id='.$row["id"].'">edit</a>]';
		
		if ($row["id"] != $admin_id){
			$table_rows .= ' [<a href="delete_user.php?id='.$row["id"].'">delete</a>] ';
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
				Users
			</td>
			<td style="text-align: right;">
				[<a href="../docs/users.php">Help</a>]
			</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				<p style="padding: 5px;"><a href="add_user.php">Add a user</a></p>
				'.$table_rows.'
			</td>
		</tr>
	</table>';

display($output);

?>
