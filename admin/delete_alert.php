<?php

include("globals.php");

$title = "anyInventory: Delete Alert";
$breadcrumbs = 'Administration > <a href="alerts.php">Alerts</a> > Delete Alert';

$alert = new alert($_REQUEST["id"]);

$output .= '
	<form action="alert_processor.php" method="post">
		<input type="hidden" name="action" value="do_delete" />
		<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
		<table class="standardHeader" cellspacing="0" cellpadding="0">
			<tr class="tableHeader">
				<td>Delete Alert</td>
				<td style="text-align: right;">[<a href="../docs/deleting_alerts.php">Help</a>]</td>
			</tr>
			<tr>
				<td class="tableData" colspan="2">
					'.$alert->export_description().'
					<p style="text-align: center; clear: both;">
						<input type="submit" name="delete" value="Delete" />
						<input type="submit" name="cancel" value="Cancel" />
					</p>
				</td>
			</tr>
		</table>
	</form>';

display($output);

?>