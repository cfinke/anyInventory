<?php

include("globals.php");

$title = 'anyInventory: Administration';
$breadcrumbs = 'Administration';

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>
				Administration
			</td>
			<td style="text-align: right;">
				[<a href="../docs/">Help</a>]
			</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				<table>
					<tr>
						<td style="width: 10%; text-align: center;">';

if ($admin_user->usertype == 'Administrator'){
	$output .= '[<a href="edit_special.php?id=front_page_text">edit</a>]';
}
else{
	$output .= '[edit]';
}

$output .= '			</td>
						<td><b>Front page text:</b> '.FRONT_PAGE_TEXT.'</td>
					</tr>
					<tr>
						<td style="width: 10%; text-align: center;">';

if ($admin_user->usertype == 'Administrator'){
	$output .= '[<a href="edit_special.php?id=name_field_name">edit</a>]';
}
else{
	$output .= '[edit]';
}

$output .= '			</td>
						<td><b>"Name" field name:</b> '.NAME_FIELD_NAME.'</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>';

display($output);

?>