<?php

require_once("globals.php");

if ($admin_user->usertype != 'Administrator'){
	header("Location: ../error_handler.php?eid=15");
	exit;
}

switch($_GET["id"]){
	case 'auto_inc_field':
		$title = EDIT_AUTOINC_FIELD;
		$breadcrumbs = '<a href="index.php">' .ADMINISTRATION.'</a> > <a href="fields.php">'.FIELDS.'</a> > '.EDIT_AUTOINC_FIELD;
		
		$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('auto_inc_field') . "='1'";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$categories = array();
		
		while ($row = $result->fetchRow()){	
			$categories[] = $row["id"];
		}
		
		$output = '
				<form method="post" action="special_processor.php">
					<input type="hidden" name="action" value="do_edit_auto_inc_field" />
					<table class="standardTable" cellspacing="0">
						<tr class="tableHeader">
							<td>'.EDIT_AUTOINC_FIELD.'</td>
							<td style="text-align: right;">[<a href="../docs/editing_fields.php">'.HELP.'</a>]</td>
						</tr>
						<tr>
							<td class="tableData" colspan="2">
								<table>
									<tr>
										<td class="form_label"><label for="name">'.NAME.':</label></td>
										<td class="form_input"><input type="text" name="name" id="name" value="'.htmlspecialchars(AUTO_INC_FIELD_NAME, ENT_QUOTES).'" maxlength="64" /></td>
									</tr>
									<tr>
										<td class="form_label">'.APPLIES_TO.':</td>
										<td class="form_input">
											<select name="add_to[]" id="add_to[]" multiple="multiple" size="10" style="width: 100%;">
												'.get_category_options($categories).'
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
		break;
	case 'front_page_text':
		$output .= '
			<form method="post" action="special_processor.php">
				<input type="hidden" name="action" value="do_edit_front_page_text" />
				<table class="standardTable" cellspacing="0">
					<tr class="tableHeader">
						<td>'.EDIT_FRONT_PAGE_TEXT.'</td>
					</tr>
					<tr>
						<td class="tableData">
							<table>
								<tr>
									<td class="form_label"><label for="name">'.TEXT.':</label></td>
									<td class="form_input"><textarea name="front_page_text" id="front_page_text" rows="8" cols="40" style="width: 100%;">'.FRONT_PAGE_TEXT.'</textarea></td>
								</tr>
								<tr>
									<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="'.SUBMIT.'" /></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</form>';
		break;
	case 'name_field_name':
		$title = EDIT_NAME_FIELD;
		$breadcrumbs = '<a href="index.php">' .ADMINISTRATION.'</a> > <a href="fields.php">'.FIELDS.'</a> > '.EDIT_NAME_FIELD;
		
		$output = '
				<form method="post" action="special_processor.php">
					<input type="hidden" name="action" value="do_edit_name_field_name" />
					<table class="standardTable" cellspacing="0">
						<tr class="tableHeader">
							<td>'.EDIT_NAME_FIELD.'</td>
							<td style="text-align: right;">[<a href="../docs/editing_fields.php">'.HELP.'</a>]</td>
						</tr>
						<tr>
							<td class="tableData" colspan="2">
								<table>
									<tr>
										<td class="form_label"><label for="name">'.NAME.':</label></td>
										<td class="form_input"><input type="text" name="name" id="name" value="'.htmlspecialchars(NAME_FIELD_NAME, ENT_QUOTES).'" maxlength="64" /></td>
									</tr>
									<tr>
										<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="'.SUBMIT.'" /></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</form>';
		break;
	case 'label_template':
		require_once("../label_templates.php");
		
		$title = EDIT_LABEL_TEMPLATE;
		$breadcrumbs = '<a href="index.php">' .ADMINISTRATION.'</a> > <a href="fields.php">'.FIELDS.'</a> > '.EDIT_LABEL_TEMPLATE;
		
		$output = '
				<form method="post" action="special_processor.php">
					<input type="hidden" name="action" value="do_edit_label_template" />
					<table class="standardTable" cellspacing="0">
						<tr class="tableHeader">
							<td>'.EDIT_LABEL_TEMPLATE.'</td>
							<td style="text-align: right;">[<a href="../docs/editing_fields.php">'.HELP.'</a>]</td>
						</tr>
						<tr>
							<td class="tableData" colspan="2">
								<table>';
		if (is_array($templates)){
			foreach($templates as $key => $template){
				$output .= '
					<tr>
						<td style="vertical-align: middle;">
							<input type="radio" name="template" value="'.$key.'"';
							if(BAR_TEMPLATE == $key) $output .= ' checked';
				$output .= '/>
						</td>
						<td>';
				
				if (is_file("../images/labels/".$key.".gif")){
					$output .= '<img src="../images/labels/'.$key.'.gif" style="float: left; padding-right: 8px;" />';
				}
				
				$output .= 	PAGE_DIMENSIONS.': '.$template["page_width"].'" x '.$template["page_height"].'" ('.($template["page_width"] * 2.54).' cm x '.($template["page_height"] * 2.54).' cm)<br />
							'.LABEL_DIMENSIONS.': '.$template["label_width"].'" x '. $template["label_height"].'" ('.($template["label_width"] * 2.54) .' cm x '. ($template["label_height"] * 2.54).' cm)<br />
							'.$template["num_cols"].' '.COLUMNS.', '.$template["num_rows"].' '.ROWS.' ('.($template["num_cols"] * $template["num_rows"]).' '.LABELS.')
						</td>
					</tr>';
			}
		}
		
		$output .= '				<tr>
										<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="'.SUBMIT.'" /></td>
									</tr>
									</table>
							</td>
						</tr>
					</table>
				</form>';
		break;
	case 'label_padding':
		$title = EDIT_LABEL_PADDING;
		$breadcrumbs = '<a href="index.php">' .ADMINISTRATION.'</a> > <a href="fields.php">'.FIELDS.'</a> > '.EDIT_LABEL_PADDING;
		
		$output = '
				<form method="post" action="special_processor.php">
					<input type="hidden" name="action" value="do_edit_label_padding" />
					<table class="standardTable" cellspacing="0">
						<tr class="tableHeader">
							<td>'.EDIT_LABEL_PADDING.'</td>
							<td style="text-align: right;">[<a href="../docs/editing_fields.php">'.HELP.'</a>]</td>
						</tr>
						<tr>
							<td class="tableData" colspan="2">
								<table>
									<tr>
										<td class="form_input"><input type="text" name="padding" id="padding" value="'.htmlspecialchars(LABEL_PADDING, ENT_QUOTES).'" maxlength="5" /></td>
									</tr>
									<tr>
										<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="'.SUBMIT.'" /></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</form>';
		break;
	case 'pad_char':
		$title = EDIT_PAD_CHAR;
		$breadcrumbs = '<a href="index.php">' .ADMINISTRATION.'</a> > <a href="fields.php">'.FIELDS.'</a> > '.EDIT_PAD_CHAR;
		
		$output = '
				<form method="post" action="special_processor.php">
					<input type="hidden" name="action" value="do_edit_pad_char" />
					<table class="standardTable" cellspacing="0">
						<tr class="tableHeader">
							<td>'.EDIT_PAD_CHAR.'</td>
							<td style="text-align: right;">[<a href="../docs/editing_fields.php">'.HELP.'</a>]</td>
						</tr>
						<tr>
							<td class="tableData" colspan="2">
								<table>
									<tr>
										<td class="form_input"><input type="text" name="char" id="char" value="'.htmlspecialchars(PAD_CHAR, ENT_QUOTES).'" maxlength="1" /></td>
									</tr>
									<tr>
										<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="'.SUBMIT.'" /></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</form>';
		break;
	case 'barcode':
		$title = EDIT_BARCODE;
		$breadcrumbs = '<a href="index.php">' .ADMINISTRATION.'</a> > <a href="fields.php">'.FIELDS.'</a> > '.EDIT_BARCODE;
		
		$output = '
				<form method="post" action="special_processor.php">
					<input type="hidden" name="action" value="do_edit_barcode" />
					<table class="standardTable" cellspacing="0">
						<tr class="tableHeader">
							<td>&nbsp;</td>
							<td>'.EDIT_BARCODE.'</td>
							<td style="text-align: right;">[<a href="../docs/editing_fields.php">'.HELP.'</a>]</td>
						</tr>
						  <tr>
							<td width="4" valign="middle"><input name="type" type="radio" value="I25"';
							if(BARCODE == I25) $output .= ' checked';
							$output .= '></td>
							<td width="96%">'.BARCODE_I25.'  </td>
						  </tr>
						  <tr>
							<td><input name="type" type="radio" value="C39"';
							if(BARCODE == C39) $output .= ' checked';
							$output .= '></td>
							<td>'.BARCODE_C39.'   </td>
						  </tr>
						  <tr>
							<td>&nbsp;</td>
							<td>'.BARCODE_C128.'</td>
						  </td>
						  <tr>
							<td>&nbsp;</td>
							<td>'.BARCODE_FOOTER.'</td>
						  </tr>
						  <tr>
							<td><input name="type" type="radio" value="C128A"';
							if(BARCODE == C128A) $output .= ' checked';
							$output .= '></td>
							<td>'.BARCODE_C128A.'</td>
						  </tr>
						  <tr>
							<td><input name="type" type="radio" value="C128B"';
							if(BARCODE == C128B) $output .= ' checked';
							$output .= '></td>
							<td>'.BARCODE_C128B.'</td>
						  </tr>
						  <tr>
							<td><input name="type" type="radio" value="C128C"';
							if(BARCODE == C128C) $output .= ' checked';
							$output .= '></td>
							<td>'.BARCODE_C128C.'</td>
						  </tr>
						  <tr>
							<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="'.SUBMIT.'" /></td>
						  </tr>
					</table>
				</form>';
		break;

}

display($output);

?>
