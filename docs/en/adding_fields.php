<?php

require_once("globals.php");

$title = "anyInventory: Help > Fields > Adding Fields";
$inHead = '
	<script type="text/javascript">
	   _editor_url = "'.$DIR_PREFIX.'htmlarea/";
	   _editor_lang = "'.LANG.'";
	</script>
	<script type="text/javascript" src="'.$DIR_PREFIX.'htmlarea/htmlarea.js"></script>';
$inBodyTag = ' onload="HTMLArea.replaceAll();"';
$breadcrumbs = '<a href="./">Help</a> > <a href="fields.php">Fields</a> > Adding Fields';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Adding Fields</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>
					To begin tracking your receipts, you must add the fields listed on the previous page so that you can enter in the data later.
					For this, proceed to the <a href="'.$DIR_PREFIX.'admin/add_field.php">field addition</a> page.  There, you will see
					something that looks like this:
				</p>
				<form method="post" action="#">
					<table>
						'.display_field_form().'
					</table>
				</form>
				<p>Let\'s begin adding our fields, shall we?  First up is the date of purchase.</p>
				<p>"But wait," you might say.  "Shouldn\'t we keep track of the name of each item?"  Don\'t worry.  You will never need to create a field to track an item name; that is one of only two built-in fields in anyInventory, the other being the auto-incrementing field.</p>
				<p>If you choose to check the box marked "Highlight this field," this field and its value will appear with a highlighted background in the item\'s description.  This might be useful for denoting special fields for an item, such as UPC, serial number, or product codes.</p>
				<p>Back to the purchase date: first, we enter in the field name:</p>
				<form method="post" action="#">
					<table>
						'.display_field_form('','Purchase Date','text').'
					</table>
				</form>
				<p>There we go.  Now, we select what type of field we want.  Since "text" is already selected here, there\'s no need to change the data type.</p>
				<p>The "default value" defines what will appear in a field by default when you add an item.  For this, maybe we want to remember what format in which to enter the date, so we set the default as YYYY/MM/DD:</p>
				<form method="post" action="#">
					<table>
						'.display_field_form('','Purchase Date','text','','YYYYMMDD').'
					</table>
				</form>
				<p>Next is the size of the field.  This limits how many characters can be entered in the field.  Since we already know the format of our date, we can set this to 10, exactly enough to hold our format of date.</p>
				<p><em>Note: if this is set to 256 or more, you will be given a text box rather than a text field to enter your data.  The text box, shown below, simply makes more data visible as your enter it.</em></p>
				<form style="padding-left: 50px; margin: 10px;">
					<textarea rows="10" cols="60" style="width: 100%;">
						This is a text box.  Feel free to type in it.
						If you have a supported browser, this should also be a WYSIWYG editor.
					</textarea>
				</form>
				<br />
				<form method="post" action="#">
					<table>
						'.display_field_form('','Purchase Date','text','','YYYYMMDD',8).'
					</table>
				</form>
				<p>The last field, "Apply to," deals with applying this field to a set of categories.  We don\'t need to worry about this, since we have not added any categories yet.  If we had already added some categories, we could select which categories we wanted to contain this field.  Adding fields to categories is described lated in <a href="categories.php#adding">adding categories</a>.</p>
				<p>Adding the total price and item purchased fields will work the same way, but let\'s take a look at one of the other fields to see how adding an enumerated field works, "enumerated" meaning that you can specify a set of values for the field.</p>
				
				<p>Let\'s add the "place of purchase" field now, which is of type "multiple."  (We set it as multiple instead of select in order 
				to allow us to type in a place if it doesn\'t appear in the list.)</p>
				<p>First, we enter in the field name and choose the field type:</p>
				<form method="post" action="#">
					<table>
						'.display_field_form('','Place of Purchase','multiple').'
					</table>
				</form>
				<p>The next thing we need to do is to give this field some values. We do this by entering the stores we want to appear in the list, separated by commas. So, let\'s put in the five stores we shop at the most often, and we\'ll set the default to the store that we shop at the most.</p>
				<form method="post" action="#">
					<table>
						'.display_field_form('','Place of Purchase','multiple',array("Staples", "Office Max", "Office Depot", "Radio Shack", "Sam Goody"),'Office Max').'
					</table>
				</form>
				<p>Once again, since we have not added any categories yet, we can ignore the "Apply to" field.<p>
				<p>This field, when it is shown on an item addition page, will look like this:</p>
				<form style="padding-left: 50px; margin: 10px;">
					<input type="text" value="Office Max" id="store_we_shop_at"/>
					<select name="field_values">
						<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Staples\';">Staples</option>
						<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Office Max\';">Office Max</option>
						<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Office Depot\';">Office Depot</option>
						<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Radio Shack\';">Radio Shack</option>
						<option onclick="document.getElementById(\'store_we_shop_at\').value = \'Sam Goody\';">Sam Goody</option>
					</select>
				</form>
				<p>Adding a radio button, checkbox, or select field works in the same way.</p>
				<p>Adding a field of type \'file\' allows you to upload a file for that field instead of typing or selecting a value.  As of version 1.6, this replaced the built-in "File Upload" and "Remote File" fields.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="fields.php#types">&lt;&lt; Previous: Field Types</a></div>
	<div style="text-align: right;"><a href="editing_fields.php">Next: Editing Fields &gt;&gt;</a></div>';

display($output);

?>