<?php

include("globals.php");

if (!$admin_user->can_admin_alert($_GET["id"])){
	header("Location: ../error_handler.php?eid=13");
	exit;
}

$title = "anyInventory: Delete Alert";
$breadcrumbs = 'Administration > <a href="alerts.php">Alerts</a> > Delete Alert';

$alert = new alert($_GET["id"]);

$output .= '
	<form action="alert_processor.php" method="post">
		<input type="hidden" name="action" value="do_delete" />
		<input type="hidden" name="id" value="'.$_GET["id"].'" />
		<table class="standardHeader" cellspacing="0" cellpadding="0">
			<tr class="tableHeader">
				<td>Delete Alert</td>
				<td style="text-align: right;">[<a href="../docs/deleting_alerts.php">Help</a>]</td>
			</tr>
			<tr>
				<td class="tableData" colspan="2">
					<p>Are you sure you want to delete this alert?</p>
					'.$alert->export_description().'
					<p class="submitButtonRow">
						<input type="submit" name="delete" value="Delete" />
						<input type="submit" name="cancel" value="Cancel" />
					</p>
				</td>
			</tr>
		</table>
	</form>';

display($output);

?>