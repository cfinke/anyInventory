<?php

include("globals.php");

if (!$admin_user->can_admin_alert($_GET["id"])){
	header("Location: ../error_handler.php?eid=13");
	exit;
}

$title = DELETE_ALERT;
$breadcrumbs = ADMINISTRATION.' > <a href="alerts.php">'.ALERTS.'</a> > '.DELETE_ALERT;

$alert = new alert($_GET["id"]);

$output .= '
	<form action="alert_processor.php" method="post">
		<input type="hidden" name="action" value="do_delete" />
		<input type="hidden" name="id" value="'.$_GET["id"].'" />
		<table class="standardHeader" cellspacing="0" cellpadding="0">
			<tr class="tableHeader">
				<td>'.DELETE_ALERT.'</td>
				<td style="text-align: right;">[<a href="../docs/'.LANG.'/deleting_alerts.php">'.HELP.'</a>]</td>
			</tr>
			<tr>
				<td class="tableData" colspan="2">
					<p>'.DELETE_ALERT_CONFIRM.'</p>
					'.$alert->export_description().'
					<p class="submitButtonRow">
						<input type="submit" name="delete" value="'._DELETE.'" />
						<input type="submit" name="cancel" value="'.CANCEL.'" />
					</p>
				</td>
			</tr>
		</table>
	</form>';

display($output);

?>