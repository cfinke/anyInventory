<?php

include("globals.php");

$title = "anyInventory: Delete Alert";

$alert = new alert($_REQUEST["id"]);

$output .= '
	<form action="alert_processor.php" method="post">
		<input type="hidden" name="action" value="do_delete" />
		<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
		<p>Are you sure you want to delete this alert?</p>
		'.$alert->export_description().'
		<p style="text-align: center; clear: both;">
			<input type="submit" name="delete" value="Delete" />
			<input type="submit" name="cancel" value="Cancel" />
		</p>
	</form>';

display($output);

?>