<?php

include("globals.php");

$title = "anyInventory: Delete Item";

$item = new item($_REQUEST["id"]);
$output .= '
	<form action="item_processor.php" method="post">
		<input type="hidden" name="action" value="do_delete" />
		<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
		<table style="width: 100%;"><tr><td>Are you sure you want to delete this item?</td><td style="text-align: right;"><a href="../docs/deleting_items.php">Help with deleting items</a></td></tr></table>
		'.$item->export_description().'
		<p style="text-align: center; clear: both;">
			<input type="submit" name="delete" value="Delete" />
			<input type="submit" name="cancel" value="Cancel" />
		</p>
	</form>';

display($output);

?>