<?php

include("globals.php");

$title = "anyInventory: Edit Field";
$inHead = '
	<script type="text/javascript">
		<!--
		
		function toggle(){
			if (document.getElementById(\'input_type\').options[document.getElementById(\'input_type\').selectedIndex].value == \'file\'){
				document.getElementById(\'values\').disabled = true;
				document.getElementById(\'default_value\').disabled = true;
				document.getElementById(\'size\').disabled = true;
			}
			else{
				document.getElementById(\'values\').disabled = (document.getElementById(\'input_type\').options[document.getElementById(\'input_type\').selectedIndex].value == "text");
				document.getElementById(\'size\').disabled = !(document.getElementById(\'input_type\').options[document.getElementById(\'input_type\').selectedIndex].value == "text");
				document.getElementById(\'default_value\').disabled = false;	
			}
		}
		
		// -->
	</script>';
$inBodyTag = ' onload="toggle();"';

$field = new field($_REQUEST["id"]);

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
			<table style="width: 100%;"><tr><td><h2>Edit a Field</h2></td><td style="text-align: right;"><a href="../docs/editing_fields.php">Help with editing fields</a></td></tr></table>
			<input type="hidden" name="action" value="do_edit" />
			<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
			<table>
				<tr>
					<td class="form_label"><label for="name">Name:</label></td>
					<td class="form_input"><input type="text" name="name" id="name" value="'.$field->name.'" /></td>
				</tr>
				<tr>
					<td class="form_label"><label for="name">Data type:</label></td>
					<td class="form_input">
						<select name="input_type" id="input_type" onchange="toggle();">
							<option value="text"';if($field->input_type == 'text') $output .= ' selected="selected"';$output.='>Text</option>
							<option value="select"';if($field->input_type == 'select') $output .= ' selected="selected"';$output.='>Select Box</option>
							<option value="multiple"';if($field->input_type == 'multiple') $output .= ' selected="selected"';$output.='>Multiple (Select + Text)</option>
							<option value="checkbox"';if($field->input_type == 'checkbox') $output .= ' selected="selected"';$output.='>Checkboxes</option>
							<option value="radio"';if($field->input_type == 'radio') $output .= ' selected="selected"';$output.='>Radio Buttons</option>
							<option value="file"';if($field->input_type == 'file') $output .= ' selected="selected"';$output.='>File</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="form_label"><label for="values">Values:</label></td>
					<td class="form_input"><input type="text" name="values" id="values" value="';
					if (is_array($field->values)){
						foreach($field->values as $value){
							$output .= $value.', ';
						}
						$output = substr($output,0,strlen($output) - 2);
					}
				$output .= '" /><br /><small>Only for data types \'Multiple\',\'Select Box\',\'Checkboxes\', and \'Radio Buttons\'.  Separate with commas.</small></td>
				</tr>
				<tr>
					<td class="form_label"><label for="default_value">Default value:</label></td>
					<td class="form_input"><input type="text" name="default_value" id="default_value" value="'.$field->default_value.'" /></td>
				</tr>
				<tr>
					<td class="form_label"><label for="size">Size, in characters:</label></td>
					<td class="form_input"><input type="text" name="size" id="size" value="'.$field->size.'" /><br /><small>Only for \'text\' data type.</small></td>
				</tr>
				<tr>
					<td class="form_label">Apply field to:</td>
					<td class="form_input">
						<select name="add_to[]" id="add_to[]" multiple="multiple" size="10">
							'.get_category_options($field->categories).'
						</select>
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