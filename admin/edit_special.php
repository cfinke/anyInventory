<?php

include("globals.php");

switch($_REQUEST["id"]){
	case 'auto_inc_field':
		$title = "anyInventory: Edit Auto-Increment Field";
		$breadcrumbs = 'Administration > <a href="fields.php">Fields</a> > Edit Auto-Increment Field';
		
		$query = "SELECT `id` FROM `anyInventory_categories` WHERE `auto_inc_field`='1'";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />' . $query);
		
		$categories = array();
		
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
			$categories[] = $row["id"];
		}
		
		$output = '
				<form method="post" action="special_processor.php">
					<input type="hidden" name="action" value="do_edit_auto_inc_field" />
					<table class="standardTable" cellspacing="0">
						<tr class="tableHeader">
							<td>Edit Auto-Increment Field</td>
							<td style="text-align: right;">[<a href="../docs/editing_fields.php">Help</a>]</td>
						</tr>
						<tr>
							<td class="tableData" colspan="2">
								<table>
									<tr>
										<td class="form_label"><label for="name">Name:</label></td>
										<td class="form_input"><input type="text" name="name" id="name" value="'.str_replace('"','\"',get_config_value("AUTO_INC_FIELD_NAME")).'" maxlength="64" /></td>
									</tr>
									<tr>
										<td class="form_label">Apply field to:</td>
										<td class="form_input">
											<select name="add_to[]" id="add_to[]" multiple="multiple" size="10" style="width: 100%;">
												'.get_category_options($categories).'
											</select>
										</td>
									</tr>
									<tr>
										<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="Submit" /></td>
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