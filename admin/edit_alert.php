<?php

include("globals.php");

$title = "anyInventory: Edit Alert";
$inHead = '
	<script type="text/javascript">
		<!-- 
			function toggle(){
				document.getElementById(\'field\').disabled = document.getElementById(\'timed\').checked;
				document.getElementById(\'condition\').disabled = document.getElementById(\'timed\').checked;
				document.getElementById(\'value\').disabled = document.getElementById(\'timed\').checked;
			}
		// -->
	</script>';
$inBodyTag = ' onload="toggle();"';
$breadcrumbs = 'Administration > <a href="alerts.php">Alerts</a> > Edit Alert';

$alert = new alert($_REQUEST["id"]);
$query = "SELECT `id`,`name` FROM `anyInventory_fields` WHERE 1 ";

if (is_array($alert->category_ids)){
	foreach($alert->category_ids as $cat_id){
		$query .= " AND `categories` LIKE '%\"".$cat_id."\"%'";
	}
}

$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);

if (mysql_num_rows($result) == 0){
	header("Location: ../error_handler.php?eid=3");
	exit;
}
else{
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		$fields[] = $row;
	}
	
	$output = '	
		<table class="standardTable" cellspacing="0">
			<tr class="tableHeader">
				<td>Edit an Alert: '.$alert->title.'</td>
				<td style="text-align: right;">[<a href="../docs/editing_alerts.php">Help</a>]</td>
			</tr>
			<tr>
				<td class="tableData" colspan="2">
					<form method="post" action="alert_processor.php">
						<input type="hidden" name="action" value="do_edit_cat_ids" />
						<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
						<table>
							<tr>
								<td class="form_label">Categories:</td>
								<td class="form_input">
									<select name="c[]" id="c[]" multiple="multiple" size="10" style="width: 100%;">
										'.get_category_options($alert->category_ids).'
									</select>
								</td>
							</tr>
							<tr>
								<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" value="Update Categories" /></td>
							</tr>
						</table>
					</form>
					<form method="post" action="alert_processor.php">
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
								<select name="i[]" id="i[]" multiple="multiple" size="10" style="width: 100%;">
									'.get_item_options($alert->category_ids, $alert->item_ids).'
								</select>
							</td>
						</tr>
						<tr>
							<td class="form_label"><input onclick="toggle();" type="checkbox" id="timed" name="timed" value="yes"';
	
	if ($alert->timed) $output .= ' checked="checked"';
	
	$output .= ' />
						</td>
						<td class="form_input">Make this alert <a href="../docs/alerts.php#time_based">time-based only</a>.
						<br /><small>For time-based alerts, you do not need to fill in the field, condition, or value.</small></td>
					</tr>
					<tr>
						<td class="form_label"><label for="field">Field:</label></td>
						<td class="form_input">
							<select name="field" id="field">';
	
	foreach($fields as $field){
		$output .= '<option value="'.$field["id"].'"';
		if ($alert->field_id == $field["id"]) $output .= ' selected="selected"';
		$output .= '> '.$field["name"].'</option>';
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
										<option value="1"';if(substr($alert->time,4,2) == '01') $output .= ' selected="selected"'; $output .= '>January</option>
										<option value="2"';if(substr($alert->time,4,2) == '02') $output .= ' selected="selected"'; $output .= '>February</option>
										<option value="3"';if(substr($alert->time,4,2) == '03') $output .= ' selected="selected"'; $output .= '>March</option>
										<option value="4"';if(substr($alert->time,4,2) == '04') $output .= ' selected="selected"'; $output .= '>April</option>
										<option value="5"';if(substr($alert->time,4,2) == '05') $output .= ' selected="selected"'; $output .= '>May</option>
										<option value="6"';if(substr($alert->time,4,2) == '06') $output .= ' selected="selected"'; $output .= '>June</option>
										<option value="7"';if(substr($alert->time,4,2) == '07') $output .= ' selected="selected"'; $output .= '>July</option>
										<option value="8"';if(substr($alert->time,4,2) == '08') $output .= ' selected="selected"'; $output .= '>August</option>
										<option value="9"';if(substr($alert->time,4,2) == '09') $output .= ' selected="selected"'; $output .= '>September</option>
										<option value="10"';if(substr($alert->time,4,2) == '10') $output .= ' selected="selected"'; $output .= '>October</option>
										<option value="11"';if(substr($alert->time,4,2) == '11') $output .= ' selected="selected"'; $output .= '>November</option>
										<option value="12"';if(substr($alert->time,4,2) == '12') $output .= ' selected="selected"'; $output .= '>December</option>
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
								<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="Submit" /></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>';
}

display($output);

?>