<?php

include("globals.php");

$title = "anyInventory: Add Item";

if (!isset($_REQUEST["c"])){
	$output = '
		<form method="get" action="add_alert.php">
			<table>
				<tr>
					<td class="form_label"><label for="c">Add alert in:</label></td>
					<td class="form_input">
						<select name="c" id="c">
							'.get_category_options().'
						</select>
					</td>
				</tr>
				<tr>
					<td class="form_label">&nbsp;</td>
					<td class="form_input"><input type="submit" name="submit" id="submit" value="Submit" /></td>
				</tr>
			</table>
		</form>';
}
elseif(!isset($_REQUEST["i"])){
	$output = '
		<form method="get" action="add_alert.php">
			<input type="hidden" name="c" value="'.$_REQUEST["c"].'" />
			<table>
				<tr>
					<td class="form_label"><label for="c">Add alert to:</label></td>
					<td class="form_input">
						<select name="i" id="i">
							'.get_item_options($_REQUEST["c"]).'
						</select>
					</td>
				</tr>
				<tr>
					<td class="form_label">&nbsp;</td>
					<td class="form_input"><input type="submit" name="submit" id="submit" value="Submit" /></td>
				</tr>
			</table>
		</form>';
}
else{
	$item = new item($_REQUEST["i"]);
	
	$output = '
			<form method="post" action="alert_processor.php" enctype="multipart/form-data">
				<h2>Add an Alert to '.$item->name.'</h2>
				<input type="hidden" name="action" value="do_add" />
				<input type="hidden" name="i" value="'.$_REQUEST["id"].'" />
				<table>
					<tr>
						<td class="form_label"><label for="name">Alert Title:</label></td>
						<td class="form_input"><input type="text" name="title" id="title" value="" maxlength="255" />
					</tr>';
	/*
	foreach($item->category->field_ids as $field_id){
		
		$field = new field($field_id);
		
		$output .= '
			<tr>
				<td class="form_label"><label for="'.str_replace(" ","_",$field->name).'">'.$field->name.':</label></td>
				<td class="form_input">';
		
		switch($field->input_type){
			case 'multiple':
				$output .= '<input type="text" id="'.str_replace(" ","_",$field->name).'_text" name="'.str_replace(" ","_",$field->name).'_text" maxlength="'.$field->size.'" value="" />';
				$output .= '<select name="'.str_replace(" ","_",$field->name).'_select" id="'.str_replace(" ","_",$field->name).'_select">';
				foreach($field->values as $value){
					$output .= '<option value="'.$value.'"';
					if ($value == $field->default_value) $output .= ' selected="selected"';
					$output .= ' onclick="document.getElementById(\''.str_replace(" ","_",$field->name).'_text\').value = \''.$value.'\';">'.$value.'</option>';
				}
				$output .= '<input type="text" name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'" maxlength="'.$field->size.'" value="'.$field->default_value.'" />';
				break;
			case 'select':
				$output .= '<select name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'">';
				foreach($field->values as $value){
					$output .= '<option value="'.$value.'"';
					if ($value == $field->default_value) $output .= ' selected="selected"';
					$output .= '>'.$value.'</option>';
				}
				break;
			case 'text':
				if ($field->size <= 64) $output .= '<input type="text" name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'" maxlength="'.$field->size.'" value="'.$field->default_value.'" />';
				else $output .= '<textarea rows="8" cols="40" name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'">'.$field->default_value.'</textarea>';
				break;
			case 'radio':
				foreach($field->values as $value){
					$output .= '<input type="radio" name="'.str_replace(" ","_",$field->name).'" value="'.str_replace(" ","_",$value).'"';
					if ($value == $field->default_value) $output .= ' checked="checked"';
					$output .= ' /> '.$value.'<br />';
				}
				break;
			case 'checkbox':
				foreach($field->values as $value){
					$output .= '<input type="checkbox" name="'.str_replace(" ","_",$field->name).'['.$value.']" value="yes"';
					if ($value == $field->default_value) $output .= ' checked="checked"';
					$output .= ' /> '.$value.'<br />';
				}
				break;
		}
		
		$output .= '</td>
			</tr>';
	}
	*/
	
	$output .= '
					<tr>
						<td class="form_label">&nbsp;</td>
						<td class="form_input"><input type="submit" name="submit" id="submit" value="Submit" /></td>
					</tr>
				</table>
			</form>';
}

display($output);

?>