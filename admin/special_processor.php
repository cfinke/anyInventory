<?php

require_once("globals.php");

if ($_GET["action"] == 'switch_view'){
	$query = "UPDATE " . $db->quoteIdentifier('anyInventory_config') . " SET " . $db->quoteIdentifier('value') . " = '";
	$query .= (ITEM_VIEW == 'list') ? 'table' : 'list';
	$query .= "' WHERE " . $db->quoteIdentifier('key') . "='ITEM_VIEW'";
	$result = $db->query($query);
	if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	
	header("Location: ../index.php?c=".$_GET["c"]);
	exit;
}

if ($admin_user->usertype != 'Administrator'){
	header("Location: ../error_handler.php?eid=15");
	exit;
}

$replace = array('"','&',"\\",':',';','`','[',']');

if ($_POST["action"] == "do_edit_auto_inc_field"){
	$_POST["name"] = stripslashes($_POST["name"]);
	$_POST["name"] = str_replace($replace,"",$_POST["name"]);
	$_POST["name"] = trim(addslashes($_POST["name"]));
	
	$query = "UPDATE " . $db->quoteIdentifier('anyInventory_config') . " SET " . $db->quoteIdentifier('value') . "='".$_POST["name"]."' WHERE " . $db->quoteIdentifier('key') . "='AUTO_INC_FIELD_NAME'";
	$result = $db->query($query);
	if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	
	$query = "UPDATE " . $db->quoteIdentifier('anyInventory_categories') . " SET " . $db->quoteIdentifier('auto_inc_field') . "='0'";
	$result = $db->query($query);
	if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	
	// Add any categories that were selected.
	if (is_array($_POST["add_to"])){
		foreach($_POST["add_to"] as $cat_id){
			$query = "UPDATE " . $db->quoteIdentifier('anyInventory_categories') . " SET " . $db->quoteIdentifier('auto_inc_field') . "='1' WHERE " . $db->quoteIdentifier('id') . "='".$cat_id."'";
			$result = $db->query($query);
			if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
		}
	}
	
	header("Location: fields.php");
	exit;
}
elseif($_POST["action"] == 'do_edit_front_page_text'){
	$query = "UPDATE " . $db->quoteIdentifier('anyInventory_config') . " SET " . $db->quoteIdentifier('value') . "='".$_POST["front_page_text"]."' WHERE " . $db->quoteIdentifier('key') . "='FRONT_PAGE_TEXT'";
	$result = $db->query($query);
	if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
}
elseif($_GET["action"] == 'pp_admin_on'){
	$query = "UPDATE " . $db->quoteIdentifier('anyInventory_config') . " SET " . $db->quoteIdentifier('value') . "='1' WHERE " . $db->quoteIdentifier('key') . "='PP_ADMIN'";
	$result = $db->query($query);
	if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
}
elseif($_GET["action"] == 'pp_admin_off'){
	$query = "UPDATE " . $db->quoteIdentifier('anyInventory_config') . " SET " . $db->quoteIdentifier('value') . "='0' WHERE " . $db->quoteIdentifier('key') . "='PP_ADMIN'";
	$result = $db->query($query);
	if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
}
elseif($_GET["action"] == 'pp_view_on'){
	$query = "UPDATE " . $db->quoteIdentifier('anyInventory_config') . " SET " . $db->quoteIdentifier('value') . "='1' WHERE " . $db->quoteIdentifier('key') . "='PP_VIEW'";
	$result = $db->query($query);
	if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
}
elseif($_GET["action"] == 'pp_view_off'){
	$query = "UPDATE " . $db->quoteIdentifier('anyInventory_config') . " SET " . $db->quoteIdentifier('value') . "='0' WHERE " . $db->quoteIdentifier('key') . "='PP_VIEW'";
	$result = $db->query($query);
	if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
}
elseif ($_POST["action"] == "do_edit_name_field_name"){
	$_POST["name"] = stripslashes($_POST["name"]);
	$_POST["name"] = str_replace($replace,"",$_POST["name"]);
	$_POST["name"] = trim(addslashes($_POST["name"]));
	
	$query = "UPDATE " . $db->quoteIdentifier('anyInventory_config') . " SET " . $db->quoteIdentifier('value') . "='".$_POST["name"]."' WHERE " . $db->quoteIdentifier('key') . "='NAME_FIELD_NAME'";
	$result = $db->query($query);
	if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
}
elseif($_POST["action"] == "change_lang"){
	$query = "UPDATE " . $db->quoteIdentifier('anyInventory_config') . " SET " . $db->quoteIdentifier('value') . "='".$_POST["lang"]."' WHERE " . $db->quoteIdentifier('key') . "='LANG'";
	$result = $db->query($query);
	if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
}
elseif($_POST["action"] == "do_edit_label_template"){
	$query = "UPDATE " . $db->quoteIdentifier('anyInventory_config') . " SET " . $db->quoteIdentifier('value') . " = '".$_POST["template"]."' WHERE " . $db->quoteIdentifier('key') . "='BAR_TEMPLATE'";
	$result = $db->query($query);
	if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
}
elseif($_POST["action"] == "do_edit_label_padding"){
	if(ctype_digit($_POST["padding"])){ 
		$query = "UPDATE " . $db->quoteIdentifier('anyInventory_config') . " SET " . $db->quoteIdentifier('value') . " = '".$_POST["padding"]."' WHERE " . $db->quoteIdentifier('key') . "='LABEL_PADDING'";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	}
	else{
		header("Location: admin/edit_special.php?id=label_padding");
	}
}
elseif($_POST["action"] == "do_edit_pad_char"){
	$char = $_POST["char"];
	if(!ctype_alnum($char)){
		header("Location: admin/edit_special.php?id=pad_char");
	}
	else{
		$query = "UPDATE " . $db->quoteIdentifier('anyInventory_config') . " SET " . $db->quoteIdentifier('value') . " = '".$char."' WHERE " . $db->quoteIdentifier('key') . "='PAD_CHAR'";
		$result = $db->query($query);
		if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
	}
}
elseif($_POST["action"] == "do_edit_barcode"){
	$_POST["type"] = stripslashes($_POST["type"]);
	$_POST["type"] = str_replace($replace,"",$_POST["type"]);
	$_POST["type"] = trim(addslashes($_POST["type"]));
	$query = "UPDATE " . $db->quoteIdentifier('anyInventory_config') . " SET " . $db->quoteIdentifier('value') . " = '".$_POST["type"]."' WHERE " . $db->quoteIdentifier('key') . "='BARCODE'";
	$result = $db->query($query);
	if(DB::isError($result)) die($result->getMessage().'<br /><br />'.SUBMIT_REPORT . '<br /><br />'. $query);
}

header("Location: index.php");
exit;

?>
