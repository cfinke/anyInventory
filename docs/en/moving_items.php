<?php

include("globals.php");

$title = "anyInventory: Help > Items > Moving Items";
$breadcrumbs = '<a href="./">Help</a> > <a href="items.php">Items</a> > Moving Items';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Moving Items</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>When you move an item, you lose the data you have entered for fields that are not part of the category to which it is moved.  The fields that the destination category contains that the old category does not will appear blank for the item.  All other information is unaffected.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="editing_items.php">&lt;&lt; Previous: Editing Items</a></div>
	<div style="text-align: right;"><a href="deleting_items.php">Next: Deleting Items &gt;&gt;</a></div>';

display($output);

?>