<?php

require("globals.php");

$title = "anyInventory: Labels";

if (!function_exists('imagecreate') ||
    !function_exists('imagecolorallocate') ||
	!function_exists('imagettftext') ||
	!function_exists('imagestring') ||
	!function_exists('imagecopyresized') ||
	!function_exists('imagedestroy') ||
	!function_exists('imagepng')){
	
	$output .= '
		<h2>Generate Labels</h2>
		<p>You do not have all of the PHP functions needed to create labels installed.  These functions are <a href="http://us3.php.net/manual/en/function.imagecreate.php">imagecreate</a>, <a href="http://us3.php.net/manual/en/function.imagecolorallocate.php">imagecolorallocate</a>, <a href="http://us3.php.net/manual/en/function.imagettftext.php">imagettftext</a>, <a href="http://us3.php.net/manual/en/function.imagestring.php">imagestring</a>, <a href="http://us3.php.net/manual/en/function.imagecopyresized.php">imagecopyresized</a>, <a href="http://us3.php.net/manual/en/function.imagedestroy.php">imagedestroy</a>, and <a href="http://us3.php.net/manual/en/function.imagepng.php">imagepng</a>.  One or more of these functions is not installed.</p>';
}
elseif ($_REQUEST["action"] == "generate"){
	if (!is_array($_REQUEST["i"])) $_REQUEST["i"] = array($_REQUEST["i"]);
	
	foreach($_REQUEST["i"] as $item_id){
		$item = new item($item_id);
		
		if ($item->fields[$_REQUEST["f"]] != '') $output .= '<img src="label_processor.php?i='.$item_id.'&amp;f='.$_REQUEST["f"].'" style="height: 61px;" /><br />';
	}
}
elseif (!isset($_REQUEST["c"])){
	$output .= '
		<table style="width: 100%;"><tr><td><h2>Generate Labels</h2></td><td style="text-align: right;"><a href="docs/labels.php">Help with labels</a></td></tr></table>
		<p>Select the categories top which the items belong for which you want to produce labels.  All categories that you select must have at least one field in common.</p>
		<form action="labels.php" method="post">
			<table>
				<tr>
					<td class="form_label">Categories:</td>
					<td class="form_input">
						<select name="c[]" id="c[]" multiple="multiple" size="10">
							'.get_category_options().'
						</select>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td style="text-align: center;"><input type="submit" name="submit" value="Submit" /></td>
				</tr>
			</table>
		</form>';
}
elseif (!isset($_REQUEST["i"])){
	if (!is_array($_REQUEST["c"])){
		$_REQUEST["c"] = array($_REQUEST["c"]);
	}
	
	$query = "SELECT `id` FROM `anyInventory_fields` WHERE ";
	
	foreach($_REQUEST["c"] as $cat_id){
		$query .= " `categories` LIKE '%\"".$cat_id."\"%' AND ";
	}
	
	$query = substr($query, 0, strlen($query) - 4);
	$result = query($query);
	
	if (mysql_num_rows($result) == 0){
		header("Location: error_handler.php?eid=3");
		exit;
	}
	else{
		$output .= '
			<table style="width: 100%;"><tr><td><h2>Generate Labels</h2></td><td style="text-align: right;"><a href="docs/labels.php">Help with labels</a></td></tr></table>
			<p>Select the field from which you want to produce the barcode and the items for which you want to produce a label.</p>
			<form action="labels.php" method="post">
				<input type="hidden" name="action" value="generate" />
				<table>
					<tr>
						<td class="form_label">
							Generate from:
						</td>
						<td class="form_input">';
		
		while ($row = mysql_fetch_array($result)){
			$field = new field($row["id"]);
			
			$output .= '<input type="radio" name="f" value="'.$field->name.'" />'.$field->name.'<br />';
		}
		
		$output .= '</td>
				</tr>
				<tr>
					<td class="form_label">
						Generate for:
					</td>
					<td class="form_input">';
		
		foreach($_REQUEST["c"] as $cat_id){
			$options .= get_item_options($cat_id);
		}
		
		$output .= '
							<select name="i[]" id="i[]" multiple="multiple" size="10">
								'.$options.'
							</select>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td style="text-align: center;"><input type="submit" name="submit" value="Submit" /></td>
					</tr>
				</table>
			</form>';
	}
}

display($output);

?>
