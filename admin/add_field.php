<?php

require_once("globals.php");

$title = ADD_FIELD;
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
$breadcrumbs = ADMINISTRATION.' > <a href="fields.php">'.FIELDS.'</a> > '.ADD_FIELD;

$output .= '
	<table class="standardTable" cellspacing="0" cellpadding="3">
		<tr class="tableHeader">
			<td>'.ADD_FIELD.'</td>
			</td>
			<td style="text-align: right;">
				[<a href="../docs/adding_fields.php">'.HELP.'</a>]
			</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				<form method="post" action="field_processor.php">
					<input type="hidden" name="action" value="do_add" />
					<table>
						<tr>
							<td class="form_label"><label for="name">'.NAME.':</label></td>
							<td class="form_input"><input type="text" name="name" id="name" value="" maxlength="64" /></td>
						</tr>
						<tr>
							<td class="form_label"><label for="name">'.DATA_TYPE.':</label></td>
							<td class="form_input">
								<select name="input_type" id="input_type" onchange="toggle();">
									<option value="text">'.TEXT.'</option>
									<option value="select">'.SELECT_BOX.'</option>
									<option value="multiple">'.MULTIPLE.'</option>
									<option value="checkbox">'.CHECKBOX.'</option>
									<option value="radio">'.RADIO.'</option>
									<option value="item">'.ITEMS.'</option>
									<option value="file">'.FILE.'</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="form_label"><label for="values">'.VALUES.':</label></td>
							<td class="form_input"><input type="text" name="values" id="values" value="" /><br /><small>'.VALUES_INFO.'</small></td>
						</tr>
						<tr>
							<td class="form_label"><label for="default_value">'.DEFAULT_VALUE.':</label></td>
							<td class="form_input"><input type="text" name="default_value" id="default_value" value="" /><br /><small>'.DEFAULT_VALUE_INFO.'</small></td>
						</tr>
						<tr>
							<td class="form_label"><label for="size">'.SIZE.':</label></td>
							<td class="form_input"><input type="text" name="size" id="size" value="" /><br /><small>'.SIZE_INFO.'</small></td>
						</tr>
						<tr>
							<td class="form_label"><input type="checkbox" name="highlight" id="highlight" value="yes" /></td>
							<td class="form_input"><label for="highlight">'.HIGHLIGHT_FIELD.'</label></td>
						</tr>
						<tr>
							<td class="form_label">'.APPLIES_TO.':</td>
							<td class="form_input">
								<select name="add_to[]" id="add_to[]" multiple="multiple" size="10" style="width: 100%;">
									'.$admin_user->get_admin_categories_options(null).'
								</select>
							</td>
						</tr>
						<tr>
							<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="'.SUBMIT.'" /></td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
	</table>';

display($output);

?>
