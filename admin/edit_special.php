<?php

include("globals.php");

if ($admin_user->usertype != 'Administrator'){
	header("Location: ../error_handler.php?eid=15");
	exit;
}

switch($_GET["id"]){
	case 'auto_inc_field':
		$title = EDIT_AUTOINC_FIELD;
		$breadcrumbs = ADMINISTRATION.' > <a href="fields.php">'.FIELDS.'</a> > '.EDIT_AUTOINC_FIELD;
		
		$query = "SELECT `id` FROM `anyInventory_categories` WHERE `auto_inc_field`='1'";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
		
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
							<td style="text-align: right;">[<a href="../docs/'.LANG.'/editing_fields.php">'.HELP.'</a>]</td>
						</tr>
						<tr>
							<td class="tableData" colspan="2">
								<table>
									<tr>
										<td class="form_label"><label for="name">'.NAME.':</label></td>
										<td class="form_input"><input type="text" name="name" id="name" value="'.str_replace('"','\"',AUTO_INC_FIELD_NAME).'" maxlength="64" /></td>
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
		$breadcrumbs = ADMINISTRATION.' > <a href="fields.php">'.FIELDS.'</a> > '.EDIT_NAME_FIELD;
		
		$output = '
				<form method="post" action="special_processor.php">
					<input type="hidden" name="action" value="do_edit_name_field_name" />
					<table class="standardTable" cellspacing="0">
						<tr class="tableHeader">
							<td>'.EDIT_NAME_FIELD.'</td>
							<td style="text-align: right;">[<a href="../docs/'.LANG.'/editing_fields.php">'.HELP.'</a>]</td>
						</tr>
						<tr>
							<td class="tableData" colspan="2">
								<table>
									<tr>
										<td class="form_label"><label for="name">'.NAME.':</label></td>
										<td class="form_input"><input type="text" name="name" id="name" value="'.str_replace('"','\"',NAME_FIELD_NAME).'" maxlength="64" /></td>
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

}

display($output);

?>
