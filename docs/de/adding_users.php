<?php

include("globals.php");

$title = "anyInventory: Help > Users > Adding Users";
$breadcrumbs = '<a href="./">Help</a> > <a href="users.php">Users</a> > Adding Users';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Adding Users</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Only administrators can add users.  When adding a user, the administrator can specify the new user as a regular user or as an administrator.  If the user is added as an administrator, then he or she will have viewing and administrative access to all categories.  Otherwise, the administrator must select a group of categories to which to give access to the new user.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="users.php#types">&lt;&lt; Previous: User Types</a></div>
	<div style="text-align: right;"><a href="editing_users.php">Next: Editing Users &gt;&gt;</a></div>';

display($output);

?>