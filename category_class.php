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
			$query = "SELECT " . $db->quoteIdentifier('name') . "," . $db->quoteIdentifier('parent') . "," . $db->quoteIdentifier('auto_inc_field') . " FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('id') . "='".$this->id."'";
			$result = $db->query($query);
            if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
            
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
						$query  = "SELECT " . $db->quoteIdentifier('name') . " FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('id') . "='".$crumb."'";
						$result = $db->query($query);
                		if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
						
						$this->breadcrumb_names .= $row["name"] . ' > ';
					}
				}
			}
			
			$this->breadcrumb_names = substr($this->breadcrumb_names, 0, strlen($this->breadcrumb_names) - 3);
			
			// Get all of the fields that this category uses.
			$query = "SELECT " . $db->quoteIdentifier('id') . "," . $db->quoteIdentifier('name') . " FROM " . $db->quoteIdentifier('anyInventory_fields') . " WHERE " . $db->quoteIdentifier('categories') . " LIKE '%\"".$this->id."\"%' OR " . $db->quoteIdentifier('input_type') . "='divider'  ORDER BY " . $db->quoteIdentifier('importance') . " ASC";
			$result = $db->query($query);
			if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
			
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
			$query = "SELECT " . $db->quoteIdentifier('id') . "," . $db->quoteIdentifier('name') . " FROM " . $db->quoteIdentifier('anyInventory_fields') . " WHERE " . $db->quoteIdentifier('categories') . " LIKE '%0%' OR " . $db->quoteIdentifier('input_type') . "='divider' ORDER BY " . $db->quoteIdentifier('importance') . "";
			$result = $db->query($query); 
            if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
			
			// Add each field id and name to the arrays.
			while ($row = $result->fetchRow()){
				$this->field_ids[] = $row["id"];
				$this->field_names[] = $row["name"];
			}
		}
		
		// Find the children of the current category
		$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('parent') . " = '".$this->id."' ORDER BY " . $db->quoteIdentifier('name') . " ASC";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		while($row = $result->fetchRow()){
			$this->children_ids[] = $row["id"];
			$this->num_children++;
		}
		
		$this->get_all_subcats($this->all_children_ids);
	}
	
	// This function returns the number of items that are inventoried in this category.
	
	function num_items(){
		global $db;
		
		$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_items') . " WHERE " . $db->quoteIdentifier('item_category') . "='".$this->id."'";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
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
			$query = "SELECT " . $db->quoteIdentifier('parent') . " FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('id') . "='".$cat_id."'";
			$result = $db->query($query);
			if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
			
			// If there is no parent, then, the parent is the Top Level.
			if ($result->numRows() == 0){
				return 0;
			}
			else{
				$row = $result->fetchRow();
				return $row['parent'];
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
	
	function export_table_header($sortfid = 0, $sort_dir = "DESC"){
		$output .= '<tr class="tableHeader">';
		
		if ($this->auto_inc_field){
			$output .= '<td>&nbsp;</td>';
		}
		
		$output .= '<td style="white-space: nowrap;"><nobr>'.NAME_FIELD_NAME.'</nobr></td>';
		
		if (is_array($this->field_ids)){
			foreach($this->field_ids as $fid){
				$field = new field($fid);
				
				if (($field->input_type != 'divider') && ($field->input_type != 'file') && ($field->input_type != 'item')){
					if ($sortfid == $field->id){
						$dir = ($sort_dir == "DESC") ? "ASC" : "DESC";
					}
					else{
						$dir = "DESC";
					}
					
					$output .= '<td style="white-space: nowrap;"><nobr><a href="'.$_SERVER["PHP_SELF"].'?c='.$this->id.'&amp;fid='.$field->id.'&amp;dir='.$dir.'">'.$field->name.'</a></nobr></td>';
				}
			}
		}
		
		$output .= '</tr>';
		
		return $output;
	}
	
	function move_subcats($parent_id = 0){
		$query = "UPDATE " . $db->quoteIdentifier('anyInventory_categories') . " SET " . $db->quoteIdentifier('parent') . "='".$parent_id."' WHERE " . $db->quoteIdentifier('parent') . "='".$this->id."'";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	}
	
	function move_items($cat_id = null){
		global $db;
		if ($cat_id == null){
			$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_items') . " WHERE " . $db->quoteIdentifier('item_category') . "='".$this->id."'";
			$result = $db->query($query);
			if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
			
			while ($row = $result->fetchRow()){
				$item = new item($row["id"]);
				$item->delete_self();
			}
		}
		else{
			$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_items') . " WHERE " . $db->quoteIdentifier('item_category') . "='".$category->id."'";
			$result = $db->query($query);
			if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
			
			while($row = $result->fetchRow()){
				$newquery = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_alerts') . " WHERE " . $db->quoteIdentifier('item_ids') . " LIKE '%\"".$row["id"]."\"%' AND " . $db->quoteIdentifier('category_ids') . " NOT LIKE '%\"".$cat_id."\"%' GROUP BY " . $db->quoteIdentifier('id') . "";
				$newresult = $db->query($newquery);
				if(DB::isError($newresult)) die($newresult->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $newquery);
				
				while ($newrow = $newresult->fetchRow()){
					$alert = new alert($newrow["id"]);
					$alert->remove_item($row["id"]);
				}
			}
			
			$query = "UPDATE " . $db->quoteIdentifier('anyInventory_items') . " SET " . $db->quoteIdentifier('item_category') . "='".$cat_id."' WHERE " . $db->quoteIdentifier('item_category') . "='".$this->id."'";
			$result = $db->query($query);
			if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		}
	}
	
	function delete_self(){
		global $admin_user;
		global $db;
		
		if (!$admin_user->can_admin($_POST["id"])){
			header("Location: ../error_handler.php?eid=13");
			exit;
		}
		else{
			// Delete the category
			$query = "DELETE FROM " . $db->quoteIdentifier('anyInventory_categories') . " WHERE " . $db->quoteIdentifier('id') . "='".$this->id."'"; 
			$result = $db->query($query);
			if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
			
			// Remove all of the fields from this category.
			if (is_array($this->field_ids)){
				foreach($this->field_ids as $field_id){
					$field = new field($field_id);
					$field->remove_category($this->id);
				}
			}
			
			$query = "SELECT " . $db->quoteIdentifier('id') . " FROM " . $db->quoteIdentifier('anyInventory_alerts') . " WHERE " . $db->quoteIdentifier('category_ids') . " LIKE '%\"".$this->id."\"%'";
			$result = $db->query($query);
			if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
			
			while ($row = $result->fetchRow()){
				$alert = new alert($row["id"]);
				$alert->remove_category($this->id);
			}
		}
	}
	
	function delete_subcats(){
		if ($this->num_children > 0){
			foreach($this->children_ids as $child_id){
				$child = new category($child_id);
				$child->delete_subcats();
			}
		}
		else{
			$this->move_items();
			$this->delete_self();
		}
	}
}

?>
