<?php

include("globals.php");

$title = "anyInventory: Help > Fields > Field Order";
$breadcrumbs = '<a href="./">Help</a> > <a href="fields.php">Fields</a> > Field Order';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Field Order</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>The [up] and [down] links on the <a href="'.$DIR_PREFIX.'">field page</a> allow you to move a field up and down the list. This list determines in what order the fields appear when you are adding an item to the inventory.  It only affects the display of the fields on the item addition and editing page, nothing else.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="deleting_fields.php">&lt;&lt; Previous: Deleting Fields</a></div>
	<div style="text-align: right;"><a href="categories.php">Next: Categories &gt;&gt;</a></div>';

display($output);

?>