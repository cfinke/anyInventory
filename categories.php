<?php

include("globals.php");

$title = 'anyInventory Categories';
$page_key = "categories";
$links = array(array("url"=>$_SERVER["PHP_SELF"]."?action=add","name"=>"Add a Category"));

if (($_REQUEST["action"] == "add") || ($_REQUEST["action"] == "edit")){
	if ($_REQUEST["action"] == "edit"){
		$category = new category($_REQUEST["id"]);
	}
	$output = '
		<form method="post" action="categories_actions.php" enctype="multipart/form-data">
			<input type="hidden" name="action" value="do_'.$_REQUEST["action"].'" />
			<input type="hidden" name="id" value="'.$category->id.'" />
			<table>
				<tr>
					<td class="form_label"><label for="name">Name:</label></td>
					<td class="form_input"><input type="text" name="name" id="name" value="'.$category->name.'" /></td>
				</tr>
				<tr>
					<td class="form_label"><label for="parent">Parent Category:</label></td>
					<td class="form_input">
						<select name="parent" id="parent">
							'.get_category_dropdown($category->parent_id).'
						</select>
					</td>
				</tr>
				<tr>
					<td class="form_label">Fields:</td>
					<td class="form_input">
						'.get_fields_checkbox_area($category->field_ids).'
					</td>
				</tr>
				<tr>
					<td class="form_label">&nbsp;</td>
					<td class="form_input"><input type="submit" name="submit" id="submit" value="Submit" /></td>
				</tr>
			</table>
		</form>';
}
elseif($_REQUEST["action"] == "delete"){
	$category = new category($_REQUEST["id"]);
	
	$output .= '
		<form method="post" action="categories_actions.php">
			<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
			<input type="hidden" name="action" value="do_delete" />
			<p>Are you sure you want to delete this category?</p>';
	
	$output .= '
		<div class="category_info">
			<p class="category_name"><b>Name:</b> '.$category->breadcrumb_names.'</p>
			<p class="category_fields"><b>Fields:</b> ';
	
	if(is_array($category->field_names)){
		foreach($category->field_names as $field){
			$output .= $field.', ';
		}
		$output = substr($output, 0, strlen($output) - 2);
	}
	else{
		$output .= 'None';
	}
	
	$output .= '</p><p><b>Number of items inventoried in this category:</b> '.$category->num_items().'</p>';
	
	if ($category->num_items() > 0){
		$output .= '
			<p>
				<input type="radio" name="item_action" value="delete" /> Delete all items in this category<br />
			   	<input type="radio" name="item_action" value="move" /> Move all items in this category to <select name="move_items_to" id="move_items_to">'.get_category_dropdown($category->parent_id).'</select>.
			</p>';
	}
	
	$output .= '<p><b>Number of subcategories:</b> '.count($category->children).'</p>';
	
	if (count($category->children) > 0){
		$output .= '
			<p>
				<input type="radio" name="subcat_action" value="delete" /> Delete all sub-categories<br />
			   	<input type="radio" name="subcat_action" value="move" /> Move all sub-categories to <select name="move_subcats_to" id="move_subcats_to">'.get_category_dropdown($category->parent_id).'</select>.
			</p>';
	}
	
	$output .= '
			<p><b>Number of items inventoried in this category\'s subcategories:</b> '.$category->num_items_r().'</p>
			<p style="text-align: center;"><input type="submit" name="delete" value="Delete" /> <input type="submit" name="cancel" value="Cancel" /></p>
		</form>';
}
else{
	$output .= '<p><a href="'.$_SERVER["PHP_SELF"].'?action=add">Add a Category.</a></p>';
	
	//$query = "SELECT *,'' as `nosortcol_`,`name` as `sortcol_Name`,'' as `nosortcol_Fields`, '' as `nosortcol_Items` FROM `anyInventory_categories`";
	//$data_obj = new dataset_library("Categories", $query, $_REQUEST, "mysql");
	//$result = $data_obj->get_result_resource();
	//$rows = $data_obj->get_result_set();
	
	$rows = get_category_array();
	
	if (count($rows) > 0){
		$i = 0;
		
		foreach($rows as $row){
			$temp = new category($row["id"]);
			
			$color_code = (($i % 2) == 1) ? 'row_on' : 'row_off';
			$table_set .= '<tr class="'.$color_code.'">';
			$table_set .= '<td align="center" style="width: 10%; white-space: nowrap;"><a href="'.$_SERVER["PHP_SELF"].'?action=edit&amp;id='.$row["id"].'">[edit]</a> <a href="'.$_SERVER["PHP_SELF"].'?action=delete&amp;id='.$row["id"].'">[delete]</a></td>';
			$table_set .= '<td style="white-space: nowrap;">'.$row["name"].'</td>';
			$table_set .= '<td>';
			
			if (count($temp->field_names) > 0){
				foreach($temp->field_names as $field){
					$table_set .= $field . ', ';
				}
				
				$table_set = substr($table_set, 0, strlen($table_set) - 2);
			}
			
			$table_set .= '&nbsp;</td>';
			$table_set .= '<td>'.$temp->num_items().'</td>';
			$table_set .= '</tr>';
			$i++;
		}
	}
	else{
		$table_set .= '<tr class="row_off"><td>There are no categories to display.</td></tr>';
	}
	
	//$table_set = $data_obj->get_sort_interface() . $table_set . $data_obj->get_paging_interface();
	
	$output .= '<table style="width: 100%; background-color: #000000;" cellspacing="1" cellpadding="2">'.$table_set.'</table>';
}

include("header.php");
echo $output;
include("footer.php");

exit;

?>