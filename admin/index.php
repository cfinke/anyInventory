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
						<td><b>Front page text:</b> '.get_config_value('FRONT_PAGE_TEXT').'</td>
			<!--	</tr>
					<tr>
						<td style="width: 10%; text-align: center; white-space: nowrap;">
							<nobr>';

if ($admin_user->usertype == 'Administrator'){
	$output .= get_config_value('PP_VIEW') ? '[<b>on</b>] [<a href="special_processor.php?action=pp_view_off">off</a>]' : '[<a href="special_processor.php?action=pp_view_on">on</a>] [<b>off</b>]';
}
else{
	$output .= get_config_value('PP_VIEW') ? '[<b>on</b>] [off]' : '[on] [<b>off</b>]';
}

$output .= '				</nobr>
						</td>
						<td>Inventory Password Protection</td>
					</tr>
					<tr>
						<td style="width: 10%; text-align: center; white-space: nowrap;">
							<nobr>';

if ($admin_user->usertype == 'Administrator'){
	$output .= get_config_value('PP_ADMIN') ? '[<b>on</b>] [<a href="special_processor.php?action=pp_admin_off">off</a>]' : '[<a href="special_processor.php?action=pp_admin_on">on</a>] [<b>off</b>]';
}
else{
	$output .= get_config_value('PP_ADMIN') ? '[<b>on</b>] [off]' : '[on] [<b>off</b>]';
}

$output .= '				</nobr>
						</td>
						<td>Administration Password Protection</td>
					</tr>-->
				</table>
			</td>
		</tr>
	</table>';

display($output);

?>