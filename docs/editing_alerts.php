<?php

include("globals.php");

$title = "anyInventory: Help > Alerts > Editing Alerts";

$output .= '
	<h2>Editing Alerts</h2>
	<p>Editing an alert is the same as adding an alert, except the form is already filled in.</p>
	<div style="float: left;"><a href="alerts.php#adding">&lt;&lt; Previous: Adding Alerts</a></div>
	<div style="text-align: right;"><a href="deleting_alerts.php">Next: Deleting Alerts &gt;&gt;</a></div>';

display($output);

?>