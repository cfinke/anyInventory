<?php

include("globals.php");

if ($_REQUEST["action"] == "add_category"){
	$query = "INSERT INTO `anyInventory_categories` (`name`,`parent`) VALUES ('".$_REQUEST["name"]."','".$_REQUEST["parent"]."')";
	$result = query($query);
	
	$this_id = insert_id();
	
	if (is_array($_REQUEST["fields"])){
		foreach($_REQUEST["fields"] as $key => $value){
			$temp_field = new field($key);
			$temp_field->add_category($this_id);
		}
	}
	
	header("Location: ".$_SERVER["PHP_SELF"]);
}

$output = '
	<html>
		<head>
			<link rel="stylesheet" type="text/css" href="style.css" />
		</head>
		<body>
			<form method="post" action="'.$_SERVER["PHP_SELF"].'" enctype="multipart/form-data">
				<input type="hidden" name="action" value="add_category" />
				<table>
					<tr>
						<td class="form_label"><label for="name">Name:</label></td>
						<td class="form_input"><input type="text" name="name" id="name" value="" /></td>
					</tr>
					<tr>
						<td class="form_label"><label for="parent">Parent Category:</label></td>
						<td class="form_input">
							<select name="parent" id="parent">
								'.get_category_dropdown().'
							</select>
						</td>
					</tr>
					<tr>
						<td class="form_label">Fields:</td>
						<td class="form_input">
							'.get_fields_checkbox_area().'
						</td>
					</tr>
					<tr>
						<td class="form_label">&nbsp;</td>
						<td class="form_input"><input type="submit" name="submit" id="submit" value="Submit" /></td>
					</tr>
				</table>
			</form>
		</body>
	</html>';

echo $output;

function get_category_dropdown($selected = 0){
	$output = '<option value="0">Top Level</option>';
	$output .= get_dropdown_children(0, '', $selected);
	
	return $output;
}

function get_dropdown_children($id, $pre = "", $selected = 0){
	$query = "SELECT * FROM `anyInventory_categories` WHERE `parent`='".$id."' ORDER BY `name` ASC";
	$result = query($query);
	
	if ($id != 0){
		$newquery = "SELECT `name` FROM `anyInventory_categories` WHERE `id`='".$id."'";
		$newresult = query($newquery);
		$category_name = result($newresult, 0, 'name');
		$pre .= $category_name . ' > ';
	}
	
	$list = '';
	
	if (num_rows($result) > 0){
		while ($row = fetch_array($result)){
			$category = $row["name"];
			
			$list .= '<option value="'.$row["id"].'"';
			if ($row["id"] == $selected) $list .= ' selected="selected"';
			$list .= '>'.$pre . $category.'</option>';
			
			$list .= get_dropdown_children($row["id"], $pre, $selected);
		}
	}
	
	return $list;
}

function get_fields_checkbox_area($checked = null){
	$query = "SELECT * FROM `anyInventory_fields` WHERE 1 ORDER BY `name` ASC";
	$result = query($query);
	
	$num_fields = num_rows($result);
	
	$output .= '<div id="field_checkboxes">
		<div style="float: left;">';
	
	for ($i = 0; $i < ceil($num_fields / 2); $i++){
		$output .= '<div class="checkbox"><input type="checkbox" name="fields['.result($result, $i, "id").']" value="yes" /> '.result($result, $i, "name").'</div>';
	}
	
	$output .= '</div>
		<div>';
	
	for (; $i < $num_fields; $i++){
		$output .= '<div class="checkbox"><input type="checkbox" name="fields['.result($result, $i, "id").']" value="yes" /> '.result($result, $i, "name").'</div>';	
	}
	
	$output .= '</div>';
	
	return $output;
}

?>