<?php

class item {
	var $id;
	
	var $category;
	
	var $name;
	var $fields = array();
	var $files = array();
	
	function item($item_id){
		$this->id = $item_id;
		
		$query = "SELECT * FROM `anyInventory_items` WHERE `id`='".$this->id."'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		
		$this->name = $row["name"];
		
		$this->category = new category($row["item_category"]);
		
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
		
		$query = "SELECT * FROM `anyInventory_files` WHERE `key`='".$this->id."'";
		$result = query($query);
		
		while ($row = mysql_fetch_array($result)){
			$this->files[] = new file_object($row["id"]);
		}
	}
	
	function export_teaser(){
		global $DIR_PREFIX;
		
		$output .= '<p><a href="'.$DIR_PREFIX.'index.php?c='.$this->category->id.'&amp;id='.$this->id.'">'.$this->name.'</a></p>';
		return $output;
	}
	
	function export_description(){
		global $DIR_PREFIX;
		
		$output .= '<h2>'.$this->name.'</h2>';
		
		$num_empty_fields = $this->count_empty_fields();
		
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
		
		if (is_array($this->files) && (count($this->files) > 0)){
			foreach($this->files as $file){
				if ($file->has_thumbnail()){
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
					$output .= '<a href="'.$image->web_path.'"><img src="'.$DIR_PREFIX.'thumbnail.php?id='.$image->id.'" class="thumbnail" /></a>';
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
	
	function count_empty_fields(){
		foreach($this->fields as $key => $value){
			if (trim($value) == ''){
				$count++;
			}
		}
		
		return $count;
	}
}

?>