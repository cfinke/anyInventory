<?php

include("globals.php");

$title = "anyInventory: Help > Fields";

$output .= '
	<h2>Fields</h2>
	<p>Fields are the basis of anyInventory.  They define the type of data that you want to track. Let\'s take a look at the different types of fields.
	</p>
	<h2><a name="types">Field Types</a></h2>
	<p>There are five types of fields from which to choose when setting up anyInventory.  Each one
	   is described below, with an example shown below it.</p>
	<ul>
		<li>
			<b>Text field</b>, which holds a word or phrase that is usually different for each item.  An example
		    of this would be the name of each item.
			<form style="padding-left: 50px; margin: 10px;">
				<input type="text" value="Name of item" />
			</form>
		</li>
		<li>
			<b>Select field</b>, which holds a value that can only be one out of a list.  An example of this
			would be selecting your country of residence from a drop-down list.
			<form style="padding-left: 50px; margin: 10px;">
				<select name="values">
					<option>Canada</option>
					<option>England</option>
					<option>Germany</option>
					<option>United States</option>
				</select>
			</form>
		</li>
		<li>
			<b>Radio buttons</b>, which hold a value that can only be one out of a few values.  An example of
		    this would be selecting "Yes" or "No" as an answer to a question: it has to be one of the two, and it 
			cannot be both.
			<form style="padding-left: 50px; margin: 10px;">
				<input type="radio" name="q" /> Yes<br />
				<input type="radio" name="q" /> No
			</form>
		</li>
		<li>
			<b>Checkboxes</b>, which hold values that can be zero or more out of a list of values.  An example
			of this would be selecting all of the colors that appear in a painting.
			<form style="padding-left: 50px; margin: 10px;">
				<input type="checkbox" name="q" /> Red<br />
				<input type="checkbox" name="q" /> Orange<br />
				<input type="checkbox" name="q" /> Yellow<br />
				<input type="checkbox" name="q" /> Green<br />
				<input type="checkbox" name="q" /> Blue<br />
				<input type="checkbox" name="q" /> Indigo<br />
				<input type="checkbox" name="q" /> Violet<br />
			</form>
		</li>
		<li>
			<b>Multiple</b>, which is a combination of the select field and the text field.  This gives you the
			option of selecting one of several commonly used values from a drop-down or entering in a
			unique value for this item.  (If you have a Web browser with Javascript enabled, the text
			field should take the value of the last selected option from the dropdown.)
			<form style="padding-left: 50px; margin: 10px;">
				<input type="text" value="Mexico" id="country"/>
				<select name="values">
					<option onclick="document.getElementById(\'country\').value = \'Canada\';">Canada</option>
					<option onclick="document.getElementById(\'country\').value = \'England\';">England</option>
					<option onclick="document.getElementById(\'country\').value = \'Germany\';">Germany</option>
					<option onclick="document.getElementById(\'country\').value = \'United States\';">United States</option>
				</select>
			</form>
		</li>
	</ul>
	<p>If this all seems confusing, don\'t worry.  It should become clearer with an example.</p>
	<h4>An Example</h4>
	<p>
		Let\'s say that you are documenting all of your receipts for tax purposes.
	   	You might want to keep track of the following: date of purchase, place of purchase, total price, tax paid, item 
	   	purchased, whether or not it was a business expense, an image of the receipt, and an image of the 
	   	item purchased.  Your fields for this type of item would look like the following:
	</p>
	<ul>
		<li>Date of purchase: text field</li>
		<li>Place of purchase: multiple field</li>
		<li>Total price: text field</li>
		<li>Item purchased: text field</li>
		<li>Business expense: radio buttons, with values "Yes" and "No"</li>
		<li>Receipt and item image: files, handled by anyInventory\'s file upload functionality</li>
	</ul>
	<p>Now that we have a group of items we want to track, let\'s see how we would go about <a href="adding_fields.php">adding
		the fields.</a>
	</p>
	<div style="float: left;"><a href="introduction.php">&lt;&lt; Previous: Introduction</a></div>
	<div style="text-align: right;"><a href="adding_fields.php">Next: Adding Fields &gt;&gt;</a></div>';

display($output);

?>