<?php

include("globals.php");

$title = "anyInventory: Help > Items > Editing Items";
$breadcrumbs = '<a href="./">Help</a> > <a href="items.php">Items</a> > Editing Items';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Editing Items</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Editing an item is very similar to adding an item, with two exceptions:</p>
				<ol>
					<li>You do not have the option of changing what category in which the item is found. This is restricted to the <a href="moving_items.php">moving items</a> page.</li>
					<li>You can choose to delete currently uploaded files for this item.  If the file is an image, a thumbnail will be shown, otherwise it will simply list the link to the file.</li>
				</ol>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="items.php#adding">&lt;&lt; Previous: Adding Items</a></div>
	<div style="text-align: right;"><a href="moving_items.php">Next: Moving Items &gt;&gt;</a></div>';

display($output);

?>