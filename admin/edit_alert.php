<?php

include("globals.php");

$title = "anyInventory: Edit Alert";

$alert = new alert($_REQUEST["id"]);

$output = '
		<form method="post" action="alert_processor.php" enctype="multipart/form-data">
			<h2>Edit Alert</h2>
			<input type="hidden" name="action" value="do_edit" />
			<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
			<table>
				<tr>
					<td class="form_label"><label for="name">Title:</label></td>
					<td class="form_input"><input type="text" name="title" id="title" value="'.$alert->title.'" maxlength="255" />
				</tr>';

$output .= '
				<tr>
					<td class="form_label">&nbsp;</td>
					<td class="form_input"><input type="submit" name="submit" id="submit" value="Submit" /></td>
				</tr>
			</table>
		</form>';

display($output);

?>