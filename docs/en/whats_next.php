<?php

require_once("globals.php");

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
				<p><b>Stronger CSS support:</b> The layout of anyInventory is currently being re-written using strict HTML for markup and CSS for layout.  This will make it easier for users of anyInventory to apply their own themes more easily.</p>
				<p><b>Multiple-condition alerts:</b> This will allow you to specify an alert for more than one condition on an item.</p>
				<p><b>XML File Support:</b> This feature will allow you to download and upload your inventory as an XML file, for easy backups and easy restores.</p>
				<p><b>Improved advanced search:</b> The search page will be improved to allow for specify whether the entered search terms should be equal to, not equal to, less than, etc. the intended resulting items.</p>
				<p><b>Wider support for remote files:</b> As of version 1.7, images can be added as local files remotely if the libcurl library is installed.  Support for systems without this library is expected as of version 1.8.</p>
				<p><b>Label sheets:</b> This feature will allow you to create standard-size sheets of labels for any items in your inventory.</p>
				<p>If you have any suggestions, comments, or complaints, contact <a href="mailto:chris@efinke.com">chris@efinke.com</a>.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="searching.php">&lt;&lt; Previous: Searching</a></div>';

display($output);

?>