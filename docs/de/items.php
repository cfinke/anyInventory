<?php

include("globals.php");

$title = "anyInventory: Help > Items and Adding Items";
$breadcrumbs = '<a href="./">Help</a> > Items and Adding Items';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Items</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>"Item" is the generic term for anything you enter into your inventory, whether it be a computer part, a document, a DVD, a picture frame - whatever.  The items in an inventory are what make it important.  Fields and categories set the structure; items fill it in.</p>
			</td>
		</tr>
		<tr class="tableHeader">
			<td><a name="adding">Adding Items</a></td>
		</tr>
		<tr>
			<td class="tableData">
				<p>To <a href="'.$DIR_PREFIX.'admin/add_item.php">add an item</a>, you must first choose a <a href="categories.php">category</a>.  This determines what <a href="fields.php">fields</a> you will need to fill in.</p>
				<p>After you have chosen a category, you will be presented with a form that consists of the fields that you have defined for this category.  There is not much more to say on this subject; you should know how to fill in the fields, because you created them.</p>
				<p>If the file you upload for a file-type field is an image, it will appear as a thumbnail (a small preview of the image) when you view the item in your inventory.  Otherwise, it will be listed as a link to the file, allowing it to be downloaded.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="deleting_categories.php">&lt;&lt; Previous: Deleting Categories</a></div>
	<div style="text-align: right;"><a href="editing_items.php">Next: Editing Items &gt;&gt;</a></div>';

display($output);

?>