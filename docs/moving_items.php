<?php

include("globals.php");

$title = "anyInventory: Help > Items > Moving Items";

$output .= '
	<h2>Moving Items</h2>
	<p>When you move an item, you lose the data you have entered for fields that are not part of the category you are moving it to.  The fields that the destination category contains will appear blank for the item.  All other information is unaffected.</p>
	<div style="float: left;"><a href="editing_items.php">&lt;&lt; Previous: Editing Items</a></div>
	<div style="text-align: right;"><a href="deleting_items.php">Next: Deleting Items &gt;&gt;</a></div>';

display($output);

?>