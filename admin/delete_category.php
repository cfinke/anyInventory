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
	$title = DELETE_CATEGORY;
	$breadcrumbs = ADMINISTRATION.' > <a href="categories.php">'.CATEGORIES.'</a> > '.DELETE_CATEGORY;
	
	$category = new category($_GET["id"]);
	
	$output .= '
		<form method="post" action="category_processor.php">
			<input type="hidden" name="id" value="'.$_GET["id"].'" />
			<input type="hidden" name="action" value="do_delete" />
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>'.DELETE_CATEGORY.'</td>
					<td style="text-align: right;">[<a href="../docs/'.LANG.'/deleting_categories.php">'.HELP.'</a>]</td>
				</tr>
				<tr>
					<td class="tableData" colspan="2">
						<p>'.DELETE_CATEGORY_CONFIRM.'</p>
					</td>
				</tr>
				<tr class="tableHeader"
					<td colspan="2">'.$category->breadcrumb_names.'</td>
				</tr>
				<tr>
					<td class="tableData" colspan="2">
						<table>
						<tr>
							<td class="form_label">'.FIELDS.':</td>
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
								<td class="form_label">'.NUM_ITEMS.':</td>
								<td>'.$category->num_items().'</td>
							</tr>';
	
	if ($category->num_items() > 0){
		$output .= '		<tr>
								<td class="form_label"><input type="radio" name="item_action" value="delete" /></td>
								<td>'.DELETE_ALL_ITEMS.'</td>
							</tr>
							<tr>
								<td class="form_label"><input type="radio" name="item_action" value="move" /></td>
								<td>'.MOVE_ITEMS_TO.'
									<select name="move_items_to" id="move_items_to">
										'.get_category_options($category->parent_id, false, $category->id).'
									</select>
								</td>
							</tr>';
	}
	
	$output .= '
							<tr>
								<td class="form_label">'.NUM_SUBCATS.':</td>
								<td>'.$category->num_children.'</td>
							</tr>';
	
	if ($category->num_children > 0){
		$exclude = $category->all_children_ids;
		$exclude[] = $category->id;
		
		$output .= '
			<tr>
				<td class="form_label"><input type="radio" name="subcat_action" value="delete" /></td>
				<td>'.DELETE_ALL_SUBCATS.'</td>
			</tr>
			<tr>
				<td class="form_label"><input type="radio" name="subcat_action" value="move" /></td>
				<td>'.MOVE_SUBCATS_TO.' 
					<select name="move_subcats_to" id="move_subcats_to">
						<option value="0">'.TOP_LEVEL_CATEGORY.'</option>
						'.get_category_options($category->parent_id, false, $exclude).'
					</select>
				</td>
			</tr>
			<tr>
				<td class="form_label">'.NUM_ITEMS_R.':</td>
				<td>'.$category->num_items_r().'</td>
			</tr>';
	}
	
	$output .= '<tr>
								<td class="submitButtonRow" colspan="2"><input type="submit" name="delete" value="'._DELETE.'" /> <input type="submit" name="cancel" value="'.CANCEL.'" /></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>';
	
	display($output);
}

?>