<?php

error_reporting(E_ALL ^ E_NOTICE);

class field {
	var $id;
	
	var $name;
	var $input_type;
	var $values = array();
	var $default_value;
	var $size;
	var $categories = array();
	
	function field($field_id){
		$this->id = $field_id;
		
		$query = "SELECT * FROM `anyInventory_fields` WHERE `id`='".$this->id."'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		
		$this->name = $row["name"];
		$this->input_type = $row["input_type"];
		$this->values = explode(",",$row["values"]);
		$this->clean_values();
		$this->default_value = $row["default_value"];
		$this->size = ($row["size"] > 0) ? $row["size"] : '';
		$this->categories = explode(",",$row["categories"]);
		$this->clean_categories();
	}
	
	function clean_values(){
		if (is_array($this->values)){
			foreach($this->values as $key => $value){
				$this->values[$key] = trim($value);
			}
		}
	}
	
	function clean_categories(){
		if (is_array($this->categories)){
			foreach($this->categories as $key => $value){
				$this->categories[$key] = trim($value);
			}
		}
	}
	
	function remove_category($cat_id){
		$key = array_search($cat_id, $this->categories);
		
		if ($key) unset($this->categories[$key]);
		
		$this->refresh_categories($this->categories);
	}
	
	function add_category($cat_id){
		$this->categories[] = $cat_id;
		
		array_unique($this->categories);
		sort($this->categories);
		
		$this->refresh_categories($this->categories);
	}
	
	function refresh_categories($cat_ids){
		if (is_array($cat_ids)){
			$query = "UPDATE `anyInventory_fields` SET `categories`='";
			
			foreach($cat_ids as $cat_id){
				if ($cat_id != ''){
					$query .= $cat_id.",";
				}
			}
			
			$query .= "' WHERE `id`='".$this->id."'";
			$result = query($query);
		}
		
		return;
	}
}

?>