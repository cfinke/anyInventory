<?php

include("globals.php");

$title = "anyInventory: Add Field";
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
$breadcrumbs = 'Administration > <a href="fields.php">Fields</a> > Add Field';

$output .= '
	<table class="standardTable" cellspacing="0" cellpadding="3">
		<tr class="tableHeader">
			<td>Add Field</td>
			</td>
			<td style="text-align: right;">
				[<a href="../docs/adding_fields.php">Help</a>]
			</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				<form method="post" action="field_processor.php">
					<input type="hidden" name="action" value="do_add" />
					<table>
						<tr>
							<td class="form_label"><label for="name">Name:</label></td>
							<td class="form_input"><input type="text" name="name" id="name" value="" /></td>
						</tr>
						<tr>
							<td class="form_label"><label for="name">Data type:</label></td>
							<td class="form_input">
								<select name="input_type" id="input_type" onchange="toggle();">
									<option value="text">Text</option>
									<option value="select">Select Box</option>
									<option value="multiple">Multiple (Select + Text)</option>
									<option value="checkbox">Checkboxes</option>
									<option value="radio">Radio Buttons</option>
									<option value="file">File</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="form_label"><label for="values">Values:</label></td>
							<td class="form_input"><input type="text" name="values" id="values" value="" /><br /><small>Only for data types \'Multiple\',\'Select Box\',\'Checkboxes\', and \'Radio Buttons\'.  Separate with commas.</small></td>
						</tr>
						<tr>
							<td class="form_label"><label for="default_value">Default value:</label></td>
							<td class="form_input"><input type="text" name="default_value" id="default_value" value="" /></td>
						</tr>
						<tr>
							<td class="form_label"><label for="size">Size, in characters:</label></td>
							<td class="form_input"><input type="text" name="size" id="size" value="" /><br /><small>Only for \'text\' data type.</small></td>
						</tr>
						<tr>
							<td class="form_label">Apply field to:</td>
							<td class="form_input">
								<select name="add_to[]" id="add_to[]" multiple="multiple" size="10" style="width: 100%;">
									'.get_category_options().'
								</select>
							</td>
						</tr>
						<tr>
							<td class="form_label">&nbsp;</td>
							<td class="form_input" style="text-align: center;"><input type="submit" name="submit" id="submit" value="Submit" class="submitButton" /></td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
	</table>';

display($output);

?>