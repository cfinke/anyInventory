<?php

include("globals.php");

$title = "anyInventory: Help > Categories > Editing Categories";
$breadcrumbs = '<a href="./">Help</a> > <a href="categories.php">Categories</a> > Editing Categories';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Editing Categories</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>Editing a category is identical to adding a category, but the information about the category is already filled into the form.  You can move the category (and its subcategories) by choosing a new parent category.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="categories.php#adding">&lt;&lt; Previous: Adding Categories</a></div>
	<div style="text-align: right;"><a href="deleting_categories.php">Next: Deleting Categories &gt;&gt;</a></div>';

display($output);

?>