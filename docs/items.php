<?php

include("globals.php");

$title = "anyInventory: Help > Items and Adding Items";

$output .= '
	<h2>Items</h2>
	<p>"Item" is the generic term for anything you enter into your inventory, whether it be a computer part, a document, a DVD, a picture frame - whatever.  The items in an inventory are what make it important.  Fields and categories set the structure; items fill it in.</p>
	<h2><a name="adding">Adding Items</a></h2>
	<p>To add an item, you must first choose a <a href="categories.php">category</a>.  This determines what <a href="fields.php">fields</a> you will need to fill in.</p>
	<p>After you have chosen a category, you will be presented with a form that consists of the fields that you have defined for this category.  There is not much more to say on this subject; you should know how to fill in the fields, because you created them.</p>
	<p><a name="remote_files">The only fields</a> (besides "Name") that you did not create, are the "File" and "Remote file" fields.  The first allows you to upload any file related to the item you are adding; the second allows you to specify a file somewhere on the Internet to which you would like to link this item.  If you want to upload more than one file or list more than one remote file, you will have that option on the <a href="editing_items.php">edit item</a> page.</p>
	<p>If the file you upload is an image, it will appear as a thumbnail (a small preview of the image) when you view the item in your inventory.  Otherwise, it will be listed as a link to the file, allowing it to be downloaded.</p>
	<div style="float: left;"><a href="deleting_categories.php">&lt;&lt; Previous: Deleting Categories</a></div>
	<div style="text-align: right;"><a href="editing_items.php">Next: Editing Items &gt;&gt;</a></div>';

display($output);

?>