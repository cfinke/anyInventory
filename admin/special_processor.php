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
	
	$query = "UPDATE `anyInventory_config` SET `value`='".$_POST["name"]."' WHERE `key`='AUTO_INC_FIELD_NAME'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	$query = "UPDATE `anyInventory_categories` SET `auto_inc_field`='0'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	// Add any categories that were selected.
	if (is_array($_POST["add_to"])){
		foreach($_POST["add_to"] as $cat_id){
			$query = "UPDATE `anyInventory_categories` SET `auto_inc_field`='1' WHERE `id`='".$cat_id."'";
			$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
		}
	}
	
	header("Location: fields.php");
	exit;
}
elseif($_POST["action"] == 'do_edit_front_page_text'){
	$query = "UPDATE `anyInventory_config` SET `value`='".$_POST["front_page_text"]."' WHERE `key`='FRONT_PAGE_TEXT'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	header("Location: index.php");
	exit;
}
elseif($_GET["action"] == 'pp_admin_on'){
	$query = "UPDATE `anyInventory_config` SET `value`='1' WHERE `key`='PP_ADMIN'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	header("Location: index.php");
	exit;
}
elseif($_GET["action"] == 'pp_admin_off'){
	$query = "UPDATE `anyInventory_config` SET `value`='0' WHERE `key`='PP_ADMIN'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	header("Location: index.php");
	exit;
}
elseif($_GET["action"] == 'pp_view_on'){
	$query = "UPDATE `anyInventory_config` SET `value`='1' WHERE `key`='PP_VIEW'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	header("Location: index.php");
	exit;
}
elseif($_GET["action"] == 'pp_view_off'){
	$query = "UPDATE `anyInventory_config` SET `value`='0' WHERE `key`='PP_VIEW'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);
	
	header("Location: index.php");
	exit;
}
elseif ($_POST["action"] == "do_edit_name_field_name"){
	$_POST["name"] = stripslashes($_POST["name"]);
	$_POST["name"] = str_replace($replace,"",$_POST["name"]);
	$_POST["name"] = trim(addslashes($_POST["name"]));
	
	$query = "UPDATE `anyInventory_config` SET `value`='".$_POST["name"]."' WHERE `key`='NAME_FIELD_NAME'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />'. $query);

	header("Location: index.php");
	exit;
}

?>