<?php

include("globals.php");

$title = "anyInventory: Add Category";
$breadcrumbs = 'Administration > <a href="categories.php">Categories</a> > Add Category';

$output = '
	<form method="post" action="category_processor.php">
		<input type="hidden" name="action" value="do_add" />
		<table class="standardTable" cellspacing="0">
			<tr class="tableHeader">
				<td>Add a Category</td>
				<td style="text-align: right;">[<a href="../docs/categories.php#adding">Help</a>]</td>
			</tr>
			<tr>
				<td class="tableData">
					<table>
						<tr>
							<td class="form_label"><label for="name">Name:</label></td>
							<td class="form_input"><input type="text" name="name" id="name" value="" /></td>
						</tr>
						<tr>
							<td class="form_label"><label for="parent">Parent Category:</label></td>
							<td class="form_input">
								<select name="parent" id="parent">
									<option value="0">Top Level</option>
									'.$admin_user->get_admin_categories_options($_GET["c"], false).'
								</select>
							</td>
						</tr>';

if (PP_VIEW){
	$output .= '
						<tr>
							<td class="form_label"><label for="parent">Give viewing priveleges to:</label></td>
							<td class="form_input">
								<select name="view_users[]" id="view_users[]" multiple="multiple" size="10" style="width: 100%;">';

$query = "SELECT * FROM `anyInventory_users` WHERE `usertype` != 'Administrator' ORDER BY `username` ASC";
$result = mysql_query($query) or die(mysql_error() . '<br /><br />' . $query);

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
							<td class="form_label"><label for="parent">Give admin priveleges to:</label></td>
							<td class="form_input">
								<select name="admin_users[]" id="admin_users[]" multiple="multiple" size="10" style="width: 100%;">';

$query = "SELECT * FROM `anyInventory_users` WHERE `usertype` != 'Administrator' ORDER BY `username` ASC";
$result = mysql_query($query) or die(mysql_error() . '<br /><br />' . $query);

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
							<td class="form_label">Fields:</td>
							<td class="form_input">
								<input type="checkbox" name="auto_inc" id="auto_inc" value="yes" checked="" /> Show auto-increment field<br /><br />
								<input type="checkbox" name="inherit_fields" id="inherit_fields" value="yes" checked="checked" /> Inherit fields from parent (in addition to fields checked below)<br /><br />
								'.get_fields_checkbox_area().'
							</td>
						</tr>
						<tr>
							<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="Submit" /></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>';

display($output);

?>