<?php

include("globals.php");

$title = "anyInventory: Help > What's Next?";
$breadcrumbs = '<a href="./">Help</a> > What\'s Next?';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>What\'s Next?</td>
		</tr>
		<tr>
			<td class="tableData">
	<p>This page details some of the features that will be added to anyInventory in future releases.</p>
	<p><b>Label sheets:</b> This feature will allow you to create standard-size sheets of labels for any items in your inventory.</p>
	<p>If you have any suggestions, comments, or complaints, contact <a href="mailto:chris@efinke.com">chris@efinke.com</a>.</p>
		</td>
	</tr>
	</table><div style="float: left;"><a href="searching.php">&lt;&lt; Previous: Searching</a></div>';

display($output);

?>