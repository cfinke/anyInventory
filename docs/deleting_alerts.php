<?php

include("globals.php");

$title = "anyInventory: Help > Items > Deleting Alerts";

$output .= '
	<h2>Deleting Alerts</h2>
	<p>Deleting an alert simply removes the alert.  It does not affect any items, categories, or fields.</p>
	<div style="float: left;"><a href="editing_alerts.php">&lt;&lt; Previous: Editing Alerts</a></div>
	<div style="text-align: right;"><a href="searching.php">Next: Searching &gt;&gt;</a></div>';

display($output);

?>