<?php

include("globals.php");

if (!$admin_user->can_admin($_GET["id"])){
	header("Location: ../error_handler.php?eid=13");
	exit;
}
elseif ($_GET["id"] == '0'){
	header("Location: ../error_handler.php?eid=7");
	exit;
}
else{
	$title = EDIT_CATEGORY;
	$breadcrumbs = ADMINISTRATION.' > <a href="categories.php">'.CATEGORIES.'</a> > '.EDIT_CATEGORY;
	
	$category = new category($_GET["id"]);
	
	$checked = ($category->auto_inc_field) ? ' checked="checked"' : '';
	
	$exclude = $category->all_children_ids;
	$exclude[] = $category->id;
	
	$output = '
		<form method="post" action="category_processor.php">
			<input type="hidden" name="action" value="do_edit" />
			<input type="hidden" name="id" value="'.$category->id.'" />
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>'.EDIT_CATEGORY.': '.$category->get_breadcrumb_admin_links().'</td>
					<td style="text-align: right;">[<a href="../docs/'.LANG.'/editing_categories.php">'.HELP.'</a>]</td>
				</tr>
				<tr>
					<td class="tableData" colspan="2">
					<table>
						<tr>
							<td class="form_label"><label for="name">'.NAME.':</label></td>
							<td class="form_input"><input type="text" name="name" id="name" value="'.$category->name.'" /></td>
						</tr>
						<tr>
							<td class="form_label"><label for="parent">'.PARENT_CATEGORY.':</label></td>
							<td class="form_input">
								<select name="parent" id="parent">
									<option value="0">'.TOP_LEVEL_CATEGORY.'</option>
									'.$admin_user->get_admin_categories_options($category->parent_id, false, $exclude).'
								</select>
							</td>
						</tr>';

if (PP_VIEW){
	$output .= '
						<tr>
							<td class="form_label"><label for="parent">'.GIVE_VIEW_TO.':</label></td>
							<td class="form_input">
								<select name="view_users[]" id="view_users[]" multiple="multiple" size="10" style="width: 100%;">';

$query = "SELECT * FROM `anyInventory_users` WHERE `usertype` != 'Administrator' ORDER BY `username` ASC";
$result = mysql_query($query) or die(mysql_error() . '<br /><br />' . $query);

while($row = mysql_fetch_array($result)){
	$temp_user = new user($row["id"]);
	
	$output .= '<option value="'.$row["id"].'"';
	if ($temp_user->can_view($_GET["id"])) $output .= ' selected="selected"';
	$output .= '>'.$row["username"].'</option>';
}

$output .= '
								</select>
							</td>
						</tr>';
}

if (PP_ADMIN){
	$output .= '
						<tr>
							<td class="form_label"><label for="parent">'.GIVE_ADMIN_TO.':</label></td>
							<td class="form_input">
								<select name="admin_users[]" id="admin_users[]" multiple="multiple" size="10" style="width: 100%;">';

$query = "SELECT * FROM `anyInventory_users` WHERE `usertype` != 'Administrator' ORDER BY `username` ASC";
$result = mysql_query($query) or die(mysql_error() . '<br /><br />' . $query);

while($row = mysql_fetch_array($result)){
	$temp_user = new user($row["id"]);
	
	$output .= '<option value="'.$row["id"].'"';
	if ($temp_user->can_admin($_GET["id"])) $output .= ' selected="selected"';
	$output .= '>'.$row["username"].'</option>';
}

$output .= '
								</select>
							</td>
						</tr>';
}

$output .= '
						<tr>
							<td class="form_label">'.FIELDS.':</td>
							<td class="form_input">
								<input type="checkbox" name="auto_inc" id="auto_inc" value="yes" '.$checked.' /> '.SHOW_AUTOINC_FIELD.'<br /><br />';
	
	if($category->id != 0){
		$output .= '<input type="checkbox" name="inherit_fields" id="inherit_fields" value="yes" /> '.INHERIT_FIELDS.'<br />';
	}
	
	if($category->num_children > 0){
		$output .= '<input type="checkbox" name="apply_fields" id="apply_fields" value="yes" /> '.APPLY_FIELDS.'<br />';
	}
	
	$output .= '<br />'.get_fields_checkbox_area($category->field_ids).'
							</td>
						</tr>
						<tr>
							<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="'.SUBMIT.'" /></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		</form>';
	
	display($output);
}

?>