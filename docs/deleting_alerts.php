<?php

include("globals.php");

$title = "anyInventory: Help > Alerts > Deleting Alerts";

$output .= '
	<h2>Deleting Alerts</h2>
	<p>Deleting an alert simply removes the alert.  It does not affect any items, categories, or fields.</p>
	<div style="float: left;"><a href="editing_alerts.php">&lt;&lt; Previous: Editing Alerts</a></div>
	<div style="text-align: right;"><a href="labels.php">Next: Labels &gt;&gt;</a></div>';

display($output);

?>