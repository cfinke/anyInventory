<?php

include("globals.php");

$title = "anyInventory: Help > Introduction";
$breadcrumbs = '<a href="./">Help</a> > <a href="introduction.php">Introduction</a>';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Introduction</td>
		</tr>
		<tr>
			<td class="tableData">
	<p>anyInventory was created to fill a void in the personal inventory system field; all of the other inventory systems are designer with a certain type of inventory in mind.  anyInventory is different; it is designed to allow you, the user, to decide what type of item you want to track and what type of data you want to keep track of.</p>
	<p>For example, any other inventory system you might come across would tell you, "With this product, you can keep track of your computer software.  For each piece of software, you can save the name, the publisher, and the date of purchase; you can also upload a picture if you wish." If you wanted to keep track of the serial number as well, you could either try to add that field into the source code, or you could just deal with it.  Here\'s how anyInventory is different:</p>
	<p>This software comes with <em>zero</em> pre-conceived notions of what you want to do with it.  It is flexible enough to track the food in your refrigerator alongside the thimbles in your 1000+ piece thimble collection.  It is simple enough to be used as a library of your DVDs, but it is powerful enough to track the inventory of your small business.</p>
	<p>The reason that anyInventory can be so powerful and flexible is the way the you, the user, enter data.  Instead of starting by entering in items into the inventory, you start by defining what data you want to track.  For a more in-depth look at this data, continue on to read about <a href="fields.php">fields</a>.  If you chose to password-protect your installation, you may want to look at the documentation on <a href="users.php">users</a>.</p>
		</td>
	</tr>
	</table><div style="float: left;"><a href="index.php">&lt;&lt; Previous: Table of Contents</a></div>
	<div style="text-align: right;"><a href="users.php">Next: Users &gt;&gt;</a></div>';

display($output);

?>