<?php

include("globals.php");

$title = "anyInventory: Help";

$output .= '
	<h2>Introduction</h2>
	<p>anyInventory was created to fill a void in the personal inventory system field; all of the other inventory systems on the market come with a pre-conceived stock, that is, the other systems were designed with inventorying a certain type of product in mind.  anyInventory is different; it is designed to allow you, the user, to decide what type of item you want to track and what type of data you want to keep track of.</p>
	<p>For example, any other inventory system you might come across would tell you, "With this product, you can keep track of your computer software.  For each piece of software, you can save the name, the publisher, and the date of purchase; you can also upload a picture if you wish." If you wanted to keep track of the serial number as well, you could either try to add that field into the source code, or you could just deal with it.  Here\'s how anyInventory is different:</p>
	<p>This software comes with <em>zero</em> pre-conceived notions of what you want to do with it.  It is flexible enough to track the food in your refrigerator or the thimbles in your 1000+ piece thimble collection.  It is simple enough to be used as a library of your DVDs, but it is powerful enough to track the inventory of your small business.</p>
	<p>The reason that anyInventory can be so powerful and flexible is the way the you, as the user, enter data.  Instead of starting by entering in items into the inventory, you start by defining what data you want to track.  For a more in-depth look at this data, continue on to read about <a href="fields.php">fields</a>.</p>
	<div style="float: left;"><a href="index.php">&lt;&lt; Previous: Table of Contents</a></div>
	<div style="text-align: right;"><a href="fields.php">Next: Fields &gt;&gt;</a></div>';

display($output);

?>