<?php

include("globals.php");

$title = "anyInventory: Add Item";

if (!isset($_REQUEST["c"])){
	$output = '
		<form method="get" action="add_item.php">
			<table>
				<tr>
					<td class="form_label"><label for="c">Add Item to:</label></td>
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
else{
	$category = new category($_REQUEST["c"]);
	
	$output = '
			<form method="post" action="item_processor.php" enctype="multipart/form-data">
				<h2>Add an Item to '.$category->get_breadcrumb_links().'</h2>
				<input type="hidden" name="action" value="do_add" />
				<input type="hidden" name="id" value="'.$_REQUEST["id"].'" />
				<input type="hidden" name="c" value="'.$_REQUEST["c"].'" />
				<table>
					<tr>
						<td class="form_label"><label for="name">Name:</label></td>
						<td class="form_input"><input type="text" name="name" id="name" value="" maxlength="64" />
					</tr>';
	
	foreach($category->field_ids as $field_id){
		
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
					$output .= '>'.$value.'</option>';
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
	
	
	$output .= '
					<tr>
						<td class="form_label">File:</td>
						<td class="form_input"><input type="file" name="file" id="file" /></td>
					</tr>
					<tr>
						<td class="form_label">&nbsp;</td>
						<td class="form_input"><input type="submit" name="submit" id="submit" value="Submit" /></td>
					</tr>
				</table>
			</form>';
}

display($output);

?>