<?php

include("globals.php");

if ($admin_user->can_admin_field($_REQUEST["id"])){
	header("Location: ../error_handler.php?eid=13");
	exit;
}

$title = "anyInventory: Delete Field";
$breadcrumbs = 'Administration > <a href="fields.php">Fields</a> > Delete Field';

$field = new field($_REQUEST["id"]);

$output .= '
	<form method="post" action="field_processor.php">
		<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
		<input type="hidden" name="action" value="do_delete" />
		<table class="standardTable" cellspacing="0">
			<tr class="tableHeader">
				<td>Delete a Field</td>
				<td style="text-align: right;">[<a href="../docs/deleting_fields.php">Help</a>]</td>
			</tr>
			<tr>
				<td class="tableData" colspan="2">
					<p>Are you sure you want to delete this field?</p>
				</td>
			</tr>
			<tr class="tableHeader">
				<td colspan="2">'.$field->name.'</td>
			</tr>
			<tr>
				<td class="tableData" colspan="2">
					<table>
						<tr>
							<td class="form_label">Input type:</td>
							<td>'.$field->input_type.'</td>
						</tr>';

if (($field->input_type != "text") && ($field->input_type != 'file')){
	$output .= '<tr>
					<td class="form_label">Values:</td>
					<td>';
	
	if(is_array($field->values)){
		foreach($field->values as $value){
			$output .= $value.', ';
		}
		$output = substr($output, 0, strlen($output) - 2);
	}
	else{
		$output .= 'None';
	}
	
	$output .= '</td></tr>';
}

if (($field->input_type == "text") || ($field->input_type == "multiple")){
	$output .= '<tr><td class="form_label">Size:</td><td>'.$field->size.'</td></tr>';
}

if ($field->input_type != 'file'){
	$output .= '<tr><td class="form_label">Default value:</td><td>'.$field->default_value.'</td></tr>';
}

$output .= '
						<tr>
							<td class="form_label">&nbsp;</td>
							<td><b>This field is used in '.count($field->categories).' categories.</b></td>
						</tr>
						<tr>
							<td class="submitButtonRow" colspan="2"><input type="submit" name="delete" value="Delete" /> <input type="submit" name="cancel" value="Cancel" /></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>';

display($output);

?>