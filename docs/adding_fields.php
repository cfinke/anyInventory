<?php

include("globals.php");

$title = "anyInventory: Help > Fields > Adding Fields";

$output .= '
	<h2>Adding Fields</h2>
	<p>To begin tracking your receipts, you must add the fields listed on the previous page so that you can enter in the data later.
	   For this, proceed to the <a href="'.$DIR_PREFIX.'admin/add_field.php">field addition</a> page.  There, you will see
	   something that looks like this:</p>
   <form method="post" action="#">
		<table>
			<tr style="display: auto;">
				<td class="form_label"><label for="name">Name:</label></td>
				<td class="form_input"><input type="text" name="name" id="name" value="" /></td>
			</tr>
			<tr>
				<td class="form_label"><label for="name">Data type:</label></td>
				<td class="form_input">
					<select name="input_type" id="input_type"">
						<option onclick="document.getElementById(\'values_row\').style.display = \'none\';document.getElementById(\'size_row\').style.display = \'\';" value="text"';if($field->input_type == 'text') $output .= ' selected="selected"';$output.='>Text</option>
						<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="select"';if($field->input_type == 'select') $output .= ' selected="selected"';$output.='>Select Box</option>
						<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="multiple"';if($field->input_type == 'multiple') $output .= ' selected="selected"';$output.='>Multiple (Select + Text)</option>
						<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="checkbox"';if($field->input_type == 'checkbox') $output .= ' selected="selected"';$output.='>Checkboxes</option>
						<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="radio"';if($field->input_type == 'radio') $output .= ' selected="selected"';$output.='>Radio Buttons</option>
					</select>
				</td>
			</tr>
			<tr id="values_row" style="display: none;">
				<td class="form_label"><label for="values">Values:</label></td>
				<td class="form_input"><input type="text" name="values" id="values" value="" /></td>
			</tr>
			<tr style="display: auto;">
				<td class="form_label"><label for="default_value">Default value:</label></td>
				<td class="form_input"><input type="text" name="default_value" id="default_value" value="" /></td>
			</tr>
			<tr style="display: auto;" id="size_row">
				<td class="form_label"><label for="size">Size, in characters:</label></td>
				<td class="form_input"><input type="text" name="size" id="size" value="" /></td>
			</tr>
			<tr style="display: auto;">
				<td class="form_label">Apply field to:</td>
				<td class="form_input">
					<select name="add_to[]" id="add_to[]" multiple="multiple" size="10">
					</select>
				</td>
			</tr>
		</table>
	</form>
	<p>Let\'s begin adding our fields, shall we?  First up is the date of purchase.</p>
	<p>"But wait," you might say.  "Shouldn\'t we keep track of the name of each item?"  Don\'t worry.  You will never need to create a field to track an item name; that is the only built-in field in anyInventory.</p>
	<p>Back to the purchase date: first, we enter in the field name:</p>
   <form method="post" action="#">
		<table>
			<tr style="display: auto;">
				<td class="form_label"><label for="name">Name:</label></td>
				<td class="form_input"><input type="text" name="name" id="name" value="Purchase Date" /></td>
			</tr>
			<tr>
				<td class="form_label"><label for="name">Data type:</label></td>
				<td class="form_input">
					<select name="input_type" id="input_type"">
						<option onclick="document.getElementById(\'values_row\').style.display = \'none\';document.getElementById(\'size_row\').style.display = \'\';" value="text"';if($field->input_type == 'text') $output .= ' selected="selected"';$output.='>Text</option>
						<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="select"';if($field->input_type == 'select') $output .= ' selected="selected"';$output.='>Select Box</option>
						<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="multiple"';if($field->input_type == 'multiple') $output .= ' selected="selected"';$output.='>Multiple (Select + Text)</option>
						<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="checkbox"';if($field->input_type == 'checkbox') $output .= ' selected="selected"';$output.='>Checkboxes</option>
						<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="radio"';if($field->input_type == 'radio') $output .= ' selected="selected"';$output.='>Radio Buttons</option>
					</select>
				</td>
			</tr>
			<tr id="values_row" style="display: none;">
				<td class="form_label"><label for="values">Values:</label></td>
				<td class="form_input"><input type="text" name="values" id="values" value="" /></td>
			</tr>
			<tr style="display: auto;">
				<td class="form_label"><label for="default_value">Default value:</label></td>
				<td class="form_input"><input type="text" name="default_value" id="default_value" value="" /></td>
			</tr>
			<tr style="display: auto;" id="size_row">
				<td class="form_label"><label for="size">Size, in characters:</label></td>
				<td class="form_input"><input type="text" name="size" id="size" value="" /></td>
			</tr>
			<tr style="display: auto;">
				<td class="form_label">Apply field to:</td>
				<td class="form_input">
					<select name="add_to[]" id="add_to[]" multiple="multiple" size="10">
					</select>
				</td>
			</tr>
		</table>
	</form>
	<p>There we go.  Now, we select what type of field we want.  Since "text" is already selected here, there\'s no need to change the data type.</p>
	<p>The "default value" defines what will appear in a field by default when you add an item.  For this, maybe we want to remember what format in which to enter the date, so we set the default as YYYY/MM/DD:</p>
		   <form method="post" action="#">
		<table>
			<tr style="display: auto;">
				<td class="form_label"><label for="name">Name:</label></td>
				<td class="form_input"><input type="text" name="name" id="name" value="Purchase Date" /></td>
			</tr>
			<tr>
				<td class="form_label"><label for="name">Data type:</label></td>
				<td class="form_input">
					<select name="input_type" id="input_type"">
						<option onclick="document.getElementById(\'values_row\').style.display = \'none\';document.getElementById(\'size_row\').style.display = \'\';" value="text"';if($field->input_type == 'text') $output .= ' selected="selected"';$output.='>Text</option>
						<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="select"';if($field->input_type == 'select') $output .= ' selected="selected"';$output.='>Select Box</option>
						<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="multiple"';if($field->input_type == 'multiple') $output .= ' selected="selected"';$output.='>Multiple (Select + Text)</option>
						<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="checkbox"';if($field->input_type == 'checkbox') $output .= ' selected="selected"';$output.='>Checkboxes</option>
						<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="radio"';if($field->input_type == 'radio') $output .= ' selected="selected"';$output.='>Radio Buttons</option>
					</select>
				</td>
			</tr>
			<tr id="values_row" style="display: none;">
				<td class="form_label"><label for="values">Values:</label></td>
				<td class="form_input"><input type="text" name="values" id="values" value="" /></td>
			</tr>
			<tr style="display: auto;">
				<td class="form_label"><label for="default_value">Default value:</label></td>
				<td class="form_input"><input type="text" name="default_value" id="default_value" value="YYYY/MM/DD" /></td>
			</tr>
			<tr style="display: auto;" id="size_row">
				<td class="form_label"><label for="size">Size, in characters:</label></td>
				<td class="form_input"><input type="text" name="size" id="size" value="" /></td>
			</tr>
			<tr style="display: auto;">
				<td class="form_label">Apply field to:</td>
				<td class="form_input">
					<select name="add_to[]" id="add_to[]" multiple="multiple" size="10">
					</select>
				</td>
			</tr>
		</table>
	</form>
	<p>Next is the size of the field.  This limits how many characters can be entered in the field.  Since we already know the format of our date, we can set this to 10, exactly enough to hold our format of date.</p>
	<p><em>Note: if this is set to 65 or more, you will be given a text box rather than a text field to enter your data.  The text box, shown below, simply makes more data visible as your enter it.</em></p>
	<form style="padding-left: 50px; margin: 10px;">
		<textarea rows="4" cols="60">This is a text box.  Feel free to type in it.</textarea>
	</form>
	<br />
   <form method="post" action="#">
		<table>
			<tr style="display: auto;">
				<td class="form_label"><label for="name">Name:</label></td>
				<td class="form_input"><input type="text" name="name" id="name" value="Purchase Date" /></td>
			</tr>
			<tr>
				<td class="form_label"><label for="name">Data type:</label></td>
				<td class="form_input">
					<select name="input_type" id="input_type"">
						<option onclick="document.getElementById(\'values_row\').style.display = \'none\';document.getElementById(\'size_row\').style.display = \'\';" value="text"';if($field->input_type == 'text') $output .= ' selected="selected"';$output.='>Text</option>
						<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="select"';if($field->input_type == 'select') $output .= ' selected="selected"';$output.='>Select Box</option>
						<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="multiple"';if($field->input_type == 'multiple') $output .= ' selected="selected"';$output.='>Multiple (Select + Text)</option>
						<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="checkbox"';if($field->input_type == 'checkbox') $output .= ' selected="selected"';$output.='>Checkboxes</option>
						<option onclick="document.getElementById(\'values_row\').style.display = \'\';document.getElementById(\'size_row\').style.display = \'none\';" value="radio"';if($field->input_type == 'radio') $output .= ' selected="selected"';$output.='>Radio Buttons</option>
					</select>
				</td>
			</tr>
			<tr id="values_row" style="display: none;">
				<td class="form_label"><label for="values">Values:</label></td>
				<td class="form_input"><input type="text" name="values" id="values" value="" /></td>
			</tr>
			<tr style="display: auto;">
				<td class="form_label"><label for="default_value">Default value:</label></td>
				<td class="form_input"><input type="text" name="default_value" id="default_value" value="YYYY/MM/DD" /></td>
			</tr>
			<tr style="display: auto;" id="size_row">
				<td class="form_label"><label for="size">Size, in characters:</label></td>
				<td class="form_input"><input type="text" name="size" id="size" value="10" /></td>
			</tr>
			<tr style="display: auto;">
				<td class="form_label">Apply field to:</td>
				<td class="form_input">
					<select name="add_to[]" id="add_to[]" multiple="multiple" size="10">
					</select>
				</td>
			</tr>
		</table>
	</form>
	<p>The last field, "Apply to," deals with applying this field to a set of categories.  We don\'t need to worry about this, since we have not added any categories yet.  If we had already added some categories, we could select which categories we wanted to contain this field.  Adding fields to categories is described lated in <a href="adding_categories.php">adding categories</a>.</p>
	<p>Adding the total price and item purchased fields will work the same way, but let\'s take a look at one of the other fields to see how adding an enumerated field works, "enumerated" meaning that you can specify a set of values for the field.</p>
	
	<p>Let\'s add the "place of purchase" field now, which is of type "multiple."  (We set it as multiple instead of select in order 
	to allow us to type in a place if it doesn\'t appear in the list.)</p>
	<p>First, we enter in the field name and choose the field type:</p>
   <form method="post" action="#">
		<table>
			<tr style="display: auto;">
				<td class="form_label"><label for="name">Name:</label></td>
				<td class="form_input"><input type="text" name="name" id="name" value="Place of Purchase" /></td>
			</tr>
			<tr>
				<td class="form_label"><label for="name">Data type:</label></td>
				<td class="form_input">
					<select name="input_type" id="input_type"">
						<option onclick="document.getElementById(\'values_row_x\').style.display = \'none\';document.getElementById(\'size_row_x\').style.display = \'\';" value="text"';if($field->input_type == 'text') $output .= ' selected="selected"';$output.='>Text</option>
						<option onclick="document.getElementById(\'values_row_x\').style.display = \'\';document.getElementById(\'size_row_x\').style.display = \'none\';" value="select"';if($field->input_type == 'select') $output .= ' selected="selected"';$output.='>Select Box</option>
						<option selected="selected" onclick="document.getElementById(\'values_row_x\').style.display = \'\';document.getElementById(\'size_row_x\').style.display = \'none\';" value="multiple"';if($field->input_type == 'multiple') $output .= ' selected="selected"';$output.='>Multiple (Select + Text)</option>
						<option onclick="document.getElementById(\'values_row_x\').style.display = \'\';document.getElementById(\'size_row_x\').style.display = \'none\';" value="checkbox"';if($field->input_type == 'checkbox') $output .= ' selected="selected"';$output.='>Checkboxes</option>
						<option onclick="document.getElementById(\'values_row_x\').style.display = \'\';document.getElementById(\'size_row_x\').style.display = \'none\';" value="radio"';if($field->input_type == 'radio') $output .= ' selected="selected"';$output.='>Radio Buttons</option>
					</select>
				</td>
			</tr>
			<tr id="values_row_x" style="display: auto;">
				<td class="form_label"><label for="values">Values:</label></td>
				<td class="form_input"><input type="text" name="values" id="values" value="" /></td>
			</tr>
			<tr style="display: auto;">
				<td class="form_label"><label for="default_value">Default value:</label></td>
				<td class="form_input"><input type="text" name="default_value" id="default_value" value="" /></td>
			</tr>
			<tr style="display: none;" id="size_row_x">
				<td class="form_label"><label for="size">Size, in characters:</label></td>
				<td class="form_input"><input type="text" name="size" id="size" value="" /></td>
			</tr>
			<tr style="display: auto;">
				<td class="form_label">Apply field to:</td>
				<td class="form_input">
					<select name="add_to[]" id="add_to[]" multiple="multiple" size="10">
					</select>
				</td>
			</tr>
		</table>
	</form>
	<p>As you can see, a new field has appeared (values) and one field has disappeared (size).  This is because the size field only applies to text fields, and the values field only applies to enumerated fields.  By changing the field type, you can see what fields need to be filled in.</p>
	<p>The next thing we need to do is to give this field some values. We do this by entering the stores we want to appear in the list, separated by commas. So, let\'s put in the five stores we shop at the most often, and we\'ll set the default to the store that we shop at the most.</p>
   <form method="post" action="#">
		<table>
			<tr style="display: auto;">
				<td class="form_label"><label for="name">Name:</label></td>
				<td class="form_input"><input type="text" name="name" id="name" value="Place of Purchase" /></td>
			</tr>
			<tr>
				<td class="form_label"><label for="name">Data type:</label></td>
				<td class="form_input">
					<select name="input_type" id="input_type"">
						<option onclick="document.getElementById(\'values_row_y\').style.display = \'none\';document.getElementById(\'size_row_y\').style.display = \'\';" value="text"';if($field->input_type == 'text') $output .= ' selected="selected"';$output.='>Text</option>
						<option onclick="document.getElementById(\'values_row_y\').style.display = \'\';document.getElementById(\'size_row_y\').style.display = \'none\';" value="select"';if($field->input_type == 'select') $output .= ' selected="selected"';$output.='>Select Box</option>
						<option selected="selected" onclick="document.getElementById(\'values_row_y\').style.display = \'\';document.getElementById(\'size_row_y\').style.display = \'none\';" value="multiple"';if($field->input_type == 'multiple') $output .= ' selected="selected"';$output.='>Multiple (Select + Text)</option>
						<option onclick="document.getElementById(\'values_row_y\').style.display = \'\';document.getElementById(\'size_row_y\').style.display = \'none\';" value="checkbox"';if($field->input_type == 'checkbox') $output .= ' selected="selected"';$output.='>Checkboxes</option>
						<option onclick="document.getElementById(\'values_row_y\').style.display = \'\';document.getElementById(\'size_row_y\').style.display = \'none\';" value="radio"';if($field->input_type == 'radio') $output .= ' selected="selected"';$output.='>Radio Buttons</option>
					</select>
				</td>
			</tr>
			<tr id="values_row_y" style="display: auto;">
				<td class="form_label"><label for="values">Values:</label></td>
				<td class="form_input"><input type="text" name="values" id="values" value="Staples, Office Max, Office Depot, Radio Shack, Sam Goody" /></td>
			</tr>
			<tr style="display: auto;">
				<td class="form_label"><label for="default_value">Default value:</label></td>
				<td class="form_input"><input type="text" name="default_value" id="default_value" value="Office Max" /></td>
			</tr>
			<tr style="display: none;" id="size_row_y">
				<td class="form_label"><label for="size">Size, in characters:</label></td>
				<td class="form_input"><input type="text" name="size" id="size" value="" /></td>
			</tr>
			<tr style="display: auto;">
				<td class="form_label">Apply field to:</td>
				<td class="form_input">
					<select name="add_to[]" id="add_to[]" multiple="multiple" size="10">
					</select>
				</td>
			</tr>
		</table>
	</form>
	<p>Once again, since we have not added any categories yet, we can ignore the "Apply to" field.<p>
	<p>This field, when it is shown on an item addition page, will look like this:</p>
	<form style="padding-left: 50px; margin: 10px;">
		<input type="text" value="Office Max" id="country"/>
		<select name="values">
			<option onclick="document.getElementById(\'country\').value = \'Staples\';">Staples</option>
			<option onclick="document.getElementById(\'country\').value = \'Office Max\';">Office Max</option>
			<option onclick="document.getElementById(\'country\').value = \'Office Depot\';">Office Depot</option>
			<option onclick="document.getElementById(\'country\').value = \'Radio Shack\';">Radio Shack</option>
			<option onclick="document.getElementById(\'country\').value = \'Sam Goody\';">Sam Goody</option>
		</select>
	</form>
	<p>Adding a radio button, checkbox, or select field works in the same way.</p>
	<div style="float: left;"><a href="fields.php#types">&lt;&lt; Previous: Field Types</a></div>
	<div style="text-align: right;"><a href="editing_fields.php">Next: Editing Fields &gt;&gt;</a></div>';

display($output);

?>