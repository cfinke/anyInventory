<?php

include("globals.php");

$title = "anyInventory: Help > Fields > Field Order";

$output .= '
	<h2>Field Order</h2>
	<p>The arrows on the <a href="'.$DIR_PREFIX.'">field page</a> allow you to move a field up and down the list. This list determines in what order the fields appear when you are adding an item to the inventory.  It affects only the display of the fiels on the item addition and editing page, nothing else.</p>
	<div style="float: left;"><a href="deleting_fields.php">&lt;&lt; Previous: Deleting Fields</a></div>
	<div style="text-align: right;"><a href="categories.php">Next: Categories &gt;&gt;</a></div>';

display($output);

?>