<?php

include("globals.php");

if (!$admin_user->can_admin_alert($_GET["id"])){
	header("Location: ../error_handler.php?eid=13");
	exit;
}

$title = EDIT_ALERT;
$inHead = '
	<script type="text/javascript">
		<!-- 
			function toggle(){
				document.getElementById(\'field\').disabled = document.getElementById(\'timed\').checked;
				document.getElementById(\'condition\').disabled = document.getElementById(\'timed\').checked;
				document.getElementById(\'value\').disabled = document.getElementById(\'timed\').checked;
				
				document.getElementById(\'expire_month\').disabled = !document.getElementById(\'expire\').checked;
				document.getElementById(\'expire_day\').disabled = !document.getElementById(\'expire\').checked;
				document.getElementById(\'expire_year\').disabled = !document.getElementById(\'expire\').checked;
			}
		// -->
	</script>';
$inBodyTag = ' onload="toggle();"';
$breadcrumbs = ADMINISTRATION.' > <a href="alerts.php">'.ALERTS.'</a> > '.EDIT_ALERT;

$alert = new alert($_GET["id"]);
$checked = ($alert->expire_time == '99999999999999') ? '' : ' checked="checked"';

$query = "SELECT `id`,`name` FROM `anyInventory_fields` WHERE `input_type` != 'divider' ";

if (is_array($alert->category_ids)){
	foreach($alert->category_ids as $cat_id){
		$query .= " AND `categories` LIKE '%\"".$cat_id."\"%'";
	}
}

$result = $db->query($query) or die($db->error() . '<br /><br />'. $query);

if ($result->numRows() == 0){
	header("Location: ../error_handler.php?eid=3");
	exit;
}
else{
	while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
		$fields[] = $row;
	}
	
	$output = '	
		<table class="standardTable" cellspacing="0">
			<tr class="tableHeader">
				<td>'.EDIT_ALERT.': '.$alert->title.'</td>
				<td style="text-align: right;">[<a href="../docs/'.LANG.'/editing_alerts.php">'.HELPS.'</a>]</td>
			</tr>
			<tr>
				<td class="tableData" colspan="2">
					<form method="post" action="alert_processor.php">
						<input type="hidden" name="action" value="do_edit_cat_ids" />
						<input type="hidden" name="id" value="'.$_GET["id"].'" />
						<table>
							<tr>
								<td class="form_label">'.CATEGORIES.':</td>
								<td class="form_input">
									<select name="c[]" id="c[]" multiple="multiple" size="10" style="width: 100%;">
										'.$admin_user->get_admin_categories_options($alert->category_ids).'
									</select>
								</td>
							</tr>
							<tr>
								<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" value="'.UPDATE_CATEGORIES.'" /></td>
							</tr>
						</table>
					</form>
					<form method="post" action="alert_processor.php">
						<input type="hidden" name="action" value="do_edit" />
						<input type="hidden" name="id" value="'.$_GET["id"].'" />
						<table>
						<tr>
							<td class="form_label"><label for="name">'.ALERT_TITLE.':</label></td>
							<td class="form_input"><input type="text" name="title" id="title" value="'.$alert->title.'" maxlength="255" />
						</tr>
						<tr>
							<td class="form_label"><label for="c">'.APPLIES_TO.':</label></td>
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
						<td class="form_input">'.TIMED_ONLY_LABEL.'
						<br /><small>'.TIMED_ONLY_EXPLANATION.'</small></td>
					</tr>
					<tr>
						<td class="form_label"><label for="field">'.FIELD.':</label></td>
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
								<td class="form_label"><label for="condition">'.CONDITION.':</label></td>
								<td class="form_input">
									<select name="condition" id="condition">
										<option value="=="';if ($alert->condition == '==') $output .= ' selected="selected"'; $output .= '>=</option>
										<option value="!="';if ($alert->condition == '!=') $output .= ' selected="selected"'; $output .= '>!=</option>
										<option value="<"';if ($alert->condition == '<') $output .= ' selected="selected"'; $output .= '>&lt;</option>
										<option value=">"';if ($alert->condition == '>') $output .= ' selected="selected"'; $output .= '>&gt;</option>
										<option value="<="';if ($alert->condition == '<=') $output .= ' selected="selected"'; $output .= '>&lt;=</option>
										<option value=">="';if ($alert->condition == '>=') $output .= ' selected="selected"'; $output .= '>&gt;=</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="form_label"><label for="value">'.VALUE.':</label></td>
								<td class="form_input"><input type="text" name="value" id="value" value="'.$alert->value.'" /></td>
							</tr>
							<tr>
								<td class="form_label"><label for="month">'.EFFECTIVE_DATE.':</label></td>
								<td class="form_input">
									<select name="month" id="month">
										<option value="1"';if(substr($alert->time,4,2) == '01') $output .= ' selected="selected"'; $output .= '>'.MONTH_1.'</option>
										<option value="2"';if(substr($alert->time,4,2) == '02') $output .= ' selected="selected"'; $output .= '>'.MONTH_2.'</option>
										<option value="3"';if(substr($alert->time,4,2) == '03') $output .= ' selected="selected"'; $output .= '>'.MONTH_3.'</option>
										<option value="4"';if(substr($alert->time,4,2) == '04') $output .= ' selected="selected"'; $output .= '>'.MONTH_4.'</option>
										<option value="5"';if(substr($alert->time,4,2) == '05') $output .= ' selected="selected"'; $output .= '>'.MONTH_5.'</option>
										<option value="6"';if(substr($alert->time,4,2) == '06') $output .= ' selected="selected"'; $output .= '>'.MONTH_6.'</option>
										<option value="7"';if(substr($alert->time,4,2) == '07') $output .= ' selected="selected"'; $output .= '>'.MONTH_7.'</option>
										<option value="8"';if(substr($alert->time,4,2) == '08') $output .= ' selected="selected"'; $output .= '>'.MONTH_8.'</option>
										<option value="9"';if(substr($alert->time,4,2) == '09') $output .= ' selected="selected"'; $output .= '>'.MONTH_9.'</option>
										<option value="10"';if(substr($alert->time,4,2) == '10') $output .= ' selected="selected"'; $output .= '>'.MONTH_10.'</option>
										<option value="11"';if(substr($alert->time,4,2) == '11') $output .= ' selected="selected"'; $output .= '>'.MONTH_11.'</option>
										<option value="12"';if(substr($alert->time,4,2) == '12') $output .= ' selected="selected"'; $output .= '>'.MONTH_12.'</option>
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
										<td class="form_label"><label for="expire_month">'.EXPIRATION_DATE.':</label></td>
										<td class="form_input">
											<select name="expire_month" id="expire_month">
												<option value="1"';if(substr($alert->expire_time,4,2) == '01') $output .= ' selected="selected"'; $output .= '>'.MONTH_1.'</option>
												<option value="2"';if(substr($alert->expire_time,4,2) == '02') $output .= ' selected="selected"'; $output .= '>'.MONTH_2.'</option>
												<option value="3"';if(substr($alert->expire_time,4,2) == '03') $output .= ' selected="selected"'; $output .= '>'.MONTH_3.'</option>
												<option value="4"';if(substr($alert->expire_time,4,2) == '04') $output .= ' selected="selected"'; $output .= '>'.MONTH_4.'</option>
												<option value="5"';if(substr($alert->expire_time,4,2) == '05') $output .= ' selected="selected"'; $output .= '>'.MONTH_5.'</option>
												<option value="6"';if(substr($alert->expire_time,4,2) == '06') $output .= ' selected="selected"'; $output .= '>'.MONTH_6.'</option>
												<option value="7"';if(substr($alert->expire_time,4,2) == '07') $output .= ' selected="selected"'; $output .= '>'.MONTH_7.'</option>
												<option value="8"';if(substr($alert->expire_time,4,2) == '08') $output .= ' selected="selected"'; $output .= '>'.MONTH_8.'</option>
												<option value="9"';if(substr($alert->expire_time,4,2) == '09') $output .= ' selected="selected"'; $output .= '>'.MONTH_9.'</option>
												<option value="10"';if(substr($alert->expire_time,4,2) == '10') $output .= ' selected="selected"'; $output .= '>'.MONTH_10.'</option>
												<option value="11"';if(substr($alert->expire_time,4,2) == '11') $output .= ' selected="selected"'; $output .= '>'.MONTH_11.'</option>
												<option value="12"';if(substr($alert->expire_time,4,2) == '12') $output .= ' selected="selected"'; $output .= '>'.MONTH_12.'</option>
											</select>
											<select name="expire_day" id="expire_day">';
					
			for ($i = 1; $i <= 31; $i++){
				$output .= '<option value="'.$i.'"';if((substr($alert->expire_time,6,2) / 1) == $i) $output .= ' selected="selected"'; $output .= '>'.$i.'</option>';
			}
			
			
			$output .= '			</select>,
									<select name="expire_year" id="expire_year">';
				
			$year = date("Y");
			
			for ($i = 0; $i < 20; $i++){
				$output .= '<option value="'.($i + $year).'"';if(substr($alert->expire_time,0,4) == ($i + $year)) $output .= ' selected="selected"'; $output .= '>'.($i + $year).'</option>';
			}
			
			
			$output .= '					</select>
											<input type="checkbox" name="expire" id="expire" value="yes" onclick="toggle();"'.$checked.' /> '.ALLOW_EXPIRATION.'
										</td>
									</tr>
							<tr>
								<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="'.SUBMIT.'" /></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>';
}

display($output);

?>
