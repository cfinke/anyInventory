<?php

include("globals.php");

$title = ITEMS;
$breadcrumbs = ITEMS;

$category = new category(0);

$query = "SELECT ".$db->quoteIdentifier('id').",".$db->quoteIdentifier('name').",".$db->quoteIdentifier('item_category')." FROM ".$db->quoteIdentifier('anyInventory_items')." WHERE ".$db->quoteIdentifier('item_category')."='".$category->id."' ORDER BY ".$db->quoteIdentifier('name')." ASC";
$result = $db->query($query);
if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);

if ($result->numRows() > 0){
	$table_rows .= '
		<table class="standardTable" cellspacing="0">
			<tr class="tableHeader">
				<td>'.$category->breadcrumb_names.'</td>
			</tr>
			<tr>
				<td class="tableData">
					<table>';
	
	while($row = $result->fetchRow()){
		$output .= '
			<tr>
				<td align="center" style="width: 18ex; white-space: nowrap;">
					<nobr>
						[<a href="edit_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">'.EDIT_LINK.'</a>]
						[<a href="move_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">'.MOVE_LINK.'</a>]
						[<a href="delete_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">'.DELETE_LINK.'</a>]
					</nobr>
				</td>
				<td><a href="../index.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">'.$row["name"].'</a></td>
			</tr>';
	}
}
else{
	$empty = true;
}

$cat_ids = get_category_array();

if (is_array($cat_ids)){
	foreach($cat_ids as $cat){
		if ($admin_user->can_admin($cat["id"])){
			$category = new category($cat["id"]);
			
			$query = "SELECT ".$db->quoteIdentifier('id').",".$db->quoteIdentifier('name').",".$db->quoteIdentifier('item_category')." FROM ".$db->quoteIdentifier('anyInventory_items')." WHERE ".$db->quoteIdentifier('item_category')."='".$category->id."' ORDER BY ".$db->quoteIdentifier('name')." ASC";
			$result = $db->query($query);
			if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
			
			if ($result->numRows() > 0){
				$table_rows .= '
					<table class="standardTable" cellspacing="0">
						<tr class="tableHeader">
							<td>'.$category->get_breadcrumb_admin_links().'</td>
							<td style="text-align: right;">[<a href="add_item.php?c='.$category->id.'">'.ADD_ITEM_HERE.'</a>]</td>
						</tr>
						<tr>
							<td class="tableData" colspan="2">
								<table>';
				
				while($row = $result->fetchRow()){
					$table_rows .= '
						<tr>
							<td style="width: 18ex; text-align: center; white-space: nowrap;">
								<nobr>
									<a href="edit_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">['.EDIT_LINK.']</a>
									<a href="move_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">['.MOVE_LINK.']</a>
									<a href="delete_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">['.DELETE_LINK.']</a>
								</nobr>
							</td>
							<td><a href="../index.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">'.$row["name"].'</a></td>
						</tr>';
				}
				
				$table_rows .= '
								</table>
							</td>
						</tr>
					</table>';
			}
		}
	}
}

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>
				'.ITEMS.'
			</td>
			<td style="text-align: right;">
				[<a href="../docs/'.LANG.'/items.php">'.HELP.'</a>]
			</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				<p style="padding-left: 5px;"><a href="add_item.php">'.ADD_ITEM.'</a></p>
				'.$table_rows.'
			</td>
		</tr>
	</table>';

display($output);

?>
