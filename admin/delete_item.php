<?php

include("globals.php");

$title = "anyInventory: Delete Item";
$breadcrumbs = 'Administration > <a href="items.php">Items</a> > Delete Item';

$item = new item($_REQUEST["id"]);

$output .= '
	<form action="item_processor.php" method="post">
		<input type="hidden" name="action" value="do_delete" />
		<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
		<table class="standardTable" cellspacing="0" cellpadding="0">
			<tr class="tableHeader">
				<td>Delete Item</td>
				<td style="text-align: right;">[<a href="../docs/deleting_items.php">Help</a>]</td>
			</tr>
			<tr>
				<td class="tableData" colspan="2">
					'.$item->export_description().'
					<p style="text-align: center; clear: both;">
						<input type="submit" name="delete" value="Delete" class="submitButton" />
						<input type="submit" name="cancel" value="Cancel" class="submitButton" />
					</p>
				</td>
			</tr>
		</table>
	</form>';

display($output);

?>