<?php

include("globals.php");

$title = "anyInventory: Help > Searching";
$breadcrumbs = '<a href="./">Help</a> > Searching';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Searching</td>
		</tr>
		<tr>
			<td class="tableData">
	<p>You can search your inventory from two places: the search box at the top of each page and the <a href="../search.php">advanced search page</a>.</p>
	<p>When you search from the search box at the top of any of the pages, anyInventory searches the "Name" field of each item for whatever term you enter.</p>
	<p>For a more powerful search, you can search from the advanced search page.  This page allows you to specify conditions for each available field.  (The fields you leave blank will be ignored.)  As of version 1.1, you can limit your search to a category and its subcategories.</p>
		</td>
	</tr>
	</table><div style="float: left;"><a href="labels.php">&lt;&lt; Previous: Labels</a></div>
	<div style="text-align: right;"><a href="whats_next.php">Next: What\'s Next? &gt;&gt;</a></div>';

display($output);

?>