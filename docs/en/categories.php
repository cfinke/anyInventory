<?php

include("globals.php");

$title = "anyInventory: Help > Categories and Adding Categories";
$breadcrumbs = '<a href="./">Help</a> > Categories and Adding Categories';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Categories</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>The category system works just like the directory structure on your computer.  You can create a set of top-level categories (such as "Electronics" or "Sporting Goods") and then you can create sub-categories for each category ("Computers" and "Baseball Equipment," respectively).  You can then create sub-categories under the sub-categories ("Hard Drives" and "Catchers\' Mitts") and so on and so forth.  This allows you to categorize your inventory in an easy to understand, logical structure.</p>
			</td>
		</tr>
		<tr class="tableHeader">
			<td><a name="adding">Adding Categories</a></td>
		</tr>
		<tr>
			<td class="tableData">
			<p><a href="'.$DIR_PREFIX.'admin/add_category.php">Adding a category</a> is quite straight-forward.  You will be asked to supply a name and a parent category.  The category you are adding will be created "under" the parent category, making it a "child" of the parent.</p>
			<p>The first category you add must be a child of the "Top Level," a special category that cannot be deleted or edited.  (If you deleted the top level, you\'d be deleting your entire inventory.)</p>
			<p>The only other information you must fill in to create a category is what <a href="fields.php">fields</a> you want it to contain.  This allows you to tailor each category, saving only the data that is relevant for each item.</p>
			<p>When choosing the fields, you have the option of having the category "Inherit fields from parent (in addition to fields checked below)."  This simply gives the category you are adding the same fields as its parent, with the option of selecting additional fields.  For example, if you created a "Books" top-level category and gave it the fields Author, UPC, and ISBN, you could check the "Inherit..." box when adding the many subcategories to have them all use the same fields without individully checking them each time.</p>
			<p>You also have the option of displaying the auto-incrementing field.  This will display the unique numerical ID of each item in the inventory at the top of its description page and to the left of its link on each category page.  This can be activated and deactivated on a category by category basis.</p>
			<p>Once you have added a category, it will appear in the <a href="'.$DIR_PREFIX.'admin/categories.php">categories list</a>, and you can start <a href="items.php#adding">adding items</a> to it.</p> 
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="field_order.php">&lt;&lt; Previous: Field Order</a></div>
	<div style="text-align: right;"><a href="editing_categories.php">Next: Editing Categories &gt;&gt;</a></div>';

display($output);

?>