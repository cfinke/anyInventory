<?php

error_reporting(E_ALL ^ E_NOTICE);

class alert {
	var $id;
	
	var $item;
	
	var $title;
	var $field_id;
	var $condition;
	var $value;
	
	var $time;
	var $unix_time;
	
	function alert($alert_id){
		// Set the item id.
		$this->id = $alert_id;
		
		$query = "SELECT *, UNIX_TIMESTAMP(`time`) AS `unix_time` FROM `anyInventory_alerts` WHERE `id`='".$this->id."'";
		$result = query($query);
		$row = mysql_fetch_array($result);
		
		$this->title = $row["title"];
		
	}
	
	// This function returns a "teaser" or short description for the alert.
	
	function export_teaser(){
		return $output;
	}
	
	// This function returns a full description of the item.
	
	function export_description(){
		global $DIR_PREFIX;
		
		// Create the header with the name.
		$output .= '<h2>'.$this->title.'</h2>';
		
		return $output;
	}
}

?>