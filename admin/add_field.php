<?php

include("globals.php");

$title = ADD_FIELD;
$inHead = '
	<script type="text/javascript">
		<!--
		
		function toggle(){
			if ((document.getElementById(\'input_type\').options[document.getElementById(\'input_type\').selectedIndex].value == \'file\') || (document.getElementById(\'input_type\').options[document.getElementById(\'input_type\').selectedIndex].value == \'item\')){
				document.getElementById(\'field_values\').disabled = true;
				document.getElementById(\'default_value\').disabled = true;
				document.getElementById(\'size\').disabled = true;
			}
			else{
				document.getElementById(\'field_values\').disabled = (document.getElementById(\'input_type\').options[document.getElementById(\'input_type\').selectedIndex].value == "text");
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
				[<a href="../docs/'.LANG.'/adding_fields.php">'.HELP.'</a>]
			</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				<form method="post" action="field_processor.php">
					<input type="hidden" name="action" value="do_add" />
					<table>
						'.display_field_form($admin_user->get_admin_categories_options(null)).'
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