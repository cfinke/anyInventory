<?php

include("globals.php");

$title = "anyInventory: Search";

// The default category is the Top Level.
if (!isset($_REQUEST["c"])) $_REQUEST["c"] = array(0);

if (!$_REQUEST["action"]){
	$breadcrumbs = "Search";
	
	$output .= '
		<table class="standardTable" cellspacing="0">
			<tr class="tableHeader">
				<td>Search</td>
				<td style="text-align: right;">[<a href="docs/searching.php">Help</a>]</a></td>
			</tr>
			<tr>
				<td class="tableData" colspan="2">
					<table>
						<form action="'.$_SERVER["PHP_SELF"].'" method="get">
							<tr>
								<td class="form_label">Limit search to:</td>
								<td>
									<select name="c[]" id="c[]" multiple="multiple" size="10" style="width: 100%;">
										'.get_category_options($_REQUEST["c"]).'
									</select>
								</td>
							</tr>
							<tr>
								<td class="form_label">&nbsp;</td>
								<td class="form_input" style="text-align: center;"><input type="submit" name="submit" value="Update Categories" class="submitButton" /></td>
							</tr>
						</form>
						</tr>
						<form action="'.$_SERVER["PHP_SELF"].'" method="get">
							<input type="hidden" name="action" value="search" />
							<input type="hidden" name="c" value="'.htmlentities(serialize($_REQUEST["c"])).'" />
							<tr>
								<td class="form_label"><label for="name">Name:</label></td>
								<td class="form_input"><input type="text" name="name" id="name" value="'.$item->name.'" maxlength="64" style="width: 100%;" />
							</tr>';
	
	// Get each field and output a search field for it.
	$query = "SELECT `id` FROM `anyInventory_fields` ORDER BY `name`";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	while($row = mysql_fetch_array($result)){
		$field = new field($row["id"]);
		
		if ($field->input_type != 'file'){
			if (is_array($_REQUEST["c"])){
				foreach($_REQUEST["c"] as $cat){
					if (in_array($cat, $field->categories)){
						$output .= '
							<tr>
								<td class="form_label"><label for="'.str_replace(" ","_",$field->name).'">'.$field->name.':</label></td>
								<td class="form_input">';
						
						switch($field->input_type){
							case 'multiple':
								$output .= '<input type="text" id="'.str_replace(" ","_",$field->name).'_text" name="'.str_replace(" ","_",$field->name).'_text" maxlength="'.$field->size.'" value="" />';
								$output .= '<select name="'.str_replace(" ","_",$field->name).'_select" id="'.str_replace(" ","_",$field->name).'_select">';
								$output .= '<option value="">Select one</option>';
								
								if (is_array($field->values)){
									foreach($field->values as $value){
										$output .= '<option value="'.$value.'" onclick="document.getElementById(\''.str_replace(" ","_",$field->name).'_text\').value = \''.$value.'\';">'.$value.'</option>';
									}
								}
								
								$output .= '<input type="text" name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'" maxlength="'.$field->size.'" value="" />';
								break;
							case 'select':
								$output .= '<select name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'">
									<option value="">Select one</option>';
								
								if (is_array($field->values)){
									foreach($field->values as $value){
										$output .= '<option value="'.$value.'">'.$value.'</option>';
									}
								}
								
								break;
							case 'text':
								$output .= '<input type="text" name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'" maxlength="'.$field->size.'" value="" style="width: 100%;" />';
								break;
							case 'radio':
								if (is_array($field->values)){
									foreach($field->values as $value){
										$output .= '<input type="radio" name="'.str_replace(" ","_",$field->name).'" value="'.str_replace(" ","_",$value).'" /> '.$value.'<br />';
									}
								}
								
								break;
							case 'checkbox':
								if (is_array($field->values)){
									foreach($field->values as $value){
										$output .= '<input type="checkbox" name="'.str_replace(" ","_",$field->name).'['.$value.']" value="yes" /> '.$value.'<br />';
									}
								}
								
								break;
						}
						
						$output .= '</td>
							</tr>';
						
						break;
					}
				}
			}
		}
	}
	
	$output .= '		
						<tr>
							<td class="form_label">&nbsp;</td>
							<td class="form_input" style="text-align: center;"><input type="submit" name="submit" id="submit" value="Search" class="submitButton" /></td>
						</tr>
					</form>
				</td>
			</tr>
		</table>';
}
else{
	$breadcrumbs = "Search Results";
	
	$query = "SELECT `name` FROM `anyInventory_fields`";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	while ($row = mysql_fetch_array($result)){
		$fields[] = $row["name"];
	}
	
	$query = "SELECT `id`,`item_category` FROM `anyInventory_items` WHERE 1 ";
	
	if ($_REQUEST["name"] != ''){
		$name_parts = explode(" ",$_REQUEST["name"]);
		$query .= " AND (";
		
		if (is_array($name_parts)){
			foreach($name_parts as $name_part){
				$query .= " (`name` LIKE '%".$name_part."%') AND ";
			}
		}
		
		$query = substr($query, 0, strlen($query) - 5) . ") ";
	}
	
	if (is_array($_REQUEST)){
		foreach($_REQUEST as $key => $value){
			if ((trim($value) != '') && in_array(str_replace("_"," ",$key), $fields)){
				if (is_array($value)){
					foreach($value as $key1 => $val){
						$query .= " AND `".str_replace("_"," ",$key)."` LIKE '%".$key1."%' ";
					}
				}
				else{
					$query .= " AND `".str_replace("_"," ",$key)."` LIKE '%".$value."%' ";
				}
			}
			elseif((trim($value) != '') && (in_array(str_replace("_"," ",str_replace("_text","",$key)), $fields))){
				$query .= " AND `".str_replace("_"," ",str_replace("_text","",$key))."` LIKE '%".$value."%' ";
			}
		}
	}
	
	$query .= " ORDER BY `item_category`,`Name`";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	$cat_id = -1;
	
	$_REQUEST["c"] = unserialize(stripslashes($_REQUEST["c"]));
	
	$output .= '<table class="standardTable" cellspacing="0">';
	
	if (mysql_num_rows($result) > 0){
		while($row = mysql_fetch_array($result)){
			$item = new item($row["id"]);
			
			if (in_array($row["item_category"], $_REQUEST["c"])){
				if ($cat_id != $row["item_category"]){
					$cat_id = $row["item_category"];
					$output .= '
						<tr class="tableHeader">
							<td>In '.$item->category->get_breadcrumb_links().'</td></tr><tr><td class="tableData">';
				}
				
				$output .= '<tr><td>'.$item->export_teaser().'</td></tr>';
			}
		}
	}
	else{
		$output .= '<tr class="tableHeader"><td>No matching results</td></tr><tr><td class="tableData">There were no items that matched your search conditions.</td></tr>';
	}
	
	$output .= '</table>';
}

display($output);

?>