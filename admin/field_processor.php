<?php

include("globals.php");

foreach($_POST as $key => $value){
	if (!is_array($_POST[$key])){
		$_POST[$key] = stripslashes($value);
	}
}

foreach($_GET as $key => $value){
	if (!is_array($_GET[$key])){
		$_GET[$key] = stripslashes($value);
	}
}

$replace = array("'",'"','&',"\\",':',';','`','[',']');

if ($_POST["action"] == "do_add"){
	if (is_array($_POST["add_to"])){
		foreach($_POST["add_to"] as $cat_id){
			if (!$admin_user->can_admin($cat_id)){
				header("Location: ../error_handler.php?eid=13");
				exit;
			}
		}
	}
	
	// Check for duplicate fields
	
	$_POST["name"] = str_replace($replace,"",$_POST["name"]);
	$_POST["name"] = str_replace("_"," ",$_POST["name"]);
	$_POST["name"] = trim($_POST["name"]);
	
	$query = "SELECT ".$db->quoteIdentifier('id')." FROM ".$db->quoteIdentifier('anyInventory_fields')." WHERE ".$db->quoteIdentifier('name')."='".$_POST["name"]."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	if ($result->numRows() > 0){
		header("Location: ../error_handler.php?eid=0");
		exit;
	}
	else{
		$_POST["field_values"] = str_replace("'","",$_POST["field_values"]);
		$_POST["field_values"] = trim(str_replace($replace,"",$_POST["field_values"]));
		
		$_POST["default_value"] = str_replace("'","",$_POST["default_value"]);
		$_POST["default_value"] = trim(str_replace($replace,"",$_POST["default_value"]));
		
		if (($_POST["input_type"] == "select") || ($_POST["input_type"] == "radio")){
			if (($_POST["default_value"] == '') || (stristr($_POST["field_values"],$_POST["default_value"]) === false)){
				header("Location: ../error_handler.php?eid=1");
				exit;
			}
			elseif($_POST["field_values"] == ''){
				header("Location: ../error_handler.php?eid=8");
				exit;
			}
		}
		elseif($_POST["input_type"] == "checkbox"){
			$_POST["default_value"] = '';
		}
		
		// Add a field
		if (($_POST["size"] == '') && ($_POST["input_type"] == "text")){
			// Set the default text size to 255
			$_POST["size"] = 255;
		}
		elseif(($_POST["size"] != '') && (!is_numeric($_POST["size"]))){
			$_POST["size"] = 255;
		}
		
		$field_values = explode(",",$_POST["field_values"]);
		
		if (is_array($field_values)){
			foreach($field_values as $key => $value){
				$field_values[$key] = trim($value);
			}
			
			$field_values = array_unique($field_values);
		}
		else{
			$field_values = array();
		}
		
		$field_values = serialize($field_values);
		$categories = array(0);
		$categories = serialize($categories);
		
		// Get the field order for this field.
		$query = "SELECT MAX(".$db->quoteIdentifier('importance').") as ".$db->quoteIdentifier('biggest')." FROM ".$db->quoteIdentifier('anyInventory_fields')."";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
		
		$row = $result->fetchRow();
		$importance = $row['biggest'] + 1;
		
		// Add this field.
		$query = "INSERT INTO ".$db->quoteIdentifier('anyInventory_fields')." (".$db->quoteIdentifier('id').",".$db->quoteIdentifier('name').",".$db->quoteIdentifier('input_type').",".$db->quoteIdentifier('field_values').",".$db->quoteIdentifier('default_value').",".$db->quoteIdentifier('size').",".$db->quoteIdentifier('categories').",".$db->quoteIdentifier('importance').",".$db->quoteIdentifier('highlight').") VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$query_data = array(get_unique_id('anyInventory_fields'),$_POST["name"],$_POST["input_type"],$field_values,$_POST["default_value"],intval($_POST["size"]),$categories,intval($importance),intval(($_POST["highlight"] == "yes")));
		$pquery = $db->prepare($query);
		$result = $db->execute($pquery, $query_data);
		if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
		
		$field = new field(get_unique_id('anyInventory_fields') - 1);
		
		// Add any categories that were selected.
		if (is_array($_POST["add_to"])){
			foreach($_POST["add_to"] as $cat_id){
				$field->add_category($cat_id);
			}
		}
	}
}
elseif($_GET["action"] == "do_add_divider"){
	$query = "SELECT MAX(".$db->quoteIdentifier('importance').") as ".$db->quoteIdentifier('biggest')." FROM ".$db->quoteIdentifier('anyInventory_fields')."";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	$row = $result->fetchRow();
	$importance = $row['biggest'] + 1;
	
	$query = "INSERT INTO ".$db->quoteIdentifier('anyInventory_fields')." (".$db->quoteIdentifier('id').",".$db->quoteIdentifier('name').",".$db->quoteIdentifier('input_type').",".$db->quoteIdentifier('importance').") VALUES (?, ?, ?, ?)";
	$query_data = array(get_unique_id('anyInventory_fields'),'divider','divider',$importance);
	$pquery = $db->prepare($query);
	$result = $db->execute($pquery, $query_data);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
}
elseif($_POST["action"] == "do_edit"){
	if (is_array($_POST["add_to"])){
		foreach($_POST["add_to"] as $cat_id){
	 		if (!$admin_user->can_admin($cat_id) || (!$admin_user->can_admin_field($_POST["id"]))){
				header("Location: ../error_handler.php?eid=13");
				exit;
			}
		}
	}
	
	$query = "SELECT ".$db->quoteIdentifier('id')." FROM ".$db->quoteIdentifier('anyInventory_fields')." WHERE ".$db->quoteIdentifier('name')."='".$_POST["name"]."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	$numrows = $result->numRows();
	$row = $result->fetchRow();
	
	if (($numrows > 0) && ($row['id'] != $_POST["id"])){
		header("Location: ../error_handler.php?eid=0");
		exit;
	}
	
	$_POST["field_values"] = str_replace("'","",$_POST["field_values"]);
	$_POST["field_values"] = trim(str_replace($replace,"",$_POST["field_values"]));
	
	$_POST["default_value"] = str_replace("'","",$_POST["default_value"]);
	$_POST["default_value"] = trim(str_replace($replace,"",$_POST["default_value"]));
	
	$_POST["name"] = str_replace($replace,"",$_POST["name"]);
	$_POST["name"] = str_replace("_"," ",$_POST["name"]);	
	$_POST["name"] = trim($_POST["name"]);
	
	if (($_POST["input_type"] == "select") || ($_POST["input_type"] == "radio")){
		if (($_POST["default_value"] == '') || (stristr($_POST["field_values"],$_POST["default_value"]) === false)){
			header("Location: ../error_handler.php?eid=1");
			exit;
		}
		elseif($_POST["field_values"] == ''){
			header("Location: ../error_handler.php?eid=8");
			exit;
		}
	}
	elseif($_POST["input_type"] == "checkbox"){
		$_POST["default_value"] = '';
	}
	
	// Make an object from the unchanged field.
	$old_field = new field($_POST["id"]);
	
	if ($_POST["input_type"] == "text"){
		// Set the default text size
		if(($_POST["size"] == 0) || (!is_numeric($_POST["size"]))){
			$_POST["size"] = 255;
		}
	}
	elseif($_POST["input_type"] == "multiple"){
		$_POST["size"] = 64;
	}
	else{
		$_POST["size"] = '';
	}
	
	$field_values = explode(",",$_POST["field_values"]);
	
	if (is_array($field_values)){
		foreach($field_values as $key => $value){
			$field_values[$key] = trim($value);
		}
		
		$field_values = array_unique($field_values);
	}
	else{
		$field_values = array();
	}
	
	$field_values = serialize($field_values);
	
	// Change the field.
	$query = "UPDATE ".$db->quoteIdentifier('anyInventory_fields')." SET
				".$db->quoteIdentifier('name')."='".$_POST["name"]."',
				".$db->quoteIdentifier('input_type')."='".$_POST["input_type"]."',
				".$db->quoteIdentifier('field_values')."='".$field_values."',
				".$db->quoteIdentifier('default_value')."='".$_POST["default_value"]."',
				".$db->quoteIdentifier('size')."='".intval($_POST["size"])."',
				".$db->quoteIdentifier('highlight')."='".((int) (($_POST["highlight"] == "yes") / 1))."'
				WHERE ".$db->quoteIdentifier('id')."='".$_POST["id"]."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	// Make an object from the new field.
	$new_field = new field($_POST["id"]);
	
	// Remove all of the old categories.
	if (is_array($old_field->categories)){
		foreach($old_field->categories as $cat_id){
			$new_field->remove_category($cat_id);
		}
	}
	
	// Add the new categories
	if (is_array($_POST["add_to"])){
		foreach($_POST["add_to"] as $cat_id){
			$new_field->add_category($cat_id);
		}
	}
}
elseif($_REQUEST["action"] == "do_delete"){
	// Delete a field.
	
	// Create an object of the field.
	$field = new field($_REQUEST["id"]);
	
	if (($_REQUEST["delete"] == "Delete") || ($field->input_type == 'divider')){
		if (!$admin_user->can_admin_field($_REQUEST["id"])){
			header("Location: ../error_handler.php?eid=13");
			exit;
		}
		
		if ($field->input_type == 'file'){
			$query = "SELECT ".$db->quoteIdentifier('value')." FROM ".$db->quoteIdentifier('anyInventory_values')." WHERE ".$db->quoteIdentifier('field_id')."='".$field->id."' GROUP BY ".$db->quoteIdentifier('value')."";
			$result = $db->query($query);
		 	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
			
			while ($row = $result->fetchRow()){
				$newquery = "SELECT * FROM ".$db->quoteIdentifier('anyInventory_files')." WHERE ".$db->quoteIdentifier('id')."='".$row["value"]."'";
				$newresult = $db->query($newquery);
				if (DB::isError($newresult)) die($newresult->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$newresult->userinfo.'<br /><br />'.SUBMIT_REPORT);
				
				$newrow = $newresult->fetchRow();
				
				$file = new file_object($newrow["id"]);
				
				if (!$file->is_remote && is_file($file->server_path)){
					unlink($file->server_path);
				}
				
				$newestquery = "DELETE FROM ".$db->quoteIdentifier('anyInventory_files')." WHERE ".$db->quoteIdentifier('id')."='".$file->id."'";
				$newestresult = $db->query($newestquery);
				if (DB::isError($newestresult)) die($newestresult->getMessage().': line '.__LINE__);
			}
		}
		
		// Change the importance of the fields below it.
		$query = "UPDATE ".$db->quoteIdentifier('anyInventory_fields')." SET ".$db->quoteIdentifier('importance')."=(".$db->quoteIdentifier('importance')." - 1) WHERE ".$db->quoteIdentifier('importance')." >= '".$field->importance."'";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
		
		if ($field->input_type != 'divider'){
			// Remove the field from the items table
			$query = "DELETE FROM ".$db->quoteIdentifier('anyInventory_values')." WHERE ".$db->quoteIdentifier('field_id')."='".$field->id."'";
			$result = $db->query($query);
			if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
		}
		
		// Delete the field 
		$query = "DELETE FROM ".$db->quoteIdentifier('anyInventory_fields')." WHERE ".$db->quoteIdentifier('id')."='".$field->id."'";
		$result = $db->query($query);
		if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	}
}
elseif($_GET["action"] == "moveup"){
	if (!$admin_user->can_admin_field($_GET["id"])){
		header("Location: ../error_handler.php?eid=13");
		exit;
	}
	
	// Move a field up
	$query = "UPDATE ".$db->quoteIdentifier('anyInventory_fields')." SET ".$db->quoteIdentifier('importance')."=".$_GET["i"]." WHERE ".$db->quoteIdentifier('importance')."='".($_GET["i"] - 1)."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	$query = "UPDATE ".$db->quoteIdentifier('anyInventory_fields')." SET ".$db->quoteIdentifier('importance')."=".($_GET["i"] - 1)." WHERE ".$db->quoteIdentifier('id')."='".$_GET["id"]."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
}
elseif($_GET["action"] == "movedown"){
	if (!$admin_user->can_admin_field($_GET["id"])){
		header("Location: ../error_handler.php?eid=13");
		exit;
	}
	
	// Move a field down
	$query = "UPDATE ".$db->quoteIdentifier('anyInventory_fields')." SET ".$db->quoteIdentifier('importance')."=".$_GET["i"]." WHERE ".$db->quoteIdentifier('importance')."='".($_GET["i"] + 1)."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	$query = "UPDATE ".$db->quoteIdentifier('anyInventory_fields')." SET ".$db->quoteIdentifier('importance')."=".($_GET["i"] + 1)." WHERE ".$db->quoteIdentifier('id')."='".$_GET["id"]."'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
}

header("Location: fields.php");

?>
