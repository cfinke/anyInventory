<?php

require("globals.php");

$title = "anyInventory: Labels";
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
				<td>Generate Labels</td>
			</tr>
			<tr>
				<td class="tableData" style="text-align: center;">
					You do not have all of the PHP functions needed to create labels installed.  These functions are <a href="http://us3.php.net/manual/en/function.imagecreate.php">imagecreate</a>, <a href="http://us3.php.net/manual/en/function.imagecolorallocate.php">imagecolorallocate</a>, <a href="http://us3.php.net/manual/en/function.imagettftext.php">imagettftext</a>, <a href="http://us3.php.net/manual/en/function.imagestring.php">imagestring</a>, <a href="http://us3.php.net/manual/en/function.imagecopyresized.php">imagecopyresized</a>, <a href="http://us3.php.net/manual/en/function.imagedestroy.php">imagedestroy</a>, and <a href="http://us3.php.net/manual/en/function.imagepng.php">imagepng</a>.  One or more of these functions is not installed.
				</td>
			</tr>
		</table>';
}
elseif ($_POST["action"] == "generate"){
	if (!is_array($_POST["i"])) $_POST["i"] = array($_POST["i"]);
	
	foreach($_POST["i"] as $item_id){
		$item = new item($item_id);
		
		if ($item->fields[$_POST["f"]] != '') $output .= '<img src="label_processor.php?i='.$item_id.'&amp;f='.$_POST["f"].'" style="height: 61px;" /><br />';
	}
}
elseif (!isset($_POST["c"])){
	$output .= '
		<table class="standardTable" cellspacing="0">
			<tr class="tableHeader">
				<td>Generate Labels</td>
				<td style="text-align: right;">[<a href="docs/labels.php">Help</a>]</td>
			</tr>
			<tr>
				<td class="tableData" colspan="2">
					<form action="labels.php" method="post">
						<table>
							<tr><td colspan="2" style="padding: 10px 0px 10px 0px;">Select the categories to which the items belong for which you want to produce labels.  All categories that you select must have at least one field in common.</td></tr>
							<tr>
								<td class="form_label">Categories:</td>
								<td class="form_input">
									<select name="c[]" id="c[]" multiple="multiple" size="10" style="width: 100%;">
										'.$view_user->get_view_categories_options(null).'
								</select>
								</td>
							</tr>
							<tr>
								<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" value="Submit" /></td>
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
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	if (mysql_num_rows($result) == 0){
		header("Location: error_handler.php?eid=3");
		exit;
	}
	else{
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Generate Labels</td>
					<td style="text-align: right;">[<a href="docs/labels.php">Help</a>]</td>
				</tr>
				<tr>
					<td class="tableData" colspan="2">
						<form action="labels.php" method="post">
							<input type="hidden" name="action" value="generate" />
							<table>
								<tr><td colspan="2" style="padding: 10px 0px 10px 0px;"><p>Select the field from which you want to produce the barcode and the items for which you want to produce a label.</td></tr>
								<tr>
									<td class="form_label">
										Generate from:
									</td>
									<td class="form_input">';
		
		while ($row = mysql_fetch_array($result)){
			$field = new field($row["id"]);
			
			$output .= '<input type="radio" name="f" value="'.$field->name.'" />'.$field->name.'<br />';
		}
		
		$output .= '
									</td>
								</tr>
								<tr>
									<td class="form_label">
										Generate for:
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
								<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" value="Submit" /></td>
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
