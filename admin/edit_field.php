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
							'.display_field_form($admin_user->get_admin_categories_options(null),
												 $field->name,
												 $field->input_type,
												 $field->values,
												 $field->default_value,
												 $field->size,
												 $field->highlight).'
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