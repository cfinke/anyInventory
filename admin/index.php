<?php

include("globals.php");

$title = ADMINISTRATION;
$breadcrumbs = ADMINISTRATION;

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>
				'.ADMINISTRATION.'
			</td>
			<td style="text-align: right;">
				[<a href="../docs/'.LANG.'/">'.HELP.'</a>]
			</td>
		</tr>
		<tr>
			<td class="tableData" colspan="2">
				<table>
					<tr>
						<td style="width: 10%; text-align: center;">';

if ($admin_user->usertype == 'Administrator'){
	$output .= '[<a href="edit_special.php?id=front_page_text">'.EDIT_LINK.'</a>]';
}
else{
	$output .= '['.EDIT_LINK.']';
}

$output .= '			</td>
						<td><b>'._FRONT_PAGE_TEXT.':</b> '.FRONT_PAGE_TEXT.'</td>
					</tr>
					<tr>
						<td style="width: 10%; text-align: center;">';

if ($admin_user->usertype == 'Administrator'){
	$output .= '[<a href="edit_special.php?id=name_field_name">'.EDIT_LINK.'</a>]';
}
else{
	$output .= '['.EDIT_LINK.']';
}

$output .= '			</td>
						<td><b>'._NAME_FIELD_NAME.':</b> '.NAME_FIELD_NAME.'</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>';

display($output);

?>