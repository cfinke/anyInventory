<?php

error_reporting(E_ALL ^ E_NOTICE);

class alert {
	var $id;
	
	var $item_ids;
	
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
		$this->item_ids = unserialize($row["item_ids"]);
		$this->field_id = $row["field_id"];
		$this->condition = $row["condition"];
		$this->value = $row["value"];
		$this->time = $row["time"];
		$this->unix_time = $row["unix_time"];
	}
	
	// This function returns a "teaser" or short description for the alert.
	
	function export_teaser(){
		return $this->title;
	}
	
	// This function returns a full description of the item.
	
	function export_description(){
		global $DIR_PREFIX;
		
		// Create the header with the name.
		$output .= '<h2>'.$this->title.'</h2>';
		$output .= '<p><b>Applies to:</b>';
		foreach($this->item_ids as $item_id){
			$item = new item($item_id);
			$output .= '<br />'.$item->export_teaser();
		}
		
		$output .= '</p><p><b>Active when: </b>';
		
		$field = new field($this->field_id);
		
		$output .= $field->name." ";
		$output .= $this->condition;
		$output .= (trim($this->value) == '') ? " ''" : ' '.$this->value;
		
		$output .= '</p><p><b>Effective as of:</b> '.date("Y m d",$this->unix_time).'</p>';
		
		return $output;
	}
}

?>