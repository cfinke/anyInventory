<?php

require_once("globals.php");

$title = "anyInventory: Help > Alerts > Deleting Alerts";
$breadcrumbs = '<a href="./">Help</a> > <a href="alerts.php">Alerts</a> > Deleting Alerts';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Deleting Alerts</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Deleting an alert simply removes the alert.  It does not affect any items, categories, or fields.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="editing_alerts.php">&lt;&lt; Previous: Editing Alerts</a></div>
	<div style="text-align: right;"><a href="labels.php">Next: Labels &gt;&gt;</a></div>';

display($output);

?>