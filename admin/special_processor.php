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
	
	$query = "UPDATE `anyInventory_config` SET `value`='".$_POST["name"]."' WHERE `key_value`='AUTO_INC_FIELD_NAME'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	$query = "UPDATE `anyInventory_categories` SET `auto_inc_field`='0'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	// Add any categories that were selected.
	if (is_array($_POST["add_to"])){
		foreach($_POST["add_to"] as $cat_id){
			$query = "UPDATE `anyInventory_categories` SET `auto_inc_field`='1' WHERE `id`='".$cat_id."'";
			$result = $db->query($query);
			if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
		}
	}
	
	header("Location: fields.php");
	exit;
}
elseif($_POST["action"] == 'do_edit_front_page_text'){
	$query = "UPDATE `anyInventory_config` SET `value`='".$_POST["front_page_text"]."' WHERE `key_value`='FRONT_PAGE_TEXT'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	header("Location: index.php");
	exit;
}
elseif($_GET["action"] == 'pp_admin_on'){
	$query = "UPDATE `anyInventory_config` SET `value`='1' WHERE `key_value`='PP_ADMIN'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	header("Location: index.php");
	exit;
}
elseif($_GET["action"] == 'pp_admin_off'){
	$query = "UPDATE `anyInventory_config` SET `value`='0' WHERE `key_value`='PP_ADMIN'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	header("Location: index.php");
	exit;
}
elseif($_GET["action"] == 'pp_view_on'){
	$query = "UPDATE `anyInventory_config` SET `value`='1' WHERE `key_value`='PP_VIEW'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	header("Location: index.php");
	exit;
}
elseif($_GET["action"] == 'pp_view_off'){
	$query = "UPDATE `anyInventory_config` SET `value`='0' WHERE `key_value`='PP_VIEW'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);
	
	header("Location: index.php");
	exit;
}
elseif ($_POST["action"] == "do_edit_name_field_name"){
	$_POST["name"] = stripslashes($_POST["name"]);
	$_POST["name"] = str_replace($replace,"",$_POST["name"]);
	$_POST["name"] = trim(addslashes($_POST["name"]));
	
	$query = "UPDATE `anyInventory_config` SET `value`='".$_POST["name"]."' WHERE `key_value`='NAME_FIELD_NAME'";
	$result = $db->query($query);
	if (DB::isError($result)) die($result->getMessage().': line '.__LINE__.'<br /><br />'.$result->userinfo);

	header("Location: index.php");
	exit;
}

?>
