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
				
				if ($field->input_type != "checkbox"){
					$this->fields[$field->name] = $row[$field->name];
				}
				else{
					if (strstr($row[$field->name],",") !== false){
						$this->fields[$field->name] = explode(",",$row[$field->name]);
						foreach($this->fields[$field->name] as $key => $value){
							$this->fields[$field->name][$key] = trim($value);
						}
					}
				}
			}
		}
		
		// Get each of this item's files and add it to the array.
		$query = "SELECT * FROM `anyInventory_files` WHERE `key`='".$this->id."'";
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
			$output .= '<table style="width: 100%;"><tr><td style="width: 50%; vertical-align: top;">';
			$i = 0;
			foreach($this->fields as $key => $value){
			if (is_array($value)){
					if (count($value) > 0){
						$output .= '<p><b>'.$key.':</b> ';
						
						foreach($value as $val){
							$output .= $val.", ";
						}
						
						$output = substr($output, 0, strlen($output) - 2);
						if ($i++ == floor((count($this->fields) - $num_empty_fields)/ 2)) $output .= '</td><td style="width: 50%;">';
					}
				}
				elseif (trim($value) != ""){
					$output .= '<p><b>'.$key.':</b> '.$value.'</p>';
					if ($i++ == floor((count($this->fields) - $num_empty_fields)/ 2)) $output .= '</td><td style="width: 50%;">';
				}
			}
			$output .= '</td></tr></table>';
		}
		
		// Output a preview of each file.
		if (is_array($this->files) && (count($this->files) > 0)){
			foreach($this->files as $file){
				if ($file->is_image()){
					$images[] = $file;
				}
				else{
					$files[] = $file;
				}
			}
			
			$i = 1;
			
			if (is_array($images) && (count($images) > 0)){
				$output .= '<h2>Images</h2>';
				foreach($images as $image){
					$output .= '<a href="'.$image->web_path.'"><img src="';
					if ($image->has_thumbnail()) $output .= $DIR_PREFIX.'thumbnail.php?id='.$image->id;
					else $output .= "item_files/no_thumb.gif";
					
					$output .= '" class="thumbnail" /></a>';
					if ($i++ % 4 == 0)$output .= '<br style="clear: both;" />';
				}
			}
			
			if (is_array($files) && (count($files) > 0)){
				$output .= '<br style="clear: both;" />
				<h2>Related Files</h2>';
				
				foreach($files as $file){
					$output .= $file->get_download_link().'<br />';
				}
			}
			
		}
		
		return $output;
	}
	
	// This function returns the number of fields that have empty values.
	
	function count_empty_fields(){
		foreach($this->fields as $key => $value){
			if (trim($value) == ''){
				$count++;
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