<?php

include("globals.php");

$title = "anyInventory: Edit Item";

$item = new item($_REQUEST["id"]);

$output = '
		<form method="post" action="item_processor.php" enctype="multipart/form-data">
		<table style="width: 100%;"><tr><td><h2>Edit an Item</h2></td><td style="text-align: right;"><a href="../docs/editing_items.php">Help with editing items</a></td></tr></table>
			<input type="hidden" name="action" value="do_edit" />
			<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
			<table>
				<tr>
					<td class="form_label"><label for="name">Name:</label></td>
					<td class="form_input"><input type="text" name="name" id="name" value="'.$item->name.'" maxlength="64" />
				</tr>';

if (is_array($item->category->field_ids)){
	foreach($item->category->field_ids as $field_id){
		
		$field = new field($field_id);
		
		$output .= '
			<tr>
				<td class="form_label"><label for="'.str_replace(" ","_",$field->name).'">'.$field->name.':</label></td>
				<td class="form_input">';
		
		switch($field->input_type){
			case 'multiple':
				$output .= '<input type="text" id="'.str_replace(" ","_",$field->name).'_text" name="'.str_replace(" ","_",$field->name).'_text" maxlength="'.$field->size.'" value="'.$item->fields[$field->name].'" />';
				$output .= '<select name="'.str_replace(" ","_",$field->name).'_select" id="'.str_replace(" ","_",$field->name).'_select">';
				$output .= '<option value="">Select One</option>';
				
				if (is_array($field->values)){
					foreach($field->values as $value){
						$output .= '<option value="'.$value.'"';
						if ($value == $item->fields[$field->name]) $output .= ' selected="selected"';
						$output .= ' onclick="document.getElementById(\''.str_replace(" ","_",$field->name).'_text\').value = \''.$value.'\';">'.$value.'</option>';
					}
				}
				
				$output .= '</select>';
				
				break;
			case 'select':
				$output .= '<select name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'">';
				
				if (is_array($field->values)){
					foreach($field->values as $value){
						$output .= '<option value="'.$value.'"';
						if ($value == $item->fields[$field->name]) $output .= ' selected="selected"';
						$output .= '>'.$value.'</option>';
					}
				}
				
				break;
			case 'text':
				if ($field->size <= 64) $output .= '<input type="text" name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'" maxlength="'.$field->size.'" value="'.$item->fields[$field->name].'" />';
				else $output .= '<textarea rows="8" cols="40" name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'">'.$item->fields[$field->name].'</textarea>';
				break;
			case 'radio':
				if (is_array($field->values)){
					foreach($field->values as $value){
						$output .= '<input type="radio" name="'.str_replace(" ","_",$field->name).'" value="'.str_replace(" ","_",$value).'"';
						if ($value == $item->fields[$field->name]) $output .= ' checked="checked"';
						$output .= ' /> '.$value.'<br />';
					}
				}
				
				break;
			case 'checkbox':
				if (is_array($field->values)){
					foreach($field->values as $value){
						$output .= '<input type="checkbox" name="'.str_replace(" ","_",$field->name).'['.$value.']" value="yes"';
						if ((is_array($item->fields[$field->name])) && in_array($value,$item->fields[$field->name])) $output .= ' checked="checked"';
						$output .= ' /> '.$value.'<br />';
					}
				}
				
				break;
		}
		
		$output .= '</td>
			</tr>';
	}
}

$query = "SELECT * FROM `anyInventory_files` WHERE `key`='".$_REQUEST["id"]."'";
$result = query($query);

if (is_array($item->files) && (count($item->files) > 0)){
	$output .= '
				<tr>
					<td class="form_label">Files:</td>
					<td class="form_input">';
	
	foreach($item->files as $file){
		$output .= '<p><input type="checkbox" name="delete_files[]" value="'.$file->id.'" /> Delete this file: '.$file->get_download_link().'';
		if ($file->has_thumbnail()) $output .= '<br /><img src="'.$DIR_PREFIX.'thumbnail.php?id='.$file->id.'" />';
		$output .= '</p>';
	}
	
	$output .= '</td></tr>';
}

$output .= '
				<tr>
					<td class="form_label">Upload Additional File:</td>
					<td class="form_input"><input type="file" name="file" id="file" /></td>
				</tr>
				<tr>
					<td class="form_label">Add Additional Remote File:</td>
					<td class="form_input"><input type="text" name="remote_file" id="remote_file" /></td>
				</tr>
				<tr>
					<td class="form_label">&nbsp;</td>
					<td class="form_input"><input type="submit" name="submit" id="submit" value="Submit" /></td>
				</tr>
			</table>
		</form>';

display($output);

?>