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
					$this->fields[$field->name] = explode(",",$row[$field->name]);
					foreach($this->fields[$field->name] as $key => $value){
						$this->fields[$field->name][$key] = trim($value);
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
		$output .= '<p><a href="index.php?c='.$this->category->id.'&amp;id='.$this->id.'">'.$this->name.'</a></p>';
		return $output;
	}
	
	function export_description(){
		$output .= '<h2>'.$this->name.'</h2>';
		
		foreach($this->fields as $key => $value){
			if (is_array($value)){
				if (count($value) > 0){
					$output .= '<p><b>'.$key.':</b> ';
					
					foreach($value as $val){
						$output .= $val.", ";
					}
					
					$output = substr($output, 0, strlen($output) - 2);
				}
			}
			elseif (trim($value) != ""){
				$output .= '<p><b>'.$key.':</b> '.$value.'</p>';
			}
		}
		
		return $output;
	}
}

?>