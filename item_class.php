<?php

error_reporting(E_ALL ^ E_NOTICE);

class item {
	var $id;					// The id of the item, matches up with id field in anyInventory_items
	
	var $category;				// A category object of the category to which this item belongs.
	
	var $name;					// The name of this item.
	var $fields = array();		// An associative array, keyed by the field name, consisting of the field values.
	var $files = array();		// An array of file objects that belong to this item.
	
	function item($item_id){
		global $db;
		
		// Set the item id.
		$this->id = $item_id;
		
		// Get the information about this item.
		$query = "SELECT * FROM `anyInventory_items` WHERE `id` = ?";
		$query_data = array($this->id);
		$pquery = $db->prepare($query);
		$result = $db->execute($pquery, $query_data);
		
		$row = $result->fetchRow();
		
		// Set the item name.
		$this->name = $row["name"];
		
		// Create the category object.
		$this->category = new category($row["item_category"]);
		
		$query = "SELECT * FROM `anyInventory_values` WHERE `item_id` = ?";
		$query_data = array($this->id);
		$pquery = $db->prepare($query);
		$result = $db->execute($pquery, $query_data);
		
		while($row = $result->fetchRow()){
			$field = new field($row["field_id"]);
			
			if ($field->input_type == 'file'){
				$this->fields[$field->name] = array("is_file"=>true,"file_id"=>$row["value"]);
			}
			elseif($field->input_type == 'item'){
				$this->fields[$field->name] = unserialize($row["value"]);
			}
			elseif($field->input_type == 'divider'){
				$this->fields[$field->name] = array("is_divider"=>true);
			}
			elseif ($field->input_type != "checkbox"){
				$this->fields[$field->name] = $row["value"];
			}
			else{
				if (strstr($row["value"],",") !== false){
					$this->fields[$field->name] = explode(",",$row["value"]);
					if (is_array($this->fields[$field->name])){
						foreach($this->fields[$field->name] as $key => $value){
							$this->fields[$field->name][$key] = trim($value);
						}
					}
				}
			}
		}
		
		// Get each of this item's files and add it to the array.
		$query = "SELECT `id` FROM `anyInventory_files` WHERE `key` = ?";
		$query_data = array($this->id);
		$pquery = $db->prepare($query);
		$result = $db->execute($pquery, $query_data);
		
		while ($row = $result->fetchRow()){
			$this->files[] = new file_object($row["id"]);
		}
	}
	
	// This function returns a "teaser" or short description and link for the item.
	
	function export_teaser(){
		global $DIR_PREFIX;
		
		$output .= '<b>'.$this->name.'</b> ';
		
		if(is_array($this->fields)){
			$output .= '<span class="snippet">';
			foreach($this->fields as $key => $value){
				if (!is_array($value) && (trim($value) != '')){
					$output .= '<b>'.$key.':</b> '.$value.', ';
				}
			}
			$output = rtrim($output, ", ");
			$output .= '</span>';
		}
		
		// Limit the "teaser" to 135 chars; if it's larger, truncate it with "..."
		if(strlen($output) > 135) {
			$output = substr($output,0,132)."...";
		}
		
		$output = '<a href="'.$DIR_PREFIX.'index.php?c='.$this->category->id.'&amp;id='.$this->id.'" style="text-decoration: none;">'.$output.'</a>';
		
		return $output;
	}
	
	// This function returns a full description of the item.
	
	function export_description(){
		global $db;
		global $DIR_PREFIX;
		global $admin_user;
		
		// Create the header with the name.
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>'.$this->name;
		
		if($admin_user->can_admin($this->category->id)){
			$output .= ' ( <a href="'.$DIR_PREFIX.'admin/move_item.php?id='.$this->id.'">'.MOVE.'</a> | <a href="'.$DIR_PREFIX.'admin/edit_item.php?id='.$this->id.'">'.EDIT.'</a> | <a href="'.$DIR_PREFIX.'admin/delete_item.php?id='.$this->id.'">'._DELETE.'</a> )';
		}
		
		$output .= '		
					</td>
				</tr>
				<tr>
					<td class="tableData">
						<table cellspacing="0" cellpadding="3">';
		
		if ($this->category->auto_inc_field){
			$output .= '
				<tr class="highlighted_field">
					<td style="width: 5%;">
						&nbsp;
					</td>
					<td style="text-align: right; width: 10%; white-space: nowrap;"><nobr><b>'.AUTO_INC_FIELD_NAME.':</b></nobr></td>
					<td style="width: 85%;"></b> '.$this->id.'</td>
				</tr>';
		}
		
		// Output each field with its value.
		if (is_array($this->category->field_ids)){
			foreach($this->category->field_ids as $field_id){
				$field = new field($field_id);
				
				if ($field->input_type == "file"){
					if ($this->fields[$field->name]["file_id"] > 0){
						$output .= '
							<tr';
						
						if ($field->highlight){
							$output .= ' class="highlighted_field"';
						}
						
						$output .= '>
								<td>&nbsp;</td>
								<td style="white-space: nowrap; text-align: right;"><b>'.$field->name.':</b></td>
								<td>';
						
						$file = new file_object($this->fields[$field->name]["file_id"]);
						
						if ($file->is_image()){
							$output .= '<a href="'.$file->web_path.'"><img src="';
							if ($file->has_thumbnail()) $output .= $DIR_PREFIX.'thumbnail.php?id='.$file->id;
							else $output .= $DIR_PREFIX."item_files/no_thumb.gif";
							
							$output .= '" class="thumbnail" /></a>';
						}
						else{
							$output .= $file->get_download_link();
						}
						
						$output .= '
								</td>
							</tr>';
					}
					
					$last_divider = false;
				}
				elseif($field->input_type == 'item'){
					if (is_array($this->fields[$field->name]) && (count($this->fields[$field->name]) > 0)){
						$output .= '
							<tr';
						
						if ($field->highlight){
							$output .= ' class="highlighted_field"';
						}
						
						$output .= '>
							<td>&nbsp;</td>
							<td style="white-space: nowrap; text-align: right;"><b>'.$field->name.':</b></td>
							<td>';
						
						foreach($this->fields[$field->name] as $item_id){
							$item = new item($item_id);
							$output .= $item->export_teaser() . '<br />';
						}
						
						$output .= '
								</td>
							</tr>';
						
						$last_divider = false;
					}
				}
				elseif($field->input_type == 'divider'){
					if (!$last_divider)	$output .= '<tr><td colspan="3"><hr /></td></tr>';
					$last_divider = true;
				}
				elseif(is_array($this->fields[$field->name]) && (count($this->fields[$field->name]) > 0)){
					$output .= '<tr';
					
					if ($field->highlight){
						$output .= ' class="highlighted_field"';
					}
					
					$output .= '><td>&nbsp;</td><td><b>'.$field->name.':</b></td><td> ';
					
					foreach($this->fields[$field->name] as $val){
						$output .= $val.", ";
					}
					
					$output = substr($output, 0, strlen($output) - 2) . '</td></tr>';
					
					$last_divider = false;
				}
				elseif (trim(strip_tags($this->fields[$field->name])) != ""){
					$output .= '
						<tr';
					
					if ($field->highlight){
						$output .= ' class="highlighted_field"';
					}
					
					$output .= '>
							<td style="width: 5%;">
								<a href="'.$DIR_PREFIX.'label_processor.php?i='.$this->id.'&amp;f='.$key.'" style="color: #000000;">'.LABEL.'</a>
							</td>
							<td style="text-align: right; width: 10%; white-space: nowrap;"><nobr><b>'.$field->name.'</b>:</nobr></td>
							<td style="width: 85%;">'.$this->fields[$field->name].'</td>
						</tr>';
					
					$last_divider = false;
				}
			}
			
			$query = "SELECT `id` FROM `anyInventory_fields` WHERE `input_type` = ?";
			$query_data = array('item');
			$pquery = $db->prepare($query);
			$result = $db->execute($pquery, $query_data);
			
			while ($row = $result->fetchRow()){
				$query2 = "SELECT `item_id` FROM `anyInventory_values` WHERE `value` LIKE ?";
				$query2_data = array('%"'.$this->id.'"%');
				$pquery2 = $db->prepare($query2);
				$result2 = $db->execute($pquery2, $query2_data);
				
				while ($row2 = $result2->fetchRow()){
					$backlinks[] = $row2["id"];
				}
			}
			
			if (is_array($backlinks)){
				if (!$last_divider){
					$output .= '<tr><td colspan="3"><hr /></td></tr>';
					$last_divider = true;
				}
				
				$output .= '
					<tr>
						<td>&nbsp;</td>
						<td style="text-align: right; width: 10%; white-space: nowrap;"><nobr><b>'.RELATED_ITEMS.':</b></nobr></td>
						<td>';
				
				foreach($backlinks as $item_id){
					$item = new item($item_id);
					
					$output .= $item->export_teaser().'<br />';
				}
				
				$output .= '</td>
						</tr>';
			}
			
			$output .= '
							</table>
						</td>
					</tr>
				</table>';
		}
		
		return $output;
	}
}

?>
