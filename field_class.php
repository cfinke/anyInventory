<?php

class field {
	var $id;
	
	var $name;
	var $input_type;
	var $values = array();
	var $size;
	var $categories = array();
	
	function field($field_id){
		$this->id = $field_id;
		
		$query = "SELECT * FROM `anyInventory_fields` WHERE `id`='".$this->id."'";
		$result = query($query);
		$row = fetch_array($result);
		
		$this->name = $row["name"];
		$this->input_type = $row["input_type"];
		$this->values = explode(",",$row["values"]);
		$this->size = $row["size"];
		$this->categories = explode(",",$row["categories"]);
	}
	
	function remove_category($cat_id){
		$key = array_search($cat_id, $this->categories);
		
		if ($key) unset($this->categories[$key]);
		
		refresh_categories($this->categories);
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
				$query .= $cat_id.",";
			}
			
			$query = substr($query,0,strlen($query) - 1);
			$query .= "' WHERE `id`='".$this->id."'";
			$result = query($query);
		}
		
		return;
	}
}

?>