<?php

include("globals.php");

$title = "anyInventory: Search";

// The default category is the Top Level.
if (!isset($_REQUEST["c"])) $_REQUEST["c"] = array(0);

if (!$_REQUEST["action"]){
	$output .= '
			<table>
				<tr>
					<td valign="top" width="50%">
						<form action="'.$_SERVER["PHP_SELF"].'" method="get">
							<h2>Limit search to:</h2>
							<select name="c[]" id="c[]" multiple="multiple">
								'.get_category_options($_REQUEST["c"]).'
							</select>
							<p style="text-align: center;"><input type="submit" name="submit" value="Update" /></p>
						</form>
					</td>
					<td width="50%">
						<form action="'.$_SERVER["PHP_SELF"].'" method="get">
							<input type="hidden" name="action" value="do_edit" />
							<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
							<input type="hidden" name="c" value="'.htmlentities(serialize($_REQUEST["c"])).'" />
							<h2>Search</h2>
							<table>
								<tr>
									<td class="form_label"><label for="name">Name:</label></td>
									<td class="form_input"><input type="text" name="name" id="name" value="'.$item->name.'" maxlength="64" />
								</tr>';
	
	// Get each field and output a search field for it.
	$query = "SELECT `id` FROM `anyInventory_fields` ORDER BY `name`";
	$result = query($query);
	
	while($row = mysql_fetch_array($result)){
		$field = new field($row["id"]);
		
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
						foreach($field->values as $value){
							$output .= '<option value="'.$value.'" onclick="document.getElementById(\''.str_replace(" ","_",$field->name).'_text\').value = \''.$value.'\';">'.$value.'</option>';
						}
						$output .= '<input type="text" name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'" maxlength="'.$field->size.'" value="" />';
						break;
					case 'select':
						$output .= '<select name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'">
							<option value="">Select one</option>';
						foreach($field->values as $value){
							$output .= '<option value="'.$value.'">'.$value.'</option>';
						}
						break;
					case 'text':
						if ($field->size <= 64) $output .= '<input type="text" name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'" maxlength="'.$field->size.'" value="" />';
						else $output .= '<textarea rows="8" cols="20" name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'"></textarea>';
						break;
					case 'radio':
						foreach($field->values as $value){
							$output .= '<input type="radio" name="'.str_replace(" ","_",$field->name).'" value="'.str_replace(" ","_",$value).'" /> '.$value.'<br />';
						}
						break;
					case 'checkbox':
						foreach($field->values as $value){
							$output .= '<input type="checkbox" name="'.str_replace(" ","_",$field->name).'['.$value.']" value="yes" /> '.$value.'<br />';
						}
						break;
				}
				
				$output .= '</td>
					</tr>';
				
				break;
			}
		}
	}
	
	$output .= '		<tr>
							<td class="form_label">&nbsp;</td>
							<td class="form_input"><input type="submit" name="submit" id="submit" value="Search" /></td>
						</tr>
					</table>
					</form>
				</td>
			</tr>
		</table>';
}
else{
	$query = "SELECT `name` FROM `anyInventory_fields`";
	$result = query($query);
	
	while ($row = mysql_fetch_array($result)){
		$fields[] = $row["name"];
	}
	
	$output .= '<h2>Search Results</h2>';
	$query = "SELECT `id`,`item_category` FROM `anyInventory_items` WHERE 1 ";
	
	if ($_REQUEST["name"] != ''){
		$name_parts = explode(" ",$_REQUEST["name"]);
		$query .= " AND (";
		
		foreach($name_parts as $name_part){
			$query .= " (`name` LIKE '%".$name_part."%') AND ";
		}
		
		$query = substr($query, 0, strlen($query) - 5) . ") ";
	}
	
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
	
	$query .= " ORDER BY `item_category`,`Name`";
	$result = query($query);
	
	$cat_id = -1;
	
	$_REQUEST["c"] = unserialize(stripslashes($_REQUEST["c"]));
	
	if (mysql_num_rows($result) > 0){
		while($row = mysql_fetch_array($result)){
			$item = new item($row["id"]);
			
			if (in_array($row["item_category"], $_REQUEST["c"])){
				if ($cat_id != $row["item_category"]){
					if ($cat_id != -1){
						$output .= '<hr />';
					}
					
					$cat_id = $row["item_category"];
					$output .= '<p><b>In '.$item->category->get_breadcrumb_links().'</b></p>';
				}
				
				$output .= $item->export_teaser();
			}
		}
	}
	else{
		$output .= 'There were no items that matched your search conditions.';
	}
}

display($output);

?>