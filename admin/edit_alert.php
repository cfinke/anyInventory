<?php

require_once("globals.php");

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

$output = '	
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>'.EDIT_ALERT.': '.$alert->title.'</td>
			<td style="text-align: right;">[<a href="../docs/'.LANG.'/editing_alerts.php">'.HELP.'</a>]</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				<form method="post" action="alert_processor.php">
					<input type="hidden" name="action" value="do_edit_cat_ids" />
					<input type="hidden" name="id" value="'.$_GET["id"].'" />
					<table>
						<tr>
							<td class="form_label"><label for="c[]">'.CATEGORIES.':</label><br /><small><a href="javascript:void(0);" onclick="selectNone(\'c[]\');">'.SELECT_NONE.'</a></small></td>
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
				</form>';

$output .= '
				<form method="post" action="alert_processor.php">
					<input type="hidden" name="action" value="do_edit" />
					<input type="hidden" name="id" value="'.$_GET["id"].'" />
					<table>
						'.display_alert_form($alert->category_ids, 
											 $alert->title, 
											 $alert->item_ids, 
											 $alert->timed, 
											 $alert->field_id, 
											 $alert->condition, 
											 $alert->value, 
											 substr($alert->time, 4, 2),
											 substr($alert->time, 6, 2),
											 substr($alert->time, 0, 4),
											 $alert->expires,
											 substr($alert->expire_time, 4, 2),
											 substr($alert->expire_time, 6, 2),
											 substr($alert->expire_time, 0, 4)).'
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
