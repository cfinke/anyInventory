<?php

include("globals.php");

$title = 'anyInventory: Fields';
$breadcrumbs = 'Administration > Fields';

$query = "SELECT * FROM `anyInventory_fields` ORDER BY `importance`";
$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);

if (mysql_num_rows($result) > 0){
	$i = 0;
	
	while($row = mysql_fetch_assoc($result)){
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