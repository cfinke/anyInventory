<?php

include("globals.php");

$title = "anyInventory: Help > What's Next?";

$output .= '
	<h2>What\'s Next?</h2>
	<p>This page details some of the features that will be added to anyInventory in future releases.</p>
	<p><b>Built-in password protection for the admin section:</b> Version 1.7 will have a built-in ability to password protect the administrative side of anyInventory to take that responsibility away from the individual user.</p>
	<p><b>Label sheets:</b> This feature will allow you to create standard-size sheets of labels for any items in your inventory.</p>
	<p>If you have any suggestions, comments, or complaints, contact <a href="mailto:chris@efinke.com">chris@efinke.com</a>.</p>
	<div style="float: left;"><a href="searching.php">&lt;&lt; Previous: Searching</a></div>';

display($output);

?>