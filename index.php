<?php

include("globals.php");

// The default category is the top level.
if (!$_REQUEST["c"]) $_REQUEST["c"] = 0;

// Create a category object for the current category.
$category = new category($_REQUEST["c"]);

$title = "anyInventory: ".$category->breadcrumb_names;
$breadcrumbs = $category->get_breadcrumb_links();

// Display the breadcrumb links to this category.
if ($_REQUEST["id"]){
	// A specific item has been requested.
	$item = new item($_REQUEST["id"]);
	$output .= $item->export_description();
	
	$query = "SELECT `id`,`field_id` FROM `anyInventory_alerts` WHERE `item_ids` LIKE '%\"".$item->id."\"%'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	if (mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)){
			$alert = new alert($row["id"]);
			$field = new field($row["field_id"]);
			
			if (($alert->timed) || (eval('return ("'.addslashes($item->fields[$field->name]).'" '.$alert->condition.' "'.addslashes($alert->value).'");'))){
				if (!$tripped){
					$output .= '</td><td style="width: 30ex;">';
					$tripped = true;
				}
				
				$output .= $alert->export_box();
			}
		}
	}
}
else{
	if ($_REQUEST["c"] == 0){
		$output .= '<p style="padding: 15px 0px 15px 0px;">This is the front page and top-level category of anyInventory.  You can <a href="docs/">read the documentation</a> for instructions on using anyInventory, or you can navigate the inventory by clicking on any of the subcategories below; any items in a category will appear below the subcategories.  You can tell where you are in the inventory by the breadcrumb links at the top of each category page.</p>';
	}
	
	$output .= '
		<table>
			<tr>
				<td style="width: 100%;">
					<table class="standardTable" cellspacing="0" cellpadding="3">
						<tr class="tableHeader">
							<td>
								Categories ( <a href="admin/edit_category.php?id='.$_REQUEST["c"].'">Edit</a> | <a href="admin/delete_category.php">Delete</a> | <a href="admin/add_category.php?c='.$_REQUEST["c"].'">Add a category here</a> )
							</td>
							<td style="text-align: right;">
								[ <a href="../docs/categories.php">Help</a> ]
							</td>
						</tr>
						<tr>
							<td class="tableData" colspan="2">
								<table>';
	
	// If this category has subcategories, display them.
	if (is_array($category->children_ids) && ($category->num_children > 0)){
		foreach($category->children_ids as $child_id){
			$child = new category($child_id);
			$output .= '<tr><td><a href="'.$_SERVER["PHP_SELF"].'?c='.$child->id.'"><b>'.$child->name.'</b> ('.$child->num_items_r().')</a></td></tr>';
		}
	}
	else{
		$output .= '<tr><td style="text-align: center;">There are no sub-categories in this category.</td></tr>';
	}
	
	$output .= '</table>
				</td>
			</tr>
			<tr class="tableHeader">
				<td>
					Items in this Category (<a href="admin/add_item.php?c='.$_REQUEST["c"].'">Add an item here</a>)
				</td>
				<td style="text-align: right;">
					[ <a href="../docs/items.php">Help</a> ]
				</td>
			</tr>
			<tr>
				<td class="tableData" colspan="2">
					<table>';
	
	// Display any items in this category.
	$query = "SELECT `id` FROM `anyInventory_items` WHERE `item_category`='".$category->id."' ORDER BY `name` ASC";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	if (mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)){
			$item = new item($row["id"]);
			
			$output .= '<tr><td>'.$item->export_teaser().'</td></tr>';
		}
	}
	else{
		$output .= '<tr><td style="text-align: center;">There are no items in this category.</td></tr>';
	}
	
	$output .= '
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td>';
	
	$query = "SELECT `id` FROM `anyInventory_alerts` WHERE `time` <= NOW()";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	while ($row = mysql_fetch_array($result)){
		$alert = new alert($row["id"]);
		
		if (is_array($alert->item_ids)){
			foreach ($alert->item_ids as $item_id){
				$item = new item($item_id);
				$field = new field($alert->field_id);
				
				if (($alert->timed) || (eval('return ("'.addslashes($item->fields[$field->name]).'" '.$alert->condition.' "'.addslashes($alert->value).'");'))){
					if (!$tripped){
						$tripped = true;
					}
					
					$output .= $alert->export_box($item_id);
				}
			}
		}
	}
	
	$output .= '</td></tr></table>';
}

display($output);

?>