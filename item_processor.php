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
	
	if (is_uploaded_file($_FILES["file"]["tmp_name"])){
		$key = mysql_insert_id();
		
		$i = 1;
		
		do {
			$filename = $key.".".$i.".".$_FILES["file"]["name"];
		} while (is_file($files_dir.$filename));
		
		if(!copy($_FILES["file"]["tmp_name"], $files_dir.$filename)){
			echo 'Could not copy uploaded file.';
			exit;
		}
		
		$query = "INSERT INTO `anyInventory_files` 
				(`key`,
				 `file_name`,
				 `file_size`,
				 `file_type`)
				VALUES
				('".$key."',
				 '".$filename."',
				 '".$_FILES["file"]["size"]."',
				 '".$_FILES["file"]["type"]."')";
		$result = query($query);
	}
	
	header("Location: index.php?c=".$_REQUEST["c"]);
}
elseif($_REQUEST["action"] == "do_edit"){
	$category = new category($_REQUEST["c"]);
	
	$query = "UPDATE `anyInventory_items` SET ";
	
	foreach($category->field_ids as $field_id){
		$field = new field($field_id);
		
		$query .= "`".str_replace("_"," ",$field->name)."`= ";
		
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
	
	$query .= " `name`='".$_REQUEST["name"]."' WHERE `id`='".$_REQUEST["id"]."'";
	$result = query($query);
	
	if (is_array($_REQUEST["delete_files"])){
		foreach($_REQUEST["delete_files"] as $file_id){
			$query = "SELECT * FROM `anyInventory_files` WHERE `id`='".$file_id."'";
			$result = query($query);
			$row = mysql_fetch_array($result);
			
			if (!unlink($files_dir.$row["file_name"])){
				echo "Could not delete ".$row["file_name"].'<br />';
				exit;
			}
			
			$query = "DELETE FROM `anyInventory_files` WHERE `id`='".$file_id."'";
			$result = query($query);
		}
	}
	
	if (is_uploaded_file($_FILES["file"]["tmp_name"])){
		$key = $_REQUEST["id"];
		
		$i = 1;
		
		do {
			$filename = $key.".".$i.".".$_FILES["file"]["name"];
		} while (is_file($files_dir.$filename));
		
		if(!copy($_FILES["file"]["tmp_name"], $files_dir.$filename)){
			echo 'Could not copy uploaded file.';
			exit;
		}
		
		$query = "INSERT INTO `anyInventory_files` 
				(`key`,
				 `file_name`,
				 `file_size`,
				 `file_type`)
				VALUES
				('".$_REQUEST["id"]."',
				 '".$filename."',
				 '".$_FILES["file"]["size"]."',
				 '".$_FILES["file"]["type"]."')";
		$result = query($query);
	}
	
	header("Location: items.php");
}
elseif($_REQUEST["action"] == "do_move"){
	$query = "UPDATE `anyInventory_items` SET `item_category`='".$_REQUEST["c"]."' WHERE `id`='".$_REQUEST["id"]."'";
	$result = query($query);
	
	header("Location: items.php");
}
elseif($_REQUEST["action"] == "do_delete"){
	if ($_REQUEST["delete"] == "Delete"){
		$item = new item($_REQUEST["id"]);
		
		if (is_array($item->files)){
			foreach($item->files as $file){
				if (unlink($files_dir.$file["file_name"])){
					$query = "DELETE FROM `anyInventory_files` WHERE `id`='".$file["id"]."'";
					$result = query($query);
				}
				else{
					echo "Could not delete ".$file["file_name"].'<br />';
					exit;
				}
			}
		}
		
		$query = "DELETE FROM `anyInventory_items` WHERE `id`='".$item->id."'";
		$result = query($query);
	}
	
	header("Location: items.php");
}

?>