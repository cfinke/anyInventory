<?php

include("globals.php");

if ($admin_user->usertype != 'Administrator'){
	header("Location: ../error_handler.php?eid=15");
	exit;
}

$replace = array('"','&',"\\",':',';','`','[',']');

if ($_POST["action"] == "do_edit_auto_inc_field"){
	$_POST["name"] = stripslashes($_POST["name"]);
	$_POST["name"] = str_replace($replace,"",$_POST["name"]);
	$_POST["name"] = trim(addslashes($_POST["name"]));
	
	$query = "UPDATE ".$db->quoteIdentifier('anyInventory_config')." SET ".$db->quoteIdentifier('value')."='".$_POST["name"]."' WHERE ".$db->quoteIdentifier('key_value')."='AUTO_INC_FIELD_NAME'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	$query = "UPDATE ".$db->quoteIdentifier('anyInventory_categories')." SET ".$db->quoteIdentifier('auto_inc_field')."='0'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	// Add any categories that were selected.
	if (is_array($_POST["add_to"])){
		foreach($_POST["add_to"] as $cat_id){
			$query = "UPDATE ".$db->quoteIdentifier('anyInventory_categories')." SET ".$db->quoteIdentifier('auto_inc_field')."='1' WHERE ".$db->quoteIdentifier('id')."='".$cat_id."'";
			$result = $db->query($query);
			if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
		}
	}
	
	header("Location: fields.php");
	exit;
}
elseif($_POST["action"] == 'do_edit_front_page_text'){
	$query = "UPDATE ".$db->quoteIdentifier('anyInventory_config')." SET ".$db->quoteIdentifier('value')."='".$_POST["front_page_text"]."' WHERE ".$db->quoteIdentifier('key_value')."='FRONT_PAGE_TEXT'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	header("Location: index.php");
	exit;
}
elseif($_GET["action"] == 'pp_admin_on'){
	$query = "UPDATE ".$db->quoteIdentifier('anyInventory_config')." SET ".$db->quoteIdentifier('value')."='1' WHERE ".$db->quoteIdentifier('key_value')."='PP_ADMIN'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	header("Location: index.php");
	exit;
}
elseif($_GET["action"] == 'pp_admin_off'){
	$query = "UPDATE ".$db->quoteIdentifier('anyInventory_config')." SET ".$db->quoteIdentifier('value')."='0' WHERE ".$db->quoteIdentifier('key_value')."='PP_ADMIN'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	header("Location: index.php");
	exit;
}
elseif($_GET["action"] == 'pp_view_on'){
	$query = "UPDATE ".$db->quoteIdentifier('anyInventory_config')." SET ".$db->quoteIdentifier('value')."='1' WHERE ".$db->quoteIdentifier('key_value')."='PP_VIEW'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	header("Location: index.php");
	exit;
}
elseif($_GET["action"] == 'pp_view_off'){
	$query = "UPDATE ".$db->quoteIdentifier('anyInventory_config')." SET ".$db->quoteIdentifier('value')."='0' WHERE ".$db->quoteIdentifier('key_value')."='PP_VIEW'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);
	
	header("Location: index.php");
	exit;
}
elseif ($_POST["action"] == "do_edit_name_field_name"){
	$_POST["name"] = stripslashes($_POST["name"]);
	$_POST["name"] = str_replace($replace,"",$_POST["name"]);
	$_POST["name"] = trim(addslashes($_POST["name"]));
	
	$query = "UPDATE ".$db->quoteIdentifier('anyInventory_config')." SET ".$db->quoteIdentifier('value')."='".$_POST["name"]."' WHERE ".$db->quoteIdentifier('key_value')."='NAME_FIELD_NAME'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': '.__FILE__.', line '.__LINE__.'<br /><br />'.$result->userinfo.'<br /><br />'.SUBMIT_REPORT);

	header("Location: index.php");
	exit;
}

?>
