<?php

include("globals.php");

$title = "anyInventory: Error";

$errors = array();

$errors[0] = array("Error","There is already a field with the name you specified.  If you wish to add a field to multiple categories, you can do so by editing the field and selecting several categories by holding down the Ctrl key.","breadcrumbs"=>"Error");
$errors[1] = array("Error","The default value for a select or radio field must be included in the list of values.","breadcrumbs"=>"Error");
$errors[2] = array("Error","There were no items in the categories you selected; there must be items in a category for you to add an alert in it.","breadcrumbs"=>"Error");
$errors[3] = array("Error","There were no common fields in the categories you selected.","breadcrumbs"=>"Error");
$errors[4] = array("Sign In",'
	<form action="'.$_REQUEST["return_to"].'" method="post">
		<input type="hidden" name="action" value="log_in" />
		<table cellspacing="0">
			<tr>
				<td class="form_label">Password:</td>
				<td class="form_input"><input type="password" name="password" value="" />
			</tr>
			<tr>
				<td class="form_label">&nbsp;</td>
				<td class="form_input" style="text-align: center;"><input type="submit" name="submit" value="Submit" class="submitButton" /></td>
			</tr>
		</table>
	</form>',"breadcrumbs"=>'Administration > Sign in');

$breadcrumbs = $errors[$_REQUEST["eid"]]["breadcrumbs"];

$output = '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>'.$errors[$_REQUEST["eid"]][0].'</td>
		</tr>
		<tr>
			<td class="tableData">
				<table>
					<tr>
						<td>'.$errors[$_REQUEST["eid"]][1].'</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>';

display($output);

?>