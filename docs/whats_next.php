<?php

include("globals.php");

$title = "anyInventory: Help > What's Next?";

$output .= '
	<h2>What\'s Next?</h2>
	<p>This page details some of the features that will be added to anyInventory in future releases.</p>
	<p><b>Alerts:</b> This feature will allow you to set alerts that relate to certain conditions.  For example, if you set the "Location" field of your favorite CD to "My friend Jim\'s house," you could set up an alert so that if, two weeks from now, that value hasn\'t changed, a message will appear on the front page of anyInventory alerting you that Jim still has your CD.  Eventually, you will be able to set up alerts so that Jim would receive an e-mail letting him know that you want your CD back.</p>
	<p><b>Search by category:</b> This feature will allow you to restrict a search to a group of categories.  This will reduce the number of fields that you need to specify values for and will allow for a more targeted search.</p>
	<p><b>Remote file upload:</b> This feature wiil allow you to add files to an item remotely.  For example, if you enter in a DVD into your inventory, you could associate the Amazon.com page for that DVD with your inventory entry.</p>
	<p><b>Label production:</b> This feature will allow you to create barcode and/or information labels for your inventory that you can print out on standard size label sheets.</p>
	<p>If you have any suggestions, comments, or complaints, contact <a href="mailto:chris@efinke.com">chris@efinke.com</a>.</p>
	<div style="float: left;"><a href="searching.php">&lt;&lt; Previous: Searching</a></div>';

display($output);

?>