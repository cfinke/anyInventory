<?php

session_start();

error_reporting(E_ALL ^ E_NOTICE);

// This is a blank template.  If you are reading this, you should run
// the included install.php script to fill in the values, or you can
// fill them in by hand and upload the new file.

$DIR_PREFIX .= "./";

$db_host = '';
$db_name = '';
$db_user = '';
$db_pass = '';

include($DIR_PREFIX."functions.php");
include($DIR_PREFIX."category_class.php");
include($DIR_PREFIX."field_class.php");
include($DIR_PREFIX."item_class.php");
include($DIR_PREFIX."file_class.php");
include($DIR_PREFIX."alert_class.php");
include($DIR_PREFIX."user_class.php");

connect_to_database();

if (!stristr($_SERVER["PHP_SELF"], "login")){
	if ((($DIR_PREFIX == './') && get_config_value('PP_VIEW') && !isset($_SESSION["user"]["id"])) || 
		(($DIR_PREFIX == '.././') && get_config_value('PP_ADMIN') && !isset($_SESSION["user"]["id"]))){
		$return_to = $_SERVER["PHP_SELF"]."?";
		
		foreach($_REQUEST as $key => $value){
			$return_to .= $key . '=' . $value . '&';
		}
		
		header("Location: ".$DIR_PREFIX."login.php?return_to=".$return_to);
		exit;
	}
	
	if (get_config_value('PP_VIEW')){
		$view_user = new user($_SESSION["user"]["id"]);
	}
	else{
		$view_user = new user(get_config_value('ADMIN_USER_ID'));
	}
	
	if (get_config_value('PP_ADMIN')){
		$admin_user = new user($_SESSION["user"]["id"]);
	}
	else{
		$admin_user = new user(get_config_value('ADMIN_USER_ID'));
	}
}


?>