<?php

require_once("globals.php");

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
								<td class="form_label"><label for="c">'.ADD_ALERT_IN.':</label><br /><small><a href="javascript:void(0);" onclick="selectNone(\'c[]\');">'.SELECT_NONE.'</a></small></td>
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
							'.display_alert_form($_GET["c"]).'
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
