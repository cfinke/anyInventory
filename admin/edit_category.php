<?php

include("globals.php");

$title = "anyInventory: Edit Category";

$category = new category($_REQUEST["id"]);

$output = '
	<form method="post" action="category_processor.php">
		<input type="hidden" name="action" value="do_edit" />
		<input type="hidden" name="id" value="'.$category->id.'" />
		<table style="width: 100%;"><tr><td><h2>Edit a Category</h2></td><td style="text-align: right;"><a href="../docs/editing_categories.php">Help with editing categories</a></td></tr></table>
		<table>
			<tr>
				<td class="form_label"><label for="name">Name:</label></td>
				<td class="form_input"><input type="text" name="name" id="name" value="'.$category->name.'" /></td>
			</tr>
			<tr>
				<td class="form_label"><label for="parent">Parent Category:</label></td>
				<td class="form_input">
					<select name="parent" id="parent">
						'.get_category_options($category->parent_id).'
					</select>
				</td>
			</tr>
			<tr>
				<td class="form_label">Fields:</td>
				<td class="form_input">';

if($category->id != 0){
	$output .= '<input type="checkbox" name="inherit_fields" id="inherit_fields" value="yes" checked="checked" /> Inherit fields from this category\'s parent.<br />';
}

if($category->num_children > 0){
	$output .= '<input type="checkbox" name="apply_fields" id="apply_fields" value="yes" checked="checked" /> Apply this category\'s fields to all subcategories.<br />';
}

$output .= '<br />'.get_fields_checkbox_area($category->field_ids).'
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