<?php

include("globals.php");

$title = 'anyInventory: Categories';
$breadcrumbs = 'Administration > Categories';

$rows = get_category_array();

if (count($rows) > 0){
	foreach($rows as $row){
		if ($view_user->can_view($row["id"]) || $admin_user->can_admin($row["id"])){
			$temp = new category($row["id"]);
			
			$table_rows .= '
				<tr>
					<td align="center" style="width: 15ex; white-space: nowrap;">
						<nobr>';
			
			if ($admin_user->can_admin($row["id"])){
				$table_rows .= '
							[<a href="edit_category.php?id='.$row["id"].'">edit</a>]
							[<a href="delete_category.php?id='.$row["id"].'">delete</a>]';
			}
			
			$table_rows .= '
						</nobr>
					</td>
					<td style="white-space: nowrap;">';
			
			if ($view_user->can_view($row["id"])){
				$table_rows .= $temp->get_breadcrumb_links();
			}
			else{
				$table_rows .= $temp->breadcrumb_names;
			}
			
			$table_rows .= ' ('.$temp->num_items_r().')</td>
				</tr>';
		}
	}
	
	$table_rows = '<table>'.$table_rows.'</table>';
}

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>
				Categories
			</td>
			<td style="text-align: right;">
				[<a href="../docs/categories.php">Help</a>]
			</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				<p style="padding-left: 5px;"><a href="add_category.php">Add a category</a></p>
				'.$table_rows.'
			</td>
		</tr>
	</table>';

display($output);

?>