<?php

require_once("globals.php");

$title = CATEGORIES;
$breadcrumbs = ADMINISTRATION.' > '.CATEGORIES;

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
							[<a href="edit_category.php?id='.$row["id"].'">'.EDIT_LINK.'</a>]
							[<a href="delete_category.php?id='.$row["id"].'">'.DELETE_LINK.'</a>]';
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
				'.CATEGORIES.'
			</td>
			<td style="text-align: right;">
				[<a href="../docs/'.LANG.'/categories.php">'.HELP.'</a>]
			</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				<p style="padding-left: 5px;"><a href="add_category.php">'.ADD_CATEGORY.'</a></p>
				'.$table_rows.'
			</td>
		</tr>
	</table>';

display($output);

?>