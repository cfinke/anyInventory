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
<p>The search page allows you to specify conditions for each available field.  (The fields you leave blank will be ignored.)  As of version 1.1, you can limit your search to a category and its subcategories.</p>
		</td>
	</tr>
	</table><div style="float: left;"><a href="labels.php">&lt;&lt; Previous: Labels</a></div>
	<div style="text-align: right;"><a href="whats_next.php">Next: What\'s Next? &gt;&gt;</a></div>';

display($output);

?>