<?php

class alert {
	var $id;
	
	var $item_ids;
	var $category_ids;
	
	var $title;
	var $field_id;
	var $condition;
	var $value;
	
	var $time;
	var $unix_time;
	
	var $expire_time;
	var $unix_expire_time;
	
	var $timed = false;
	
	var $expires = false;
	
	function alert($alert_id){
		global $db;
		$this->id = $alert_id;
		
		$query = "SELECT *, UNIX_TIMESTAMP(" . $db->quoteIdentifier('time') . ") AS " . $db->quoteIdentifier('unix_time') . ", UNIX_TIMESTAMP(" . $db->quoteIdentifier('expire_time') . ") AS " . $db->quoteIdentifier('unix_expire_time') . " FROM " . $db->quoteIdentifier('anyInventory_alerts') . " WHERE " . $db->quoteIdentifier('id') . "='".$this->id."'";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		$row = $result->fetchRow(); 
		$this->title = $row["title"];
		
		$this->item_ids = unserialize($row["item_ids"]);
		$this->category_ids = unserialize($row["category_ids"]);
		
		$this->field_id = $row["field_id"];
		$this->condition = $row["condition"];
		$this->value = $row["value"];
		
		$this->time = $row["time"];
		$this->unix_time = $row["unix_time"];
		
		$this->expire_time = $row["expire_time"];
		$this->unix_expire_time = $row["unix_expire_time"];
		
		if ($this->expire_time != '00000000000000'){
			$this->expires = true;
		}
		
		$this->timed = $row["timed"];
	}
	
	// This function returns a "teaser" or short description for the alert.
	
	function export_teaser(){
		return $this->title;
	}
	
	// This function removes an item from the alert.
	
	function remove_item($item_id){
		$this->item_ids = array_unique($this->item_ids);
		
		// Find the key of the category id in the array.
		$key = array_search($item_id, $this->item_ids);
		
		// If the category id is in the array, remove it.
		if ($key !== false) unset($this->item_ids[$key]);
		
		$query = "UPDATE " . $db->quoteIdentifier('anyInventory_alerts') . " SET " . $db->quoteIdentifier('item_ids') . "='".serialize($this->item_ids)."' WHERE " . $db->quoteIdentifier('id') . "='".$this->id."'";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	}
	
	function remove_category($category_id){
		$query = "SELECT " . $db->quoteIdentifier("id") . ", " . $db->quoteIdentifier("category_id") . " FROM " . $db->quoteIdentifier("anyInventory_items") . " WHERE " . $db->quoteIdentifier("id") . " IN ('".implode("','", $this->item_ids)."')";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		
		while ($row = $result->fetchRow()){
			if ($row["category_id"] == $category_id){
				$this->remove_item($row["id"]);
			}
		}
		
		// Find the key of the category id in the array.
		$key = array_search($category_id, $this->category_ids);
		
		// If the category id is in the array, remove it.
		if ($key !== false) unset($this->category_ids[$key]);
		
		// Update the database
		if (count($this->category_ids) == 0){
			$query = "DELETE FROM " . $db->quoteIdentifier('anyInventory_alerts') . " WHERE " . $db->quoteIdentifier('id') . "='".$this->id."'";
		}
		else{
			$query = "UPDATE " . $db->quoteIdentifier('anyInventory_alerts') . " SET " . $db->quoteIdentifier('category_ids') . "='".serialize($this->category_ids)."' WHERE " . $db->quoteIdentifier('id') . "='".$this->id."'";
		}
		
		$result = $db->query($query);
        if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	}
	
	// This function returns a full description of the item.
	
	function export_description(){
		global $DIR_PREFIX;
		
		// Create the header with the name.
		$output .= '
			<table class="standardHeader" cellspacing="0" cellpadding="0">
				<tr class="tableHeader">
					<td>'.$this->title.'</td>
				</tr>
				<tr>
					<td class="tableData">
						<table>
							<tr>
								<td class="form_label">'.APPLIES_TO.':</td>
								<td>';
		
		if (is_array($this->item_ids)){
			$query = "SELECT " . $db->quoteIdentifier("id") . ", " . $db->quoteIdentifier("category_id") . ", " . $db->quoteIdentifier("name") . " FROM " . $db->quoteIdentifier("anyInventory_items") . " WHERE " . $db->quoteIdentifier("id") . " IN ('".implode("','", $this->item_ids)."')";
			$result = $db->query($query);
			if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
			
			while ($row = $result->fetchRow()){
				$output .= '<a href="'.$DIR_PREFIX.'index.php?c='.$row["category_id"].'&amp;id='.$row["id"].'" style="text-decoration: none;"><b>'.$row["name"].'</b></a>';
			}
		}
		
		$output .= '</td>
						</tr>
						<tr>
							<td class="form_label">'.ACTIVE_WHEN.':</td>
							<td>';
		
		$query = "SELECT " . $db->quoteIdentifier("name") . " FROM " . $db->quoteIdentifier("anyInventory_fields") . " WHERE " . $db->quoteIdentifier("id") . " = '".$this->field_id."'";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		$row = $result->fetchRow();
		
		$output .= $row["name"]." ";
		$output .= $this->condition;
		$output .= (trim($this->value) == '') ? " ''" : ' '.$this->value;
		
		$output .= '</td>
							</tr>
							<tr>
								<td class="form_label">'.EFFECTIVE_DATE.':</td>
								<td>'.date("Y m d",$this->unix_time).'</td>
							</tr>';
		
		if ($this->expires){
			$output .= '
				<tr>
					<td class="form_label">'.EXPIRATION_DATE.':</td>
					<td>'.date("Y m d",$this->unix_expire_time).'</td>
				</tr>';
		}
		
		if ($this->email != ''){
			$output .= '
				<tr>
					<td class="form_label">'.EMAIL_ALERT_TO.':</td>
					<td>'.$this->email.'</td>
				</tr>';
		}
		
		$output .= '
						</table>
					</td>
				</tr>
			</table>';
		
		return $output;
	}
	
	function export_box($item_id = null){
		// This function creates an alert box for an activated alert.
		global $DIR_PREFIX;
		
		if ($item_id != null){
			$query = "SELECT " . $db->quoteIdentifier("name") . " FROM " . $db->quoteIdentifier("anyInventory_items") . " WHERE " . $db->quoteIdentifier("id") . " ='".$item_id."'";
			$result = $db->query($query);
			if (DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
			
			$item_link = '<br /><a href="'.$DIR_PREFIX.'index.php?id='.$item_id.'">'.$row["name"].'</a>';
		}
		else{
			$item_link = '';
		}
		
		$output = '
			<table class="alertBox" cellspacing="0" cellpadding="2" border="0">
				<tr class="alertTitle">
					<td>
						'.ALERT.'
					</td>
					<td style="text-align: right;">
						<a href="'.$DIR_PREFIX.'docs/alerts.php">?</a>
					</td>
				</tr>
				<tr class="alertContent">
					<td colspan="2">
						<b>'.$this->title.'</b>'.$item_link.'
					</td>
				</tr>
			</table>';
		
		return $output;
	}
}

?>
