<?php

include("globals.php");

$title = ADD_ALERT;
$breadcrumbs = ADMINISTRATION.' > <a href="alerts.php">'.ALERTS.'</a> > '.ADD_ALERT;

if (!is_array($_GET["c"])){
	$output = '
		<form method="get" action="add_alert.php">
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>'.ADD_ALERT.'</td>
					<td style="text-align: right;">[<a href="../docs/'.LANG.'/alerts.php#adding">'.HELP.'</a>]</td>
				</tr>
				<tr>
					<td class="tableData">
						<table style="width: 100%;">
							<tr>
								<td class="form_label"><label for="c">'.ADD_ALERT_IN.':</label></td>
								<td class="form_input">
									<select name="c[]" id="c[]" multiple="multiple" size="20" style="width: 100%;">
										'.$admin_user->get_admin_categories_options(null).'
									</select>
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
else{
	$query = "SELECT `id`,`name` FROM `anyInventory_fields` WHERE ";
	
	foreach($_GET["c"] as $cat_id){
		if (!$admin_user->can_admin($cat_id)){
			header("Location: ../error_handler.php?eid=13");
			exit;
		}
		else{
			$query .= " `categories` LIKE '%\"".$cat_id."\"%' AND `input_type` NOT IN ('divider','file','item') AND ";
		}
	}
	
	$query = substr($query, 0, strlen($query) - 4);
	$result = $db->query($query) or die($db->error() . '<br /><br />'. $query);
	
	if ($result->numRows() == 0){
		header("Location: ../error_handler.php?eid=3");
		exit;
	}
	else{
		while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
			$fields[] = $row;
		}
		
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
		
		$query = "SELECT `id`,`name` FROM `anyInventory_items` WHERE `item_category` IN (";
		
		foreach($_GET["c"] as $cat_id){
			$query .= $cat_id.", ";
		}
		
		$query = substr($query, 0, strlen($query) - 2);
		
		$query .= ")";
		$result = $db->query($query) or die($db->error() . '<br /><br />'. $query);
		
		if ( $result->numRows() == 0){
			header("Location: ../error_handler.php?eid=2");
			exit;
		}
		else{
			$output = '
					<form method="post" action="alert_processor.php">
						<input type="hidden" name="action" value="do_add" />
						<input type="hidden" name="c" value="'.htmlentities(serialize($_GET["c"])).'" />
						<table class="standardTable" cellspacing="0">
							<tr class="tableHeader">
								<td>'.ADD_ALERT.'</td>
								<td style="text-align: right;">[<a href="../docs/'.LANG.'/alerts.php#adding">'.HELP.'</a>]</td>
							</tr>
							<tr>
								<td class="tableData">
									<table>
										<tr>
											<td class="form_label"><label for="title">'.ALERT_TITLE.':</label></td>
											<td class="form_input"><input type="text" name="title" id="title" value="" maxlength="255" style="width: 100%;" />
										</tr>
										<tr>
											<td class="form_label"><label for="c">'.APPLIES_TO.':</label></td>
											<td class="form_input">
												<select name="i[]" id="i[]" multiple="multiple" size="10" style="width: 100%;">';
			
			while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
				$output .= '<option value="'.$row["id"].'" selected="selected">'.$row["name"].'</option>';
			}
			
			$output .= '
											</select>
										</td>
									</tr>
									<tr>
										<td class="form_label"><input onclick="toggle();" type="checkbox" id="timed" name="timed" value="yes" /></td>
										<td class="form_input"><label for="timed">'.TIMED_ONLY_LABEL.'</label>.
										<br /><small>'.TIMED_ONLY_EXPLANATION.'</small></td>
									</tr>
									<tr>
										<td class="form_label"><label for="field">'.FIELD.':</label></td>
										<td class="form_input">
											<select name="field" id="field" style="width: 100%;">';
			
			foreach($fields as $field){
				$output .= '<option value="'.$field["id"].'"> '.$field["name"].'</option>';
			}
			
			$output .= '			</select>
										</td>
									</tr>
									<tr>
										<td class="form_label"><label for="condition">'.CONDITION.':</label></td>
										<td class="form_input">
											<select name="condition" id="condition" style="width: 100%;">
												<option value="==">=</option>
												<option value="!=">!=</option>
												<option value="<">&lt;</option>
												<option value=">">&gt;</option>
												<option value="<=">&lt;=</option>
												<option value=">=">&gt;=</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="form_label"><label for="value">'.VALUE.':</label></td>
										<td class="form_input"><input type="text" name="value" id="value" value="" style="width: 100%;" /></td>
									</tr>
									<tr>
										<td class="form_label"><label for="month">'.EFFECTIVE_DATE.':</label></td>
										<td class="form_input">
											<select name="month" id="month">
												<option value="1"';if(date("n") == 1) $output .= ' selected="selected"'; $output .= '>'.MONTH_1.'</option>
												<option value="2"';if(date("n") == 2) $output .= ' selected="selected"'; $output .= '>'.MONTH_2.'</option>
												<option value="3"';if(date("n") == 3) $output .= ' selected="selected"'; $output .= '>'.MONTH_3.'</option>
												<option value="4"';if(date("n") == 4) $output .= ' selected="selected"'; $output .= '>'.MONTH_4.'</option>
												<option value="5"';if(date("n") == 5) $output .= ' selected="selected"'; $output .= '>'.MONTH_5.'</option>
												<option value="6"';if(date("n") == 6) $output .= ' selected="selected"'; $output .= '>'.MONTH_6.'</option>
												<option value="7"';if(date("n") == 7) $output .= ' selected="selected"'; $output .= '>'.MONTH_7.'</option>
												<option value="8"';if(date("n") == 8) $output .= ' selected="selected"'; $output .= '>'.MONTH_8.'</option>
												<option value="9"';if(date("n") == 9) $output .= ' selected="selected"'; $output .= '>'.MONTH_9.'</option>
												<option value="10"';if(date("n") == 10) $output .= ' selected="selected"'; $output .= '>'.MONTH_10.'</option>
												<option value="11"';if(date("n") == 11) $output .= ' selected="selected"'; $output .= '>'.MONTH_11.'</option>
												<option value="12"';if(date("n") == 12) $output .= ' selected="selected"'; $output .= '>'.MONTH_12.'</option>
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
										<td class="form_label"><label for="expire_month">'.EXPIRATION_DATE.':</label></td>
										<td class="form_input">
											<select name="expire_month" id="expire_month">
												<option value="1"';if(date("n") == 1) $output .= ' selected="selected"'; $output .= '>'.MONTH_1.'</option>
												<option value="2"';if(date("n") == 2) $output .= ' selected="selected"'; $output .= '>'.MONTH_2.'</option>
												<option value="3"';if(date("n") == 3) $output .= ' selected="selected"'; $output .= '>'.MONTH_3.'</option>
												<option value="4"';if(date("n") == 4) $output .= ' selected="selected"'; $output .= '>'.MONTH_4.'</option>
												<option value="5"';if(date("n") == 5) $output .= ' selected="selected"'; $output .= '>'.MONTH_5.'</option>
												<option value="6"';if(date("n") == 6) $output .= ' selected="selected"'; $output .= '>'.MONTH_6.'</option>
												<option value="7"';if(date("n") == 7) $output .= ' selected="selected"'; $output .= '>'.MONTH_7.'</option>
												<option value="8"';if(date("n") == 8) $output .= ' selected="selected"'; $output .= '>'.MONTH_8.'</option>
												<option value="9"';if(date("n") == 9) $output .= ' selected="selected"'; $output .= '>'.MONTH_9.'</option>
												<option value="10"';if(date("n") == 10) $output .= ' selected="selected"'; $output .= '>'.MONTH_10.'</option>
												<option value="11"';if(date("n") == 11) $output .= ' selected="selected"'; $output .= '>'.MONTH_11.'</option>
												<option value="12"';if(date("n") == 12) $output .= ' selected="selected"'; $output .= '>'.MONTH_12.'</option>
											</select>
											<select name="expire_day" id="expire_day">';
					
			for ($i = 1; $i <= 31; $i++){
				$output .= '<option value="'.$i.'"';if(date("j") == $i) $output .= ' selected="selected"'; $output .= '>'.$i.'</option>';
			}
			
			
			$output .= '			</select>,
									<select name="expire_year" id="expire_year">';
				
			$year = date("Y");
			
			for ($i = 0; $i < 20; $i++){
				$output .= '<option value="'.($i + $year).'">'.($i + $year).'</option>';
			}
			
			
			$output .= '					</select>
											<input type="checkbox" name="expire" id="expire" value="yes" onclick="toggle();" /> '.ALLOW_EXPIRATION.'
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
	}
}

display($output);

?>
