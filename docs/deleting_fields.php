<?php

include("globals.php");

$title = "anyInventory: Help > Fields > Editing Fields";

$output .= '
	<h2>Deleting Fields</h2>
	<p>When you delete a field, you\'re also deleting all of the data you\'ve entered in for that field, so be careful when you delete.</p>
	<div style="float: left;"><a href="editing_fields.php">&lt;&lt; Previous: Editing Fields</a></div>
	<div style="text-align: right;"><a href="field_order.php">Next: Field Order &gt;&gt;</a></div>';

display($output);

?>