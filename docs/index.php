<?php

include("globals.php");

$title = "anyInventory: Help";

$output .= '
	<h2>Table of Contents</h2>
	<p>Welcome to the help section for anyInventory.  You can read through the pages in order, or use the table of contents below to help you find what you\'re looking for.</p>
	<p style="text-align: right;"><a href="introduction.php">First: Introduction &gt;&gt;</a></p>
	<ol>
		<li><a href="introduction.php">Introduction</a></li>
		<li><a href="fields.php">Fields</a></li>
		<ol>
			<li><a href="fields.php#types">Field Types</a></li>
			<li><a href="adding_fields.php">Adding</a></li>
			<li><a href="editing_fields.php">Editing</a></li>
			<li><a href="deleting_fields.php">Deleting</a></li>
			<li><a href="field_order.php">Field Order</a></li>
		</ol>
		<li>Categories</li>
		<ol>
			<li>Adding</li>
			<li>Editing</li>
			<li>Deleting</li>
		</ol>
		<li>Items</li>
		<ol>
			<li>Adding</li>
			<li>Editing</li>
			<li>Moving</li>
			<li>Deleting</li>
			<li>File Uploads</li>
		</ol>
		<li>Searching</li>
		<li>What\'s Next?</li>
	</ol>';

display($output);

?>