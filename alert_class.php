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
	
	var $timed = false;
	
	function alert($alert_id){
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
		$this->timed = $row["timed"];
	}
	
	// This function returns a "teaser" or short description for the alert.
	
	function export_teaser(){
		return $this->title;
	}
	
	// This function removes an item from the alert.
	
	function remove_item($item_id){
		// Find the key of the category id in the array.
		$key = array_search($item_id, $this->item_ids);
		
		// If the category id is in the array, remove it.
		if ($key) unset($this->item_ids[$key]);
		
		if (count($this->item_ids) == 0){
			$query = "DELETE FROM `anyInventory_alerts` WHERE `id`='".$this->id."'";
		}
		else{
			$query = "UPDATE `anyInventory_alerts` SET `item_ids`='".serialize($this->item_ids)."' WHERE `id`='".$this->id."'";
		}
		
		query($query);
	}
	
	// This function returns a full description of the item.
	
	function export_description(){
		global $DIR_PREFIX;
		
		// Create the header with the name.
		$output .= '<h2>'.$this->title.'</h2>';
		$output .= '<p><b>Applies to:</b>';
		
		if (is_array($this->item_ids)){
			foreach($this->item_ids as $item_id){
				$item = new item($item_id);
				$output .= '<br />'.$item->export_teaser();
			}
		}
		
		$output .= '</p><p><b>Active when: </b>';
		
		$field = new field($this->field_id);
		
		$output .= $field->name." ";
		$output .= $this->condition;
		$output .= (trim($this->value) == '') ? " ''" : ' '.$this->value;
		
		$output .= '</p><p><b>Effective as of:</b> '.date("Y m d",$this->unix_time).'</p>';
		
		return $output;
	}
	
	function export_box($item_id = null){
		// This function creates an alert box for an activated alert.
		global $DIR_PREFIX;
		
		if ($item_id != null){
			$item = new item($item_id);
			$item_link = '<br /><a href="'.$DIR_PREFIX.'index.php?id='.$item->id.'">'.$item->name.'</a>';
		}
		else{
			$item_link = '';
		}
		
		$output = '
			<table cellspacing="1" cellpadding="2" style="background: #000000; width: 25ex; margin-bottom: 10px;" border="0">
				<tr style="background: #000000; color: #D3D3A6;">
						<td>
						Alert
					</td>
					<td style="text-align: right;">
						<a style="color: #D3D3A6;" href="'.$DIR_PREFIX.'docs/alerts.php">?</a>
					</td>
				</tr>
				<tr style="background: #D3D3A6;">
					<td style="text-align: center;" colspan="2">
						<b>'.$this->title.'</b>'.$item_link.'
					</td>
				</tr>
			</table>';
		
		return $output;
	}
}

?>