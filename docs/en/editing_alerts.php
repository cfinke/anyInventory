<?php

require_once("globals.php");

$title = "anyInventory: Help > Alerts > Editing Alerts";
$breadcrumbs = '<a href="./">Help</a> > <a href="alerts.php">Alerts</a> > Editing Alerts';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Editing Alerts</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Editing an alert is the same as adding an alert, except the form is already filled in.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="alerts.php#adding">&lt;&lt; Previous: Adding Alerts</a></div>
	<div style="text-align: right;"><a href="deleting_alerts.php">Next: Deleting Alerts &gt;&gt;</a></div>';

display($output);

?>