<?php

include("globals.php");

$title = "anyInventory: Help > Fields > Editing Fields";
$breadcrumbs = '<a href="./">Help</a> > <a href="fields.php">Fields</a> > Editing Fields';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Editing Fields</td>
		</tr>
		<tr>
			<td class="tableData">
	<p>Editing a field works exactly the same way as adding a field, only the information is already entered into the form.</p>
		</td>
	</tr>
	</table><div style="float: left;"><a href="adding_fields.php">&lt;&lt; Previous: Adding Fields</a></div>
	<div style="text-align: right;"><a href="deleting_fields.php">Next: Deleting Fields &gt;&gt;</a></div>';

display($output);

?>