<?php

include("globals.php");

$field = new field($_REQUEST["id"]);

$output = '
		<form method="post" action="field_processor.php">
			<h2>Edit a Field</h2>
			<input type="hidden" name="action" value="do_edit" />
			<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
			<table>
				<tr style="display: auto;">
					<td class="form_label"><label for="name">Name:</label></td>
					<td class="form_input"><input type="text" name="name" id="name" value="'.$field->name.'" /></td>
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
					<td class="form_label"><label for="values">Values:</label><br /><small>Only for data types \'Multiple\',\'Select Box\',\'Checkboxes\', and \'Radio Buttons\'.  Separate with commas.</small></td>
					<td class="form_input"><input type="text" name="values" id="values" value="';
					if (is_array($field->values)){
						foreach($field->values as $value){
							$output .= $value.', ';
						}
						$output = substr($output,0,strlen($output) - 2);
					}
				$output .= '" /></td>
				</tr>
				<tr style="display: auto;">
					<td class="form_label"><label for="default_value">Default value:</label></td>
					<td class="form_input"><input type="text" name="default_value" id="default_value" value="'.$field->default_value.'" /></td>
				</tr>
				<tr style="display: auto;" id="size_row">
					<td class="form_label"><label for="size">Size, in characters:</label><br /><small>Only for \'text\' data type.</small></td>
					<td class="form_input"><input type="text" name="size" id="size" value="'.$field->size.'" /></td>
				</tr>
				<tr style="display: auto;">
					<td class="form_label">Apply field to:</td>
					<td class="form_input">
						<select name="add_to[]" id="add_to[]" multiple="multiple" size="15">
							'.get_category_options($field->categories).'
						</select>
					</td>
				</tr>
				<tr style="display: auto;">
					<td class="form_label">&nbsp;</td>
					<td class="form_input"><input type="submit" name="submit" id="submit" value="Submit" /></td>
				</tr>
			</table>
		</form>';

display($output);

?>