<?php

class item {
	var $id;
	
	var $category;
	
	var $name;
	var $fields = array();
	
	function item($item_id){
		$this->id = $item_id;
		
		$query = "SELECT * FROM `anyInventory_items` WHERE `id`='".$this->id."'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		
		$this->name = $row["name"];
		
		$this->category = new category($row["item_category"]);
		
		if (is_array($this->category->field_names)){
			foreach($this->category->field_names as $field_name){
				$this->fields[$field_name] = $row[$field_name];
			}
		}
	}
	
	function export_teaser(){
		$output .= '<p><a href="index.php?c='.$this->category->id.'&amp;id='.$this->id.'">'.$this->name.'</a></p>';
		return $output;
	}
	
	function export_description(){
		$output .= '<h2>'.$this->name.'</h2>';
		
		foreach($this->fields as $key => $value){
			if (trim($value) != ""){
				$output .= '<p><b>'.$key.':</b> '.$value.'</p>';
			}
		}
		
		return $output;
	}
}

?>