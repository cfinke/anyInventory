<?php

include("globals.php");

$item = new item($_REQUEST["id"]);
$output .= '
	<form action="item_processor.php" method="post">
		<input type="hidden" name="action" value="do_delete" />
		<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
		<p>Are you sure you want to delete this item?</p>
		'.$item->export_description().'
		<p style="text-align: center;">
			<input type="submit" name="delete" value="Delete" />
			<input type="submit" name="cancel" value="Cancel" />
		</p>
	</form>';

display($output);

?>