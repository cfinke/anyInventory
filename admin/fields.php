<?php

include("globals.php");

$title = 'anyInventory: Fields';
$breadcrumbs = 'Administration > Fields';

$query = "SELECT * FROM `anyInventory_fields` WHERE `id` > 0 ORDER BY `importance`";
$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);

if (mysql_num_rows($result) > 0){
	$i = 0;
	
	if ($admin_user->usertype == 'Administrator'){
		$table_rows .= '
			<tr>
				<td align="center" style="width: 15ex; white-space: nowrap;">
					<nobr>
						[<a href="edit_special.php?id=auto_inc_field">edit</a>]
						[delete]
						[up]
						[down]
					</nobr>
				</td>
				<td style="white-space: nowrap;">'.get_config_value("AUTO_INC_FIELD_NAME").'</td>
				<td>auto-increment</td>
			</tr>';
	}
	
	while($row = mysql_fetch_assoc($result)){
		if ($admin_user->can_admin_field($row["id"])){
			$table_rows .= '
				<tr>
					<td align="center" style="width: 15ex; white-space: nowrap;">
						<nobr>
							[<a href="edit_field.php?id='.$row["id"].'">edit</a>]
							[<a href="delete_field.php?id='.$row["id"].'">delete</a>]
							[<a href="field_processor.php?action=moveup&amp;id='.$row["id"].'&amp;i='.$row["importance"].'">up</a>]
							[<a href="field_processor.php?action=movedown&amp;id='.$row["id"].'&amp;i='.$row["importance"].'">down</a>]
						</nobr>
					</td>
					<td style="white-space: nowrap;">'.$row["name"].'</td>
					<td>'.$row["input_type"].'</td>
				</tr>';
		}
	}
	
	$table_rows = '<table>'.$table_rows.'</table>';
}

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>
				Fields
			</td>
			<td style="text-align: right;">
				[<a href="../docs/fields.php">Help</a>]
			</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				<p style="padding: 5px;"><a href="add_field.php">Add a field</a></p>
				'.$table_rows.'
			</td>
		</tr>
	</table>';

display($output);

?>