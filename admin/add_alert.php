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
							'.get_category_options().'
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
	$item = new item($_REQUEST["i"][0]);
	
	$output = '
			<form method="post" action="alert_processor.php" enctype="multipart/form-data">
				<h2>Add an Alert</h2>
				<input type="hidden" name="action" value="do_add" />
				<input type="hidden" name="i" value="'.htmlentities(serialize($_REQUEST["i"])).'" />
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
	
	foreach($item->category->field_ids as $field_id){
		$field = new field($field_id);
		
		$output .= '<option value="'.$field_id.'"> '.$field->name.'</option>';
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
								<option value="1">January</option>
								<option value="2">February</option>
								<option value="3">March</option>
								<option value="4">April</option>
								<option value="5">May</option>
								<option value="6">June</option>
								<option value="7">July</option>
								<option value="8">August</option>
								<option value="9">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>
							<select name="day" id="day">';
	
	for ($i = 1; $i <= 31; $i++){
		$output .= '<option value="'.$i.'">'.$i.'</option>';
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