<?php

include("globals.php");

$title = 'anyInventory: Items';
$breadcrumbs = 'Administration > Items';

$category = new category(0);

$query = "SELECT `id`,`name`,`item_category` FROM `anyInventory_items` WHERE `item_category`='".$category->id."' ORDER BY `name` ASC";
$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);

if (mysql_num_rows($result) > 0){
	$table_rows .= '
		<table class="standardTable" cellspacing="0">
			<tr class="tableHeader">
				<td>'.$category->breadcrumb_names.'</td>
			</tr>
			<tr>
				<td class="tableData">
					<table>';
	
	while($row = mysql_fetch_assoc($result)){
		$output .= '
			<tr>
				<td align="center" style="width: 18ex; white-space: nowrap;">
					<nobr>
						[<a href="edit_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">edit</a>]
						[<a href="move_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">move</a>]
						[<a href="delete_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">delete</a>]
					</nobr>
				</td>
				<td>'.$row["name"].'</td>
			</tr>';
	}
}
else{
	$empty = true;
}

$cat_ids = get_category_array();

if (is_array($cat_ids)){
	foreach($cat_ids as $cat){
		$category = new category($cat["id"]);
		
		$query = "SELECT `id`,`name`,`item_category` FROM `anyInventory_items` WHERE `item_category`='".$category->id."' ORDER BY `name` ASC";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
		
		if (mysql_num_rows($result) > 0){
			$table_rows .= '
				<table class="standardTable" cellspacing="0">
					<tr class="tableHeader">
						<td>'.$category->get_breadcrumb_admin_links().'</td>
						<td style="text-align: right;">[<a href="add_item.php?c='.$category->id.'">Add an item here</a>]</td>
					</tr>
					<tr>
						<td class="tableData" colspan="2">
							<table>';
			
			while($row = mysql_fetch_assoc($result)){
				$table_rows .= '
					<tr>
						<td style="width: 18ex; text-align: center; white-space: nowrap;">
							<nobr>
								<a href="edit_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">[edit]</a>
								<a href="move_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">[move]</a>
								<a href="delete_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">[delete]</a>
							</nobr>
						</td>
						<td>'.$row["name"].'</td>
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

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>
				Items
			</td>
			<td style="text-align: right;">
				[<a href="../docs/items.php">Help</a>]
			</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				<p style="padding-left: 5px;"><a href="add_item.php">Add an item</a></p>
				'.$table_rows.'
			</td>
		</tr>
	</table>';

display($output);

?>