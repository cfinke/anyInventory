<?php

class category{
	var $id;
	
	var $name;
	
	var $parent;
	var $children = array();
	
	var $breadcrumbs = array();
	
	var $fields;
	
	function category($cat_id){
		$this->id = $cat_id;
		
		$query = "SELECT * FROM `anyInventory_categories` WHERE `id`='".$this->id."'";
		$result = query($query);
		$row = fetch_array($result);
		
		$this->name = $row["name"];
		$this->parent = $row["parent"];
		
		$query = "SELECT * FROM `anyInventory_categories` WHERE `parent` = '".$this->id."'";
		$result = query($query);
		
		while($row = fetch_array($result)){
			$this->children[] = category($row["id"]);
		}
	}
	
	function num_items(){
		$query = "SELECT `id` FROM `anyInventory`.`items` WHERE `category`='".$this->id."'";
		$result = query($query);
		
		return num_rows($result);
	}
	
	function num_items_r(){
		return num_items();
	}
}

?>