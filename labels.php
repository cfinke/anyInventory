<?php

require("globals.php");

if ($_REQUEST["action"] == "generate"){
	if (!is_array($_REQUEST["i"])) $_REQUEST["i"] = array($_REQUEST["i"]);
	
	foreach($_REQUEST["i"] as $item_id){
		$item = new item($item_id);
		
		if ($item->fields[$_REQUEST["f"]] != '') $output .= '<img src="label_processor.php?i='.$item_id.'&amp;f='.$_REQUEST["f"].'" style="height: 61px;" /><br />';
	}
}
elseif (!isset($_REQUEST["c"])){
	$output .= '<h2>Generate Labels</h2>
		<form action="labels.php" method="post">
			<select name="c[]" id="c[]" multiple="multiple">
				'.get_category_options().'
			</select>
			<input type="submit" name="submit" value="Submit" />
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
			<h2>Generate Labels</h2>
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
							<select name="i[]" id="i[]" multiple="multiple">
								'.$options.'
							</select>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" name="submit" value="Submit" /></td>
					</tr>
				</table>
			</form>';
	}
}

display($output);

?>
