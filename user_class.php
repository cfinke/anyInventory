<?php

error_reporting(E_ALL ^ E_NOTICE);

class user {
	var $id;
	
	var $username;
	
	var $usertype;
	
	var $categories_view = array();
	var $categories_admin = array();
	
	function user($user_id){
		$this->id = $user_id;
		
		$query = "SELECT * FROM `anyInventory_users` WHERE `id`='".$this->id."'";
		$result = mysql_query($query) or die(mysql_error() . '<br /><br />' . $query);
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		
		$this->username = $row["username"];
		$this->usertype = $row["usertype"];
		
		$this->categories_view = (is_array(unserialize($row["categories_view"]))) ? unserialize($row["categories_view"]) : array();
		$this->categories_admin = (is_array(unserialize($row["categories_admin"]))) ? unserialize($row["categories_admin"]) : array();
	}
	
	function can_view($cat_id){
		return (($cat_id == 0) || ($this->usertype == 'Administrator') || in_array($cat_id, $this->categories_view));
	}
	
	function can_admin($cat_id){
		return (($cat_id == 0) || ($this->usertype == 'Administrator') || in_array($cat_id, $this->categories_admin));
	}
	
	function get_admin_categories_options($selected = null){
		if ($this->usertype == 'Administration'){
			return get_category_options($selected);
		}
		else{
			return category_array_to_options($this->categories_admin, $selected);
		}
	}
	
	function get_view_categories_options(){
		if ($this->usertype == 'Administration'){
			return get_category_options($selected);
		}
		else{
			return category_array_to_options($this->categories_view, $selected);
		}
	}
	
	function add_category_view($category_id){
		$this->categories_view[] = $category_id;
		
		$query = "UPDATE `anyInventory_users` SET `categories_view`='".addslashes(serialize($this->categories_view))."' WHERE `id`='".$this->id."'";
		mysql_query($query) or die(mysql_error() . '<br /><br />' . $query);
	}
	
	function add_category_admin($category_id){
		$this->categories_admin[] = $category_id;
		
		$query = "UPDATE `anyInventory_users` SET `categories_admin`='".addslashes(serialize($this->categories_admin))."' WHERE `id`='".$this->id."'";
		mysql_query($query) or die(mysql_error() . '<br /><br />' . $query);
	}
	
	function update_categories_view($category_ids){
		$this->categories_view = $category_ids;
		
		$query = "UPDATE `anyInventory_users` SET `categories_view`='".addslashes(serialize($this->categories_view))."' WHERE `id`='".$this->id."'";
		mysql_query($query) or die(mysql_error() . '<br /><br />' . $query);
	}
	
	function update_categories_admin($category_ids){
		$this->categories_admin = $category_ids;
		
		$query = "UPDATE `anyInventory_users` SET `categories_admin`='".addslashes(serialize($this->categories_admin))."' WHERE `id`='".$this->id."'";
		mysql_query($query) or die(mysql_error() . '<br /><br />' . $query);
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
								<td class="form_label">User type:</td>
								<td class="form_input">'.$this->usertype.'</td>
							</tr>';
			
			if (is_array($this->categories_view)){
				$output .= '
							<tr>
								<td class="form_label">Can view:</td>
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
								<td class="form_label">Can admin:</td>
								<td class="form_input">';
				
				foreach($this->categories_admin as $cat_id){
					$category = new category($cat_id);
					
					$output .= $category->breadcrumb_names . '<br />';
				}
				
				$output .= '
								</td>
							</tr>';
			}
			
			$output .= '
						</table>
					</tr>
				</table>';
		
		return $output;
	}
}

?>