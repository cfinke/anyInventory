<?php

include("globals.php");

$title = "anyInventory: Add Field";

$output = '
		<script type="text/javascript">
			<!--
			
			function show_hide(selObj){
				if(selObj.options[selObj.selectedIndex].value == "text"){
					document.getElementById(\'values_row\').style.display = \'none\';
					document.getElementById(\'size_row\').style.display = \'\';
				}
				else {
					document.getElementById(\'values_row\').style.display = \'\';
					document.getElementById(\'size_row\').style.display = \'none\';
				}
				
				return true;
			}
			
			// -->
		</script>
		<form method="post" action="field_processor.php">
			<table style="width: 100%;"><tr><td><h2>Add a Field</h2></td><td style="text-align: right;"><a href="../docs/adding_fields.php">Help with adding fields</a></td></tr></table>
			<input type="hidden" name="action" value="do_add" />
			<table>
				<tr style="display: auto;">
					<td class="form_label"><label for="name">Name:</label></td>
					<td class="form_input"><input type="text" name="name" id="name" value="" /></td>
				</tr>
				<tr>
					<td class="form_label"><label for="name">Data type:</label></td>
					<td class="form_input">
						<select name="input_type" id="input_type" onchange="show_hide(this);">
							<option value="text">Text</option>
							<option value="select">Select Box</option>
							<option value="multiple">Multiple (Select + Text)</option>
							<option value="checkbox">Checkboxes</option>
							<option value="radio">Radio Buttons</option>
						</select>
					</td>
				</tr>
				<tr id="values_row" style="display: auto;">
					<td class="form_label"><label for="values">Values:</label></td>
					<td class="form_input"><input type="text" name="values" id="values" value="" /><br /><small>Only for data types \'Multiple\',\'Select Box\',\'Checkboxes\', and \'Radio Buttons\'.  Separate with commas.</small></td>
				</tr>
				<tr style="display: auto;">
					<td class="form_label"><label for="default_value">Default value:</label></td>
					<td class="form_input"><input type="text" name="default_value" id="default_value" value="" /></td>
				</tr>
				<tr style="display: auto;" id="size_row">
					<td class="form_label"><label for="size">Size, in characters:</label></td>
					<td class="form_input"><input type="text" name="size" id="size" value="" /><br /><small>Only for \'text\' data type.</small></td>
				</tr>
				<tr style="display: auto;">
					<td class="form_label">Apply field to:</td>
					<td class="form_input">
						<select name="add_to[]" id="add_to[]" multiple="multiple" size="10">
							'.get_category_options().'
						</select>
					</td>
				</tr>
				<tr style="display: auto;">
					<td class="form_label">&nbsp;</td>
					<td class="form_input"><input type="submit" name="submit" id="submit" value="Submit" /></td>
				</tr>
			</table>
			</form>
			<script type="text/javascript">
				<!--
					document.getElementById(\'values_row\').style.display = \'none\';
				// -->
			</script>';

display($output);

?>