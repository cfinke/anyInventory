<?php

include("globals.php");

$title = "anyInventory: Help > Categories > Deleting Categories";
$breadcrumbs = '<a href="./">Help</a> > <a href="categories.php">Categories</a> > Deleting Categories';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Deleting Categories</td>
		</tr>
		<tr>
			<td class="tableData">
	<p>When you choose to delete a category, you have the option of deleting all of its subcategories or moving them to another category.  The form defaults to moving the subcategories to the category\'s parent.  You will also be informed of how many items are inventoried in the category and its subcategories.</p>
		</td>
	</tr>
	</table><div style="float: left;"><a href="editing_categories.php">&lt;&lt; Previous: Editing Categories</a></div>
	<div style="text-align: right;"><a href="items.php">Next: Items &gt;&gt;</a></div>';

display($output);

?>