<?php

require_once("globals.php");

$title = ADMINISTRATION;
$breadcrumbs = ADMINISTRATION;

$output .= '
	<table class="standardTable" cellspacing="0">
		<tr class="tableHeader">
			<td>
				'.ADMINISTRATION.'
			</td>
			<td style="text-align: right;">
				[<a href="../docs/">'.HELP.'</a>]
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
									<option value="de"';if(LANG == "de") $output .= ' selected="selected"'; $output .= '>Deutsch</option>
									<option value="en"';if(LANG == "en") $output .= ' selected="selected"'; $output .= '>English</option>
									<option value="es"';if(LANG == "es") $output .= ' selected="selected"'; $output .= '>Espa&ntilde;ol</option>
									<option value="fr"';if(LANG == "fr") $output .= ' selected="selected"'; $output .= '>Fran&ccedil;ais</option>
									<option value="no"';if(LANG == "no") $output .= ' selected="selected"'; $output .= '>Norweigan (Bokmal)</option>
								</select>
								<input type="submit" name="submit" value="'.SUBMIT.'" />
							</form>';
}
else{
	if(LANG == "en") $output .= 'English';
	elseif(LANG == "es") $output .= 'Espa&ntilde;ol';
	elseif(LANG == "fr") $output .= 'Francais';
	elseif(LANG == "no") $output .= 'Norweigan (Bokmal)';
	elseif(LANG == "de") $output .= 'Deutsch';
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
	require_once("../label_templates.php");
	$output .= '
					<tr>
						<td style="width: 10%; text-align: center;">
							[<a href="edit_special.php?id=label_template">'.EDIT_LINK.'</a>]
						</td>
						<td>
							<b>'._LABEL_TEMPLATE.':</b> <br />'.PAGE_DIMENSIONS.': '.$templates[BAR_TEMPLATE]["page_width"].'" x '.$templates[BAR_TEMPLATE]["page_height"].'" ('.($templates[BAR_TEMPLATE]["page_width"] * 2.54).' cm x '.($templates[BAR_TEMPLATE]["page_height"] * 2.54).' cm)<br />
							'.LABEL_DIMENSIONS.': '.$templates[BAR_TEMPLATE]["label_width"].'" x '. $templates[BAR_TEMPLATE]["label_height"].'" ('.($templates[BAR_TEMPLATE]["label_width"] * 2.54) .' cm x '. ($templates[BAR_TEMPLATE]["label_height"] * 2.54).' cm)<br />
							'.$templates[BAR_TEMPLATE]["num_cols"].' '.COLUMNS.', '.$templates[BAR_TEMPLATE]["num_rows"].' '.ROWS.' ('.($templates[BAR_TEMPLATE]["num_cols"] * $templates[BAR_TEMPLATE]["num_rows"]).' '.LABELS.')
						</td>
					</tr>
					<tr>
						<td style="width: 10%; text-align: center;">
							[<a href="edit_special.php?id=label_padding">'.EDIT_LINK.'</a>]
						</td>
						<td>
							<b>'._LABEL_PADDING.':</b> '.LABEL_PADDING.'</td>
						</td>
					</tr>
					<tr>
						<td style="width: 10%; text-align: center;">
							[<a href="edit_special.php?id=pad_char">'.EDIT_LINK.'</a>]
						</td>
						<td>
							<b>'._PAD_CHAR.':</b> '.PAD_CHAR.'</td>
						</td>
					</tr>
					<tr>
						<td style="width: 10%; text-align: center;">
							[<a href="edit_special.php?id=barcode">'.EDIT_LINK.'</a>]
						</td>
						<td>
							<b>'._BARCODE.':</b> '.BARCODE.'</td>
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