<?php

include("globals.php");

$title = 'anyInventory: Move Items';

$item = new item($_REQUEST["id"]);

$output = '
		<form method="post" action="item_processor.php" enctype="multipart/form-data">
		<table style="width: 100%;"><tr><td><h2>Move an Item: '.$item->name.'</h2></td><td style="text-align: right;"><a href="../docs/moving_items.php">Help with moving items</a></td></tr></table>
			<input type="hidden" name="action" value="do_move" />
			<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
			<table>
				<tr>
					<td class="form_label"><label for="c">Move to:</label></td>
					<td class="form_input">
						<select name="c" id="c">
							'.get_category_options($item->category->id).'
						</select>
					</td>
				</tr>
				<tr>
					<td class="form_label">&nbsp;</td>
					<td class="form_input" style="text-align: center;"><input type="submit" name="submit" id="submit" value="Submit" /></td>
				</tr>
			</table>
		</form>';

display($output);

?>