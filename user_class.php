<?php

class user {
	var $id;							// The id of this user
	
	var $username;						// This user's username
	
	var $usertype;						// Either 'Administrator' or 'User'
	
	var $categories_view = array();		// The category ids of the categories that this user can view.
	var $categories_admin = array();	// The category ids of the categories that this user can administrate
	
	function user($user_id){
		global $db;
		
		$this->id = $user_id;
		
		$query = "SELECT * FROM " . $db->quoteIdentifier('anyInventory_users') . " WHERE " . $db->quoteIdentifier('id') . " = ?";
		$query_data = array($this->id);
		$pquery = $db->prepare($query);
		$result = $db->execute($pquery, $query_data);
		if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
		
		$row = $result->fetchRow();
		
		$this->username = $row["username"];
		$this->usertype = $row["usertype"];
		
		if ($this->usertype == 'Administrator'){
			$this->categories_view = get_category_id_array();
			$this->categories_admin = get_category_id_array();
		}
		else{
			$categories_view = unserialize($row["categories_view"]);
			$categories_admin = unserialize($row["categories_admin"]);
			
			$this->categories_view = (is_array($categories_view)) ? $categories_view : array();
			$this->categories_admin = (is_array($categories_admin)) ? $categories_admin : array();
		}
	}
	
	function can_view($cat_id){
		return (($cat_id == 0) || ($this->usertype == 'Administrator') || in_array($cat_id, $this->categories_view));
	}
	
	function can_admin($cat_id){
		if (($cat_id == 0) && ($this->usertype != 'Administrator')){
			return false;
		}
		else{
			return (($this->usertype == 'Administrator') || in_array($cat_id, $this->categories_admin));
		}
	}
	
	function can_admin_alert($alert_id){
		$alert = new alert($alert_id);
		
		if (is_array($alert->category_ids)){
			foreach($alert->category_ids as $cat_id){
				if (!$this->can_admin($cat_id)){
					return false;
				}
			}
			
			return true;
		}
		else{
			return true;
		}
	}
	
	function can_admin_field($field_id){
		$field = new field($field_id);
		
		if (is_array($field->categories)){
			foreach($field->categories as $cat_id){
				if (!$this->can_admin($cat_id)){
					return false;
				}
			}
			
			return true;
		}
		else{
			return true;
		}
	}
	
	function get_admin_categories_options($selected = null, $multiple = true, $exclude = null){
		if ($this->usertype == 'Administrator'){
			return get_category_options($selected, $multiple, $exclude);
		}
		else{
			return category_array_to_options($this->categories_admin, $selected, $exclude);
		}
	}
	
	function get_view_categories_options(){
		if ($this->usertype == 'Administrator'){
			return get_category_options($selected);
		}
		else{
			return category_array_to_options($this->categories_view, $selected);
		}
	}
	
	function add_category_view($category_id){
		global $db;
		
		if ($this->usertype != 'Administrator'){
			$this->categories_view[] = $category_id;
			
			$query = "UPDATE " . $db->quoteIdentifier('anyInventory_users') . " SET " . $db->quoteIdentifier('categories_view') . " = ? WHERE " . $db->quoteIdentifier('id') . "= ?";
			#$query_data = array(addslashes(serialize($this->categories_view)),$this->id);
			$query_data = array(serialize($this->categories_view),$this->id);
			$pquery = $db->prepare($query);
			$result = $db->execute($pquery, $query_data);
			if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
		}
	}
	
	function add_category_admin($category_id){
		global $db;
		
		if ($this->usertype != 'Administrator'){
			$this->categories_admin[] = $category_id;
			
			$query = "UPDATE " . $db->quoteIdentifier('anyInventory_users') . " SET " . $db->quoteIdentifier('categories_admin') . " = ? WHERE " . $db->quoteIdentifier('id') . " = ?";
			#$query_data = array(addslashes(serialize($this->categories_admin)),$this->id);
			$query_data = array(serialize($this->categories_admin),$this->id);
			$pquery = $db->prepare($query);
			$result = $db->execute($pquery, $query_data);
			if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
		}
	}
	
	function remove_category_view($category_id){
		global $db;
		
		if ($this->usertype != 'Administrator'){
			$key = array_search($category_id, $this->categories_view);
			
			if ($key!==FALSE){
				unset($this->categories_view[$key]);
				
				$this->categories_view = array_unique($this->categories_view);
				
				$query = "UPDATE " . $db->quoteIdentifier('anyInventory_users') . " SET " . $db->quoteIdentifier('categories_view') . " = ? WHERE " . $db->quoteIdentifier('id') . " = ?";
				#$query_data = array(addslashes(serialize($this->categories_view)), $this->id);
				$query_data = array(serialize($this->categories_view), $this->id);
				$pquery = $db->prepare($query);
				$result = $db->execute($pquery, $query_data);
				if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
			}
		}
	}
	
	function remove_category_admin($category_id){
		global $db;
		
		if ($this->usertype != 'Administrator'){
			$key = array_search($category_id, $this->categories_admin);
			
			if ($key!==FALSE){
				unset($this->categories_admin[$key]);
				
				$this->categories_admin = array_unique($this->categories_admin);
				
				$query = "UPDATE " . $db->quoteIdentifier('anyInventory_users') . " SET " . $db->quoteIdentifier('categories_admin') . " = ? WHERE " . $db->quoteIdentifier('id') . " = ?";
				#$query_data = array(addslashes(serialize($this->categories_admin)), $this->id);
				$query_data = array(serialize($this->categories_admin), $this->id);
				$pquery = $db->prepare($query);
				$result = $db->execute($pquery, $query_data);
				if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
			}
		}
	}
	
	function update_categories_view($category_ids){
		global $db;
		
		$this->categories_view = $category_ids;
		
		$query = "UPDATE " . $db->quoteIdentifier('anyInventory_users') . " SET " . $db->quoteIdentifier('categories_view') . " = ? WHERE " . $db->quoteIdentifier('id') . " = ?";
		$query_data = array(addslashes(serialize($this->categories_view)), $this->id);
		$pquery = $db->prepare($query);
		$result = $db->execute($pquery, $query_data);
		if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	}
	
	function update_categories_admin($category_ids){
		global $db;
		
		$this->categories_admin = $category_ids;
		
		$query = "UPDATE " . $db->quoteIdentifier('anyInventory_users') . " SET " . $db->quoteIdentifier('categories_admin') . " = ? WHERE " . $db->quoteIdentifier('id') . " = ?";
		$query_data = array(addslashes(serialize($this->categories_admin)), $this->id);
		$pquery = $db->prepare($query);
		$result = $db->execute($pquery, $query_data);
		if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	}
	
	function export_description(){
		$output .= '
			<table class="standardTable" cellspacing="0">
				<tr class="tableHeader">
					<td>'.$this->username.'</td>
				</tr>
				<tr>
					<td class="tableData">
						<table>
							<tr>
								<td class="form_label">'.USER_TYPE.':</td>
								<td class="form_input">'.$this->usertype.'</td>
							</tr>';
			
			if ($this->usertype == 'Administrator'){
				$output .= '<tr>
								<td class="form_label">'.CAN_VIEW.':</td>
								<td class="form_input">'.ALL.'</td>
							</tr>
							<tr>
								<td class="form_label">'.CAN_ADMIN.':</td>
								<td class="form_input">'.ALL.'</td>
							</tr>';
			}
			else{
				if (is_array($this->categories_view)){
					$output .= '
								<tr>
									<td class="form_label">'.CAN_VIEW.':</td>
									<td class="form_input">';
					
					foreach($this->categories_view as $cat_id){
						$category = new category($cat_id);
						
						$output .= $category->breadcrumb_names . '<br />';
					}
					
					$output .= '
									</td>
								</tr>';
				}
				
				if (is_array($this->categories_view)){
					$output .= '
								<tr>
									<td class="form_label">'.CAN_ADMIN.':</td>
									<td class="form_input">';
					
					foreach($this->categories_admin as $cat_id){
						$category = new category($cat_id);
						
						$output .= $category->breadcrumb_names . '<br />';
					}
					
					$output .= '
									</td>
								</tr>';
				}
			}
			
			$output .= '
						</table>
					</tr>
				</table>';
		
		return $output;
	}
}

?>
