<?php

include("globals.php");

if ($_REQUEST["action"] == "add_field"){
	$sized_input_types = array("text","multiple");
	
	if (($_REQUEST["size"] == '') && (in_array($_REQUEST["input_type"], $sized_input_types))){
		$_REQUEST["size"] = 255;
	}
	
	$query = "INSERT INTO `anyInventory_fields` (`name`,`input_type`,`values`,`default_value`,`size`,`categories`) VALUES ('".$_REQUEST["name"]."','".$_REQUEST["input_type"]."','".$_REQUEST["values"]."','".$_REQUEST["default_value"]."','".$_REQUEST["size"]."','0')";
	$result = query($query);
	
	$query = "ALTER TABLE `anyInventory_items` ADD `".$_REQUEST["name"]."`";
	
	switch($_REQUEST["input_type"]){
		case 'text':
		case 'multiple':
			if ($_REQUEST["size"] < 256){
				$query .= " VARCHAR(".$_REQUEST["size"].") DEFAULT '".$_REQUEST["default_value"]."' ";
			}
			else{
				$query .= " TEXT ";
			}
			break;
		case 'radio':
		case 'checkbox':
		case 'select':
			$query .= " ENUM(";
			
			$enums = explode(",",$_REQUEST["values"]);
			
			foreach($enums as $enum){
				$query .= $enum.",";
			}
			
			$query = substr($query, 0, strlen($query) - 1);
			
			$query .= ") DEFAULT '".$_REQUEST["default_value"]."' ";
			break;
	}
	
	$query .= " NOT NULL";
	$result = query($query);
	
	header("Location: ".$_SERVER["PHP_SELF"]);
}
elseif($_REQUEST["action"] == "delete_field"){
	$field = new field($_REQUEST["field"]);
	
	$query = "ALTER TABLE `anyInventory_items` DROP `".$field->name."`";
	$result = query($query);
	
	$query = "DELETE FROM `anyInventory_fields` WHERE `id`='".$field->id."'";
	$result = query($query);
	
	header("Location: ".$_SERVER["PHP_SELF"]);
}

$output = '
	<html>
		<head>
			<link rel="stylesheet" type="text/css" href="style.css" />
		</head>
		<body>
			<form method="post" action="'.$_SERVER["PHP_SELF"].'" enctype="multipart/form-data">
				<h2>Add Field</h2>
				<input type="hidden" name="action" value="add_field" />
				<table>
					<tr>
						<td class="form_label"><label for="name">Name:</label></td>
						<td class="form_input"><input type="text" name="name" id="name" value="" /></td>
					</tr>
					<tr>
						<td class="form_label"><label for="name">Data type:</label></td>
						<td class="form_input">
							<select name="input_type" id="input_type"">
								<option value="text">Text</option>
								<option value="select">Select Box</option>
								<option value="multiple">Multiple (Select + Text)</option>
								<option value="checkbox">Checkboxes</option>
								<option value="radio">Radio Buttons</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="form_label"><label for="values">Values:</label><br /><small>Only for data types \'Multiple\',\'Select Box\',\'Checkboxes\', and \'Radio Buttons\'.  Separate with commas.</small></td>
						<td class="form_input"><input type="text" name="values" id="values" value="" /></td>
					</tr>
					<tr>
						<td class="form_label"><label for="default_value">Default value:</label></td>
						<td class="form_input"><input type="text" name="default_value" id="default_value" value="" /></td>
					</tr>
					<tr>
						<td class="form_label"><label for="size">Size, in characters:</label><br /><small>Only for data types \'Multiple\' and \'Text\'.</small></td>
						<td class="form_input"><input type="text" name="size" id="size" value="" /></td>
					</tr>
					<tr>
						<td class="form_label">&nbsp;</td>
						<td class="form_input"><input type="submit" name="submit" id="submit" value="Submit" /></td>
					</tr>
				</table>
			</form>
			<form method="post" action="'.$_SERVER["PHP_SELF"].'" enctype="multipart/form-data">
				<h2>Delete Field</h2>
				<input type="hidden" name="action" value="delete_field" />
				<table>
					<tr>
						<td class="form_label"><label for="field">Field:</label></td>
						<td class="form_input">
							<select name="field" id="field">';

$query = "SELECT * FROM `anyInventory_fields` WHERE 1 ORDER BY `name` ASC";
$result = query($query);

while ($row = fetch_array($result)){
	$output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
}

$output .= '				</select>
						</td>
					</tr>
					<tr>
						<td class="form_label">&nbsp;</td>
						<td class="form_input"><input type="submit" name="submit" id="submit" value="Delete" /></td>
					</tr>
				</table>
			</form>
		</body>
	</html>';

echo $output;
exit;

?>