<?php

include("globals.php");

$title = "anyInventory: Help > Users";
$breadcrumbs = '<a href="./">Help</a> > Users';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Users</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Version 1.8 of anyInventory has a more complex user system than that of previous versions.  This allows you to setup password protection for the entire inventory application or just the administration section.  The system put in place in version 1.8 is more complex and more powerful than the previous password protection because multiple users can be created with different viewing and administrative priveleges.</p>
			</td>
		</tr>
		<tr class="tableHeader">
			<td><a name="types">User Types</a></td>
		</tr>
		<tr>
			<td class="tableData">
				<p>There are two types of users: regular users and administrators.  Administrators have full power to add, edit, and delete users, fields, categories, items, and the front page text.  They can turn off password protection for the inventory and the administration as well.  Regular users can only edit fields, items, and categories that they are explicitly allowed to by an administrator.</p>
				<p>The administrator account that is created at install cannot be deleted.  This is to ensure that one cannot get accidentally locked out of the inventory system by deleting all users.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="introduction.php">&lt;&lt; Previous: Introduction</a></div>
	<div style="text-align: right;"><a href="adding_users.php">Next: Adding Users &gt;&gt;</a></div>';

display($output);

?>