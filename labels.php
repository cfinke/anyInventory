<?php

require("globals.php");
include("label_templates.php");

$title = LABELS;
$breadcrumbs = LABELS;

if (!function_exists('imagecreate') ||
    !function_exists('imagecolorallocate') ||
	!function_exists('imagettftext') ||
	!function_exists('imagestring') ||
	!function_exists('imagecopyresized') ||
	!function_exists('imagedestroy') ||
	!function_exists('imagepng')){
	
	$output .= '
		<table class="standardTable">
			<tr class="tableHeader">
				<td>'.GENERATE_LABELS.'</td>
			</tr>
			<tr>
				<td class="tableData" style="text-align: center;">
					'.LABEL_ERROR.'
				</td>
			</tr>
		</table>';
}
elseif (!isset($_POST["c"])){
	$output .= '
		<table class="standardTable" cellspacing="0">
			<tr class="tableHeader">
				<td>'.GENERATE_LABELS.'</td>
				<td style="text-align: right;">[<a href="docs/'.LANG.'/labels.php">'.HELP.'</a>]</td>
			</tr>
			<tr>
				<td class="tableData" colspan="2">
					<form action="labels.php" method="post">
						<table>
							<tr><td colspan="2" style="padding: 10px 0px 10px 0px;">'.LABEL_CAT_INSTRUCTIONS.'</td></tr>
							<tr>
								<td class="form_label">'.CATEGORIES.':</td>
								<td class="form_input">
									<select name="c[]" id="c[]" multiple="multiple" size="10" style="width: 100%;">
										'.$view_user->get_view_categories_options(null).'
								</select>
								</td>
							</tr>
							<tr>
								<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" value="'.SUBMIT.'" /></td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>';
}
elseif (!isset($_POST["i"])){
	if (!is_array($_POST["c"])){
		$_POST["c"] = array($_POST["c"]);
	}
	
	$query = "SELECT `id` FROM `anyInventory_fields` WHERE `id` > 0 AND `input_type` NOT IN ('item','divider','file') AND ";
	
	foreach($_POST["c"] as $cat_id){
		if (!$view_user->can_view($cat_id)){
			header("Location: error_handler.php?eid=12");
			exit;
		}
		
		$query .= " `categories` LIKE '%\"".$cat_id."\"%' AND ";
	}
	
	$query = substr($query, 0, strlen($query) - 4);
	$result = mysql_query($query) or die(mysql_error().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	
	if (mysql_num_rows($result) == 0){
		header("Location: error_handler.php?eid=3");
		exit;
	}
	else{
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>'.GENERATE_LABELS.'</td>
					<td style="text-align: right;">[<a href="docs/'.LANG.'/labels.php">'.HELP.'</a>]</td>
				</tr>
				<tr>
					<td class="tableData" colspan="2">
						<form action="pdf.php" method="post">
							<table>
								<tr><td colspan="2" style="padding: 10px 0px 10px 0px;"><p>'.LABEL_ITEM_INSTRUCTIONS.'</p></td></tr>
								<tr>
									<td class="form_label">
										'.GENERATE_FROM.':
									</td>
									<td class="form_input">
										<select name="f" id="f">
										';
		
		while ($row = mysql_fetch_array($result)){
			$field = new field($row["id"]);
			
			$output .= '<option value="'.$field->id.'" />'.$field->name.'</option>';
		}
		
		$output .= '
										</select>
									</td>
								</tr>
								<tr>
									<td class="form_label">
										'.GENERATE_FOR.':
									</td>
									<td class="form_input">';
		
		foreach($_POST["c"] as $cat_id){
			$options .= get_item_options($cat_id);
		}
		
		$output .= '
									<select name="i[]" id="i[]" multiple="multiple" size="10" style="width: 100%;">
										'.$options.'
									</select>
								</td>
							</tr>
							<tr>
								<td class="form_label">
									'.LABEL_TEMPLATE.'
								</td>
								<td class="form_input">
									<table>
									';
		
		if (is_array($templates)){
			foreach($templates as $key => $template){
				$output .= '
					<tr>
						<td style="vertical-align: middle;">
							<input type="radio" name="template" value="'.$key.'" />
						</td>
						<td>
							<img src="images/labels/'.$key.'.gif" style="float: left; padding-right: 8px;" />
							'.PAGE_DIMENSIONS.': '.$template["page_width"].'" x '.$template["page_height"].'" ('.($template["page_width"] * 2.54).' cm x '.($template["page_height"] * 2.54).' cm)<br />
							'.LABEL_DIMENSIONS.': '.$template["label_width"].'" x '. $template["label_height"].'" ('.($template["label_width"] * 2.54) .' cm x '. ($template["label_height"] * 2.54).' cm)<br />
							'.$template["num_cols"].' '.COLUMNS.', '.$template["num_rows"].' '.ROWS.' ('.($template["num_cols"] * $template["num_rows"]).' '.LABELS.')
						</td>
					</tr>';
			}
		}
		
		$output .= '				</table>
								</td>
							</tr>
							<tr>
								<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" value="'.SUBMIT.'" /></td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>';
	}
}

display($output);

?>
