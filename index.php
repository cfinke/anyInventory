<?php

require_once("globals.php");

// The default category is the top level.
if (!$_GET["c"]) $_GET["c"] = 0;

// Create a category object for the current category.
$category = new category($_GET["c"]);
if (!$view_user->can_view($category->id)){
	header("Location: error_handler.php?eid=12");
	exit;
}

$title = $category->breadcrumb_names;
$breadcrumbs = $category->get_breadcrumb_links();

// Display the breadcrumb links to this category.
if ($_GET["id"]){
	// A specific item has been requested.
	$item = new item($_GET["id"]);
	$breadcrumbs = $item->category->get_breadcrumb_links();
	$output .= '
		<table cellspacing="0" cellpadding="0">
			<tr>
				<td style="width: 100%;">';
	
	$output .= $item->export_description();
	
	$query = "SELECT " . $db->quoteIdentifier('id') . "," . $db->quoteIdentifier('field_id') . " FROM " . $db->quoteIdentifier('anyInventory_alerts') . " WHERE " . $db->quoteIdentifier('item_ids') . " LIKE '%\"".$item->id."\"%' AND " . $db->quoteIdentifier('time') . " <= NOW() AND (" . $db->quoteIdentifier('expire_time') . " >= NOW() OR " . $db->quoteIdentifier('expire_time') . "='00000000000000')";
	$result = $db->query($query);
	if(DB::isError($result)) die($query->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	
	if ($result->numRows()> 0){
		$output .= '
				</td>
				<td style="padding-left: 5px;">';
		
		while ($row = $result->fetchRow()){
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
	
	$output .= '</td></tr></table>';
}
else{
	if ($_GET["c"] == 0){
		$query = "SELECT * FROM " . $db->quoteIdentifier('anyInventory_config') . " WHERE " . $db->quoteIdentifier('key') . "='FRONT_PAGE_TEXT'";
		$result = $db->query($query);
		if(DB::isError($query)) die($query->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		if ($result->numRows() > 0){
			$row = $result->fetchRow();
			$output .= '<p style="padding: 0px 0px 15px 0px;">'.$row["value"].'</p>';
		}
	}
	
	$output .= '
		<table cellspacing="0" cellpadding="0">
			<tr>
				<td style="width: 100%;">
					<table class="standardTable" cellspacing="0">
						<tr class="tableHeader">
							<td>'.SUBCATS_IN.' '.$category->get_breadcrumb_links();
	
	if($admin_user->can_admin($category->id)){
		if ($category->id != 0){
			$output .= ' ( <a href="admin/edit_category.php?id='.$_GET["c"].'">'.EDIT.'</a> | <a href="admin/delete_category.php?id='.$_GET["c"].'">'._DELETE.'</a> | ';
		}
		else{
			$output .= ' (';
		}
		
		$output .= ' <a href="admin/add_category.php?c='.$_GET["c"].'">'.ADD_CAT_HERE.'</a> )';
	}
	
	$output .= '			</td>
							<td style="text-align: right;">[<a href="docs/categories.php">'.HELP.'</a>]</td>
						</tr>
						<tr>
							<td class="tableData" colspan="2">
								<table>';
	
	// If this category has subcategories, display them.
	if (is_array($category->children_ids) && ($category->num_children > 0)){
		foreach($category->children_ids as $child_id){
			$child = new category($child_id);
			
			if ($view_user->can_view($child->id)){
				$output .= '<tr><td><a href="'.$_SERVER["PHP_SELF"].'?c='.$child->id.'"><b>'.$child->name.'</b> ('.$child->num_items_r().')</a></td></tr>';
			}
		}
	}
	else{
		$output .= '<tr><td style="text-align: center;">'.NO_SUBCATS.'</td></tr>';
	}
	
	$output .= '</table>
				</td>
			</tr>';
	
	// Display any items in this category.
	$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_items') . " WHERE " . $db->quoteIdentifier('item_category') . "='".$category->id."' ORDER BY " . $db->quoteIdentifier('name') . " ASC";
	$result = $db->query($query);
    if(DB::isError($result))  die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	
	if (($_GET["c"] != 0) || ($result->numRows()> 0)){
		$output .= '
			<tr class="tableHeader">
				<td>'.ITEMS_IN_CAT;
		
		if($admin_user->can_admin($_GET["c"])){
			if ($_GET["c"] != 0) $output .= ' ( <a href="admin/add_item.php?c='.$_GET["c"].'">'.ADD_ITEM_HERE.'</a> )';
		}
		
		$output .= '</td>
					<td style="text-align: right;">[<a href="'.$DIR_PREFIX.'admin/special_processor.php?action=switch_view&amp;c='.$_GET["c"].'">';
		
		$output .= (ITEM_VIEW == 'list') ? SWITCH_TO_TABLE : SWITCH_TO_LIST;
		
		$output .= '</a>]&nbsp;[<a href="docs/items.php">'.HELP.'</a>]</td>
				</tr>
				<tr>
					<td class="tableData" colspan="2">
						';
		
		if ($result->numRows() > 0){
			if (ITEM_VIEW == 'list'){
				$output .= '<table>';
				while ($row = $result->fetchRow()){
					$item = new item($row["id"]);
					
					$output .= '<tr>';
					
					if ($item->category->auto_inc_field){
						$output .= '<td style="width: 8%;">'.$item->id.'</td>';
					}
					
					$output .= '<td>'.$item->export_teaser().'</td></tr>';
				}
			}
			else{
				$output .= '<table cellspacing="0" cellpadding="3">';
				$output .= $category->export_table_header($_GET["fid"],$_GET["dir"]);
				
				if (isset($_GET["fid"])){
					while ($row = $result->fetchRow()){
						$item = new item($row["id"]);
						$item_rows[] = $item->export_assoc_array();
					}
					
					$item_rows = incision_sort($item_rows, "field_".$_GET["fid"]);
					
					if ($_GET["dir"] == "DESC"){
						$item_rows = array_reverse($item_rows);
					}
					
					foreach ($item_rows as $item_row){
						$item = new item($item_row["id"]);
						$output .= $item->export_table_row();
					}
				}
				else{
					while ($row = $result->fetchRow()){
						$item = new item($row["id"]);
						$output .= $item->export_table_row();
					}
				}
			}
		}
		else{
			$output .= '<table><tr><td style="text-align: center;">'.NO_ITEMS_HERE.'</td></tr>';
		}
		
		$output .= '
					</table>
				</td>
			</tr>';
	}
	
	$output .= '
			</table>
		</td>
		<td style="padding-left: 5px;">';
	
	$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_alerts') . " WHERE " . $db->quoteIdentifier('time') . " <= ? AND (" . $db->quoteIdentifier('expire_time') . " >= ? OR " . $db->quoteIdentifier('expire_time') . "= ?)";
	$query_data = array(date("YmdHis"),date("YmdHis"),'00000000000000');
	
	$pquery = $db->prepare($query);
	$result = $db->execute($pquery, $query_data);
    if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	
	while ($row = $result->fetchRow()){
		$alert = new alert($row["id"]);
		
		if (is_array($alert->item_ids)){
			foreach ($alert->item_ids as $item_id){
				$item = new item($item_id);
				$field = new field($alert->field_id);
				
				if ($view_user->can_view($item->category->id)){
					if (($alert->timed) || (eval('return ("'.addslashes($item->fields[$field->name]).'" '.$alert->condition.' "'.addslashes($alert->value).'");'))){
						if (!$tripped){
							$tripped = true;
						}
						
						$output .= $alert->export_box($item_id);
					}
				}
			}
		}
	}
	
	$output .= '</td></tr></table>';
}

display($output);

?>
