<?php

error_reporting(E_ALL ^ E_NOTICE);

class item {
	var $id;				// The id of the item, matches up with id field in anyInventory_items
	
	var $category;			// A category object of the category to which this item belongs.
	
	var $name;				// The name of this item.
	var $fields = array();	// An associative array, keyed by the field name, consisting of the field values.
	var $files = array();	// An array of file objects that belong to this item.
	
	function item($item_id){
		// Set the item id.
		$this->id = $item_id;
		
		// Get the information about this item.
		$query = "SELECT * FROM `anyInventory_items` WHERE `id`='".$this->id."'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		
		// Set the item name.
		$this->name = $row["name"];
		
		// Create the category object.
		$this->category = new category($row["item_category"]);
		
		// Add each field and its value to the array.
		if (is_array($this->category->field_ids)){
			foreach($this->category->field_ids as $field_id){
				$field = new field($field_id);
				
				if ($field->input_type == 'file'){
					$this->fields[$field->name] = array("is_file"=>true,"file_id"=>$row[$field->name]);
				}
				elseif ($field->input_type != "checkbox"){
					$this->fields[$field->name] = $row[$field->name];
				}
				else{
					if (strstr($row[$field->name],",") !== false){
						$this->fields[$field->name] = explode(",",$row[$field->name]);
						if (is_array($this->fields[$field->name])){
							foreach($this->fields[$field->name] as $key => $value){
								$this->fields[$field->name][$key] = trim($value);
							}
						}
					}
				}
			}
		}
		
		// Get each of this item's files and add it to the array.
		$query = "SELECT `id` FROM `anyInventory_files` WHERE `key`='".$this->id."'";
		$result = query($query);
		
		while ($row = mysql_fetch_array($result)){
			$this->files[] = new file_object($row["id"]);
		}
	}
	
	// This function returns a "teaser" or short description and link for the item.
	
	function export_teaser(){
		global $DIR_PREFIX;
		
		$output .= '<a href="'.$DIR_PREFIX.'index.php?c='.$this->category->id.'&amp;id='.$this->id.'">'.$this->name.'</a>';
		return $output;
	}
	
	// This function returns a full description of the item.
	
	function export_description(){
		global $DIR_PREFIX;
		
		// Create the header with the name.
		$output .= '<h2>'.$this->name.'</h2>';
		
		// Get the number of fields that have no value.
		$num_empty_fields = $this->count_empty_fields();
		
		// Output each field with its value.
		if (is_array($this->fields) && ((count($this->fields) - $num_empty_fields) > 0)){
			$output .= '
				<table style="width: 100%; margin: 0px; padding: 0px;">
					<tr>
						<td style="width: 50%; vertical-align: top;">';
			
			$i = 0;
			foreach($this->fields as $key => $value){
				if (is_array($value)){
					if ($value["is_file"] == true){
						if ($value["file_id"] > 0){
							$output .= '<p><b>'.$key.':</b> ';
							
							$file = new file_object($value["file_id"]);
							
							if ($file->is_image()){
								$output .= '<a href="'.$file->web_path.'"><img src="';
								if ($file->has_thumbnail()) $output .= $DIR_PREFIX.'thumbnail.php?id='.$file->id;
								else $output .= "item_files/no_thumb.gif";
								
								$output .= '" class="thumbnail" /></a><br style="clear: both;" />';
							}
							else{
								$output .= $file->get_download_link();
							}
						}
					}
					elseif (count($value) > 0){
						$output .= '<p><b>'.$key.':</b> ';
						
						foreach($value as $val){
							$output .= $val.", ";
						}
						
						$output = substr($output, 0, strlen($output) - 2);
						if ($i++ == floor((count($this->fields) - $num_empty_fields)/ 2)) $output .= '</td><td style="width: 50%;">';
					}
				}
				elseif (trim($value) != ""){
					$output .= '<p><b><a href="label_processor.php?i='.$this->id.'&amp;f='.$key.'" style="color: #000000;" title="Create a barcode label for the '.$key.' field">'.$key.'</a>:</b> '.$value.'</p>';
					if ($i++ == floor((count($this->fields) - $num_empty_fields)/ 2)) $output .= '</td><td style="width: 50%;">';
				}
			}
			
			$output .= '
						</td>
					</tr>
				</table>';
		}
		
		return $output;
	}
	
	// This function returns the number of fields that have empty values.
	
	function count_empty_fields(){
		if (is_array($this->fields)){
			foreach($this->fields as $key => $value){
				if (trim($value) == ''){
					$count++;
				}
			}
		}
		
		return $count;
	}
	
	// This function returns true if the item is in a subcategory that is, or
	// is a child of, $cat_id.
	
	function in_or_below($cat_id){
		if (in_array($cat_id, $this->category->breadcrumbs)){
			return true;
		}
		else{
			return false;
		}
	}
}

?>