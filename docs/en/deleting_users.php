<?php

include("globals.php");

$title = "anyInventory: Help > Users > Deleting Users";
$breadcrumbs = '<a href="./">Help</a> > <a href="users.php">Users</a> > Deleting Users';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Deleting Users</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>You cannot delete the administrator user added during the install, and you cannot delete your own user.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="editing_users.php">&lt;&lt; Previous: Editing Users</a></div>
	<div style="text-align: right;"><a href="fields.php">Next: Fields &gt;&gt;</a></div>';

display($output);

?>