<?php

include("globals.php");

$title = "anyInventory: Add Alert";

if (!isset($_REQUEST["c"])){
	$output = '
		<form method="get" action="add_alert.php">
			<table>
				<tr>
					<td class="form_label"><label for="c">Add alert in:</label></td>
					<td class="form_input">
						<select name="c" id="c">
							'.get_category_options(null, true).'
						</select>
					</td>
				</tr>
				<tr>
					<td class="form_label">&nbsp;</td>
					<td class="form_input"><input type="submit" name="submit" id="submit" value="Submit" /></td>
				</tr>
			</table>
		</form>';
}
else{
	$query = "SELECT `id` FROM `anyInventory_items` WHERE `item_category`='".$_REQUEST["c"]."'";
	$result = query($query);
	
	if (mysql_num_rows($result) == 0){
		header("Location: ../error_handler.php?eid=2");
		exit;
	}
	else{
		$item = new item(mysql_result($result, 0, 'id'));
	}
	
	$output = '
			<form method="post" action="alert_processor.php" enctype="multipart/form-data">
				<h2>Add an Alert</h2>
				<input type="hidden" name="action" value="do_add" />
				<table>
					<tr>
						<td class="form_label"><label for="name">Alert Title:</label></td>
						<td class="form_input"><input type="text" name="title" id="title" value="" maxlength="255" />
					</tr>
					<tr>
						<td class="form_label"><label for="c">Applies to:</label></td>
						<td class="form_input">
							<select name="i[]" id="i[]" multiple="multiple">
								'.get_item_options($_REQUEST["c"]).'
							</select>
						</td>
					</tr>
					<tr>
						<td class="form_label"><label for="field">Field:</label></td>
						<td class="form_input">
							<select name="field" id="field">';
	
	if (is_array($item->category->field_ids)){
		foreach($item->category->field_ids as $field_id){
			$field = new field($field_id);
			
			$output .= '<option value="'.$field_id.'"> '.$field->name.'</option>';
		}
	}
	
	$output .= '			</select>
						</td>
					</tr>
					<tr>
						<td class="form_label"><label for="condition">Condition:</label></td>
						<td class="form_input">
							<select name="condition" id="condition">
								<option value="==">Equal to</option>
								<option value="!=">Not equal to</option>
								<option value="<">Less than</option>
								<option value=">">Greater than</option>
								<option value="<=">Less than or equal to</option>
								<option value=">=">Greater than or equal to</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="form_label"><label for="value">Value:</label></td>
						<td class="form_input"><input type="text" name="value" id="value" value="" /></td>
					</tr>
					<tr>
						<td class="form_label"><label for="month">Effective as of:</label></td>
						<td class="form_input">
							<select name="month" id="month">
								<option value="1"';if(date("n") == 1) $output .= ' selected="selected"'; $output .= '>January</option>
								<option value="2"';if(date("n") == 2) $output .= ' selected="selected"'; $output .= '>February</option>
								<option value="3"';if(date("n") == 3) $output .= ' selected="selected"'; $output .= '>March</option>
								<option value="4"';if(date("n") == 4) $output .= ' selected="selected"'; $output .= '>April</option>
								<option value="5"';if(date("n") == 5) $output .= ' selected="selected"'; $output .= '>May</option>
								<option value="6"';if(date("n") == 6) $output .= ' selected="selected"'; $output .= '>June</option>
								<option value="7"';if(date("n") == 7) $output .= ' selected="selected"'; $output .= '>July</option>
								<option value="8"';if(date("n") == 8) $output .= ' selected="selected"'; $output .= '>August</option>
								<option value="9"';if(date("n") == 9) $output .= ' selected="selected"'; $output .= '>September</option>
								<option value="10"';if(date("n") == 10) $output .= ' selected="selected"'; $output .= '>October</option>
								<option value="11"';if(date("n") == 11) $output .= ' selected="selected"'; $output .= '>November</option>
								<option value="12"';if(date("n") == 12) $output .= ' selected="selected"'; $output .= '>December</option>
							</select>
							<select name="day" id="day">';
	
	for ($i = 1; $i <= 31; $i++){
		$output .= '<option value="'.$i.'"';if(date("j") == $i) $output .= ' selected="selected"'; $output .= '>'.$i.'</option>';
	}
	
	
	$output .= '			</select>,
							<select name="year" id="year">';
	
	$year = date("Y");
	
	for ($i = 0; $i < 20; $i++){
		$output .= '<option value="'.($i + $year).'">'.($i + $year).'</option>';
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
}

display($output);

?>