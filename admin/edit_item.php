<?php

include("globals.php");

$title = "anyInventory: Edit Item";
$breadcrumbs = 'Administration > <a href="items.php">Items</a> > Edit Item';

$item = new item($_GET["id"]);

if (!$admin_user->can_admin($item->category->id)){
	header("Location: ../error_handler.php?eid=13");
	exit;
}

$output = '
		<form method="post" action="item_processor.php" enctype="multipart/form-data">
			<input type="hidden" name="action" value="do_edit" />
			<input type="hidden" name="id" value="'.$_GET["id"].'" />
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>Edit an Item
					<td style="text-align: right;">[<a href="../docs/editing_items.php">Help</a>]</td>
				</tr>
				<tr>
					<td class="tableData" colspan="2">
						<table cellspacing="0" cellpadding="2">
							<tr>
								<td class="form_label"><label for="name">Name:</label></td>
								<td class="form_input"><input type="text" name="name" id="name" value="'.$item->name.'" maxlength="64" />
							</tr>';

if (is_array($item->category->field_ids)){
	foreach($item->category->field_ids as $field_id){
		
		$field = new field($field_id);
		
		if ($field->input_type == 'divider'){
			$output .= '<tr><td colspan="2"><hr /></td></tr>';
		}
		else{
			if ($field->highlight) $extra = ' class="highlighted_field"';
			else $extra = '';
			
			$output .= '
				<tr'.$extra.'>
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
				case 'file':
					if (is_array($item->fields[$field->name]) && ($item->fields[$field->name]["file_id"] > 0)){
						$file = new file_object($item->fields[$field->name]["file_id"]);
						$output .= '<input type="checkbox" name="delete_files[]" value="'.$file->id.'" /> Delete this file: '.$file->get_download_link().'';
						if ($file->has_thumbnail()) $output .= '<br /><img src="'.$DIR_PREFIX.'thumbnail.php?id='.$file->id.'" />';
						$output .= '<br /><br />Replace file: ';
					}
					
					$output .= '<input type="file" name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'" /> or <input type="text" name="'.str_replace(" ","_",$field->name).'remote" id="'.str_replace(" ","_",$field->name).'remote" value="http://" />';
			}
			
			$output .= '</td>
				</tr>';
		}
	}
}

$output .= '
							<tr>
								<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="Submit" /></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>';

display($output);

?>