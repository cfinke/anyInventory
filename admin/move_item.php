<?php

include("globals.php");

$title = MOVE_ITEM;
$breadcrumbs = ADMINISTRATION.' > <a href="items.php">'.ITEMS.'</a> > '.MOVE_ITEM;

$item = new item($_GET["id"]);

if (!$admin_user->can_admin($item->category->id)){
	header("Location: ../error_handler.php?eid=13");
	exit;
}

$output = '
		<form method="post" action="item_processor.php">
			<input type="hidden" name="action" value="do_move" />
			<input type="hidden" name="id" value="'.$_GET["id"].'" />
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>'.MOVE_ITEM.': '.$item->name.'</td>
					<td style="text-align: right;">[<a href="../docs/'.LANG.'/moving_items.php">'.HELP.'</a>]</td>
				</tr>
				<tr>
					<td class="tableData" colspan="2">
						<table>
							<tr>
								<td class="form_label"><label for="c">'.MOVE_TO.':</label></td>
								<td class="form_input">
									<select name="c" id="c" style="width: 100%;">
										'.get_category_options($item->category->id, false).'
									</select>
								</td>
							</tr>
							<tr>
								<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="'.SUBMIT.'" /></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>';

display($output);

?>