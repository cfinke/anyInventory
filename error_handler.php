<?php

include("globals.php");

$title = "anyInventory: Error";

$errors = array();

$errors[0] = array("Error","There is already a field with the name you specified.  If you wish to add a field to multiple categories, you can do so by editing the field and selecting several categories by holding down the Ctrl key.","breadcrumbs"=>"Error");
$errors[1] = array("Error","The default value for a select or radio field must be included in the list of values.","breadcrumbs"=>"Error");
$errors[2] = array("Error","There were no items in the categories you selected; there must be items in a category for you to add an alert in it.","breadcrumbs"=>"Error");
$errors[3] = array("Error","There were no common fields in the categories you selected.","breadcrumbs"=>"Error");
$errors[5] = array('Error','An alert must apply to at least one category.','breadcrumbs'=>'Error');
$errors[6] = array('Error','An alert must apply to at least one item.','breadcrumbs'=>'Error');
$errors[7] = array('Error','The Top Level category cannot be edited or deleted.','breadcrumbs'=>'Error');
$errors[8] = array('Error','You must supply a list of values for this field.','breadcrumbs'=>'Error');
$errors[9] = array('Error','Not logged in. Please <a href='.$DIR_PREFIX.'index.php">click here</a> to login. ','breadcrumbs'=>'Error');
$errors[10] = array('Access Denied','You must be a privileged used to edit, add, or delete. ','breadcrumbs'=>'Access Denied');
$errors[11] = array('Access Denied','You must be an administrator to add, edit, or delete users. ','breadcrumbs'=>'Access Denied');
$errors[12] = array('Access Denied','You do not have viewing priveleges for this category.','breadcrumbs'=>'Access Denied');
$errors[13] = array('Access Denied','You do not have editing priveleges for this category.','breadcrumbs'=>'Access Denied');
$errors[14] = array('Access Denied','You cannot delete your own user account.','breadcrumbs'=>'Access Denied');
$errors[15] = array('Access Denied','You must be an administrator to access this page.','breadcrumbs'=>'Access Denied');
$errors[16] = array('Error','A user with that name already exists.','breadcrumbs'=>'Error');

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