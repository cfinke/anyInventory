<?php

error_reporting(E_ALL ^ E_NOTICE);

class field {
	var $id;					// The id of this field, matches up with id field in anyInventory_fields
	
	var $name;					// The name of this field.
	var $input_type;			// The input type of this field, can be one of: text, select, radio, checkbox, multiple
	var $values = array();		// The possible values for this field, doesn't apply to input type text
	var $default_value;			// The default value for this field, doesn't apply to input type text when size is greater than 255
	var $size;					// The size (number of characters allowed) of this field, only entered by the user for input type text
	var $categories = array();	// The ids of the categories that use this field
	
	function field($field_id){
		// Set the id of this field.
		$this->id = $field_id;
		
		// Get the information about this field.
		$query = "SELECT * FROM `anyInventory_fields` WHERE `id`='".$this->id."'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		
		// Set the name and input type
		$this->name = $row["name"];
		$this->input_type = $row["input_type"];
		
		// Set the values; the values are stored separated by commas
		$this->values = explode(",",$row["values"]);
		
		// Remove the whitespace from each value.
		$this->clean_values();
		
		// Set the default value
		$this->default_value = $row["default_value"];
		
		// If there is a size set, set it here. Otherwise, just keep an empty string. 
		$this->size = ($row["size"] > 0) ? $row["size"] : '';
		
		// Set the categories, which are also stores separated by commas
		$this->categories = explode(",",$row["categories"]);
		
		// Remove the whitespace from each category id
		$this->clean_categories();
	}
	
	// This function removes the whitespace from each value.
	
	function clean_values(){
		if (is_array($this->values)){
			foreach($this->values as $key => $value){
				$this->values[$key] = trim($value);
			}
		}
	}
	
	// This function removes the whitespace from each category id
	
	function clean_categories(){
		if (is_array($this->categories)){
			foreach($this->categories as $key => $value){
				$this->categories[$key] = trim($value);
			}
		}
	}
	
	// This function removes a field from a category.
	// ***It modifies the database, not just the object.***
	
	function remove_category($cat_id){
		// Find the key of the category id in the array.
		$key = array_search($cat_id, $this->categories);
		
		// If the category id is in the array, remove it.
		if ($key) unset($this->categories[$key]);
		
		// Synchronize with the DB.
		$this->refresh_categories($this->categories);
	}
	
	// This function adds a field to a category.
	// ***It modifies the database, not just the object.***
	
	function add_category($cat_id){
		// Add the category id to the array
		$this->categories[] = $cat_id;
		
		// Remove any duplicate values.
		array_unique($this->categories);
		
		// Sort the values in order.
		sort($this->categories);
		
		// Synchronize with the DB.
		$this->refresh_categories($this->categories);
	}
	
	// This function synchronizes the category list in the database with the category list in the object.
	
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