<?php

class category {
	var $id;						// The id in the database anyInventory_categories for this category
	
	var $name;						// The name of this category
	
	var $parent_id;					// The id in the database anyInventory_categories for this category's parent
	var $children_ids = array();	// An array of category ids that are children of this category
	var $num_children = 0;			// The number of children this category has.  (Counts children only throught the first generation.)
	
	var $all_children_ids = array();
	
	var $breadcrumbs = array();		// An array of the parents of this category, starting at 0, the top level.
	var $breadcrumb_names;			// A breadcrumb style string of $this->breadcrumbs, ie. Top > Books > Fiction
	
	var $field_ids = array();		// An array of all of the ids (found in anyInventory_fields) of the fields that this category uses.
	var $field_names = array();		// An array of the field names that matches up with the ids found in $this->field_ids.
	
	var $auto_inc_field = false;
	
	function category($cat_id){
		global $db;
		
		// Set the id of this category.
		$this->id = $cat_id;
		
		// Separate the actions for the Top Level category and the other categories
		if ($this->id != 0){
			// Not the Top Level
			
			// Get all of the information about this category from the categories table.
			$query = "SELECT `name`,`parent`,`auto_inc_field` FROM `anyInventory_categories` WHERE `id`= ?";
			$query_data = array($this->id);
			$pquery = $db->prepare($query);
			$result = $db->execute($pquery, $query_data);
			$row = $result->fetchRow();
			
			// Set the name and parent id
			$this->name = $row["name"];
			$this->parent_id = $row["parent"];
			$this->auto_inc_field = $row["auto_inc_field"];
			
			// Begin setting the breadcrumbs of this category.
			
			// Set the parent id to this category's id
			$parent_id = $this->id;
			
			// As long as the parent is not the Top Level, set another breadcrumb
			while ($parent_id != 0){
				// Add the parent id to the breadcrumbs
				$this->breadcrumbs[] = $parent_id;
				
				// Set the parent id to the parent of the current parent id
				$parent_id = $this->find_parent_id($parent_id);
			}
			
			// Add the top level to the breadcrumbs.
			$this->breadcrumbs[] = 0;
			
			// Reverse the breadcrumbs so that the Top Level is at the beginning
			$this->breadcrumbs = array_reverse($this->breadcrumbs);
			
			// Set the breadcrumb names from $this->breadcrumbs
			if (is_array($this->breadcrumbs)){
				foreach($this->breadcrumbs as $crumb){
					if ($crumb == 0){
						// The Top Level category
						$this->breadcrumb_names .= TOP_LEVEL_CATEGORY.' > ';
					}
					else{
						// Find the name of the current category
						$query  = "SELECT `name` FROM `anyInventory_categories` WHERE `id`= ?";
						$query_data = array($crumb);
						$pquery = $db->prepare($query);
						$result = $db->execute($pquery, $query_data);
						$row = $result->fetchRow();
						$this->breadcrumb_names .= $row["name"] . ' > ';
					}
				}
			}
			
			// Cut off the last three characters from the breadcrumbs string
			$this->breadcrumb_names = substr($this->breadcrumb_names, 0, strlen($this->breadcrumb_names) - 3);
			
			// Get all of the fields that this category uses.
			$query = "SELECT `id`,`name` FROM `anyInventory_fields` WHERE `categories` LIKE ? OR `input_type`= ? ORDER BY `importance` ASC";
			$query_data = array('%"'.$this->id.'"%', 'divider');
			$pquery = $db->prepare($query);
			$result = $db->execute($pquery, $query_data);
			
			// Add each field's id and name to the appropriate arrays.
			while ($row = $result->fetchRow()){
				$this->field_ids[] = $row["id"];
				$this->field_names[] = $row["name"];
			}
		}
		else{
			// Top Level category
			$this->name = TOP_LEVEL_CATEGORY;
			$this->parent_id = 0;
			
			// Set the breadcrumbs and breadcrumbs names
			$this->breadcrumbs[] = 0;
			$this->breadcrumb_names = TOP_LEVEL_CATEGORY;
			
			// Get the fields that the Top Level uses.
			$query = "SELECT `id`,`name` FROM `anyInventory_fields` WHERE `categories` LIKE ?  OR `input_type`= ? ORDER BY `importance`";
			$query_data = array('%"0"%','divider');
			$pquery = $db->prepare($query);
			$result = $db->execute($pquery, $query_data);
			
			// Add each field id and name to the arrays.
			while ($row = $result->fetchRow()){
				$this->field_ids[] = $row["id"];
				$this->field_names[] = $row["name"];
			}
		}
		
		// Find the children of the current category
		$query = "SELECT `id` FROM `anyInventory_categories` WHERE `parent` = ? ORDER BY `name` ASC";
		$query_data = array($this->id);
		$pquery = $db->prepare($query);
		$result = $db->execute($pquery, $query_data); 
		
		if (DB::isError($result)) {
		    die($result->getMessage());
		}
		
		while($row = $result->fetchRow()){
			$this->children_ids[] = $row["id"];
			$this->num_children++;
		}
		
		$this->get_all_subcats($this->all_children_ids);
	}
	
	// This function returns the number of items that are inventoried in this category.
	
	function num_items(){
		global $db;
		
		$query = "SELECT `id` FROM `anyInventory_items` WHERE `item_category`= ?";
		$query_data = array($this->id);
		$pquery = $db->prepare($query);
		$result = $db->execute($pquery, $query_data);
		
		return $result->numRows();
	}
	
	// This function returns the number of items that are inventoried in this category AND its subcategories.
	
	function num_items_r(){
		// First, start with the number of items in this category.
		$total = $this->num_items();
		
		if (is_array($this->children_ids)){
			// For each child, call this function on it.
			foreach($this->children_ids as $child_id){
				$child = new category($child_id);
				$total += $child->num_items_r();
			}
		}
		
		return $total;
	}
	
	function get_all_subcats(&$subcats){
		if ($this->num_children > 0){
			foreach($this->children_ids as $child_id){	
				$subcats[] = $child_id;
				
				$child = new category($child_id);
				
				$child->get_all_subcats($subcats);
			}
		}
		
		sort($subcats);
	}
	
	// This function returns the parent id of a given category id.
	
	function find_parent_id($cat_id){
		global $db;
		
		if ($cat_id == 0){
			// The Top Level is its own category.
			return 0;
		}
		else{
			// Get the parent from the categories table.
			$query = "SELECT `parent` FROM `anyInventory_categories` WHERE `id` = ?";
			$query_data = array($cat_id);
			$pquery = $db->prepare($query);
			$result = $db->execute($pquery, $query_data);
			
			// If there is no parent, then, the parent is the Top Level.
			if ($result->numRows() == 0){
				return 0;
			}
			else{
				$resultrows = $result->fetchRow();
				return $resultrows['parent'];
			}
		}
	}
	
	// This function returns the breadcrumbs_names string with links for each category.
	
	function get_breadcrumb_links(){
		global $DIR_PREFIX;
		
		// For each id in the breadcrumbs, add the link and separator.
		if (is_array($this->breadcrumbs)){
			foreach($this->breadcrumbs as $id){
				if($id == 0){
					$breadcrumbs .= '<a href="'.$_SERVER["PHP_SELF"].'?c=0">'.TOP_LEVEL_CATEGORY.'</a> &gt; ';
				}
				else{
					$crumb = new category($id);
					
					if ($crumb->id)
					$breadcrumbs .= '<a href="'.$DIR_PREFIX.'index.php?c='.$crumb->id.'">'.$crumb->name.'</a> &gt; ';
				}
			}
		}
		
		// Remove the last 6 characters from the string.
		$breadcrumbs = substr($breadcrumbs, 0, strlen($breadcrumbs) - 6);
		
		return $breadcrumbs;
	}
	
	function get_breadcrumb_admin_links(){
		global $DIR_PREFIX;
		
		// For each id in the breadcrumbs, add the link and separator.
		if (is_array($this->breadcrumbs)){
			foreach($this->breadcrumbs as $id){
				if($id == 0){
					$breadcrumbs .=  TOP_LEVEL_CATEGORY .' &gt; ';
				}
				else{
					$crumb = new category($id);
					
					if ($crumb->id)
					$breadcrumbs .= '<a href="'.$DIR_PREFIX.'admin/edit_category.php?id='.$crumb->id.'">'.$crumb->name.'</a> &gt; ';
				}
			}
		}
		
		// Remove the last 6 characters from the string.
		$breadcrumbs = substr($breadcrumbs, 0, strlen($breadcrumbs) - 6);
		
		return $breadcrumbs;
	}
}

?>
