<?php

include("globals.php");

$title = "anyInventory: Help > Categories > Deleting Categories";

$output .= '
	<h2>Deleting Categories</h2>
	<p>When you choose to delete a category, you have the option of deleting all of its subcategories or moving them to another category.  The form defaults to moving the subcategories to the category\'s parent.  You will also be informed of how many items are inventoried in the category and its subcategories.</p>
	<div style="float: left;"><a href="editing_categories.php">&lt;&lt; Previous: Editing Categories</a></div>
	<div style="text-align: right;"><a href="items.php">Next: Items &gt;&gt;</a></div>';

display($output);

?>