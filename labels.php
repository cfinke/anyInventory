<?php

include("globals.php");

$title = "Labels";
$breadcrumbs = "Labels";

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
elseif ($_POST["action"] == "generate"){
	if (!is_array($_POST["i"])) $_POST["i"] = array($_POST["i"]);
	
	$field = new field($_POST["f"]);
	
	foreach($_POST["i"] as $item_id){
		$item = new item($item_id);
		
		if ($item->fields[$field->name] != '') $output .= '<img src="label_processor.php?i='.$item_id.'&amp;f='.$_POST["f"].'" /><br />';
	}
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
								<td class="form_label"><label for="c[]">'.CATEGORIES.':</label><br /><small><a href="javascript:void(0);" onclick="selectNone(\'c[]\');">'.SELECT_NONE.'</a></small></td>
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
	
	$query = "SELECT `id` FROM `anyInventory_fields` WHERE `id` > 0 AND ";
	
	foreach($_POST["c"] as $cat_id){
		if (!$view_user->can_view($cat_id)){
			header("Location: error_handler.php?eid=12");
			exit;
		}
		
		$query .= " `categories` LIKE '%\"".$cat_id."\"%' AND ";
	}
	
	$query = substr($query, 0, strlen($query) - 4);
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	if ($result->numRows() == 0){
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
						<form action="labels.php" method="post">
							<input type="hidden" name="action" value="generate" />
							<table>
								<tr><td colspan="2" style="padding: 10px 0px 10px 0px;"><p>'.LABEL_ITEM_INSTRUCTIONS.'</p></td></tr>
								<tr>
									<td class="form_label">
										'.GENERATE_FROM.':
									</td>
									<td class="form_input">';
		
		while ($row = $result->fetchRow()){
			$field = new field($row["id"]);
			
			$output .= '<input type="radio" name="f" value="'.$field->id.'" />'.$field->name.'<br />';
		}
		
		$output .= '
									</td>
								</tr>
								<tr>
									<td class="form_label">
										<label for="i[]">'.GENERATE_FOR.':</label>
										<br /><small><a href="javascript:void(0);" onclick="selectNone(\'i[]\');">'.SELECT_NONE.'</a></small>
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
