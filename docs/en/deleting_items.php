<?php

include("globals.php");

$title = "anyInventory: Help > Items > Deleting Items";
$breadcrumbs = '<a href="./">Help</a> > <a href="items.php">Items</a> > Deleting Items';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Deleting Items</td>
		</tr>
		<tr>
			<td class="tableData">
	<p>When you delete an item, all related files will be deleted as well.  The rest is pretty self-explanatory.</p>
		</td>
	</tr>
	</table><div style="float: left;"><a href="moving_items.php">&lt;&lt; Previous: Moving Items</a></div>
	<div style="text-align: right;"><a href="alerts.php">Next: Alerts &gt;&gt;</a></div>';

display($output);

?>