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
						<td style="width: 10%; text-align: center;">&nbsp;</td>
						<td>
							<b>'.LANGUAGE.':</b>';

if ($admin_user->usertype == 'Administrator'){
	$output .= '
							<form action="special_processor.php" method="post" style="margin: 0; padding: 0; display: inline;">
								<input type="hidden" name="action" value="change_lang" />
								<select name="lang" id="lang">
									<option value="en"';if(LANG == "en") $output .= ' selected="selected"'; $output .= '>English</option>
									<option value="es"';if(LANG == "es") $output .= ' selected="selected"'; $output .= '>Espa&ntilde;ol</option>
									<option value="fr"';if(LANG == "fr") $output .= ' selected="selected"'; $output .= '>Fran&ccedil;ais</option>
								</select>
								<input type="submit" name="submit" value="'.SUBMIT.'" />
							</form>';
}
else{
	if(LANG == "en") $output .= 'English';
	elseif(LANG == "es") $output .= 'Espa&ntilde;ol';
	elseif(LANG == "fr") $output .= 'Francais';
}

$output .= '
						</td>
					</tr>
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
					</tr>';

if ($admin_user->usertype == 'Administrator'){
	$output .= '
					<tr>
						<td style="width: 10%; text-align: center;">
							[<a href="xml_export.php">'.DOWNLOAD_LINK.'</a>]
						</td>
						<td>
							<b>'.DOWNLOAD_AS_XML.'</b>
						</td>
					</tr>';
}

$output .= '
				</table>
			</td>
		</tr>
	</table>';

display($output);

?>