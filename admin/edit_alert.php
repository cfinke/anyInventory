<?php

include("globals.php");

$title = "anyInventory: Edit Alert";

$alert = new alert($_REQUEST["id"]);

$item = new item($alert->item_ids[0]);

$output = '
		<form method="post" action="alert_processor.php" enctype="multipart/form-data">
		<table style="width: 100%;"><tr><td><h2>Edit an Alert</h2></td><td style="text-align: right;"><a href="../docs/editing_alerts.php">Help with editing alerts</a></td></tr></table>
			<input type="hidden" name="action" value="do_edit" />
			<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
			<table>
				<tr>
					<td class="form_label"><label for="name">Alert Title:</label></td>
					<td class="form_input"><input type="text" name="title" id="title" value="'.$alert->title.'" maxlength="255" />
				</tr>
				<tr>
					<td class="form_label"><label for="c">Applies to:</label></td>
					<td class="form_input">
						<select name="i[]" id="i[]" multiple="multiple">
							'.get_item_options($item->category->id, $alert->item_ids).'
						</select>
					</td>
				</tr>
				<tr>
					<td class="form_label"><label for="field">Field:</label></td>
					<td class="form_input">
						<select name="field" id="field">';

foreach($item->category->field_ids as $field_id){
	$field = new field($field_id);
	
	$output .= '<option value="'.$field_id.'"';
	if ($alert->field_id == $field_id) $output .= ' selected="selected"';
	$output .= '> '.$field->name.'</option>';
}

$output .= '			</select>
					</td>
				</tr>
				<tr>
					<td class="form_label"><label for="condition">Condition:</label></td>
					<td class="form_input">
						<select name="condition" id="condition">
							<option value="=="';if ($alert->condition == '==') $output .= ' selected="selected"'; $output .= '>Equal to</option>
							<option value="!="';if ($alert->condition == '!=') $output .= ' selected="selected"'; $output .= '>Not equal to</option>
							<option value="<"';if ($alert->condition == '<') $output .= ' selected="selected"'; $output .= '>Less than</option>
							<option value=">"';if ($alert->condition == '>') $output .= ' selected="selected"'; $output .= '>Greater than</option>
							<option value="<="';if ($alert->condition == '<=') $output .= ' selected="selected"'; $output .= '>Less than or equal to</option>
							<option value=">="';if ($alert->condition == '>=') $output .= ' selected="selected"'; $output .= '>Greater than or equal to</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="form_label"><label for="value">Value:</label></td>
					<td class="form_input"><input type="text" name="value" id="value" value="'.$alert->value.'" /></td>
				</tr>
				<tr>
					<td class="form_label"><label for="month">Effective as of:</label></td>
					<td class="form_input">
						<select name="month" id="month">
							<option value="1"';if(substr($alert->time,4,2) == 01) $output .= ' selected="selected"'; $output .= '>January</option>
							<option value="2"';if(substr($alert->time,4,2) == 02) $output .= ' selected="selected"'; $output .= '>February</option>
							<option value="3"';if(substr($alert->time,4,2) == 03) $output .= ' selected="selected"'; $output .= '>March</option>
							<option value="4"';if(substr($alert->time,4,2) == 04) $output .= ' selected="selected"'; $output .= '>April</option>
							<option value="5"';if(substr($alert->time,4,2) == 05) $output .= ' selected="selected"'; $output .= '>May</option>
							<option value="6"';if(substr($alert->time,4,2) == 06) $output .= ' selected="selected"'; $output .= '>June</option>
							<option value="7"';if(substr($alert->time,4,2) == 07) $output .= ' selected="selected"'; $output .= '>July</option>
							<option value="8"';if(substr($alert->time,4,2) == 08) $output .= ' selected="selected"'; $output .= '>August</option>
							<option value="9"';if(substr($alert->time,4,2) == 09) $output .= ' selected="selected"'; $output .= '>September</option>
							<option value="10"';if(substr($alert->time,4,2) == 10) $output .= ' selected="selected"'; $output .= '>October</option>
							<option value="11"';if(substr($alert->time,4,2) == 11) $output .= ' selected="selected"'; $output .= '>November</option>
							<option value="12"';if(substr($alert->time,4,2) == 12) $output .= ' selected="selected"'; $output .= '>December</option>
						</select>
						<select name="day" id="day">';

for ($i = 1; $i <= 31; $i++){
	$output .= '<option value="'.$i.'"';if((substr($alert->time,6,2) / 1) == $i) $output .= ' selected="selected"'; $output .= '>'.$i.'</option>';
}


$output .= '			</select>,
						<select name="year" id="year">';

$year = date("Y");

for ($i = 0; $i < 20; $i++){
	$output .= '<option value="'.($i + $year).'"';if(substr($alert->time,0,4) == ($i + $year)) $output .= ' selected="selected"'; $output .= '>'.($i + $year).'</option>';
}


$output .= '			</select>
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