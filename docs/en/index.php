<?php

include("globals.php");

$title = "anyInventory: Help";
$breadcrumbs = 'Help';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Table of Contents</td>
		</tr>
		<tr>
			<td class="tableData">
			<p>Welcome to the help section for anyInventory.  You can read through the pages in order, or use the table of contents below to help you find what you\'re looking for.</p>
			<ol style="margin-left: 5%;">
				<li><a href="introduction.php">Introduction</a></li>
				<li><a href="users.php">Users</a></li>
				<ol>
					<li><a href="users.php#types">User Types</a></li>
					<li><a href="adding_users.php">Adding Users</a></li>
					<li><a href="editing_users.php">Editing Users</a></li>
					<li><a href="deleting_users.php">Deleting Users</a></li>
				</ol>
				<li><a href="fields.php">Fields</a></li>
				<ol>
					<li><a href="fields.php#types">Field Types</a></li>
					<li><a href="adding_fields.php">Adding</a></li>
					<li><a href="editing_fields.php">Editing</a></li>
					<li><a href="deleting_fields.php">Deleting</a></li>
					<li><a href="field_order.php">Field Order</a></li>
				</ol>
				<li><a href="categories.php">Categories</a></li>
				<ol>
					<li><a href="categories.php#adding">Adding</a></li>
					<li><a href="editing_categories.php">Editing</a></li>
					<li><a href="deleting_categories.php">Deleting</a></li>
				</ol>
				<li><a href="items.php">Items</a></li>
				<ol>
					<li><a href="items.php#adding">Adding</a></li>
					<li><a href="editing_items.php">Editing</a></li>
					<li><a href="moving_items.php">Moving</a></li>
					<li><a href="deleting_items.php">Deleting</a></li>
				</ol>
				<li><a href="alerts.php">Alerts</a></li>
				<ol>
					<li><a href="alerts.php#adding">Adding</a></li>
					<li><a href="editing_alerts.php">Editing</a></li>
					<li><a href="deleting_alerts.php">Deleting</a></li>
				</ol>
				<li><a href="labels.php">Labels</a></li>
				<li><a href="searching.php">Searching</a></li>
				<li><a href="whats_next.php">What\'s Next?</a></li>
			</ol>
		</td>
	</tr>
	</table>
	<div style="text-align: right;"><a href="introduction.php">First: Introduction &gt;&gt;</a></div>';

display($output);

?>