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
		<li><a href="searching.php">Searching</a></li>
		<li><a href="whats_next.php">What\'s Next?</a></li>
	</ol>';

display($output);

?>