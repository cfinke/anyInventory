<?php

require_once("globals.php");

$title = EDIT_ITEM;
$inHead = '
	<script type="text/javascript">
	   _editor_url = "../htmlarea/";
	   _editor_lang = "'.LANG.'";
	</script>
	<script type="text/javascript" src="../htmlarea/htmlarea.js"></script>';
$inBodyTag = ' onload="HTMLArea.replaceAll();"';
$breadcrumbs = ADMINISTRATION.' > <a href="items.php">'.ITEMS.'</a> > '.EDIT_ITEM;

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
					<td>'.EDIT_ITEM.'</td>
					<td style="text-align: right;">[<a href="../docs/editing_items.php">'.HELP.'</a>]</td>
				</tr>
				<tr>
					<td class="tableData" colspan="2">
						<table cellspacing="0" cellpadding="2">
							<tr>
								<td class="form_label"><label for="name">'.NAME_FIELD_NAME.':</label></td>
								<td class="form_input"><input type="text" name="name" id="name" value="'.htmlspecialchars($item->name, ENT_QUOTES).'" maxlength="64" />
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
					$output .= '<input type="text" id="'.htmlspecialchars(str_replace(" ","_",$field->name), ENT_QUOTES).'_text" name="'.str_replace(" ","_",$field->name).'_text" maxlength="'.$field->size.'" value="'.$item->fields[$field->name].'" />';
					$output .= '<select name="'.htmlspecialchars(str_replace(" ","_",$field->name), ENT_QUOTES).'_select" id="'.str_replace(" ","_",$field->name).'_select">';
					$output .= '<option value="">Select One</option>';
					
					if (is_array($field->values)){
						foreach($field->values as $value){
							$output .= '<option value="'.htmlspecialchars($value, ENT_QUOTES).'"';
							if ($value == $item->fields[$field->name]) $output .= ' selected="selected"';
							$output .= ' onclick="document.getElementById(\''.str_replace(" ","_",$field->name).'_text\').value = \''.$value.'\';">'.$value.'</option>';
						}
					}
					
					$output .= '</select>';
					
					break;
				case 'select':
					$output .= '<select name="'.str_replace(" ","_",$field->name).'" id="'.htmlspecialchars(str_replace(" ","_",$field->name), ENT_QUOTES).'">';
					
					if (is_array($field->values)){
						foreach($field->values as $value){
							$output .= '<option value="'.htmlspecialchars($value, ENT_QUOTES).'"';
							if ($value == $item->fields[$field->name]) $output .= ' selected="selected"';
							$output .= '>'.$value.'</option>';
						}
					}
					
					break;
				case 'text':
					if ($field->size <= 255) $output .= '<input type="text" name="'.htmlspecialchars(str_replace(" ","_",$field->name), ENT_QUOTES).'" id="'.htmlspecialchars(str_replace(" ","_",$field->name), ENT_QUOTES).'" maxlength="'.$field->size.'" value="'.htmlspecialchars($item->fields[$field->name], ENT_QUOTES).'" />';
					else $output .= '<textarea rows="8" cols="40" name="'.htmlspecialchars(str_replace(" ","_",$field->name), ENT_QUOTES).'" id="'.htmlspecialchars(str_replace(" ","_",$field->name), ENT_QUOTES).'" style="width: 100%;">'.$item->fields[$field->name].'</textarea>';
					break;
				case 'radio':
					if (is_array($field->values)){
						foreach($field->values as $value){
							$output .= '<input type="radio" name="'.htmlspecialchars(str_replace(" ","_",$field->name), ENT_QUOTES).'" value="'.htmlspecialchars(str_replace(" ","_",$value), ENT_QUOTES).'"';
							if ($value == $item->fields[$field->name]) $output .= ' checked="checked"';
							$output .= ' /> '.$value.'<br />';
						}
					}
					
					break;
				case 'checkbox':
					if (is_array($field->values)){
						foreach($field->values as $value){
							$output .= '<input type="checkbox" name="'.htmlspecialchars(str_replace(" ","_",$field->name), ENT_QUOTES).'['.$value.']" value="yes"';
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
					
					$output .= '<input type="file" name="'.htmlspecialchars(str_replace(" ","_",$field->name), ENT_QUOTES).'" id="'.htmlspecialchars(str_replace(" ","_",$field->name), ENT_QUOTES).'" /> or <input type="text" name="'.htmlspecialchars(str_replace(" ","_",$field->name), ENT_QUOTES).'remote" id="'.htmlspecialchars(str_replace(" ","_",$field->name), ENT_QUOTES).'remote" value="http://" />';
					break;
				case 'item':
					$output .= '<select name="'.htmlspecialchars(str_replace(" ","_",$field->name), ENT_QUOTES).'[]" id="'.htmlspecialchars(str_replace(" ","_",$field->name), ENT_QUOTES).'[]" style="width: 100%;" multiple="multiple" size="10">';
					
					if (is_array($view_user->categories_view)){
						foreach($view_user->categories_view as $cat_id){
							$category = new category($cat_id);
							
							$options = get_item_options($cat_id, $item->fields[$field->name], $item->id, false);
							
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
								<td class="submitButtonRow" colspan="2"><input type="submit" name="submit" id="submit" value="'.SUBMIT.'" /> <input type="submit" name="cancel" value="'.CANCEL.'" /></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>';

display($output);

?>
