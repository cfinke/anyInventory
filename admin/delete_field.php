<?php

require_once("globals.php");

if (!$admin_user->can_admin_field($_GET["id"])){
	header("Location: ../error_handler.php?eid=13");
	exit;
}

$title = DELETE_FIELD;
$breadcrumbs = ADMINISTRATION.' > <a href="fields.php">'.FIELDS.'</a> > '.DELETE_FIELD;

$field = new field($_GET["id"]);

$output .= '
	<form method="post" action="field_processor.php">
		<input type="hidden" name="id" value="'.$_GET["id"].'" />
		<input type="hidden" name="action" value="do_delete" />
		<table class="standardTable" cellspacing="0">
			<tr class="tableHeader">
				<td>'.DELETE_FIELD.'</td>
				<td style="text-align: right;">[<a href="../docs/'.LANG.'/deleting_fields.php">'.HELP.'</a>]</td>
			</tr>
			<tr>
				<td class="tableData" colspan="2">
					<p>'.DELETE_FIELD_CONFIRM.'</p>
				</td>
			</tr>
			<tr class="tableHeader">
				<td colspan="2">'.$field->name.'</td>
			</tr>
			<tr>
				<td class="tableData" colspan="2">
					<table>
						<tr>
							<td class="form_label">'.DATA_TYPE.':</td>
							<td>'.$field->input_type.'</td>
						</tr>';

if (($field->input_type != "text") && ($field->input_type != 'file') && ($field->input_type != 'item')){
	$output .= '<tr>
					<td class="form_label">'.VALUES.':</td>
					<td>';
	
	if(is_array($field->field_values)){
		foreach($field->field_values as $value){
			$output .= $value.', ';
		}
		$output = substr($output, 0, strlen($output) - 2);
	}
	else{
		$output .= NONE;
	}
	
	$output .= '</td></tr>';
}

if (($field->input_type == "text") || ($field->input_type == "multiple")){
	$output .= '<tr><td class="form_label">'.SIZE.':</td><td>'.$field->size.'</td></tr>';
}

if (($field->input_type != 'file') && ($field->input_type != 'item')){
	$output .= '<tr><td class="form_label">'.DEFAULT_VALUE.':</td><td>'.$field->default_value.'</td></tr>';
}

$output .= '
						<tr>
							<td class="form_label">&nbsp;</td>
							<td><b>'.FIELD_CATS_PRE.' '.count($field->categories).' '.CATEGORIES.'.</b></td>
						</tr>
						<tr>
							<td class="submitButtonRow" colspan="2"><input type="submit" name="delete" value="'._DELETE.'" /> <input type="submit" name="cancel" value="'.CANCEL.'" /></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>';

display($output);

?>