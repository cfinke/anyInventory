<?php

include("globals.php");

if ($_REQUEST["action"] == "log_in"){
	$query = "SELECT * FROM `anyInventory_users` WHERE `username`='".$_REQUEST["username"]."'";
	$result = mysql_query($query) or die(mysql_error() . '<br /><br />' . $query);
	
	if (mysql_num_rows($result) == 0){
		header("Location: login.php?f=1&return_to=".$_REQUEST["return_to"]);
		exit;
	}
	else{
		if (md5($_REQUEST["password"]) == mysql_result($result, 0, 'password')){
			unset($_SESSION["user"]);
			
			$_SESSION["user"] = array();
			$_SESSION["user"]["id"] = mysql_result($result, 0, 'id');
			$_SESSION["user"]["username"] = mysql_result($result, 0, 'username');
			$_SESSION["user"]["usertype"] = mysql_result($result, 0, 'usertype');
			
			if ($_REQUEST["return_to"] == ''){
				$_REQUEST["return_to"] = './admin/index.php';
			}
			
			header("Location: ".$_REQUEST["return_to"]);
			exit;
		}
		else{
			header("Location: login.php?f=1&return_to=".$_REQUEST["return_to"]);
			exit;
		}
	}
}
elseif($_REQUEST["action"] == "log_out"){
	unset($_SESSION["user"]);
	session_destroy();
	
	header("Location: index.php");
	exit;
}

?>