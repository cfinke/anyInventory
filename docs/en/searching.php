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
				<p>When you enter search terms in the box at the top of any page in anyInventory, the search is made in the following manner:</p>
				<ol>
					<li>If you enter a number and no other terms, anyInventory will search each field <em>plus</em> the unique auto-incrementing field for that number.</li>
					<li>If you enter one term that is not numeric, anyInventory will search each field that you defined <em>plus</em> the "name" field.</li>
					<li>If you enter more than one term, anyInventory will seach for an item that has each of the search terms contained somewhere within one or more of its fields.</li>
				</ol>
				<p>anyInventory will then return the results ordered by category.  Boolean searches are not currently supported (ie. using "AND" or "OR" will not affect the search).</p>
		</td>
	</tr>
	</table><div style="float: left;"><a href="labels.php">&lt;&lt; Previous: Labels</a></div>
	<div style="text-align: right;"><a href="whats_next.php">Next: What\'s Next? &gt;&gt;</a></div>';

display($output);

?>