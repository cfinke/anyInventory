<?php

require_once("globals.php");

$title = FIELDS;
$breadcrumbs = ADMINISTRATION.' > '.FIELDS;

$query = "SELECT * FROM " . $db->quoteIdentifier('anyInventory_fields') . " WHERE " . $db->quoteIdentifier('id') . " > 0 ORDER BY " . $db->quoteIdentifier('importance') . "";
$result = $db->query($query);
if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);

if ($admin_user->usertype == 'Administrator'){
	$table_rows .= '
		<tr>
			<td align="center" style="width: 15ex; white-space: nowrap;">
				<nobr>
					[<a href="edit_special.php?id=auto_inc_field">'.EDIT_LINK.'</a>]
					['.DELETE_LINK.']
					['.UP_LINK.']
					['.DOWN_LINK.']
				</nobr>
			</td>
			<td style="white-space: nowrap;">'.AUTO_INC_FIELD_NAME.'</td>
			<td>'.AUTO_INCREMENT.'</td>
		</tr>';
}

if ($result->numRows() > 0){
	while($row = $result->fetchRow()){
		if ($row["input_type"] != 'divider'){
			$table_rows .= '
				<tr>
					<td align="center" style="width: 15ex; white-space: nowrap;">
						<nobr>';
			
			if ($admin_user->can_admin_field($row["id"])){
				$table_rows .= '
					[<a href="edit_field.php?id='.$row["id"].'">'.EDIT_LINK.'</a>]
					[<a href="delete_field.php?id='.$row["id"].'">'.DELETE_LINK.'</a>]
					[<a href="field_processor.php?action=moveup&amp;id='.$row["id"].'&amp;i='.$row["importance"].'">'.UP_LINK.'</a>]
					[<a href="field_processor.php?action=movedown&amp;id='.$row["id"].'&amp;i='.$row["importance"].'">'.DOWN_LINK.'</a>]';
			}
			else{
				$table_rows .= '
					['.EDIT_LINK.']
					['.DELETE_LINK.']
					['.UP_LINK.']
					['.DOWN_LINK.']';
			}
			
			$table_rows .= '
							</nobr>
						</td>
						<td style="white-space: nowrap;">'.$row["name"].'</td>
						<td>'.$row["input_type"].'</td>
					</tr>';
		}
		else{
			$table_rows .= '
				<tr>
					<td align="center" style="width: 15ex; white-space: nowrap;">
						<nobr>
							['.EDIT_LINK.']
							[<a href="field_processor.php?action=do_delete&amp;id='.$row["id"].'">'.DELETE_LINK.'</a>]
							[<a href="field_processor.php?action=moveup&amp;id='.$row["id"].'&amp;i='.$row["importance"].'">'.UP_LINK.'</a>]
							[<a href="field_processor.php?action=movedown&amp;id='.$row["id"].'&amp;i='.$row["importance"].'">'.DOWN_LINK.'</a>]
						</nobr>
					</td>
					<td style="white-space: nowrap;" colspan="2"><hr /></td>
				</tr>';
		}
	}
}

$table_rows = '<table>'.$table_rows.'</table>';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>
				'.FIELDS.'
			</td>
			<td style="text-align: right;">
				[<a href="../docs/fields.php">'.HELP.'</a>]
			</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				<p style="padding: 5px;"><a href="add_field.php">'.ADD_FIELD.'</a> | <a href="field_processor.php?action=do_add_divider">'.ADD_DIVIDER.'</a>.</p>
				'.$table_rows.'
			</td>
		</tr>
	</table>';

display($output);

?>
