<?php

include("globals.php");

$title = "anyInventory: Edit Item";
$inHead = '
	<script type="text/javascript">
	   _editor_url = "../htmlarea/";
	   _editor_lang = "en";
	</script>
	<script type="text/javascript" src="../htmlarea/htmlarea.js"></script>';
$inBodyTag = ' onload="HTMLArea.replaceAll();"';
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
								<td class="form_label"><label for="name">'.NAME_FIELD_NAME.':</label></td>
								<td class="form_input"><input type="text" name="name" id="name" value="'.$item->name.'" maxlength="64" />
							</tr>';

if (is_array($item->category->field_ids)){
	foreach($item->category->field_ids as $field_id){
		
		$field = new field($field_id);
		
		if (!$last_divider && ($field->input_type == 'divider')){
			$output .= '<tr><td colspan="2"><hr /></td></tr>';
			$last_divider = true;
		}
		else{
			$last_divider = false;
			
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
					else $output .= '<textarea rows="8" cols="40" name="'.str_replace(" ","_",$field->name).'" id="'.str_replace(" ","_",$field->name).'" style="width: 100%;">'.$item->fields[$field->name].'</textarea>';
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
					break;
				case 'item':
					$output .= '<select name="'.str_replace(" ","_",$field->name).'[]" id="'.str_replace(" ","_",$field->name).'[]" style="width: 100%;" multiple="multiple" size="10">';
					
					if (is_array($view_user->categories_view)){
						foreach($view_user->categories_view as $cat_id){
							$category = new category($cat_id);
							
							$options = get_item_options($cat_id, $item->fields[$field->name]);
							
							if ($options != ''){
								$output .= '<optgroup label="'.$category->breadcrumb_names.'">';
								$output .= $options;
								$output .= '</optgroup>';
							}
						}
					}
					 
					$output .= '</select>';
					break;
			}
			
			$output .= '</td>
				</tr>';
		}
	}
}

$output .= '
							<tr>
								<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="'.SUBMIT.'" /></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>';

display($output);

?>