<?php

include("globals.php");

$title = "anyInventory: Error";

$errors = array();

$errors[0] = "<h2>Error</h2>There is already a field with the name you specified.  If you wish to add a field to multiple categories, you can do so by editing the field and selecting several categories by holding down the Ctrl key.";
$errors[1] = "<h2>Error</h2>The default value for a select or radio field must be included in the list of values.";
$errors[2] = "<h2>Error</h2>There must be items in a category for you to add an alert in it.";
$errors[3] = "<h2>Error</h2>There were no common fields in the categories you selected.";

$errors[4] = '
	<h2>Sign In</h2>
	<form action="'.$_REQUEST["return_to"].'" method="post">
		<input type="hidden" name="action" value="log_in" />
		<table>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="password" value="" />
				<td><input type="submit" name="submit" value="Submit" /></td>
			</tr>
		</table>
	</form>';

$output = $errors[$_REQUEST["eid"]];

display($output);

?>