<?php

class item {
	var $id;
	var $category;
	
	function item($item_id){
		$this->id = $item_id;
		
		$query = "SELECT * FROM `anyInventory_items` WHERE `id`='".$this->id."'";
		$result = query($query);
		$row = fetch_array($result);
		
		$this->category = new category($row["category"]);
	}
}

?>