<?php

include("globals.php");

$title = ADD_CATEGORY;
$breadcrumbs = ADMINISTRATION.' > <a href="categories.php">'.CATEGORIES.'</a> > '.ADD_CATEGORY;

$output = '
	<form method="post" action="category_processor.php">
		<input type="hidden" name="action" value="do_add" />
		<table class="standardTable" cellspacing="0">
			<tr class="tableHeader">
				<td>'.ADD_CATEGORY.'</td>
				<td style="text-align: right;">[<a href="../docs/'.LANG.'/categories.php#adding">'.HELP.'</a>]</td>
			</tr>
			<tr>
				<td class="tableData">
					<table>
						<tr>
							<td class="form_label"><label for="name">'.NAME.':</label></td>
							<td class="form_input"><input type="text" name="name" id="name" value="" /></td>
						</tr>
						<tr>
							<td class="form_label"><label for="parent">'.PARENT_CATEGORY.':</label></td>
							<td class="form_input">
								<select name="parent" id="parent">
									<option value="0">'.TOP_LEVEL_CATEGORY.'</option>
									'.$admin_user->get_admin_categories_options($_GET["c"], false).'
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
$result = mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />' . $query);

while($row = mysql_fetch_array($result)){
	$output .= '<option value="'.$row["id"].'" selected="selected">'.$row["username"].'</option>';
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
$result = mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />' . $query);

while($row = mysql_fetch_array($result)){
	$output .= '<option value="'.$row["id"].'">'.$row["username"].'</option>';
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
								<input type="checkbox" name="auto_inc" id="auto_inc" value="yes" /> '.SHOW_AUTOINC_FIELD.'<br /><br />
								<input type="checkbox" name="inherit_fields" id="inherit_fields" value="yes" checked="checked" /> '.INHERIT_FIELDS.'<br /><br />
								'.get_fields_checkbox_area().'
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

?>