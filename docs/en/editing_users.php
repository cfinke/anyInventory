<?php

include("globals.php");

$title = "anyInventory: Help > Users > Editing Users";
$breadcrumbs = '<a href="./">Help</a> > <a href="users.php">Users</a> > Editing Users';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Editing Users</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Editing a user is similar to adding a user, only the information is already filled in.  Editing will differ from adding in the following situations:</p>
				<ul>
					<li>When editing the administrator user added during the install, you can only change the username and password.</li>
					<li>When editing your own user, you can only change the password.</li>
				</ul>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="adding_users.php">&lt;&lt; Previous: Adding Users</a></div>
	<div style="text-align: right;"><a href="deleting_users.php">Next: Deleting Users &gt;&gt;</a></div>';

display($output);

?>