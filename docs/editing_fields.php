<?php

include("globals.php");

$title = "anyInventory: Help > Fields > Editing Fields";

$output .= '
	<h2>Editing Fields</h2>
	<p>Editing a field works exactly the same way as adding a field, only the information is already entered into the form.</p>
	<div style="float: left;"><a href="adding_fields.php">&lt;&lt; Previous: Adding Fields</a></div>
	<div style="text-align: right;"><a href="deleting_fields.php">Next: Deleting Fields &gt;&gt;</a></div>';

display($output);

?>