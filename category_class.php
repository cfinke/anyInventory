<?php

error_reporting(E_ALL ^ E_NOTICE);

class category {
	var $id;
	
	var $name;
	
	var $parent;
	var $children = array();
	var $num_children = 0;
	
	var $breadcrumbs = array();
	var $breadcrumb_names;
	
	var $field_ids = array();
	var $field_names = array();
	
	function category($cat_id){
		$this->id = $cat_id;
		
		if ($this->id != 0){
			$query = "SELECT * FROM `anyInventory_categories` WHERE `id`='".$this->id."'";
			$result = query($query);
			$row = mysql_fetch_array($result);
			
			$this->name = $row["name"];
			$this->parent_id = $row["parent"];
			
			$parent_id = $this->id;
			
			while ($parent_id != 0){
				$this->breadcrumbs[] = $parent_id;
				
				$parent_id = $this->find_parent_id($parent_id);
			}
			
			$this->breadcrumbs[] = 0;
			
			$this->breadcrumbs = array_reverse($this->breadcrumbs);
			
			foreach($this->breadcrumbs as $crumb){
				if ($crumb == 0){
					$this->breadcrumb_names .= "Top > ";
				}
				else{
					$query  = "SELECT `name` FROM `anyInventory_categories` WHERE `id`='".$crumb."'";
					$result = query($query);
					
					$this->breadcrumb_names .= mysql_result($result, 0, 'name') . ' > ';
				}
			}
			
			$this->breadcrumb_names = substr($this->breadcrumb_names, 0, strlen($this->breadcrumb_names) - 3);
			
			$query = "SELECT `id`,`name` FROM `anyInventory_fields` WHERE `categories` LIKE '%,".$this->id.",%' OR `categories` LIKE '%,".$this->id."' ORDER BY `importance` ASC";
			$result = query($query);
			
			while ($row = mysql_fetch_array($result)){
				$this->field_ids[] = $row["id"];
				$this->field_names[] = $row["name"];
			}
		}
		else{
			$this->name = "Top Level";
			$this->parent_id = 0;
			
			$query = "SELECT `id`,`name` FROM `anyInventory_fields` ORDER BY `importance`";
			$result = query($query);
			
			$this->breadcrumbs[] = 0;
			$this->breadcrumb_names[] = "Top";
			
			while ($row = mysql_fetch_array($result)){
				$this->field_ids[] = $row["id"];
				$this->field_names[] = $row["name"];
			}
		}
		
		$query = "SELECT * FROM `anyInventory_categories` WHERE `parent` = '".$this->id."'";
		$result = query($query);
		
		while($row = mysql_fetch_array($result)){
			$this->children[] = new category($row["id"]);
			$this->num_children++;
		}
	}
	
	function num_items(){
		$query = "SELECT `id` FROM `anyInventory_items` WHERE `item_category`='".$this->id."'";
		$result = query($query);
		
		return mysql_num_rows($result);
	}
	
	function num_items_r(){
		$total = $this->num_items();
		
		if (is_array($this->children)){
			foreach($this->children as $child){
				$total += $child->num_items_r();
			}
		}
		
		return $total;
	}
	
	function find_parent_id($cat_id){
		if ($cat_id == 0){
			return 0;
		}
		else{
			$query = "SELECT `parent` FROM `anyInventory_categories` WHERE `id`='".$cat_id."'";
			$result = query($query);
			
			if (mysql_num_rows($result) == 0){
				return 0;
			}
			else{
				return mysql_result($result, 0, 'parent');
			}
		}
	}
	
	function get_breadcrumb_links(){
		foreach($this->breadcrumbs as $id){
			if($id == 0){
				$breadcrumbs .= '<a href="'.$_SERVER["PHP_SELF"].'?c=0">Top</a> &gt; ';
			}
			else{
				$crumb = new category($id);
				
				if ($crumb->id)
				$breadcrumbs .= '<a href="'.$_SERVER["PHP_SELF"].'?c='.$crumb->id.'">'.$crumb->name.'</a> &gt; ';
			}
		}
		
		$breadcrumbs = substr($breadcrumbs, 0, strlen($breadcrumbs) - 6);
		
		return $breadcrumbs;
	}
}

?>