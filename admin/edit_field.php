<?php

include("globals.php");

if (!$admin_user->can_admin_field($_GET["id"])){
	header("Location: ../error_handler.php?eid=13");
	exit;
}

$title = EDIT_FIELD;
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
$breadcrumbs = ADMINISTRATION.' > <a href="fields.php">'.FIELDS.'</a> > '.EDIT_FIELD;

$field = new field($_GET["id"]);
$checked = ($field->highlight) ? ' checked="checked"' : '';

$output = '
		<form method="post" action="field_processor.php">
			<input type="hidden" name="action" value="do_edit" />
			<input type="hidden" name="id" value="'.$_GET["id"].'" />
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>'.EDIT_FIELD.'</td>
					<td style="text-align: right;">[<a href="../docs/'.LANG.'/editing_fields.php">'.HELP.'</a>]</td>
				</tr>
				<tr>
					<td class="tableData" colspan="2">
						<table>
							<tr>
								<td class="form_label"><label for="name">'.NAME.':</label></td>
								<td class="form_input"><input type="text" name="name" id="name" value="'.htmlspecialchars($field->name, ENT_QUOTES).'" maxlength="64" /></td>
							</tr>
							<tr>
								<td class="form_label"><label for="name">'.DATA_TYPE.':</label></td>
								<td class="form_input">
									<select name="input_type" id="input_type" onchange="toggle();">
										<option value="text"';if($field->input_type == 'text') $output .= ' selected="selected"';$output.='>'.TEXT.'</option>
										<option value="select"';if($field->input_type == 'select') $output .= ' selected="selected"';$output.='>'.SELECT_BOX.'</option>
										<option value="multiple"';if($field->input_type == 'multiple') $output .= ' selected="selected"';$output.='>'.MULTIPLE.'</option>
										<option value="checkbox"';if($field->input_type == 'checkbox') $output .= ' selected="selected"';$output.='>'.CHECKBOX.'</option>
										<option value="radio"';if($field->input_type == 'radio') $output .= ' selected="selected"';$output.='>'.RADIO.'</option>
										<option value="item"';if($field->input_type == 'item') $output .= ' selected="selected"';$output.='>'.ITEMS.'</option>
										<option value="file"';if($field->input_type == 'file') $output .= ' selected="selected"';$output.='>'.FILE.'</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="form_label"><label for="values">'.VALUES.':</label></td>
								<td class="form_input"><input type="text" name="values" id="values" value="';
								if (is_array($field->values)){
									foreach($field->values as $value){
										$output .= htmlspecialchars($value, ENT_QUOTES).', ';
									}
									$output = substr($output,0,strlen($output) - 2);
								}
							$output .= '" /><br /><small>'.VALUES_INFO.'</small></td>
							</tr>
							<tr>
								<td class="form_label"><label for="default_value">'.DEFAULT_VALUE.':</label></td>
								<td class="form_input"><input type="text" name="default_value" id="default_value" value="'.htmlspecialchars($field->default_value, ENT_QUOTES).'" /><br /><small>'.DEFAULT_VALUE_INFO.'</small></td>
							</tr>
							<tr>
								<td class="form_label"><label for="size">'.SIZE.':</label></td>
								<td class="form_input"><input type="text" name="size" id="size" value="'.$field->size.'" /><br /><small>'.SIZE_INFO.'</small></td>
							</tr>
							<tr>
								<td class="form_label"><input type="checkbox" name="highlight" id="highlight" value="yes" '.$checked.' /></td>
								<td class="form_input"><label for="highlight">'.HIGHLIGHT_FIELD.'</label></td>
							</tr>
							<tr>
								<td class="form_label">'.APPLIES_TO.':</td>
								<td class="form_input">
									<select name="add_to[]" id="add_to[]" multiple="multiple" size="10" style="width: 100%;">
										'.$admin_user->get_admin_categories_options($field->categories).'
									</select>
								</td>
							</tr>
							<tr>
								<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="'.SUBMIT.'" /> <input type="submit" name="cancel" value="'.CANCEL.'" /></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>';

display($output);

?>