<?php

include("globals.php");

$title = "anyInventory: Help > Items > Deleting Items";

$output .= '
	<h2>Deleting Items</h2>
	<p>When you delete an item, all related files will be deleted as well.  The rest is pretty self-explanatory.</p>
	<div style="float: left;"><a href="moving_items.php">&lt;&lt; Previous: Moving Items</a></div>
	<div style="text-align: right;"><a href="searching.php">Next: Searching &gt;&gt;</a></div>';

display($output);

?>