<?php

include("globals.php");

$title = "anyInventory: Add Category";

$output = '
	<form method="post" action="category_processor.php">
		<input type="hidden" name="action" value="do_add" />
		<table style="width: 100%;"><tr><td><h2>Add a Category</h2></td><td style="text-align: right;"><a href="../docs/categories.php#adding">Help with adding categories</a></td></tr></table>
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
						'.get_category_options($_REQUEST["c"], false).'
					</select>
				</td>
			</tr>
			<tr>
				<td class="form_label">Fields:</td>
				<td class="form_input">
					<input type="checkbox" name="inherit_fields" id="inherit_fields" value="yes" checked="checked" /> Inherit fields from parent (in addition to fields checked below)<br /><br />
					'.get_fields_checkbox_area().'
				</td>
			</tr>
			<tr>
				<td class="form_label">&nbsp;</td>
				<td class="form_input"><input type="submit" name="submit" id="submit" value="Submit" /></td>
			</tr>
		</table>
	</form>';

display($output);

?>