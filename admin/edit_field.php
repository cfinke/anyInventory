<?php

include("globals.php");

if (!$admin_user->can_admin_field($_GET["id"])){
	header("Location: ../error_handler.php?eid=13");
	exit;
}

$title = "anyInventory: Edit Field";
$inHead = '
	<script type="text/javascript">
		<!--
		
		function toggle(){
			if ((document.getElementById(\'input_type\').options[document.getElementById(\'input_type\').selectedIndex].value == \'file\') || (document.getElementById(\'input_type\').options[document.getElementById(\'input_type\').selectedIndex].value == \'item\')){
				document.getElementById(\'values\').disabled = true;
				document.getElementById(\'default_value\').disabled = true;
				document.getElementById(\'size\').disabled = true;
			}
			else{
				document.getElementById(\'values\').disabled = (document.getElementById(\'input_type\').options[document.getElementById(\'input_type\').selectedIndex].value == "text");
				document.getElementById(\'size\').disabled = !(document.getElementById(\'input_type\').options[document.getElementById(\'input_type\').selectedIndex].value == "text");
				document.getElementById(\'default_value\').disabled = (document.getElementById(\'input_type\').options[document.getElementById(\'input_type\').selectedIndex].value == "checkbox");
			}
		}
		
		// -->
	</script>';
$inBodyTag = ' onload="toggle();"';
$breadcrumbs = 'Administration > <a href="fields.php">Fields</a> > Edit Field';

$field = new field($_GET["id"]);
$checked = ($field->highlight) ? ' checked="checked"' : '';

$output = '
		<form method="post" action="field_processor.php">
			<input type="hidden" name="action" value="do_edit" />
			<input type="hidden" name="id" value="'.$_GET["id"].'" />
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Edit a Field</td>
					<td style="text-align: right;">[<a href="../docs/editing_fields.php">Help</a>]</td>
				</tr>
				<tr>
					<td class="tableData" colspan="2">
						<table>
							<tr>
								<td class="form_label"><label for="name">Name:</label></td>
								<td class="form_input"><input type="text" name="name" id="name" value="'.str_replace('"','\"',$field->name).'" maxlength="64" /></td>
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
										<option value="item"';if($field->input_type == 'item') $output .= ' selected="selected"';$output.='>Item(s)</option>
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
								<td class="form_input"><input type="text" name="default_value" id="default_value" value="'.$field->default_value.'" /><br /><small>Only for data types \'Multiple\',\'Select Box\',\'Text\', and \'Radio Buttons\'.</small></td>
							</tr>
							<tr>
								<td class="form_label"><label for="size">Size, in characters:</label></td>
								<td class="form_input"><input type="text" name="size" id="size" value="'.$field->size.'" /><br /><small>Only for \'text\' data type.</small></td>
							</tr>
							<tr>
								<td class="form_label"><input type="checkbox" name="highlight" id="highlight" value="yes" '.$checked.' /></td>
								<td class="form_input"><label for="highlight">Highlight this field</label></td>
							</tr>
							<tr>
								<td class="form_label">Apply field to:</td>
								<td class="form_input">
									<select name="add_to[]" id="add_to[]" multiple="multiple" size="10" style="width: 100%;">
										'.$admin_user->get_admin_categories_options($field->categories).'
									</select>
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