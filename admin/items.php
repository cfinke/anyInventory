<?php

include("globals.php");

$title = 'anyInventory: Items';

$output .= '<table style="width: 100%;"><tr><td><a href="add_item.php">Add an item.</a></td><td style="text-align: right;"><a href="../docs/items.php">Help with items</a></td></tr></table>';

$category = new category(0);

$query = "SELECT `id`,`name`,`item_category` FROM `anyInventory_items` WHERE `item_category`='".$category->id."' ORDER BY `name` ASC";
$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);

if (mysql_num_rows($result) > 0){
	$output .= '<h3>'.$category->breadcrumb_names.'</h3>';
	$output .= '
		<table style="width: 100%; background-color: #000000;" cellspacing="1" cellpadding="2">
			<tr class="row_head"><td>&nbsp;</td><td>Name</td></tr>';
	
	$i = 0;
	
	while($row = mysql_fetch_assoc($result)){
		$color_code = (($i % 2) == 1) ? 'row_on' : 'row_off';
		$output .= '
			<tr class="'.$color_code.'">
				<td align="center" style="width: 18ex; white-space: nowrap;">
					<a href="edit_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">[edit]</a>
					<a href="move_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">[move]</a>
					<a href="delete_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">[delete]</a>
				</td>
				<td>'.$row["name"].'</td>
			</tr>';
		
		$i++;
	}
	
	$output .= '</table>';
}

$cat_ids = get_category_array();

if (is_array($cat_ids)){
	foreach($cat_ids as $cat){
		$category = new category($cat["id"]);
		
		$query = "SELECT `id`,`name`,`item_category` FROM `anyInventory_items` WHERE `item_category`='".$category->id."' ORDER BY `name` ASC";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
		
		if (mysql_num_rows($result) > 0){
			$output .= '<h3>'.$category->breadcrumb_names.'</h3>';
			$output .= '
				<table style="width: 100%; background-color: #000000;" cellspacing="1" cellpadding="2">
					<tr class="row_head"><td>&nbsp;</td><td>Name</td></tr>';
			
			$i = 0;
			
			while($row = mysql_fetch_assoc($result)){
				$color_code = (($i % 2) == 1) ? 'row_on' : 'row_off';
				$output .= '
					<tr class="'.$color_code.'">
						<td align="center" style="width: 18ex; white-space: nowrap;">
							<a href="edit_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">[edit]</a>
							<a href="move_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">[move]</a>
							<a href="delete_item.php?c='.$row["item_category"].'&amp;id='.$row["id"].'">[delete]</a>
						</td>
						<td>'.$row["name"].'</td>
					</tr>';
				
				$i++;
			}
			
			$output .= '</table>';
		}
	}
}

display($output);

?>