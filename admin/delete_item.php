<?php

include("globals.php");

$title = DELETE_ITEM;
$breadcrumbs = ADMINISTRATION.' > <a href="items.php">'.Items.'</a> > '.DELETE_ITEM;

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
				<td>'.DELETE_ITEM.'</td>
				<td style="text-align: right;">[<a href="../docs/'.LANG.'/deleting_items.php">'.HELP.'</a>]</td>
			</tr>
			<tr>
				<td class="tableData" colspan="2">
					<p>'.DELETE_ITEM_CONFIRM.'</p>
					'.$item->export_description().'
					<p class="submitButtonRow">
						<input type="submit" name="delete" value="'.DELETE.'" />
						<input type="submit" name="cancel" value="'.CANCEL.'" />
					</p>
				</td>
			</tr>
		</table>
	</form>';

display($output);

?>