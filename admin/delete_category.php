<?php

include("globals.php");

if (!$admin_user->can_admin($_GET["id"])){
	header("Location: ../error_handler.php?eid=13");
	exit;
}

if ($_GET["id"] == 0){
	header("Location: ../error_handler.php?eid=7");
	exit;
}
else{
	$title = "anyInventory: Delete Category";
	$breadcrumbs = 'Administration > <a href="categories.php">Categories</a> > Delete Category';
	
	$category = new category($_GET["id"]);
	
	$output .= '
		<form method="post" action="category_processor.php">
			<input type="hidden" name="id" value="'.$_GET["id"].'" />
			<input type="hidden" name="action" value="do_delete" />
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Delete a Category</td>
					<td style="text-align: right;">[<a href="../docs/deleting_categories.php">Help</a>]</td>
				</tr>
				<tr>
					<td class="tableData" colspan="2">
						<p>Are you sure you want to delete this category?</p>
					</td>
				</tr>
				<tr class="tableHeader"
					<td colspan="2">'.$category->breadcrumb_names.'</td>
				</tr>
				<tr>
					<td class="tableData" colspan="2">
						<table>
						<tr>
							<td class="form_label">Fields:</td>
							<td>';
	
	if(is_array($category->field_names)){
		foreach($category->field_names as $field){
			$output .= $field.', ';
		}
		$output = substr($output, 0, strlen($output) - 2);
	}
	else{
		$output .= 'None';
	}
	
	$output .= '</td>
							</tr>
							<tr>
								<td class="form_label">Number of items:</td>
								<td>'.$category->num_items().'</td>
							</tr>';
	
	if ($category->num_items() > 0){
		$output .= '		<tr>
								<td class="form_label"><input type="radio" name="item_action" value="delete" /></td>
								<td>Delete all items in this category</td>
							</tr>
							<tr>
								<td class="form_label"><input type="radio" name="item_action" value="move" /></td>
								<td>Move all items in this category to <select name="move_items_to" id="move_items_to">'.get_category_options($category->parent_id, false).'</select></td>
							</tr>';
	}
	
	$output .= '
							<tr>
								<td class="form_label">Number of subcategories:</td>
								<td>'.$category->num_children.'</td>
							</tr>';
	
	if ($category->num_children > 0){
		$output .= '
			<tr>
				<td class="form_label"><input type="radio" name="subcat_action" value="delete" /></td>
				<td>Delete all sub-categories</td>
			</tr>
			<tr>
				<td class="form_label"><input type="radio" name="subcat_action" value="move" /></td>
				<td>Move all sub-categories to <select name="move_subcats_to" id="move_subcats_to">'.get_category_options($category->parent_id, false).'</select></td>
			</tr>
			<tr>
				<td class="form_label">Number of items in this<br /> category and its subcategories:</td>
				<td>'.$category->num_items_r().'</td>
			</tr>';
	}
	
	$output .= '<tr>
								<td class="submitButtonRow" colspan="2"><input type="submit" name="delete" value="Delete" /> <input type="submit" name="cancel" value="Cancel" /></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>';
	
	display($output);
}

?>