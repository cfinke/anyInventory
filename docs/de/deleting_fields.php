<?php

include("globals.php");

$title = "anyInventory: Help > Fields > Deleting Fields";
$breadcrumbs = '<a href="./">Help</a> > <a href="fields.php">Fields</a> > Deleting Fields';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>Deleting Fields</td>
		</tr>
		<tr>
			<td class="tableData">
				<p>When you delete a field, you\'re also deleting all of the data you\'ve entered in for that field for any items that you\'ve added, so be careful when you delete.</p>
			</td>
		</tr>
	</table>
	<div style="float: left;"><a href="editing_fields.php">&lt;&lt; Previous: Editing Fields</a></div>
	<div style="text-align: right;"><a href="field_order.php">Next: Field Order &gt;&gt;</a></div>';

display($output);

?>