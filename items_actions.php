<?php

include("globals.php");

if ($_REQUEST["action"] == "do_add"){
	$category = new category($_REQUEST["c"]);
	
	$query = "INSERT INTO `anyInventory_items` (";
	
	foreach($category->field_ids as $field_id){
		$field = new field($field_id);
		
		$query .= "`".str_replace("_"," ",$field->name)."`, ";
	}
	
	$query .= " `item_category`,`name`) VALUES (";
	
	foreach($category->field_ids as $field_id){
		$field = new field($field_id);
		
		if ($field->input_type == "multiple"){
			if ($_REQUEST[str_replace(" ","_",$field->name)."_text"] == ""){
				$query .= "'".$_REQUEST[str_replace(" ","_",$field->name)."_select"]."', ";
			}
			else{
				$query .= "'".$_REQUEST[str_replace(" ","_",$field->name)."_text"]."', ";
			}
		}
		elseif($field->input_type == "checkbox"){
			if (is_array($_REQUEST[str_replace(" ","_",$field->name)])){
				foreach($_REQUEST[str_replace(" ","_",$field->name)] as $key => $val){
					$string .= $key.", ";
				}
				
				$_REQUEST[str_replace(" ","_",$field->name)] = substr($string,0,strlen($string) - 2);
				$query .= "'".$_REQUEST[str_replace(" ","_",$field->name)]."', ";
			}
			else{
				$query .= "'', ";
			}
		}
		else{
			$query .= "'".$_REQUEST[str_replace(" ","_",$field->name)]."', ";
		}
	}
	
	$query .= " '".$_REQUEST["c"]."','".$_REQUEST["name"]."')";
	$result = query($query);
	
	header("Location: index.php?c=".$_REQUEST["c"]);
}
elseif($_REQUEST["action"] == "do_delete"){
header("Location: items.php");
}



?>