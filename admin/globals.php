<?php

error_reporting(E_ALL ^ E_NOTICE);

$DIR_PREFIX .= "../";

include($DIR_PREFIX."globals.php");

if ($admin_pass != ''){
	session_start();
	
	if ($_REQUEST["action"] == "log_in"){
		if ($_REQUEST["password"] != $admin_pass){
			header("Location: ".$DIR_PREFIX."error_handler.php?eid=4&return_to=".$_SERVER["REQUEST_URI"]);
			exit;
		}
		else{
			$_SESSION["anyInventory"]["signed_in"] = true;
		}
	}
	
	if ($_SESSION["anyInventory"]["signed_in"] != true){
		$return_location = $DIR_PREFIX."error_handler.php?eid=4&return_to=".$_SERVER["PHP_SELF"];
		
		foreach($HTTP_GET as $key => $val){
			$return_location .= '&'.$key.'='.$val;
		}
		
		header("Location: ".$return_location);
		exit;
	}
}

?>