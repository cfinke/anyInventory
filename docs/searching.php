<?php

include("globals.php");

$title = "anyInventory: Help > Searching";

$output .= '
	<h2>Searching</h2>
	<p>You can search your inventory from two places: the search box at the top of each page and the <a href="../search.php">advanced search page</a>.</p>
	<p>When you search from the search box at the top of any of the pages, anyInventory searches the "Name" field of each item for whatever term you enter.</p>
	<p>For a more powerful search, you can search from the advanced search page.  This page allows you to specify conditions for each available fields.  (The fields you leave blank will be ignored.)</p>
	<div style="float: left;"><a href="deleting_items.php">&lt;&lt; Previous: Deleting Items</a></div>
	<div style="text-align: right;"><a href="whats_next.php">Next: What\'s Next? &gt;&gt;</a></div>';

display($output);

?>