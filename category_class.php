<?php

error_reporting(E_ALL ^ E_NOTICE);

class category {
	var $id;
	
	var $name;
	
	var $parent;
	var $children;
	
	var $breadcrumbs;
	var $breadcrumb_names;
	
	var $fields;
	
	function category($cat_id){
		$this->id = $cat_id;
		
		$query = "SELECT * FROM `anyInventory_categories` WHERE `id`='".$this->id."'";
		$result = query($query);
		$row = fetch_array($result);
		
		$this->name = $row["name"];
		$this->parent_id = $row["parent"];
		
		$query = "SELECT * FROM `anyInventory_categories` WHERE `parent` = '".$this->id."'";
		$result = query($query);
		
		while($row = fetch_array($result)){
			$this->children[] = new category($row["id"]);
		}
		
		$this->breadcrumbs[] = $this->id;
		
		while ($parent != 0){
			$this->breadcrumbs[] = $parent;
			
			$parent = $this->find_parent($parent);
		}
		
		$this->breadcrumbs = array_reverse($this->breadcrumbs);
		
		foreach($this->breadcrumbs as $crumb){
			$query  = "SELECT `name` FROM `anyInventory_categories` WHERE `id`='".$crumb."'";
			$result = query($query);
			
			$this->breadcrumb_names .= result($result, 0, 'name') . ' > ';
		}
		
		$this->breadcrumb_names = substr($this->breadcrumb_names, 0, strlen($this->breadcrumb_names) - 3);
		
		$query = "SELECT `id`,`name` FROM `anyInventory_fields` WHERE `categories` LIKE '%,".$this->id.",' OR `categories` LIKE '%,".$this->id."'";
		$result = query($query);
		
		while ($row = fetch_array($result)){
			$this->fields[] = $row;
		}
	}
	
	function num_items(){
		$query = "SELECT `id` FROM `anyInventory_items` WHERE `category`='".$this->id."'";
		$result = query($query);
		
		return num_rows($result);
	}
	
	function num_items_r(){
		$total = $this->num_items();
		
		if (is_array($this->children)){
			foreach($this->children as $child){
				$total += $child->num_items();
			}
		}
		
		return $total;
	}
	
	function find_parent_id($cat_id){
		$query = "SELECT `parent` FROM `anyInventory_categories` WHERE `id`='".$cat_id."'";
		$result = query($query);
		
		if (num_rows($result) == 0){
			return 0;
		}
		else{
			return result($result, 0, 'parent');
		}
	}
}

?>