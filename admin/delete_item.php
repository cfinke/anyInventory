<?php

include("globals.php");

$title = "anyInventory: Delete Item";
$breadcrumbs = 'Administration > <a href="items.php">Items</a> > Delete Item';

$item = new item($_GET["id"]);

if (!$admin_user->can_admin($item->category->id)){
	header("Location: ../error_handler.php?eid=13");
	exit;
}

$output .= '
	<form action="item_processor.php" method="post">
		<input type="hidden" name="action" value="do_delete" />
		<input type="hidden" name="id" value="'.$_GET["id"].'" />
		<table class="standardTable" cellspacing="0" cellpadding="0">
			<tr class="tableHeader">
				<td>Delete Item</td>
				<td style="text-align: right;">[<a href="../docs/deleting_items.php">Help</a>]</td>
			</tr>
			<tr>
				<td class="tableData" colspan="2">
					<p>Are you sure you want to delete this item?</p>
					'.$item->export_description().'
					<p class="submitButtonRow">
						<input type="submit" name="delete" value="Delete" />
						<input type="submit" name="cancel" value="Cancel" />
					</p>
				</td>
			</tr>
		</table>
	</form>';

display($output);

?>