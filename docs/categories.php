<?php

include("globals.php");

$title = "anyInventory: Help > Categories";

$output .= '
	<h2>Categories</h2>
	<p>anyInventory categories work just like a directory structure on your computer.  You can create a set of top-level categories (such as "Electronics" or "Sporting Goods") and then you can create sub-categories for each category ("Computers" and "Baseball Equipment," respectively).  You can then create sub-categories under the sub-categories ("Hard Drives" and "Catchers\' Mitts") and so on and so forth.  This allows you to categorize your inventory in an easy to understand, logical structure.</p>
	<h2><a name="adding">Adding Categories</a></h2>
	<p><a href="../admin/add_category.php">Adding a category</a> is quite straight-forward.  You will be asked to supply a name and a parent category.  The parent category is the category that the category you are adding will become a sub-category of.  The category you are adding is also known as a "child" of the parent.</p>
	<p>The first category you add must be a child of the "Top Level," a special category that cannot be deleted or edited.  (If you deleted the top level, you\'d be deleting your entire inventory.)</p>
	<p>The only other information you must fill in to create a category is what <a href="fields.php">fields</a> you want it to contain.  This allows you to tailor each category, saving only the data that is relevant for each item.</p>
	<p>When choosing the fields, you have the option of having the category "Inherit fields from parent (in addition to fields checked below)."  This simply gives the category you are adding the same fields as the new category\'s parent, with the option of selecting additional fields.  For example, if you created a "Books" top-level category and gave it the fields Author, UPC, and ISBN, you could check the "Inherit..." box when adding the many subcategories to have them all use the same fields without individully checking them each time.</p>
	<p>Once you have added a category, it will appear in the <a href="../admin/categories.php">categories list</a>, and you can start <a href="adding_items.php">adding items</a> to it.</p> 
	<div style="float: left;"><a href="field_order.php">&lt;&lt; Previous: Field Order</a></div>
	<div style="text-align: right;"><a href="editing_categories.php">Next: Editing Categories &gt;&gt;</a></div>';

display($output);

?>